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
        $verificaropcion = $validar->VerificarMenuServidor('atenci');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="turnos/vista/js/script_atencion.js"></script>         
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
        <section  class="content" id="atencionSecAtencionturnos">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <span class="fa fa-bullhorn"></span>
                        <h3 class="box-title hidden-xs">Atención de Turnos</h3>
                    </div>
                    <div class="box-body">
                        <div class=" col-xs-12  col-sm-4" id="log">
                            <div class="form-group">
                                <label for="">Trámite Actual:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTramiteActual" placeholder="Ninguno" type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Turno Actual:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTurnoActual" placeholder="Ninguno" type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 general-padding-cero">
                                <label for="">Estado Turno Actual:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtEstadoTurnoActual" placeholder="Ninguno" type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 general-padding-cero">
                                <label for="">Tiempo de Atención:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTurnoTiempoActual"  type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 general-padding-cero">
                                <label for="">Turnos Espera:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTurnoEspera"  type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 general-padding-cero">
                                <label for="">Tiempo de espera:</label>
                                <div class="input-group" >
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input id="esperaTxtTurnoTiempoEspera"  type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 general-padding-cero ">
                                <label for="">Turnos Atendidos:</label>
                                <div class="input-group ">
                                    <div class="input-group-addon ">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTurnoAtendidos" type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group col-xs-6 col-sm-6 general-padding-cero">
                                <label for="">Tiempo Promedio :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTurnoTiempoPromedioAtendidos" type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Turnos Anulados:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="esperaTxtTurnoAnulados" type="text" class="form-control pull-right text-uppercase atencionTxtClassCampos" disabled/>
                                </div>
                            </div>
                        </div>                            
                        <div class="box-body col-xs-12 col-sm-8" id="atencionDivContenedorMenu" >
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box bg-light-blue">
                                            <span class="info-box-icon "><i class="fa fa-arrow-right "></i></span>
                                            <div class="info-box-content puntero" id="atencionBtnSiguiente" >
                                                <br>
                                                <span class="info-box-text text-center">                      
                                                    <h4><b>Siguiente</b></h4>
                                                </span>                  
                                            </div>
                                        </div>
                                        <div class="info-box bg-olive">
                                            <span class="info-box-icon"><i class="fa fa-phone"></i></span>
                                            <div class="info-box-content puntero" id="atencionBtnLlamar" >
                                                <br>
                                                <span class="info-box-text text-center">                      
                                                    <h4><b>Llamar</b></h4>
                                                </span>                  
                                            </div>
                                        </div>
                                        <div class="info-box bg-green ">
                                            <span class="info-box-icon"><i class="fa fa-check"></i></span>
                                            <div class="info-box-content puntero" id="atencionBtnAtender">
                                                <br>
                                                <span class="info-box-text text-center">                      
                                                    <h4><b>Atender</b></h4>
                                                </span>                  
                                            </div>
                                        </div>                                           
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box bg-orange">
                                            <span class="info-box-icon"><i class="fa fa-ban"></i></span>
                                            <div class="info-box-content puntero" id="atencionBtnFinalizar">
                                                <br>
                                                <span class="info-box-text text-center">                      
                                                    <h4><b>Finalizar</b></h4>
                                                </span>                  
                                            </div>
                                        </div>
                                        <div class="info-box bg-red">
                                            <span class="info-box-icon"><i class="fa fa-trash"></i></span>
                                            <div class="info-box-content puntero" id="atencionBtnAnular" >
                                                <br>
                                                <span class="info-box-text text-center">                      
                                                    <h4><b>Anular</b></h4>
                                                </span>                  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <section id="pacientesSecNuevopaciente" class="content pacientesClsCampoOculto" >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Ingreso de Pacientes</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pacientesTxtNombreNuevopaciente">Nombre (*):</label>
                                    <label for="pacientesTxtNombreNuevopaciente" class="text-danger pull-right hide msgErrorNuevopaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Nombre
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoNuevo text-uppercase " id="pacientesTxtNombreNuevopaciente" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pacientesTxtApellidoNuevopaciente">Apellido (*):</label>
                                    <label for="pacientesTxtApellidoNuevopaciente" class="text-danger pull-right hide msgErrorNuevopaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Apellido
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoNuevo text-uppercase" id="pacientesTxtApellidoNuevopaciente" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pacientesTxtIdentificacionNuevopaciente">CUI (*):</label>
                                    <label for="pacientesTxtIdentificacionNuevopaciente" class="text-danger pull-right hide msgErrorNuevopaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese CUI
                                    </label>
                                    <label for="pacientesTxtIdentificacionNuevopaciente" class="text-danger pull-right hide msgErrorNuevopacienteCedula" id="msgErrorEmailInvalidoNuevoUsuario">
                                        <i class="fa fa-times-circle-o"></i>
                                        CUI Inválida
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoNuevo text-uppercase" id="pacientesTxtIdentificacionNuevopaciente" maxlength="14"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pacientesTxtDireccionNuevopaciente">Dirección (*):</label>
                                    <label for="pacientesTxtDireccionNuevopaciente" class="text-danger pull-right hide msgErrorNuevopaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Dirección
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoNuevo text-uppercase" id="pacientesTxtDireccionNuevopaciente" maxlength="200"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pacientesTxtTelefonoNuevopaciente">Teléfono (*):</label>
                                    <label for="pacientesTxtTelefonoNuevopaciente" class="text-danger pull-right hide msgErrorNuevopaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Teléfono
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoNuevo text-uppercase" id="pacientesTxtTelefonoNuevopaciente" maxlength="50"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgpacientessVerificandoNuevopaciente" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="pacientesBtnCancelarNuevopaciente"  class="btn btn-default ">
                                    <span class="fa fa-ban"></span>
                                    Cancelar
                                </button>
                                <button id="pacientesBtnGuardarNuevopaciente" class="btn btn-primary">
                                    <span class="fa fa-save"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </body>
</html>
