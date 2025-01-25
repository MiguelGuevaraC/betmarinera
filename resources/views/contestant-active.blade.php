<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Apuestas | Concursos Activos</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="..\assets\css\default\app.min.css" rel="stylesheet">
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="..\assets\plugins\datatables.net-bs4\css\dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="..\assets\plugins\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css" rel="stylesheet">
    <!-- ================== END PAGE LEVEL STYLE ================== -->
    <!-- Incluir Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        .col-lg-2-4 {
            flex: 0 0 20%;
            /* Ocupa el 20% del ancho total */
            max-width: 20%;
        }

        @media (max-width: 1200px) {
            .col-lg-2-4 {
                flex: 0 0 25%;
                /* Cambia a 4 columnas en pantallas medianas */
                max-width: 25%;
            }
        }

        @media (max-width: 992px) {
            .col-lg-2-4 {
                flex: 0 0 33.33%;
                /* Cambia a 3 columnas en pantallas medianas */
                max-width: 33.33%;
            }
        }

        @media (max-width: 768px) {
            .col-lg-2-4 {
                flex: 0 0 50%;
                /* Cambia a 2 columnas en pantallas pequeñas */
                max-width: 50%;
            }
        }

        @media (max-width: 576px) {
            .col-lg-2-4 {
                flex: 0 0 100%;
                /* Una columna en pantallas extra pequeñas */
                max-width: 100%;
            }
        }

        .widget {
            padding: 15px;
            border-radius: 8px;
            color: #fff;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease;
            /* Transición suave para el aumento de tamaño */
        }

        .widget:hover {
            transform: scale(1.1);
            /* Aumenta el tamaño del contenedor al 110% */
        }




        .widget .stats-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .widget .stats-info h4 {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }

        .widget .stats-info p {
            font-size: 14px !important;
            margin: 0;
            font-weight: bold;
        }

        .widget .stats-link {
            margin-top: 10px;
        }

        .widget .btn {
            background: #fff;
            color: #333;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 14px;
            cursor: pointer;
        }

        .widget .btn:hover {
            background: #f0f0f0;
        }

        /* Estilo para el mensaje de estado */
        .infobet {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            font-size: 16px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-warning {
            background-color: #ffc107;
            color: white;
        }

        /* Aseguramos que el mensaje se vea bien en dispositivos pequeños */
        @media (max-width: 767px) {
            .infobet {
                padding: 10px;
            }

            .alert {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <!-- begin #header -->
        <div id="header" class="header navbar-inverse">
            <!-- begin navbar-header -->
            <div class="navbar-header">
                <a href="index-1.html" class="navbar-brand"><span class="navbar-logo"></span> <b>Apuestas</b>
                    Marinera</a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end navbar-header -->

            <!-- begin header-nav -->
            <ul class="navbar-nav navbar-right">
                <li class="dropdown navbar-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="..\assets\img\user\user-13.jpeg" alt="">
                        <span id="usernamebarra2" class="d-none d-md-inline"> Administrador</span> <b
                            class="caret"></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="profile" class="dropdown-item">Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0);" class="dropdown-item" onclick="logout()">Cerrar Sesión</a>

                    </div>
                </li>
            </ul>
            <!-- end header-nav -->
        </div>
        <!-- end #header -->

        <!-- begin #sidebar -->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar user -->
                <ul class="nav">
                    <li class="nav-profile">
                        <a href="javascript:;" data-toggle="nav-profile">
                            <div class="cover with-shadow"></div>
                            <div class="image">
                                <img src="..\assets\img\user\user-13.jpeg" alt="">
                            </div>
                            <div class="info">
                                <b class="caret pull-right"></b>
                                <p id="usernamebarra">Miguel Guevara</p>

                                <small>
                                    <p id="typeuser">Administrador</p>
                                </small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <ul class="nav nav-profile">
                            <li><a href="profile"><i class="fa fa-pencil-alt"></i> Perfil</a></li>
                            <li><a href="javascript:void(0);" onclick="logout()"><i class="fa fa-cog"></i> Cerrar
                                    Sesión</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                <ul class="nav" id="navpermissions">
                    <!-- El menú se llenará dinámicamente con JavaScript -->
                </ul>

            </div>
            <!-- end sidebar scrollbar -->
        </div>
        <div class="sidebar-bg"></div>
        <!-- end #sidebar -->

        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="concurso-activo">Concurso Activo</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Apuestas <small> Marinera</small></h1>
            <!-- end page-header -->
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Opciones</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                            data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                            data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <style></style>
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                    <div class="row mb-2">
                        <div class="form-group col-md-6">
                            <label for="contestactive" class="font-weight-bold">Concurso</label>
                            <input type="hidden" id="statusByApostador" value="">
                            <select class="form-control" id="contestactiveselect" required>
                                <option value="" disabled selected>No hay Concursos Activos</option>
                                <!-- Agrega más opciones aquí -->
                            </select>
                        </div>

                        <div class="form-group col-md-6 d-flex justify-content-end">
                            <!-- Alineamos el botón a la derecha -->
                            <!-- Botón Mejorado -->
                            <button class="btn btn-primary mt-3" id="confirmBetButton" style="display: none;"
                                onclick="confirmBet()">
                                <i class="fa fa-check-circle"></i> Confirmar Apuesta
                            </button>

                        </div>

                    </div>


                    <div class="row d-flex flex-wrap">

                    </div>
                </div>



                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end #content -->
        <div id="contestantBetCategory" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="editConcursoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
                style="max-width: 90%; width: 90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editConcursoModalLabel">Seleccionar concursante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updatebet" class="row align-items-end" style="margin: auto; text-align: justify">
                            <!-- Aquí va el contenido de la tabla de concursantes -->
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table id="contestantsBetTable" class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Filas dinámicas de concursantes se agregarán aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <!-- end theme-panel -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->

    <script src="..\assets\js\app.min.js"></script>
    <script src="..\assets\js\theme\default.min.js"></script>
    <!-- Incluir Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ================== END BASE JS ================== -->
    <script src="..\resources\js\contestant-active.js"></script>
    <script src="..\resources\js\config.js"></script>
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="..\assets\plugins\datatables.net\js\jquery.dataTables.min.js"></script>
    <script src="..\assets\plugins\datatables.net-bs4\js\dataTables.bootstrap4.min.js"></script>
    <script src="..\assets\plugins\datatables.net-responsive\js\dataTables.responsive.min.js"></script>
    <script src="..\assets\plugins\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js"></script>
    <script src="..\assets\js\demo\table-manage-default.demo.js"></script>


    <!-- ================== END PAGE LEVEL JS ================== -->
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
