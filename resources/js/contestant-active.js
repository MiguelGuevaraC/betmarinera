$(document).ready(function () {
    verifyToken(localStorage.getItem("token"),'concursos-active');
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
            error: function (error) {
                console.error("Error al obtener las categorías:", error);
                Swal.close();
            },
        });
    }
    // Llamar a la función de AJAX cuando cambie el select
    $("#contestactiveselect").on("select2:select", function (e) {
        const contestStatus = e.params.data.status; // Obtener el estado adicional "status"

        $(".row.d-flex.flex-wrap").html("");

        if ($("#contestactiveselect").val() != null) {
            if(contestStatus != 'Apuesta Confirmada'){
                fetchCategories(); // Llamar a la función cuando el valor del select cambie
            }else{
                $(".row.d-flex.flex-wrap").html('<div class="infobet alert alert-success">Este concurso ya tiene una apuesta realizada.</div>');
                $("#confirmBetButton").fadeOut();
            }
           
        } else {
            $("#confirmBetButton").fadeOut();
        }
    });

    // Supongamos que el modal tiene el id 'contestantBetCategory'
    $("#contestantBetCategory").on("hidden.bs.modal", function () {
        // Llama a la función fetchCategories después de que el modal se haya cerrado
        fetchCategories();
    });
});

$(document).on("click", ".open-contestants-modal", function () {
    const categoryId = $(this).data("category-id");

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
});

// Manejar la selección de un participante
$(document).on("click", ".select-contestant", function () {
    const contestantId = $(this).data("contestant-id");
    console.log("Seleccionaste al participante con ID:", contestantId);
    // Aquí puedes agregar la lógica para manejar la selección
});

$(document).ready(function () {
    const contestId = $("#contestId").val();

    $("#contestactiveselect").select2({
        placeholder: "Buscar Concurso...",
        allowClear: true,
        ajax: {
            url: API_RUTA + "/list-contest", // Ruta para obtener las categorías
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token de autenticación
            },
            data: function (params) {
                // Obtener contestId cada vez que el usuario escribe
                const contestId = $("#contestId").val();
                return {
                    status: "Activo", // Enviar el contest_id actualizado
                    search: params.term || "", // Enviar el término de búsqueda (params.term)
                };
            },
            delay: 500, // Retardo en milisegundos para evitar hacer peticiones muy rápidas
            processResults: function (data) {
                // Transformar los datos para que Select2 pueda mostrarlos correctamente
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.id, // El valor que se enviará al servidor al seleccionar una opción
                            text: item.name, // El texto que se mostrará en el select
                            status: item.
                            statusByApostador || "Apuesta No Confirmada", // Agregar un campo "status" en el objeto
                        };
                    }),
                };
            },
            cache: true, // Para evitar realizar las mismas peticiones múltiples veces
        },
    });
});

function viewBet(id) {
    $("#contestApostadorTable").DataTable({
        language: DATATABLES_LANGUAGE_ES,
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        lengthMenu: [25, 50, 100],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: "inline",
            },
        },
        autoWidth: false,
        pagingType: "simple_numbers",
        ajax: {
            url: API_RUTA + "/list-apostadores/" + id,
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data: function (d) {
                return {
                    contest_id: id,
                    page: d.start / d.length + 1,
                    per_page: d.length,
                    search: d.search.value,
                };
            },
            dataSrc: DATA_SRC_FUNCTION,
        },
        columns: [
            { data: "name_apostador", title: "Nombre" },
            { data: "score", title: "Puntaje" },
        ],
        columnDefs: [],
        createdRow: function (row, data) {
            // Eliminar cambio de color basado en el estado "Ganador"
            // Si no deseas cambiar el color, simplemente elimina o comenta la siguiente línea:
            // if (data.status != "Ganador") {
            //     $(row).css("background-color", "#ffe5e5"); // Color rojo bajito
            // } else {
            //     $(row).css("background-color", "#e7ffe5"); //
            // }
        },
        drawCallback: function () {
            if ($(window).width() <= 576) {
                $(".dataTables_paginate, .dataTables_length, .dataTables_info").hide();
            } else {
                $(".dataTables_paginate, .dataTables_filter, .dataTables_info").show();
                $(".dataTables_length").hide();
            }
        },
    });
    $("#listapostadores").modal("show");
}
