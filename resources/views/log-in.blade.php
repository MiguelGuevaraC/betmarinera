<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Apuestas | Login</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="..\assets\css\default\app.min.css" rel="stylesheet">
    <!-- ================== END BASE CSS STYLE ================== -->
</head>

<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- Contenedor para el login -->
        <div id="login-container" class="login login-with-news-feed">
            <div class="news-feed">
                <div class="news-image" style="background-image: url(../assets/img/login-bg/login-bg-11.jpeg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title"><b>Apuestas</b> Marinera</h4>
                </div>
            </div>

            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span> <b>Apuestas</b> Marinera
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in-alt"></i>
                    </div>
                </div>
                <!-- end login-header -->

                <!-- begin login-content -->
                <div class="login-content">
                    <form id="loginForm" action="login" method="POST" class="margin-bottom-0">
                        <div class="form-group m-b-15">
                            <input type="text" id="email" class="form-control form-control-lg"
                                placeholder="Correo" required="">
                        </div>
                        <div class="form-group m-b-15">
                            <input type="password" id="password" class="form-control form-control-lg"
                                placeholder="Contraseña" required="">
                        </div>
                        <div class="m-t-10 m-b-20 p-b-10 text-inverse">
                            No eres un usuario aún? Click <a href="#" onclick="showCreateUserModal()">Aquí</a>
                            para registrarte.
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
        </div>
        <!-- end login-container -->

        <!-- Contenedor para el contenido (oculto inicialmente) -->
        <div id="content-container" style="display:none;">
            <div id="content">
                <!-- Aquí se insertará el contenido de bienvenida y otros elementos -->
            </div>
        </div>
    </div>
    <!-- end page-container -->
    <!-- Modal Crear Usuario -->


    <div id="createUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editConcursoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 90%; width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConcursoModalLabel">Registrar Usuario Profesional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registerProfessionalForm" class="row g-3" style="margin: auto; text-align: justify">
                        <!-- Nombre y Apellido -->
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" id="name" class="form-control" placeholder="Nombre"
                                        required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="lastName" class="form-label">Apellido</label>
                                    <input type="text" id="lastName" class="form-control" placeholder="Apellido"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="col-12 mb-2">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <input type="email" id="emailregister" class="form-control" placeholder="Correo"
                                    required>
                                <button type="button" onclick="validateEmailBtn()" class="btn btn-primary">Validar</button>
                            </div>
                        </div>

                        <!-- Token -->
                        <div class="col-12 mb-2">
                            <label for="token" class="form-label">Token</label>
                            <input type="text" id="token" class="form-control" placeholder="Escribe aquí el Token"
>
                        </div>

                        <!-- Contraseña -->
                        <div class="col-md-6 mb-2">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="passwordregister" class="form-control" placeholder="Contraseña"
                                required>
                        </div>

                        <!-- Botón Registrar Usuario -->
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-success btn-block">Registrar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="..\assets\js\app.min.js"></script>
    <script src="..\assets\js\theme\default.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="..\resources\js\login.js"></script>
    <script src="..\resources\js\config.js"></script>
    <!-- ================== END BASE JS ================== -->

    <script>
        // Lógica para el login y manejo del contenido
        $('#loginForm').submit(function(e) {
            e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            // Recoger los datos del formulario
            var email = $('#email').val();
            var password = $('#password').val();

            // Realizar la solicitud AJAX
            $.ajax({
                url: API_RUTA + '/login', // URL para procesar el login
                method: 'POST',
                data: {
                    email: email,
                    password: password,
                    _token: $('input[name="_token"]')
                        .val() // Asegúrate de que el token CSRF esté bien configurado
                },
                success: function(response) {
                    // Supongamos que el backend devuelve el token como parte de la respuesta
                    if (response.token) {
                        // Guardar el token en el localStorage
                        localStorage.setItem('token', response.token);
                        console.log('Token guardado en el localStorage:', response.token);

                        // Redirigir a la página de inicio
                        if (verifyToken(response.token,'home') == "ok") {
                            window.location.href =
                                WEB_RUTA + '/home';
                        }
                    } else {
                        // Si no hay token en la respuesta, mostrar un error
                        alert('No se recibió un token válido.');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 422) {
                        // Si el backend devuelve un mensaje en lugar de un objeto de errores
                        var errorMessage = xhr.responseJSON.message || xhr.responseJSON.error ||
                            'Hubo un error al intentar iniciar sesión. Por favor, verifica tus datos.';

                        alert('Error al iniciar sesión: ' +
                            errorMessage); // Mostrar el mensaje al usuario
                    } else {
                        // Si hay otro tipo de error
                        alert(
                            'Hubo un error al intentar iniciar sesión. Por favor, verifica tus datos.'
                        );
                    }
                }
            });
        });
    </script>


    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-53034621-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>

</html>
