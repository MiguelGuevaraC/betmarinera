<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Apuestas | Concursos</title>
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

    <!-- Incluir jQuery (si no lo tienes ya) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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
                <li class="breadcrumb-item"><a href="concurso-list">Concursos</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Concursos <small> Marinera</small></h1>
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
                <!-- end panel-heading -->
                <!-- begin panel-body -->
                <div class="panel-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-sm btn-primary" onclick="mostrarCrearConcursoModal()">
                            Nuevo
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="table-contant" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>F. Creación</th>
                                    <th>F. Inicio</th>
                                    <th>F. Fin</th>
                                    <th>Concursantes</th>
                                    <th>Categorias</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end #content -->
        <!-- Modal para Agregar Categorías -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
                style="max-width: 90%; width: 90%;">
                <!-- Modal más ancho y responsive -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Agregar Categorías</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm" class="row align-items-end"
                            style="margin: auto; text-align: justify">
                            <!-- Campo de texto para Nombre de la Categoría -->
                            <div class="form-group col-md-8 col-sm-12">
                                <label for="categoryName">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="categoryName" placeholder="Nombre"
                                    required>
                            </div>

                            <!-- Campo oculto para el ID del concurso -->
                            <input type="hidden" id="contestId" value="">

                            <!-- Botón Agregar -->
                            <div class="form-group col-md-4 col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>


                        <!-- Campo oculto para el ID del concurso -->
                        <input type="hidden" id="contestId" value="">

                        <!-- Tabla de categorías con DataTable -->
                        <table class="table table-bordered" id="categoryTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se cargarán las categorías -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addContestantModal" tabindex="-1" role="dialog"
            aria-labelledby="addContestantModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
                style="max-width: 90%; width: 90%;">
                <!-- Modal más ancho y responsive -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContestantModalLabel">Agregar Concursante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para agregar un concursante -->
                        <form id="addContestantForm" class="row align-items-end"
                            style="margin: auto; text-align: center;">
                            <div class="form-group col-md-3">
                                <label for="contestantName">Nombre</label>
                                <input type="text" class="form-control" id="contestantName" placeholder="Nombre"
                                    required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="contestantDescription">Descripción</label>
                                <input type="text" class="form-control" id="contestantDescription"
                                    placeholder="Descripción" value="-">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="contestantCategory">Categoría</label>
                                <select class="form-control" id="contestantCategory" required>
                                    <option value="" disabled selected>Seleccione</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="contestantDescription"> </label>

                                <button type="submit" class="btn btn-primary">Agregar</button>

                            </div>

                            <input type="hidden" id="contestId" value="">

                        </form>

                        <hr>

                        <!-- Tabla de concursantes -->
                        <div class="table-responsive">
                            <table id="contestantTable" class="table table-striped table-bordered"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Categoría</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Filas dinámicas -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <div class="modal fade" id="crearConcursoModal" tabindex="-1" role="dialog"
            aria-labelledby="crearConcursoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearConcursoModalLabel">Crear Nuevo Concurso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="crearConcursoForm">
                            <div class="form-group">
                                <label for="name">Nombre del Concurso</label>
                                <input type="text" class="form-control" id="name" name="nombre"
                                    placeholder="Ingrese el nombre del concurso" required>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Fecha de Inicio</label>
                                <input type="datetime-local" class="form-control" id="start_date"
                                    name="fecha_inicio" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Fecha de Fin</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="fecha_fin"
                                    required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="editConcursoModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="editConcursoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editConcursoModalLabel">Editar Concurso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editConcursoForm">
                            <input type="hidden" id="editContestId" name="contest_id">
                            <div class="form-group">
                                <label for="editName">Nombre del Concurso</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="editStartDate">Fecha de Inicio</label>
                                <input type="datetime-local" class="form-control" id="editStartDate"
                                    name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="editEndDate">Fecha de Fin</label>
                                <input type="datetime-local" class="form-control" id="editEndDate" name="end_date"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="contestantWinCategory" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="editConcursoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
            style="max-width: 90%; width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConcursoModalLabel">Seleccionar concursante Ganador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updatewincategory" class="row align-items-end" style="margin: auto; text-align: justify">
                        <!-- Aquí va el contenido de la tabla de concursantes -->
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table id="contestantsWinCategoryTable" class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Ganador</th>
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

    
    <div id="listapostadores" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="listapostadores" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
        style="max-width: 90%; width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listapostadores">Listado de Apostadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updatewincategory" class="row align-items-end" style="margin: auto; text-align: justify">
                    <!-- Aquí va el contenido de la tabla de concursantes -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table id="contestApostadorTable" class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Apostador</th>
                                    <th scope="col">Puntaje</th>
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

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->

    <script src="..\assets\js\app.min.js"></script>
    <script src="..\assets\js\theme\default.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <!-- Incluir Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="..\resources\js\contestant-list.js"></script>
    <script src="..\resources\js\categories.js"></script>
    <script src="..\resources\js\concursantes.js"></script>
    <script src="..\resources\js\config.js"></script>
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="..\assets\plugins\datatables.net\js\jquery.dataTables.min.js"></script>
    <script src="..\assets\plugins\datatables.net-bs4\js\dataTables.bootstrap4.min.js"></script>
    <script src="..\assets\plugins\datatables.net-responsive\js\dataTables.responsive.min.js"></script>
    <script src="..\assets\plugins\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js"></script>
    <script src="..\assets\js\demo\table-manage-default.demo.js"></script>

    <!-- Incluir Select2 JS -->

    <script>
        $(document).ready(function() {
            // Inicialización de DataTable
            $('#table-contant').DataTable({
                processing: true, // Muestra un indicador de "cargando"
                serverSide: true, // Activar procesamiento del lado del servidor
                responsive: true, // Habilitar comportamiento responsivo
                ajax: {
                    url: API_RUTA + '/list-contest', // Ruta a tu API
                    type: 'GET', // Método HTTP
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem(
                            'token') // Envía el token almacenado
                    },
                    data: function(d) {
                        // Modifica los datos enviados al servidor
                        return {
                            page: (d.start / d.length) + 1, // Calcula la página actual
                            per_page: d.length, // Cantidad de registros por página
                            search: d.search.value // Valor del campo de búsqueda
                        };
                    },
                    dataSrc: DATA_SRC_FUNCTION,
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                        title: 'Nombre'
                    }, // Columna Nombre
                    {
                        data: 'created_at',
                        name: 'created_at',
                        title: 'F. Creación',
                        render: function(data, type, row) {
                            return data; // Formatea la fecha
                        }
                    }, // Columna Fecha de Fin
                    {
                        data: 'start_date',
                        name: 'start_date',
                        title: 'F. Inicio',
                        render: function(data, type, row) {
                            return data; // Formatea la fecha
                        }
                    }, // Columna Fecha de Inicio
                    {
                        data: 'end_date',
                        name: 'end_date',
                        title: 'F. Fin',
                        render: function(data, type, row) {
                            return data; // Formatea la fecha
                        }
                    }, // Columna Fecha de Fin

                    {
                        data: 'categories_count',
                        name: 'categories_count',
                        title: 'Categorias',

                        render: function(data, type, row) {
                            return data; // Muestra el valor
                        }
                    }, // Columna Nro Categorías
                    {
                        data: 'contestants_count',
                        name: 'contestants_count',
                        title: 'Concursantes',

                        render: function(data, type, row) {
                            return data; // Muestra el valor
                        }
                    }, // Columna Concursantes
                    {
                        data: 'status',
                        name: 'status',
                        title: 'Estado',
                        render: function(data, type, row) {
                            return data; // Muestra el estado
                        }
                    }, // Columna Estado
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Acciones',
                        render: function(data, type, row) {
                            return data; // Muestra las acciones
                        },
                        className: 'text-center'
                    }
                ],
                columnDefs: [{
                    targets: [4,
                        5
                    ], // Indices de las columnas: Categorias (4) y Concursantes (5)
                    width: '50px', // Ancho de las columnas
                    className: 'text-center' // Opcional: para alinear el contenido de las celdas al centro
                }],
                language: DATATABLES_LANGUAGE_ES,
                drawCallback: function(settings) {
                    // Verifica si el número de registros totales es NaN

           
                }
            });
        });
    </script>
    <style>
        /* Mejorar la visualización en pantallas pequeñas */
        @media (max-width: 576px) {
            .dataTables_wrapper {
                font-size: 12px;
                /* Tamaño de fuente más pequeño */
                padding: 10px;
            }

            /* Reducir el espacio entre los controles */
            .dataTables_length,
            .dataTables_filter,
            .dataTables_paginate {
                margin-bottom: 10px;
            }

            /* Hacer que los botones de la paginación sean más pequeños */
            .dataTables_paginate .paginate_button {
                padding: 3px 8px;
                font-size: 12px;
            }

            /* Hacer los controles de búsqueda más pequeños */
            .dataTables_filter input {
                font-size: 12px;
                padding: 5px;
                width: 100px;
                /* Reducir el tamaño del campo de búsqueda */
            }

            /* Ajustar el espacio para las filas de la tabla */
            .dataTables_wrapper .dataTables_info {
                font-size: 12px;
            }
        }

        /* Ajuste adicional para pantallas extremadamente pequeñas */
        @media (max-width: 400px) {
            .dataTables_wrapper {
                font-size: 10px;
                /* Disminuir aún más el tamaño de fuente */
                padding: 5px;
            }

            .dataTables_paginate .paginate_button {
                font-size: 10px;
                /* Botones más pequeños */
                padding: 2px 5px;
                /* Menos padding */
            }

            .dataTables_filter input {
                width: 80px;
                /* Aumentar un poco el campo de búsqueda */
            }

            .dataTables_length,
            .dataTables_filter {
                font-size: 10px;
                /* Disminuir los controles */
            }

            .dataTables_wrapper .dataTables_info {
                font-size: 10px;
            }

            .dataTables_paginate {
                font-size: 10px;
            }
        }
    </style>

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
