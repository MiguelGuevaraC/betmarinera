$(document).ready(function () {
    verifyToken(localStorage.getItem("token"), "concursos-list");
});

function mostrarCrearConcursoModal() {
    // Obtener la fecha actual
    const fechaActual = new Date();
    const anio = fechaActual.getFullYear();
    const mes = String(fechaActual.getMonth() + 1).padStart(2, "0"); // Mes (0-indexed, +1 para ajustarlo)
    const dia = String(fechaActual.getDate()).padStart(2, "0");
    const inicioDia = `${anio}-${mes}-${dia}T00:00`;
    const finDia = `${anio}-${mes}-${dia}T23:59`;
    $("#start_date").val(inicioDia);
    $("#end_date").val(finDia);
    $("#crearConcursoModal").modal("show");
}

$("#crearConcursoForm").submit(function (event) {
    event.preventDefault(); // Evita el envío tradicional del formulario

    // Recoge los valores de los campos
    var nombre = $("#name").val();
    var fechaInicio = $("#start_date").val();
    var fechaFin = $("#end_date").val();

    // Verifica que los campos no estén vacíos

    $.ajax({
        url: API_RUTA + "/contest", // Ajusta la URL según tu API
        method: "POST",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas un token de autorización
        },
        data: {
            name: nombre,
            start_date: fechaInicio,
            end_date: fechaFin,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Concurso creado con éxito",
                text: "El concurso ha sido guardado correctamente.",
                timer: 2000,
                showConfirmButton: false,
            });
            $("#crearConcursoModal").modal("hide"); // Cierra el modal
            if ($.fn.DataTable.isDataTable("#table-contant")) {
                // Recarga la tabla de DataTables
                $("#table-contant").DataTable().ajax.reload(null, false);
            }
        },
        error: function (error) {
            if (error.status === 422) {
                const errors = error.responseJSON.message; // Asumiendo que el mensaje es un string

                let errorMessages = "<ul>";
                errorMessages += `<li>${errors}</li>`; // Añadir el mensaje de error al listado
                errorMessages += "</ul>";

                Swal.fire({
                    icon: "error",
                    title: "Errores de validación",
                    html: errorMessages, // Utiliza HTML para mostrar la lista de errores
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error al crear el concurso",
                    text: "Hubo un problema al guardar el concurso. Intente nuevamente.",
                });
            }
        },
    });
});

function editContest(id, name, start_date, end_date) {
    // Muestra el modal de edición
    $("#editConcursoModal").modal("show");

    // Llena los campos del formulario con los valores actuales
    $("#editName").val(name);
    $("#editStartDate").val(start_date);
    $("#editEndDate").val(end_date);

    // Si deseas, puedes guardar el ID en un campo oculto para usarlo al enviar el formulario
    $("#editContestId").val(id);
}

$("#editConcursoForm").submit(function (event) {
    event.preventDefault(); // Evita el envío tradicional del formulario

    // Recoge los valores de los campos
    var id = $("#editContestId").val();
    var nombre = $("#editName").val();
    var fechaInicio = $("#editStartDate").val();
    var fechaFin = $("#editEndDate").val();

    // Realiza la solicitud AJAX para actualizar el concurso
    $.ajax({
        url: API_RUTA + "/contest/" + id, // Ajusta la URL según tu API
        method: "PUT",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas token de autorización
        },
        data: {
            name: nombre,
            start_date: fechaInicio,
            end_date: fechaFin,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Concurso actualizado con éxito",
                text: "El concurso ha sido actualizado correctamente.",
                timer: 2000,
                showConfirmButton: false,
            });
            $("#editConcursoModal").modal("hide"); // Cierra el modal

            // Actualiza la tabla de DataTables
            if ($.fn.DataTable.isDataTable("#table-contant")) {
                $("#table-contant").DataTable().ajax.reload(null, false);
            }
        },
        error: function (error) {
            // Verifica si el error es de validación (422)
            if (error.status === 422) {
                const errors = error.responseJSON.message; // Asumiendo que el mensaje es un string

                let errorMessages = "<ul>";
                errorMessages += `<li>${errors}</li>`; // Añadir el mensaje de error al listado
                errorMessages += "</ul>";

                // Muestra los errores en una alerta
                Swal.fire({
                    icon: "error",
                    title: "Errores de validación",
                    html: errorMessages, // Muestra los errores como lista
                });
            } else {
                // Si no es un error de validación, muestra un error genérico
                Swal.fire({
                    icon: "error",
                    title: "Error al actualizar el concurso",
                    text: "Hubo un problema al actualizar el concurso. Intente nuevamente.",
                });
            }
        },
    });
});

// Función para mostrar el botón de eliminar
function deleteContest(id) {
    // Confirmación con SweetAlert antes de eliminar
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esta acción!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud AJAX para eliminar el concurso
            $.ajax({
                url: API_RUTA + "/contest/" + id, // Ajusta la URL según tu API
                method: "DELETE",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas token de autorización
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Concurso eliminado",
                        text: "El concurso ha sido eliminado correctamente.",
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    // Actualiza la tabla de DataTables
                    if ($.fn.DataTable.isDataTable("#table-contant")) {
                        $("#table-contant")
                            .DataTable()
                            .ajax.reload(null, false);
                    }
                },
                error: function (error) {
                    // Verifica si el error es de validación (422)
                    if (error.status === 422) {
                        const errors = error.responseJSON.message; // Asumiendo que el mensaje es un string

                        let errorMessages = "<ul>";
                        errorMessages += `<li>${errors}</li>`; // Añadir el mensaje de error al listado
                        errorMessages += "</ul>";

                        // Muestra los errores en una alerta
                        Swal.fire({
                            icon: "error",
                            title: "Errores de validación",
                            html: errorMessages, // Muestra los errores como lista
                        });
                    } else {
                        // Si no es un error de validación, muestra un error genérico
                        Swal.fire({
                            icon: "error",
                            title: "Error al actualizar el concurso",
                            text: "Hubo un problema al actualizar el concurso. Intente nuevamente.",
                        });
                    }
                },
            });
        }
    });
}

function finalizeBet(id) {
    // Mostrar la alerta de confirmación
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción finalizará la apuesta.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, finalizar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar la solicitud AJAX
            $.ajax({
                url: API_RUTA + `/contest/${id}/statusfinalizado`, // Ruta dinámica con el ID
                type: "POST",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas token de autorización
                },
                data: {
                    _method: "PUT", // Laravel utiliza PUT para actualizar
                    _token: $('meta[name="csrf-token"]').attr("content"), // Token CSRF
                },
                success: function (response) {
                    // Manejar la respuesta exitosa
                    Swal.fire(
                        "¡Finalizado!",
                        "La apuesta ha sido finalizada exitosamente.",
                        "success"
                    );
                    if ($.fn.DataTable.isDataTable("#table-contant")) {
                        $("#table-contant")
                            .DataTable()
                            .ajax.reload(null, false);
                    }
                    // Opcional: Actualizar la interfaz o tabla
                },
                error: function (xhr) {
                    // Manejar errores
                    Swal.fire(
                        "Error",
                        "Hubo un problema al finalizar la apuesta. Por favor, intenta de nuevo.",
                        "error"
                    );
                },
            });
        }
    });
}

function activateContest(id) {
    // Mostrar la alerta de confirmación
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción activará el concurso para apuestas.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, activar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar la solicitud AJAX
            $.ajax({
                url: API_RUTA + `/contest/${id}/statusactivo`, // Ruta dinámica para activar el concurso
                type: "POST",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas token de autorización
                },
                data: {
                    _method: "PUT", // Laravel utiliza PUT para actualizar
                    _token: $('meta[name="csrf-token"]').attr("content"), // Token CSRF
                },
                success: function (response) {
                    // Manejar la respuesta exitosa
                    Swal.fire(
                        "¡Activado!",
                        "El concurso ha sido activado para apuestas exitosamente.",
                        "success"
                    );
                    if ($.fn.DataTable.isDataTable("#table-contant")) {
                        $("#table-contant")
                            .DataTable()
                            .ajax.reload(null, false);
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
    });
}

function addWinner(id) {
    $("#contestantsWinCategoryTable").DataTable({
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
            url: API_RUTA + "/list-categories",
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
            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = WEB_RUTA + "/log-in"; // Reemplazar con la URL de tu página de login
                } else {
                    console.error("Error: " + error);
                }
                Swal.close();
            },
            dataSrc: DATA_SRC_FUNCTION,
        },
        columns: [
            { data: "name", title: "Nombre" },
            { data: "names_contestant_win", title: "Ganador" },
            {
                data: "id",
                title: "Acción",
                render: function (data, type, row) {
                    return `
                    <select class="form-control select-contestant custom-select-width" 
                            data-id="${row.id}" 
                            data-contest-id="${row.contest_id}" 
                            data-contestantwin-id="${row.contestant_win_id}">
                        <option value="" disabled>Seleccionar...</option>
                    </select>
               `;
                },
            },
        ],
        columnDefs: [
            {
                targets: 0,
                width: "35%",
            },
            {
                targets: 1,
                width: "35%",
            },
            {
                targets: 2,
                width: "30%",
            },
        ],
        createdRow: function (row, data) {
            if (data.names_contestant_win === "Sin Ganador") {
                $(row).css("background-color", "#ffe5e5"); // Color rojo bajito
            } else {
                $(row).css("background-color", "#e7ffe5"); // Color rojo bajito
            }
        },
        drawCallback: function () {
            $(".select-contestant").each(function () {
                const $select = $(this);
                const categoryId = $select.data("id");
                const contestId = $select.data("contest-id");
                const contestantWinId = $select.data("contestantwin-id");

                // Inicializar select2
                $select.select2({
                    placeholder: "Seleccionar concursante...",
                    allowClear: true,
                    ajax: {
                        url: API_RUTA + "/list-contestants",
                        method: "GET",
                        headers: {
                            Authorization:
                                "Bearer " + localStorage.getItem("token"),
                        },
                        data: function (params) {
                            return {
                                category_id: categoryId,
                                contest_id: contestId,
                                search: params.term || "",
                            };
                        },
                        error: function (xhr, status, error) {
                            if (xhr.status === 401) {
                                window.location.href = WEB_RUTA + "/log-in"; // Reemplazar con la URL de tu página de login
                            } else {
                                console.error("Error: " + error);
                            }
                            Swal.close();
                        },
                        delay: 500,
                        processResults: function (data) {
                            return {
                                results: data.data.map(function (item) {
                                    return {
                                        id: item.id,
                                        text: item.names,
                                    };
                                }),
                            };
                        },
                        cache: true,
                    },
                });

                // Agregar evento change al select para enviar el PUT
                $select.on("change", function () {
                    const selectedContestantWinId = $(this).val(); // Obtener el id del concursante seleccionado
                    const categoryId = $select.data("id");

                    if (selectedContestantWinId) {
                        // Realizar el PUT para actualizar el ganador
                        $.ajax({
                            url: API_RUTA + `/categories/${categoryId}/win`,
                            method: "PUT",
                            headers: {
                                Authorization:
                                    "Bearer " + localStorage.getItem("token"),
                            },
                            data: {
                                contestantwin_id: selectedContestantWinId, // Enviar el id del concursante como contestantwin_id
                            },
                            success: function (response) {
                                if (
                                    $.fn.DataTable.isDataTable("#table-contant")
                                ) {
                                    // Recarga la tabla de DataTables
                                    $("#contestantsWinCategoryTable")
                                        .DataTable()
                                        .ajax.reload(null, false);
                                }
                            },
                            error: function (error) {
                                if (error.status === 422) {
                                    const errors = error.responseJSON.message; // Asumiendo que el mensaje es un string

                                    let errorMessages = "<ul>";
                                    errorMessages += `<li>${errors}</li>`; // Añadir el mensaje de error al listado
                                    errorMessages += "</ul>";

                                    Swal.fire({
                                        icon: "error",
                                        title: "Errores de validación",
                                        html: errorMessages, // Utiliza HTML para mostrar la lista de errores
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error al crear el concurso",
                                        text: "Hubo un problema al guardar el concurso. Intente nuevamente.",
                                    });
                                }
                            },
                        });
                    }
                });
            });

            if ($(window).width() <= 576) {
                $(
                    ".dataTables_paginate, .dataTables_length, .dataTables_info"
                ).hide();
            } else {
                $(
                    ".dataTables_paginate, .dataTables_filter, .dataTables_info"
                ).show();
                $(".dataTables_length").hide();
            }
        },
    });
    $("#contestantWinCategory").modal("show");
}

function downloadWinnersReport(contestId, namecontest) {
    // Deshabilitar el botón para evitar múltiples clics
    let button = document.querySelector("button");
    button.disabled = true;

    let url = API_RUTA;  // Asegúrate de que API_RUTA esté bien definida en tu código.

    // Mostrar SweetAlert para elegir entre PDF o Excel
    Swal.fire({
        title: "Selecciona el formato",
        text: "Elige si deseas descargar el reporte en PDF o Excel",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "PDF",
        cancelButtonText: "Excel",
    }).then((result) => {
        // Actualizar la URL según el formato seleccionado
        if (result.isConfirmed) {
            url = url + `/exportContestPDFReport/${contestId}`;
        } else if (result.isDismissed) {
            url = url + `/exportContestReport/${contestId}`;
        }

        // Realizar la solicitud AJAX para descargar el archivo
        $.ajax({
            url: url,
            method: "GET",
            xhrFields: {
                responseType: "blob", // Necesario para manejar archivos binarios como PDF o Excel
            },
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),  // Asegúrate de que el token esté disponible
            },
            success: function (response) {
                // Crear un enlace temporal para descargar el archivo
                const fileUrl = window.URL.createObjectURL(response);
                const a = document.createElement("a");
                a.href = fileUrl;

                // Verificar el tipo de archivo para poner la extensión correcta
                if (result.isConfirmed) {
                    a.download = "Reporte-" + namecontest + ".pdf";  // Si es PDF
                } else {
                    a.download = "Reporte-" + namecontest + ".xlsx";  // Si es Excel
                }

                document.body.appendChild(a);
                a.click();
                a.remove();
            },
            error: function (xhr, status, error) {
                alert("Ocurrió un error al descargar el reporte.");
            },
            complete: function () {
                // Habilitar el botón nuevamente después de la respuesta
                button.disabled = false;
            },
        });
    });
}


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
            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = WEB_RUTA + "/log-in"; // Reemplazar con la URL de tu página de login
                } else {
                    console.error("Error: " + error);
                }
                Swal.close();
            },
            dataSrc: function (json) {
                // Verificar que cada objeto de datos tenga "name_apostador" y "score"
                json.data.forEach(function (row) {
                    if (
                        !row.hasOwnProperty("name_apostador") ||
                        !row.hasOwnProperty("score")
                    ) {
                        row.name_apostador = "No Disponible";
                        row.score = "0"; // Asignar valores predeterminados si faltan
                    }
                });
                return json.data;
            },
        },
        columns: [
            { data: "name_apostador", title: "Nombre" },
            { data: "score", title: "Puntaje" },
        ],
        columnDefs: [
            {
                targets: 0,
                width: "70%",
            },
            {
                targets: 1,
                width: "30%",
            },
        ],
        createdRow: function (row, data) {
            // Verificar si hay un ganador y aplicar el fondo
            if (data.status !== "Ganador") {
                $(row).css("background-color", "#ffe5e5"); // Color rojo bajito
            } else {
                $(row).css("background-color", "#e7ffe5"); // Color verde para ganador
            }
        },
        drawCallback: function () {
            if ($(window).width() <= 576) {
                $(
                    ".dataTables_paginate, .dataTables_length, .dataTables_info"
                ).hide();
            } else {
                $(
                    ".dataTables_paginate, .dataTables_filter, .dataTables_info"
                ).show();
                $(".dataTables_length").hide();
            }
        },
    });
    $("#listapostadores").modal("show");
}
