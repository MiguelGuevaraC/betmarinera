<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Apuestas | Home</title>
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
                <a href="index-1.html" class="navbar-brand"><span class="navbar-logo"></span> <b>Apuestas</b> Marinera</a>
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
                        <span id="usernamebarra2" class="d-none d-md-inline"> Administrador</span> <b class="caret"></b>
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
                                
                                <small> <p id="typeuser">Administrador</p></small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <ul class="nav nav-profile">
                            <li><a href="profile"><i class="fa fa-pencil-alt"></i> Perfil</a></li>
                            <li><a href="javascript:void(0);" onclick="logout()"><i class="fa fa-cog"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                <ul class="nav">
                    <li class="nav-header">Menú de Navegación</li>
                    <li><a href="home"  style="font-weight: bold"><i class="fa fa-home"></i> Inicio</a></li>
                    <li><a href="users"><i class="fa fa-users"></i> Apostadores</a></li>
                    <li><a href="concurso-list"><i class="fa fa-trophy"></i> Concursos</a></li>
                    <li><a href="concurso-activo"><i class="fa fa-calendar-check"></i> Concursos Activos</a></li>
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
                <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Home <small>Marinera</small></h1>
    
        </div>
        
        <!-- end #content -->

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
    <!-- ================== END BASE JS ================== -->
    <script src="..\resources\js\home.js"></script>
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
