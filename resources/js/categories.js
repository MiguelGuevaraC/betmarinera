// Mostrar las categorías del concurso
function showCategories(id) {
    $("#contestId").val(id);
    $("#categoryTable").DataTable({
        language: DATATABLES_LANGUAGE_ES, // Idioma en español
        processing: true, // Mostrar indicador "Cargando"
        serverSide: true, // Activar procesamiento del lado del servidor
        destroy: true, // Eliminar instancia anterior al crear una nueva
        pageLength: 5, // Número de registros por página
        lengthMenu: [5, 10, 25, 50], // Opciones de registros por página
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate, // Optimiza para móviles
                type: 'inline'
            }
        },
        autoWidth: false, // Deshabilitar ancho automático para mejorar diseño en móviles
        pagingType: 'simple_numbers',

        ajax: {
            url: API_RUTA + "/list-categories", // Ruta para obtener las categorías
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data: function(d) {
                // Parámetros adicionales de la solicitud AJAX
                return {
                    contest_id: $("#contestId").val(), // ID del concurso
                    page: (d.start / d.length) + 1, // Página actual
                    per_page: d.length, // Cantidad de registros por página
                    search: d.search.value // Valor del campo de búsqueda
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
            { 
                data: null, 
                title: "Acción", 
                render: function(data) {
                    return `<button class="btn btn-danger btn-sm mx-auto d-block" onclick="removeCategory(${data.id})">
                                <i class="fa fa-trash"></i>
                            </button>`;
                },
            },
        ], columnDefs: [
            {
                targets: 1, // Índice de la columna "Acción"
                width: '10%' // Ancho del 20%
            }
        ],
        drawCallback: function(settings) {
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
        }
    });

    // Mostrar el modal
    $("#addCategoryModal").modal("show");
}


$(document).ready(function () {
    // Manejador de envío del formulario dentro del modal
    $(document).on("submit", "#addCategoryForm", function (e) {
        e.preventDefault(); // Prevenir recarga de página

        // Obtener valores del formulario
        const categoryName = $("#categoryName").val().trim();
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
            url: API_RUTA + "/categories", // Ruta para agregar la categoría
            method: "POST",
            data: {
                name: categoryName, // Nombre de la categoría
                contest_id: contestId, // ID del concurso
            },
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Token si es necesario
            },
            success: function (response) {
                // Limpiar el formulario
                $("#categoryName").val("");

                // Recargar la tabla de categorías
                if ($.fn.DataTable.isDataTable("#categoryTable")) {
                    $("#categoryTable").DataTable().ajax.reload(null, false);
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
                    window.location.href =
                    "http://localhost/bet-marinera/public/log-in";
                } else{
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

