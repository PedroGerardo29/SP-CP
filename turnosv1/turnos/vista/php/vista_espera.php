<?php
error_reporting(\E_ERROR);
include_once '../../../configuracion/configuracion.php';
include_once '../../../configuracion/conexionlogin.php';
include_once '../../../seguridades/modelo/php/modelo.php';
$validar = new Usuario();
if (!$validar->VerificarLogin()) {
    $validar->RedireccionarURL('../../../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>        
        <?php
        $verificaropcion = $validar->VerificarMenuServidor('espera');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="turnos/vista/js/script_espera.js"></script>        
            <?php
        } else {
            if ($verificaropcion == 0) {
                echo "Acceso denegado usted no tiene permisos para acceder a este módulo.";
                die();
            } else if ($verificaropcion == -2) {
                echo "Error al acceder al módulo de reportes, por favor contactese con el proveedor del servicio.";
                die();
            }
        }
        ?>
    </head>
    <body >
        <section  class="content bg-gris">
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
                                                <th class="col-xs-6 hidden-xs text-center" id="esperaThEncabezadoModulo" >NUMERO DE TURNO</th>
                                                <th class="col-xs-6 hidden-xs text-center" id="esperaThEncabezadoTurno" >SALA ASIGNADA</th>
                                                <th class="col-xs-6 visible-xs text-center" id="esperaThEncabezadoModulo" >TURNO</th>
                                                <th class="col-xs-6 visible-xs text-center" id="esperaThEncabezadoTurno" >SALA</th>
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
                                                    <?php
                                                    if (!isset($_SESSION)) {
                                                        session_start();
                                                    }
                                                    echo $_SESSION['PAR_MEN'];
                                                    ?>
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
                                            <?php
                                            if (!isset($_SESSION)) {
                                                session_start();
                                            }
                                            echo $_SESSION['PAR_WEBINS'];
                                            ?>
                                        </i>
                                    </div>
                                    <div class="pull-left">
                                        <i id="esperaNombreInstitucion">
                                            <?php
                                            if (!isset($_SESSION)) {
                                                session_start();
                                            }
                                            echo $_SESSION['PAR_NOMINS'];
                                            ?>
                                        </i>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
