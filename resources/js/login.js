function showCreateUserModal() {
    $("#createUserModal").modal("show");
}

function validateEmailBtn() {
    var email = $("#emailregister").val();
    if (email === '' || !email.includes("@")) {
        Swal.fire({
            icon: "error",
            title: "Error en el correo",
            html: "El campo debe estar lleno y contener un '@' para ser válido.", // Mensaje de error claro
        });
        return; // Detenemos la ejecución si el correo no es válido
    }

    // Realizar la solicitud AJAX
    $.ajax({
        url: API_RUTA +"/validatemail", // Ruta donde se enviará la solicitud
        method: "POST",
        headers: {
            Authorization: "Bearer " +  "ZXCV-CVBN-VBNM", // Reemplaza por tu token fijo
        },
        data: {
            email: email, // Enviar el correo al backend
        },
        success: function (response) {
        
                Swal.fire({
                    icon: "succes",
                    title: "Correo Enviado",
                    html: "Verificar y Digitar el token que se ha enviado",
                });
          
        },
        error: function () {
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


$("#registerProfessionalForm").on("submit", function (e) {
    e.preventDefault(); // Prevenimos el comportamiento predeterminado del formulario

    // Obtener los datos del formulario
    var formData = $(this).serialize(); // Recopila todos los datos del formulario
    var name = $("#name").val(); // Nombre
    var lastName = $("#lastName").val(); // Apellido
    var email = $("#emailregister").val(); // Correo
    var password = $("#password").val(); // Contraseña
    var token = $("#token").val(); // Contraseña
    // Enviar solicitud AJAX para registrar al usuario
    $.ajax({
        url: API_RUTA + "/registerUser", // Reemplaza con la ruta real de tu backend
        method: "POST",
        headers: {
            Authorization: "Bearer " + "ZXCV-CVBN-VBNM", // Reemplaza por tu token válido
        },
        data: { 
            name: name, 
            lastName: lastName, 
            email: email, 
            password: password ,
            token: token 
        }, // Enviar los datos del formulario al backend
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Registro exitoso",
                html: "Tu registro se ha realizado correctamente. Revisa tu correo para más instrucciones.",
            });

            // Habilitar el campo de token después del éxito
            $("#tokenField").removeClass("d-none"); // Asegúrate de que el campo de token tenga esta clase para ocultarlo inicialmente
        },
        error: function (error) {
            if (error.status === 422) {
                const errors = error.responseJSON.message;

                let errorMessages = "<ul>";
                errors.forEach(function (error) {
                    errorMessages += `<li>${error}</li>`;
                });
                errorMessages += "</ul>";

                Swal.fire({
                    icon: "error",
                    title: "Errores de validación",
                    html: errorMessages,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error en el registro",
                    text: "Hubo un problema al registrar al usuario. Intente nuevamente.",
                });
            }
        },
    });
});
