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
        $verificaropcion = $validar->VerificarMenuServidor('turnos');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="turnos/vista/js/script_turnos.js"></script>       
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
    <body class="bg-primary">
        <div class="content ">
            <div class="box-header with-border col-xs-12 " id="turnosDivContenedorCabecera">
                <div class="pull-left">
                    <img id="turnosImgLogoInstitucion" src="includes/img/logoinstitucion.png" height="50" width="100"/>
                </div>
                <div class="pull-right">
                    <b>
                        <div id="turnosDivContenedorHora" class="pull-right turnosClsPadding30" > </div>
                        <div id="turnosDivContenedorFecha" class="pull-right turnosClsPadding30" > </div>  
                    </b>                 
                </div>
            </div>
            <div class="box-body col-xs-12">
                <div  id="turnossecListaturno">                            
                </div>
            </div>
            <div  id="turnosDivContenedorEnlaceTicket" style="width: 0px;height: 0px">
                <iframe  id="turnosFrameTicket" name="turnosFrameTicket" style="width: 0px;height: 0px"></iframe>
            </div>
        </div>
    </body>
</html>
