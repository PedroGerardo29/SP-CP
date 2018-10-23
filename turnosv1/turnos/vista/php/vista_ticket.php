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
        <link href="../css/estilosticket.css?w" type="text/css" rel="stylesheet" media="all"/>
        <link href="../../../includes/printarea/printarea.css" type="text/css" media="all" rel="stylesheet"/>
        <script src="../../../includes/AdminLTE-master/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="../../../includes/printarea/jquery.printarea.js"></script>
    </head>
    <body >
        <?php
        error_reporting(\E_ERROR);
        include_once '../../../turnos/modelo/php/modelo.php';
        $ticket = new Turno();
        ?>
        <div id="parametrosDivContenidoVistaPrevia" >
            <div id="parametrosDivContenedorTicket">
                <div id="parametrosIdTurnosVistaPreviaTicket" style="<?php $ticket->setEstilosTicket(); ?>" >
                    <div id="parametrosIdTurnosVistaPreviaDivContenedorLogo" >
                        <img id="parametrosTurnosVistaPreviaLogo" src="../../../includes/img/logoinstitucion.png" style="<?php $ticket->setEstilosLogo(); ?> ">
                    </div>
                    <div id="parametrosTurnosDivContenedoPrincipalTurno" >
                        <b>
                            <div>
                                <div id="parametrosTurnosVistaPreviaTurno" class="parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviacentrado parametorsClsTicketVistaPreviaflotaizquierda" style="<?php $ticket->setEstilosTurno(); ?> ">
                                    <?php
                                    echo $_GET['turno'];
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div id="parametrosTurnosVistaPreviaModulo" class="parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviacentrado parametorsClsTicketVistaPreviaflotaizquierda" style="<?php $ticket->setEstilosModulo(); ?>">
                                    <?php
                                    echo $_GET['tramite'];
                                    ?>
                                </div> 
                            </div>
                        </b> 
                    </div> 
                    <div id="parametrosTurnosDivContenedorFooter" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal">                                           
                        <div id="turnosVistaPreviaEspera" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal   parametorsClsTicketVistaPreviatextoizquierda" style="<?php $ticket->setEstilosEspera(); ?> ">
                            Turnos en espera: &nbsp;<?php
                            echo $_GET['espera'];
                            ?>
                        </div>
                    </div>
                    <div id="parametrosTurnosDivContenedorFooter2" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal">
                        <div  class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoizquierda">                                                
                            <div id="parametrosTurnosVistaPreviaFecha" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoizquierda   parametorsClsTicketVistaPreviatotal" style="<?php $ticket->setEstilosFecha(); ?>">
                                <?php
                                echo $_GET['fecha'];
                                ?>
                            </div>
                            <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha   parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                &nbsp;
                            </div>
                        </div>
                        <div class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha">
                            <div id="ParametrosTurnosVistaPreviaHora" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha   parametorsClsTicketVistaPreviatotal" style="<?php $ticket->setEstilosHora(); ?>">
                                <?php
                                echo $_GET['hora'];
                                ?>
                            </div>
                            <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha   parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                &nbsp;
                            </div>
                        </div>                                                                                               
                    </div>
                    <div id="ParametrosparametrosTurnosDivContenedorFooterInfo" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal">
                        <div class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviatextoizquierda">
                            <div id="parametrosTurnosVistaPreviaNombre" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoizquierda   parametorsClsTicketVistaPreviatotal" style="<?php $ticket->setEstilosNombre(); ?>">
                                <?php
                                if (!$_SESSION) {
                                    session_start();
                                }
                                echo $_SESSION['PAR_NOMINS'];
                                ?>
                            </div>
                            <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha   parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                &nbsp;
                            </div>
                        </div>
                        <div class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha">
                            <div id="parametrosTurnosVistaPreviaSitioWeb" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha   parametorsClsTicketVistaPreviatotal" style="<?php $ticket->setEstilosSitioWeb(); ?>">
                                <?php
                                if (!$_SESSION) {
                                    session_start();
                                }
                                echo $_SESSION['PAR_WEBINS'];
                                ?>
                            </div>
                            <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha   parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            $("#parametrosDivContenidoVistaPrevia").printArea();
        </script>
    </body>
</html>
