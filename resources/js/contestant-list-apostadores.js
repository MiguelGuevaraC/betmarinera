$(document).ready(function () {
    verifyToken(localStorage.getItem("token"), "concursos-apostadores");
});

$(document).ready(function () {
    var retryCount = 0; // Contador de intentos
    var maxRetries = 3; // Máximo de intentos permitidos

    function loadDataTable() {
        $("#table-contant").DataTable({
            destroy: true, // Permite recargar la tabla
            processing: true, // Muestra indicador de carga
            serverSide: true, // Activar procesamiento del lado del servidor
            responsive: true, // Comportamiento responsivo
            ajax: {
                url: API_RUTA + "/list-contest-apostadores", // Ruta a tu API
                type: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                data: function (d) {
                    return {
                        page: d.start / d.length + 1,
                        per_page: d.length,
                        search: d.search.value,
                    };
                },
                dataSrc: DATA_SRC_FUNCTION,
                error: function (xhr, textStatus, errorThrown) {
                    retryCount++; // Incrementa el contador de intentos
                    if (retryCount <= maxRetries) {
                        console.warn(`Error en DataTable. Reintentando... (${retryCount}/${maxRetries})`);
                        setTimeout(loadDataTable, 2000); // Espera 2 segundos antes de reintentar
                    } else {
                        console.error("Error en DataTable después de varios intentos:", errorThrown);
                    }
                },
            },
            columns: [
                { data: "contest.name", name: "contest.name", title: "Nombre" },
                { 
                    data: "contest.created_at", 
                    name: "contest.created_at", 
                    title: "F. Creación",
                    render: function (data) { return data || "-"; } 
                },
                { 
                    data: "created_at", 
                    name: "created_at", 
                    title: "F. Apuesta",
                    render: function (data) { return data || "-"; } 
                },
                { 
                    data: "contest.status", 
                    name: "contest.status", 
                    title: "Estado",
                    render: function (data) { return data || "-"; } 
                },
                { 
                    data: "action", 
                    name: "action", 
                    title: "Acciones",
                    render: function (data) { return data || "-"; },
                    className: "text-center",
                },
            ],
            columnDefs: [
                { targets: [3, 4], width: "50px", className: "text-center" },
            ],
            language: DATATABLES_LANGUAGE_ES,
        });
    }

    loadDataTable(); // Cargar la tabla inicialmente
});


function viewBetDetails(id) {
    $("#misapuestasTable").DataTable({
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
            url: API_RUTA + "/list-categories-contest-active",
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
            { data: "name", title: "Categoría" },
            { 
                data: "bet", 
                title: "Apuesta",
                render: function(data, type, row) {
                    return (data && data.contestant && data.contestant.names) ? data.contestant.names : "Sin apuesta";
                }
            }
        ],
        
        
        columnDefs: [],
        createdRow: function (row, data) {

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
    $("#misapuestas").modal("show");
}

function downloadWinnersReport(contestId, namecontest) {
    // Obtener el botón que disparó la acción
    let button = event.target;
    button.disabled = true; // Deshabilitar el botón para evitar múltiples clics

    let url = API_RUTA; // Asegurar que API_RUTA esté definida

    // Mostrar SweetAlert para elegir entre PDF o Excel
    Swal.fire({
        title: "Selecciona el formato",
        text: "Elige si deseas descargar el reporte en PDF o Excel",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "PDF",
        cancelButtonText: "Excel",
    }).then((result) => {
        // Si el usuario cierra la alerta sin seleccionar, no hacer nada
        if (result.dismiss === Swal.DismissReason.cancel) {
            url += `/exportContestReport/${contestId}`; // Descargar Excel
        } else if (result.isConfirmed) {
            url += `/exportContestPDFReport/${contestId}`; // Descargar PDF
        } else {
            button.disabled = false; // Rehabilitar el botón si no se seleccionó nada
            return; // Salir sin hacer la solicitud AJAX
        }

        // Realizar la solicitud AJAX para descargar el archivo
        $.ajax({
            url: url,
            method: "GET",
            xhrFields: {
                responseType: "blob", // Para manejar archivos binarios (PDF/Excel)
            },
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token de autenticación
            },
            success: function (response) {
                const fileUrl = window.URL.createObjectURL(response);
                const a = document.createElement("a");
                a.href = fileUrl;

                // Determinar el nombre del archivo según el formato elegido
                a.download = `Reporte-${namecontest}.${result.isConfirmed ? "pdf" : "xlsx"}`;

                document.body.appendChild(a);
                a.click();
                a.remove();
            },
            error: function () {
                Swal.fire("Error", "Ocurrió un error al descargar el reporte.", "error");
            },
            complete: function () {
                button.disabled = false; // Rehabilitar el botón al finalizar
            },
        });
    });
}
function downloadWinnersReportMiApuesta(contestId, namecontest) {
    // Obtener el botón que disparó la acción
    let button = event.target;
    button.disabled = true; // Deshabilitar el botón para evitar múltiples clics

    let url = API_RUTA; // Asegurar que API_RUTA esté definida

    // Mostrar SweetAlert para elegir entre PDF o Excel
    Swal.fire({
        title: "Selecciona el formato",
        text: "Elige si deseas descargar el reporte en PDF o Excel",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "PDF",
        cancelButtonText: "Excel",
    }).then((result) => {
        // Si el usuario cierra la alerta sin seleccionar, no hacer nada
        if (result.dismiss === Swal.DismissReason.cancel) {
            url += `/exportContestReportMiApuesta/${contestId}`; // Descargar Excel
        } else if (result.isConfirmed) {
            url += `/exportContestPDFReportMiApuesta/${contestId}`; // Descargar PDF
        } else {
            button.disabled = false; // Rehabilitar el botón si no se seleccionó nada
            return; // Salir sin hacer la solicitud AJAX
        }

        // Realizar la solicitud AJAX para descargar el archivo
        $.ajax({
            url: url,
            method: "GET",
            xhrFields: {
                responseType: "blob", // Para manejar archivos binarios (PDF/Excel)
            },
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token de autenticación
            },
            success: function (response) {
                const fileUrl = window.URL.createObjectURL(response);
                const a = document.createElement("a");
                a.href = fileUrl;

                // Determinar el nombre del archivo según el formato elegido
                a.download = `Reporte-${namecontest}.${result.isConfirmed ? "pdf" : "xlsx"}`;

                document.body.appendChild(a);
                a.click();
                a.remove();
            },
            error: function () {
                Swal.fire("Error", "Ocurrió un error al descargar el reporte.", "error");
            },
            complete: function () {
                button.disabled = false; // Rehabilitar el botón al finalizar
            },
        });
    });
}