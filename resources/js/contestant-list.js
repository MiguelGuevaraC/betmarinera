$(document).ready(function () {
    verifyToken(localStorage.getItem('token'));
});

// $('#addCategoryModal').on('hidden.bs.modal', function () {
//     if ($.fn.DataTable.isDataTable("#table-contant")) {
//         // Recarga la tabla de DataTables
//         $("#table-contant").DataTable().ajax.reload(null, false);
//     }
// });

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
    $('#editConcursoModal').modal('show');

    // Llena los campos del formulario con los valores actuales
    $('#editName').val(name);
    $('#editStartDate').val(start_date);
    $('#editEndDate').val(end_date);

    // Si deseas, puedes guardar el ID en un campo oculto para usarlo al enviar el formulario
    $('#editContestId').val(id);
}


$('#editConcursoForm').submit(function(event) {
    event.preventDefault(); // Evita el envío tradicional del formulario

    // Recoge los valores de los campos
    var id = $('#editContestId').val();
    var nombre = $('#editName').val();
    var fechaInicio = $('#editStartDate').val();
    var fechaFin = $('#editEndDate').val();

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
        success: function(response) {
            Swal.fire({
                icon: "success",
                title: "Concurso actualizado con éxito",
                text: "El concurso ha sido actualizado correctamente.",
                timer: 2000,
                showConfirmButton: false,
            });
            $('#editConcursoModal').modal('hide'); // Cierra el modal

            // Actualiza la tabla de DataTables
            if ($.fn.DataTable.isDataTable("#table-contant")) {
                $("#table-contant").DataTable().ajax.reload(null, false);
            }
        },
        error: function(error) {
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
        }
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
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Concurso eliminado",
                        text: "El concurso ha sido eliminado correctamente.",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                    
                    // Actualiza la tabla de DataTables
                    if ($.fn.DataTable.isDataTable("#table-contant")) {
                        $("#table-contant").DataTable().ajax.reload(null, false);
                    }
                },
                error: function(error) {
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
                }
            });
        }
    });
}
