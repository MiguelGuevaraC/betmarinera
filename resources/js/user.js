$(document).ready(function () {
    verifyToken(localStorage.getItem('token'),'users');
});

function editUser(userId,firstname,lastname,email) {
    $("#firstName").val(firstname);
    $("#lastName").val(lastname);
    $("#email").val(email);
    $("#userId").val(userId);
    $("#editUserModal").modal("show");
}

function saveUser() {
    const formData = $("#editUserForm").serialize(); // Obtiene los datos del formulario

    $.ajax({
        url: API_RUTA + "/user/" + userId,
        method: "POST",
        data: formData,
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"), // Si necesitas token
        },
        success: function (response) {
            // Oculta el modal y muestra un mensaje de éxito
            $("#editUserModal").modal("hide");
            alert("Usuario actualizado correctamente.");

            // Opcional: Recarga el DataTable
            $("#table-users").DataTable().ajax.reload();
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar el usuario:", error);
            alert("Hubo un error al actualizar el usuario.");
        },
    });
}
