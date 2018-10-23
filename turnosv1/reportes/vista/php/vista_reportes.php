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
        $verificaropcion = $validar->VerificarMenuServidor('report');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="reportes/vista/js/script_reportes.js"></script>        
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
    <body>
        <section id="personalSecNuevoReporteAsistencia" class="content " >
            <div class="col-md-12" >
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Reportes</h3>
                    </div>
                    <div id="reportesIdCabecera" class="box-body">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="reportesTipoReporteNuevo">Tipo:</label>
                                <select id="reportesTipoReporteNuevo" class="form-control">
                                    <option value="1" data-tipo="U">Turnos Atendidos por Usuarios</option>
                                    <option value="2" data-tipo="M">Turnos Atendidos por Módulos</option>                                    
                                    <option value="3" data-tipo="U">Tiempo Promedio de Atención por Usuarios</option>
                                    <option value="4" data-tipo="M">Tiempo Promedio de Atención por Módulos</option>
                                    <option value="5" data-tipo="U">Tiempo Promedio de Espera por Usuarios</option>
                                    <option value="6" data-tipo="M">Tiempo Promedio de Espera por Módulos</option>
                                    <option value="7" data-tipo="U">General por Usuarios</option>
                                    <option value="8" data-tipo="M">General por Módulos</option>
                                    <option value="9" data-tipo="C">Turnos Atendidos por pacientes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha:</label>
                                </label>
                                <div id="reportesTurnosRangoFecha" class="input-daterange input-group" >
                                    <span class="input-group-addon">Desde</span>
                                    <input id="reportesFechaInicioTurnosNuevo" type="text" class="input-sm form-control datepicker reportesTurnosCampoValidado" name="start" />
                                    <span class="input-group-addon">Hasta</span>
                                    <input id="reportesFechaFinTurnosNuevo" type="text" class="input-sm form-control datepicker reportesTurnosCampoValidado" name="end" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="reportesPersonaTurnosNuevo" id="reportesLblUsuarioModulo">Usuario:</label>
                                <select id="reportesUsuarioModuloTurnosNuevo" class="form-control">
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <br>
                                <button id="reportesBtnNuevoReporteTurnos"  class="btn btn-default col-xs-12">
                                    <span class="fa fa-file-pdf-o"></span>
                                    Visualizar
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <br>
                                <button id="reportesBtnNuevoReporteTurnosExcel"  class="btn btn-default col-xs-12">
                                    <span class="fa fa-file-excel-o"></span>
                                    Descargar
                                </button>
                            </div>
                        </div>
                        <div id="reportesIdFrmReporte" class="col-xs-12">
                            <div id="reportesFrmReportesTurnos" class="box-body" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
