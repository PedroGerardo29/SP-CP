<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TURNOS +</title>
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
    <body class="menuClaseFullScreen background-gris">
        <section  class="content ">
            <div >
                <div class="box-header with-border" id="esperaDivContenidoCabecera">
                    <div class="pull-left">
                        <img id="esperaFotoNuevoFoto" src="includes/img/logoinstitucion.png" class="user-image" alt="Logo" />                                  
                    </div>
                    <div id="esperaDivContenidoFechaHora" class="pull-right">
                        <b >
                            <div class="pull-right " id="esperaTxtHoraActual"></div> 
                            <div class="pull-right " id="esperaTxtFechaActual"></div> 
                        </b>
                    </div>
                </div>
                <div >
                    <div>
                        <div class="box-body">
                            <div class=" col-md-5 col-xs-12 col-sm-12 " id="esperaDivContenidoTurnos">
                                <div id="esperaDivTurno">
                                    <table class="table " id="esperaTblTurnos">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-6 hidden-xs text-center" id="esperaThEncabezadoModulo" >TURNO</th>
                                                <th class="col-xs-6 hidden-xs text-center" id="esperaThEncabezadoTurno" >MÓDULO</th>
                                                <th class="col-xs-6 visible-xs text-center" id="esperaThEncabezadoModulo" >TURNO</th>
                                                <th class="col-xs-6 visible-xs text-center" id="esperaThEncabezadoTurno" >MÓD</th>
                                            </tr>
                                        </thead>
                                        <tbody id="esperaTbdListaTurnos" >
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-body col-md-7 hidden-xs hidden-sm" id="esperaDivContenidoInformacion">
                                <div class=" clearfix" id="esperaDivContenidoMensaje">
                                    <center>
                                        <marquee direction="left" id="margueMensaje">
                                            <span >
                                                <b id="esperaMensajeInstitucion">

                                                </b>
                                            </span>
                                        </marquee>
                                    </center>
                                </div>
                                <div class="clearfix" id="esperaDivContenidoVideo" >
                                    <video id="esperaVideoNuevoVideo"  autoplay  controls class="col-xs-12" style="width: 100%    !important;  height: auto   !important;">
                                        Tu navegador no implementa el elemento <code>video</code>.
                                    </video>
                                </div>
                                <div class="box-footer clearfix background-gris" id="esperaDivContenidoMensajeFooter">
                                    <div class="pull-right">
                                        <i id="esperaWebInstitucion">

                                        </i>
                                    </div>
                                    <div class="pull-left">
                                        <i id="esperaNombreInstitucion">

                                        </i>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
        <script src="includes/sweetalert2-master/dist/sweetalert2.min.js" type="text/javascript"></script>
        <script src='includes/select2-3.5.2/select2.min.js'></script>
        <script src='includes/select2-3.5.2/select2_locale_es.js'></script>        
        <script src="includes/socket/script_socket.js"></script>
        <script src="includes/printarea/jquery.printarea.js"></script>
        <script src="includes/jquery-fullscreen-plugin-master/jquery.fullscreen-min.js"></script>
        <script src="seguridades/vista/js/script_path.js"></script>
        <script src="turnos/vista/js/script_espera.js"></script>
    </body>
</html>
