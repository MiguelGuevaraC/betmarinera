$(document).ready(function () {
    const contestId = $("#contestId").val();
    // Inicializar Select2 cuando el modal se muestre
    $("#contestantCategory").select2({
        placeholder: "Buscar categoría...",
        allowClear: true,
        ajax: {
            url: API_RUTA + "/list-categories", // Ruta para obtener las categorías
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token de autenticación
            },
            data: function (params) {
                // Obtener contestId cada vez que el usuario escribe
                const contestId = $("#contestId").val();
                return {
                    contest_id: contestId, // Enviar el contest_id actualizado
                    search: params.term || '', // Enviar el término de búsqueda (params.term)
                };
            },
            delay: 400, // Retardo en milisegundos para evitar hacer peticiones muy rápidas
            processResults: function (data) {
                // Transformar los datos para que Select2 pueda mostrarlos correctamente
                return {
                    results: data.data.map(function (item) {
                        return {
                            
                            id: item.id, // El valor que se enviará al servidor al seleccionar una opción
                            text: item.name, // El texto que se mostrará en el select
                        };
                    }),
                };
            },
            cache: true, // Para evitar realizar las mismas peticiones múltiples veces
        },
    });
});

function showContestants(id) {
    $("#contestId").val(id);
    $("#contestantTable").DataTable({
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
            { data: "category.name", title: "Categoría" },
            {
                data: null,
                title: "Acción",
                render: function (data) {
                    return `
                        <button class="btn btn-danger btn-sm mx-auto d-block" onclick="removeContestant(${data.id})">
                            <i class="fa fa-trash"></i>
                        </button>`;
                },
            },
        ],
        columnDefs: [
            {
                targets: 3, // Índice de la columna "Acción"
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
                $(".dataTables_length").show(); // Mostrar longitud de página
                $(".dataTables_filter").show(); // Mostrar filtro
                $(".dataTables_info").show();
            }
        },
    });
    $("#addContestantModal").modal("show");
}

$(document).ready(function () {
    // Manejador de envío del formulario dentro del modal
    $(document).on("submit", "#addContestantForm", function (e) {
        e.preventDefault(); // Prevenir recarga de página

        // Obtener valores del formulario
        const contestantName = $("#contestantName").val();
        const contestantDescription = $("#contestantDescription").val();
        const contestantCategory = $("#contestantCategory").val();
        const contestId = $("#contestId").val();

        // Validar entrada
        if (!categoryName) {
            Swal.fire({
                icon: "warning",
                title: "Campo Requerido",
                text: "Por favor, ingrese el nombre de la categoría.",
            });
            return;
        }

        // Realizar la solicitud AJAX
        $.ajax({
            url: API_RUTA + "/contestant", // Ruta para agregar la categoría
            method: "POST",
            data: {
                names: contestantName,
                description: contestantDescription,
                category_id: contestantCategory,
                contest_id: contestId,
            },
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token si es necesario
            },
            success: function (response) {
                // Limpiar el formulario
                $("#categoryName").val("");

                $("#contestantName").val("");
                $("#contestantDescription").val("");

                // Recargar la tabla de categorías

                if ($.fn.DataTable.isDataTable("#contestantTable")) {
                    $("#contestantTable").DataTable().ajax.reload(null, false);
                    $("#table-contant").DataTable().ajax.reload(null, false);
                }
                Swal.fire({
                    icon: "success",
                    title: "Categoría Agregada",
                    text: "La categoría se agregó correctamente.",
                });
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
    });
});
