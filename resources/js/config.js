const API_RUTA = "http://137.184.71.147:82/betmarinera/public/api";
const WEB_RUTA = "http://137.184.71.147:82/betmarinera/public";

// const API_RUTA = "http://localhost/bet-marinera/public/api";
// const WEB_RUTA = "http://localhost/bet-marinera/public";
const DATA_SRC_FUNCTION = function (json) {
    // Asegurarse de que json tiene la propiedad meta y meta.total
    const totalRecords =
        json && json.meta && json.meta.total ? json.meta.total : 0;
    json.recordsTotal = totalRecords;
    json.recordsFiltered = totalRecords; // Si no hay filtrado, usamos el mismo total

    // Verificar que json.data esté presente y sea un array
    return Array.isArray(json.data) ? json.data : [];
};
console.log("config.js");

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

function verifyToken(token, ruta) {
    $.ajax({
        url: API_RUTA + "/authenticate", // Ruta del backend para verificar el token
        type: "GET", // Usamos GET porque es solo una verificación
        dataType: "json",
        headers: {
            Authorization: "Bearer " + token, // Enviar el token en el encabezado
        },
        data: {
            route: ruta ?? "home",
        },
        beforeSend: function () {
            // Puedes agregar un spinner o algo para indicar que se está verificando
            console.log("Verificando autenticación...");
        },
        success: function (response) {
            // Si la respuesta indica que el token es válido
            if (response.message == "Autenticado") {
                console.log("Autenticado");

                // Actualizar los elementos del DOM con los datos del usuario
                $("#usernamebarra").text(
                    response.user.first_name + " " + response.user.last_name
                );
                $("#usernamebarra2").text(
                    response.user.first_name + " " + response.user.last_name
                );
                $("#typeuser").text(response.user.rol.name);

                // Obtener los permisos del usuario desde la respuesta
                var permissions = response.user.rol.permissions;

                var $navPermissions = $("#navpermissions");

                // Limpiar el menú antes de agregar los nuevos ítems
                $navPermissions.empty();
                $navPermissions.append(
                    '<li class="nav-header">Menú de Navegación</li>'
                ); // Agregar el ítem al menú
                // Definir los ítems del menú
                var menuItems = [
                    { name: "Inicio", route: "home", icon: "fa-home" },
                    { name: "Apostadores", route: "users", icon: "fa-users" },
                    {
                        name: "Concursos",
                        route: "concursos-list",
                        icon: "fa-trophy",
                    },
                    {
                        name: "Apuestas",
                        route: "concursos-active",
                        icon: "fa-calendar-check",
                    },
                ];

                // Recorrer los ítems del menú y agregar solo los que el usuario tiene permiso
                menuItems.forEach(function (item) {
                    // Comprobamos si el usuario tiene el permiso correspondiente
                    var permission = permissions.find(
                        (p) => p.name === item.name
                    );

                    // Si el permiso existe y está activo, agregarlo al menú
                    if (permission) {
                        var menuItemHTML = `<li><a href="${item.route}"><i class="fa ${item.icon}"></i> ${item.name}</a></li>`;
                        $navPermissions.append(menuItemHTML); // Agregar el ítem al menú
                    }
                });
            } else if (response.message == "SinPermiso") {
                // window.location.href = WEB_RUTA+"/403"; // Redirige a la página de sin permisos
            }
        },
        error: function (xhr, status, error) {
            if (xhr.status === 401) {
                window.location.href = WEB_RUTA + "/log-in"; // Redirige al login si el token es inválido
            }
            // if (xhr.status === 403) {
            //     window.location.href = WEB_RUTA+"/403"; // Redirige al login si el token es inválido
            // }

            if (xhr.status == 500) {
                window.location.href = WEB_RUTA + "/500"; // Redirige al login si el token es inválido
            }
            // Si hay un error con la solicitud o el token es inválido
            console.log("Error al verificar autenticación:", error);
        },
    });
    return "ok"; // Este valor no se usa, ya que la función es asíncrona
}
