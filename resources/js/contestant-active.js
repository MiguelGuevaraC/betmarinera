$(document).ready(function () {
    verifyToken(localStorage.getItem("token"), "concursos-active");
});

$(document).ready(function () {
    // Función para realizar la solicitud AJAX
    function fetchCategories() {
        Swal.fire({
            title: "Cargando...",
            text: "Por favor, espere mientras cargamos las categorías.",
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
        $.ajax({
            url: API_RUTA + "/list-categories-contest-active", // Endpoint de la API
            type: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas un token de autorización
            },
            data: {
                contest_id: $("#contestactiveselect").val(), // Obtener el valor del select.
                per_page: 300, // Obtener el valor del select
            },
            success: function (response) {
                // Asegúrate de que la respuesta contenga los datos esperados
                if (response && response.data) {
                    $("#confirmBetButton").fadeIn();

                    let categoriesHtml = "";

                    // Iterar sobre las categorías y construir el HTML
                    response.data.forEach(function (category) {
                        const betInfo = category.bet
                            ? category.bet.contestant.names
                            : "Sin Apuesta";

                        // Determinar el color de fondo basado en si hay apuesta o no
                        const backgroundClass =
                            betInfo === "Sin Apuesta"
                                ? "bg-danger"
                                : "bg-primary"; // bg-warning es amarillo

                        categoriesHtml += `
                            <div class="col-lg-2-4 col-md-4 col-sm-6 col-12 mb-3">
                                <div class="widget widget-stats ${backgroundClass}">
                                    <div class="stats-icon">
                                        <i class="fa fa-user-friends"></i> <!-- Ícono relacionado con música o baile -->
                                    </div>
                                    <div class="stats-info">
                                        <h4>${category.name}</h4> <!-- Nombre de la categoría -->
                                        <p>${betInfo}</p> <!-- Información adicional -->
                                    </div>
                                    <div class="stats-link">
                                        <button class="btn btn-light btn-sm open-contestants-modal" 
                                            data-category-id="${category.id}" 
                                              data-category-name="${category.name}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#contestantBetCategory">Ver</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // Insertar el HTML generado dentro del contenedor
                    $(".row.d-flex.flex-wrap").html(categoriesHtml);
                    Swal.close();
                } else {
                    console.log("No se encontraron categorías activas.");
                    Swal.close();
                }
            },

            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = WEB_RUTA + "/log-in"; // Reemplazar con la URL de tu página de login
                } else {
                    console.error("Error: " + error);
                }
                Swal.close();
            },
        });
    }
    // Llamar a la función de AJAX cuando cambie el select
    $("#contestactiveselect").on("select2:select", function (e) {
        const contestStatus = e.params.data.status; // Obtener el estado adicional "status"

        $(".row.d-flex.flex-wrap").html("");

        if ($("#contestactiveselect").val() != null) {
            if (contestStatus != "Apuesta Confirmada") {
                fetchCategories(); // Llamar a la función cuando el valor del select cambie
            } else {
                $(".row.d-flex.flex-wrap").html(
                    '<div class="infobet alert alert-success">Este concurso ya tiene una apuesta realizada.</div>'
                );
                $("#confirmBetButton").fadeOut();
            }
        } else {
            $("#confirmBetButton").fadeOut();
        }
    });
    $("#contestactiveselect").on("select2:clear", function () {
        $(".row.d-flex.flex-wrap").html("");
    });

    // Supongamos que el modal tiene el id 'contestantBetCategory'
    $("#contestantBetCategory").on("hidden.bs.modal", function () {
        // Llama a la función fetchCategories después de que el modal se haya cerrado
        fetchCategories();
    });

    const contestId = $("#contestId").val();

    $("#contestactiveselect").select2({
        placeholder: "Buscar Concurso...",
        allowClear: true,
        ajax: {
            url: API_RUTA + "/list-contest", // Ruta para obtener los concursos
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token de autenticación
            },
            data: function (params) {
                return {
                    status: "Activo",
                    search: params.term || "",
                };
            },
            delay: 500,
            processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            status: item.statusByApostador || "Apuesta No Confirmada",
                        };
                    }),
                };
            },
            cache: true,
        },
    });

    // Búsqueda automática del primer concurso
    $.ajax({
        url: API_RUTA + "/list-contest",
        method: "GET",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
        data: {
            status: "Activo",
            search: "",
        },
        success: function (response) {
            if (response.data && response.data.length > 0) {
                let firstContest = response.data[0]; // Tomar el primer concurso
                $("#contestactiveselect").append(
                    new Option(firstContest.name, firstContest.id, true, true)
                ).trigger("change"); // Agregar y seleccionar automáticamente
                const contestStatus = firstContest.statusByApostador; // Obtener el estado adicional "status"

                if (contestStatus != "Apuesta Confirmada") {
                    fetchCategories(); // Llamar a la función cuando el valor del select cambie
                } else {
                    $(".row.d-flex.flex-wrap").html(
                        '<div class="infobet alert alert-success">Este concurso ya tiene una apuesta realizada.</div>'
                    );
                    $("#confirmBetButton").fadeOut();
                }
            }
        },
        error: function () {
            console.error("Error al obtener los concursos.");
        },
    });
});

// Función que se ejecuta al hacer clic en el botón
function confirmBet() {
    // Muestra un mensaje de confirmación
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¿Deseas confirmar tu apuesta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, confirmar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, puedes realizar la solicitud AJAX
            $.ajax({
                url: API_RUTA + "/confirm-bet", // Ruta para obtener las categorías
                method: "PUT",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"), // Token de autenticación
                },
                data: {
                    contest_id: $("#contestactiveselect").val(), // Obtener el valor del select.
                    per_page: 300, // Obtener el valor del select
                },
                success: function (response) {
                    // Si la solicitud es exitosa, muestra un mensaje de éxito
                    Swal.fire(
                        "Confirmado!",
                        "Tu apuesta ha sido realizada.",
                        "success"
                    );
                    $(".row.d-flex.flex-wrap").html(
                        '<div class="infobet alert alert-success">Este concurso ya tiene una apuesta realizada.</div>'
                    );
                    $("#confirmBetButton").fadeOut();
                },
                error: function (error) {
                    if (error.status === 422) {
                        const errors = error.responseJSON.message;

                        let errorMessages = "<ul>";
                        errorMessages += `<li>${errors}</li>`;
                        errorMessages += "</ul>";

                        Swal.fire({
                            icon: "error",
                            title: "Errores de Validación",
                            html: errorMessages,
                        });
                    } else if (xhr.status === 401) {
                        window.location.href = "/"; // Aquí se manda a la ruta raíz que carga la vista log-in
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "No se pudo agregar la categoría. Intente nuevamente.",
                        });
                    }
                },
            });
        }
    });
}

$(document).on("click", ".open-contestants-modal", function () {
    const categoryId = $(this).data("category-id");
    var categoryName = $(this).data("category-name");
    $("#categoryName").text(categoryName);

    $("#contestantsBetTable").DataTable({
        language: DATATABLES_LANGUAGE_ES, // Establecer el idioma en español
        processing: true, // Muestra el indicador de "cargando"
        serverSide: true, // Activar procesamiento del lado del servidor
        destroy: true, // Elimina la instancia anterior de DataTable al crear una nueva
        pageLength: 5, // Número de registros por página
        lengthMenu: [5, 10, 25, 50],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate, // Optimiza para móviles
                type: "inline",
            },
        },
        autoWidth: false, // Deshabilitar ancho automático para mejorar diseño en móviles
        pagingType: "simple_numbers",
        ajax: {
            url: API_RUTA + "/list-contestants", // Ruta para obtener los concursantes
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data: function (d) {
                // Envía los parámetros de paginación junto con el ID del concurso
                return {
                    contest_id: $("#contestId").val(), // ID del concurso
                    category_id: categoryId,
                    page: d.start / d.length + 1, // Calcula la página actual
                    per_page: d.length, // Cantidad de registros por página
                    search: d.search.value, // Valor del campo de búsqueda
                };
            },
            dataSrc: DATA_SRC_FUNCTION,
            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = WEB_RUTA + "/log-in"; // Reemplazar con la URL de tu página de login
                } else {
                    console.error("Error: " + error);
                }
            },
        },
        columns: [
            { data: "names", title: "Nombre" },
            { data: "description", title: "Descripción" },
            {
                data: "statusbet",
                title: "Acción",
                render: function (data, type, row) {
                    // Verificar el estado de la apuesta (true o false)
                    let isChecked = data ? "checked" : ""; // Si 'data' es true, marcar el radio button

                    // El name es común para todos, lo que permite seleccionar solo uno
                    return `
                    <input type="radio" name="statusbet" class="statusbet-radio" 
                        data-bet-id="${row?.bet?.id ?? "null"}" 
                        data-category-id="${row?.category_id ?? "null"}" 
                        data-contestant-id="${row?.id ?? "null"}" 
                        ${isChecked} />
                `;
                },
            },
        ],
        columnDefs: [
            {
                targets: 2, // Índice de la columna "Acción"
                width: "10%", // Ancho del 20%
            },
        ],
        drawCallback: function (settings) {
            // Mostrar/ocultar paginado y controles en pantallas pequeñas
            if ($(window).width() <= 576) {
                $(".dataTables_paginate").hide(); // Ocultar paginado en pantallas pequeñas
                $(".dataTables_length").hide(); // Ocultar longitud de página
                $(".dataTables_info").hide();
            } else {
                $(".dataTables_paginate").show(); // Mostrar paginado en pantallas grandes
                $(".dataTables_length").hide(); // Ocultar longitud de página
                $(".dataTables_filter").show(); // Mostrar filtro
                $(".dataTables_info").show();
            }
        },
    });

    $("#contestantBetCategory").modal("show");
});

$(document).on("change", ".statusbet-radio", function () {
    const isChecked = $(this).prop("checked");
    const betId = $(this).data("bet-id") ?? "null";
    const categoryId = $(this).data("category-id") ?? null;
    const contestantId = $(this).data("contestant-id") ?? null;
    // Realizar una acción cuando se cambia el estado de un radio button
    $.ajax({
        type: "PUT",
        url: API_RUTA + "/createupdatebet/" + betId, // Endpoint de la API

        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas un token de autorización
        },
        data: {
            contestant_id: contestantId, // Obtener el valor del select.
            category_id: categoryId, // Obtener el valor del select.
            per_page: 300, // Obtener el valor del select
        },
        success: function (response) {},
        error: function (error) {
            if (error.status === 422) {
                const errors = error.responseJSON.message;

                let errorMessages = "<ul>";
                errorMessages += `<li>${errors}</li>`;
                errorMessages += "</ul>";

                Swal.fire({
                    icon: "error",
                    title: "Errores de Validación",
                    html: errorMessages,
                });
            } else if (xhr.status === 401) {
                window.location.href = WEB_RUTA + "/log-in"; // Aquí se manda a la ruta raíz que carga la vista log-in
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo agregar la categoría. Intente nuevamente.",
                });
            }
        },
    });
});

// Manejar la selección de un participante
$(document).on("click", ".select-contestant", function () {
    const contestantId = $(this).data("contestant-id");
    console.log("Seleccionaste al participante con ID:", contestantId);
    // Aquí puedes agregar la lógica para manejar la selección
});



