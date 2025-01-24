const API_RUTA = "http://localhost/bet-marinera/public/api";
const WEB_RUTA = "http://localhost/bet-marinera/public";
const DATA_SRC_FUNCTION = function (json) {
    // Usamos la constante TOTAL_RECORDS_PATH para acceder a json.meta.total
    const totalRecords = json?.meta?.total ?? 0;  // Usamos valor por defecto (0) si no existe
    json.recordsTotal = totalRecords;
    json.recordsFiltered = totalRecords;  // Si no hay filtrado, usas el mismo total

    return json.data; // Devuelve los datos de la tabla
};

const DATATABLES_LANGUAGE_ES = {
    processing: "Procesando...",
    search: "Buscar:",
    lengthMenu: "Mostrar _MENU_ registros",
    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
   
    infoFiltered: "(filtrado de _MAX_ registros totales)",
    infoPostFix: "",
    info: "Mostrando _START_ a _END_ de _TOTAL_ registros", // Información general
    infoEmpty: "Mostrando 0 a 0 de 0 registros", // Cuando no hay registros
   
    loadingRecords: "Cargando...",
    zeroRecords: "No se encontraron resultados",
    emptyTable: "No hay datos disponibles en la tabla",
    paginate: {
        first: "Primero",
        previous: "Anterior",
        next: "Siguiente",
        last: "Último",
    },
    aria: {
        sortAscending: ": activar para ordenar la columna de manera ascendente",
        sortDescending:
            ": activar para ordenar la columna de manera descendente",
    },
};

function logout() {
    $.ajax({
        url: API_RUTA + "/logout", // Ruta de cierre de sesión
        type: "GET", // Usamos POST para cerrar sesión
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"), // Si usas un token de autorización
        },
        success: function (response) {
            // Si la sesión se cierra correctamente, redirige al login
            window.location.href = WEB_RUTA + "/log-in"; // Redirige a la página de login
        },
        error: function (xhr, status, error) {
            // Si hay un error en la solicitud, muestra un mensaje
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo cerrar sesión. Intenta nuevamente.",
            });
        },
    });
}

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

                $("#usernamebarra").text(
                    response.user.first_name + " " + response.user.last_name
                );
                $("#usernamebarra2").text(
                    response.user.first_name + " " + response.user.last_name
                );
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
            if (xhr.status === 401) {
                window.location.href =
                    "http://localhost/bet-marinera/public/log-in";
            }
            // Si hay un error con la solicitud o el token es inválido
            console.log("Error al verificar autenticación:", error);
            window.location.href =
                "http://localhost/bet-marinera/public/log-in"; // Redirige al login en caso de error
        },
    });
    return "ok";
}
