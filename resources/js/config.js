const API_RUTA = "http://localhost/bet-marinera/public/api";
const WEB_RUTA = "http://localhost/bet-marinera/public";

function verifyToken(token) {
    $.ajax({
        url: API_RUTA + "/authenticate", // Ruta del backend para verificar el token
        type: "GET", // Usamos GET porque es solo una verificación
        dataType: "json",
        headers: {
            Authorization: "Bearer " + token, // Enviar el token en el encabezado
        },
        beforeSend: function () {
            // Puedes agregar un spinner o algo para indicar que se está verificando
            console.log("Verificando autenticación...");
        },
        success: function (response) {
            // Si la respuesta indica que el token es válido
            if (response.message == "Autenticado") {
                console.log("Authenticado");
           
                $("#usernamebarra").text(response.user.first_name + " "+response.user.last_name);
                $("#usernamebarra2").text(response.user.first_name + " "+response.user.last_name);
                $("#typeuser").text(response.user.rol.name);
            } else if (response.message == "SinPermiso") {
                window.location.href =
                    "http://localhost/bet-marinera/public/403"; // Redirige al login si el token no es válido
            } else {
                // Si la respuesta no indica que está autenticado
                console.log("Token inválido o expirado.");
                window.location.href =
                    "http://localhost/bet-marinera/public/log-in"; // Redirige al login si el token no es válido
            }
        },
        error: function (xhr, status, error) {
            // Si hay un error con la solicitud o el token es inválido
            console.log("Error al verificar autenticación:", error);
            window.location.href =
                "http://localhost/bet-marinera/public/log-in"; // Redirige al login en caso de error
        },
    });
    return "ok";
}
