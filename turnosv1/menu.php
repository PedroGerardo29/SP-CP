<?php
error_reporting(\E_ERROR);
include_once './configuracion/configuracion.php';
include_once './configuracion/conexionlogin.php';
include_once './seguridades/modelo/php/modelo.php';
$validar = new Usuario();
if (!$validar->VerificarLogin()) {
    $validar->RedireccionarURL('index.php');
    exit;
}
$validar->ActualizarParametros();
$validar->ActualizarPermisos();
$validar->ActualizarInformacionUsuario();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Pre-clasificación y Control de Pacientes</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>    
        <link href="includes/AdminLTE-master/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/dist/css/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/dist/css/ionicons-master/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
        <link href="includes/AdminLTE-master/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
        <link href="includes/sweetalert2-master/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
        <link href="includes/select2-3.5.2/select2.css" rel="stylesheet" type="text/css" />
        <link href="includes/select2-3.5.2/select2-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <link href="includes/webcodecamjs-master/css/style.css" rel="stylesheet" type="text/css" />
        <link href="includes/printarea/printarea.css" rel="stylesheet" type="text/css" />
        <link href="includes/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
        <link href="parametros/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="seguridades/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="modulos/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="turnos/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="tramites/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="reportes/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="clientes/vista/css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="includes/general/stylemenu.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="skin-blue sidebar-mini sidebar-collapse" >
        <div class="wrapper">
            <div id="menuFullScreen">
                <header class="main-header">
                    <a href="menu.php" class="logo">
                        <span class="logo-mini" title="Sistema de Turnos">
                            <span class="fa fa-sort-numeric-asc"></span>
                        </span>
                        <span class="logo-lg">
                            <span class="fa fa-sort-numeric-asc"></span>
                            <b>SP&CP</b> <sup>+</sup>
                        </span>
                    </a>
                    <nav class="navbar navbar-static-top" role="navigation">
                        <a  href="javascript::;" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Opciones</span>
                            &nbsp;&nbsp;
                            <span class="text-bold">
                                <b>                                    
                                    <?php
                                    echo $_SESSION['PAR_NOMINS'];
                                    ?>

                                </b>
                            </span>
                        </a>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <li class="dropdown user user-menu">
                                    <a href="javascript::;" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="
                                        <?php
                                        echo $_SESSION['foto'];
                                        ?>
                                             " class="user-image imagenPerfilUsuario" alt="User Image" />
                                        <span class="hidden-xs menuNombresApellidosusuario">
                                            <?php
                                            echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                                            ?>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="user-header">
                                            <img src="
                                            <?php
                                            echo $_SESSION['foto'];
                                            ?>
                                                 " class="img-circle imagenPerfilUsuario" alt="User Image" />
                                            <p class="menuNombresApellidosusuario">
                                                <?php
                                                echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                                                ?>
                                            </p>
                                        </li>
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" id="btnMenuOpcionPerfil"class="btn btn-default btn-flat">Perfíl</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="#" id="btnMenuOpcionSalir"class="btn btn-default btn-flat">Salir</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <aside class="main-sidebar" >
                    <section class="sidebar">
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img id="menuImgLogoInstitucion" src="includes/img/logoinstitucion.png" class="img-circle" alt="Logo" />
                            </div>
                            <div class="pull-left info">
                                <p><b>Conectado&nbsp;</b><i class="fa fa-circle text-success"></i><br></p>

                            </div>
                        </div>
                        <ul class="sidebar-menu" id="idMenuUsuarios">
                            <li class="header">MENÚ</li>
                        </ul>
                    </section>
                </aside>
            </div>  

            <div id="frame" class="content-wrapper" >
            </div>

        </div>
        <script src="includes/AdminLTE-master/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="includes/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>        
        <script src="includes/AdminLTE-master/plugins/moment/moment.min.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src='includes/AdminLTE-master/plugins/fastclick/fastclick.min.js'></script>
        <script src="includes/AdminLTE-master/plugins/jQueryUI/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/plugins/icheck/icheck.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/plugins/daterangepicker/moment.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="includes/AdminLTE-master/dist/js/app.min.js" type="text/javascript"></script>
        <script src="includes/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>
        <script src="includes/sha256/sha256.js" type="text/javascript"></script>
        <script src="includes/canvasResize-master/binaryajax.js"></script>
        <script src="includes/canvasResize-master/exif.js"></script>
        <script src="includes/canvasResize-master/canvasResize.js"></script>
        <script src="includes/sweetalert2-master/src/sweetalert2.js" type="text/javascript"></script>
        <script src='includes/select2-3.5.2/select2.min.js'></script>
        <script src='includes/select2-3.5.2/select2_locale_es.js'></script>        
        <script src="includes/socket/script_socket.js"></script>
        <script src="includes/printarea/jquery.printarea.js"></script>
        <script src="includes/jquery-fullscreen-plugin-master/jquery.fullscreen-min.js"></script>
        <script src="seguridades/vista/js/script_path.js"></script>

        <script src="includes/reconnecting-websocket-master/reconnecting-websocket.js"></script>
        <script src="seguridades/vista/js/script_menu.js"></script>
    </body>
</html>