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
        $verificaropcion = $validar->VerificarMenuServidor('client');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="pacientes/vista/js/script_pacientes.js"></script>       
            <?php
        } else {
            if ($verificaropcion == 0) {
                echo "Acceso denegado usted no tiene permisos para acceder a este módulo.";
                die();
            } else if ($verificaropcion == -2) {
                echo "Error al acceder al módulo de pacientes, por favor contactese con el proveedor del servicio.";
                die();
            }
        }
        ?>
    </head>
    <body>
        <div class="content">
            <!-- Contenido Cabecera -->
            <section class="content-header">
                <div class="col-md-12 column">
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar">                                
                                </span><span class="icon-bar"></span>
                            </button> 
                            <a class="navbar-brand" href="#">Pacientes</a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                            </ul>
                            <form class="navbar-form navbar-right" role="search">
                                <button id="pacientesBtnNuevopaciente" class="btn btn-default">
                                    <span class="fa fa-plus-circle"></span>
                                    Nuevo
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </section>
            <!-- Fin Contenido Cabecera -->

            <!-- Contenido lista-->
            <section id="pacientessecListapacientes" class="content">
                <div >
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <span class="fa fa-server"></span>
                                <h3 class="box-title hidden-xs">Lista de Pacientes</h3>
                                <div class="box-tools">
                                    <div class="input-group">
                                        <input id="pacientesTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right"  placeholder="Búsqueda"/>
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-xs-1 hidden-xs text-center">#</th>
                                            <th class="col-xs-6 text-center">Nombres</th>                                            
                                            <th class="col-xs-3 text-center">CUI</th>
                                            <th class="col-xs-1 text-center">Opción</th>
                                            <th class="col-xs-1 text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pacientesTbdListapacientes">
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                                <div class="pull-left ">
                                    <div id="msgpacientessVerificandoListapaciente" class="col-xs-1 overlay hide">
                                        <i class="fa fa-refresh fa-spin "></i>
                                        <span >
                                            <span class="visible-xs">&nbsp;</span>                                    
                                            <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                        </span>                            
                                    </div>
                                </div>
                                <ul id="pacientesUlPaginacionpacientes" class="pagination pagination-sm no-margin pull-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Fin contenido lista -->

            <!--Contenido Nuevo-->
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
                                        CUI Inválido
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoNuevo text-uppercase" id="pacientesTxtIdentificacionNuevopaciente" maxlength="13"/>
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
            <!--Fin Contenido Nuevo-->

            <!--Contenido Editar-->
            <section id="pacientesSecEditarpaciente" class="content pacientesClsCampoOculto" >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edición de Pacientes</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pacientesTxtNombreEditarpaciente">Nombre (*):</label>
                                    <label for="pacientesTxtNombreEditarpaciente" class="text-danger pull-right hide msgErrorEditarpaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Nombre
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoEditar text-uppercase " id="pacientesTxtNombreEditarpaciente" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pacientesTxtApellidoEditarpaciente">Apellido (*):</label>
                                    <label for="pacientesTxtApellidoEditarpaciente" class="text-danger pull-right hide msgErrorEditarpaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Apellido
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoEditar text-uppercase" id="pacientesTxtApellidoEditarpaciente" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pacientesTxtIdentificacionEditarpaciente">CUI (*):</label>
                                    <label for="pacientesTxtIdentificacionEditarpaciente" class="text-danger pull-right hide msgErrorEditarpaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese CUI
                                    </label>
                                    <label for="pacientesTxtIdentificacionEditarpaciente" class="text-danger pull-right hide msgErrorEditarpacienteCedula" id="msgErrorEmailInvalidoEditarUsuario">
                                        <i class="fa fa-times-circle-o"></i>
                                        CUI Inválido
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoEditar text-uppercase" id="pacientesTxtIdentificacionEditarpaciente" maxlength="13"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pacientesTxtDireccionEditarpaciente">Dirección (*):</label>
                                    <label for="pacientesTxtDireccionEditarpaciente" class="text-danger pull-right hide msgErrorEditarpaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Dirección
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoEditar text-uppercase" id="pacientesTxtDireccionEditarpaciente" maxlength="200"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pacientesTxtTelefonoEditarpaciente">Teléfono (*):</label>
                                    <label for="pacientesTxtTelefonoEditarpaciente" class="text-danger pull-right hide msgErrorEditarpaciente">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Teléfono
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right pacientesClsCampoValidadoEditar text-uppercase" id="pacientesTxtTelefonoEditarpaciente" maxlength="50"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgpacientessVerificandoEditarpaciente" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="pacientesBtnCancelarEditarpaciente"  class="btn btn-default ">
                                    <span class="fa fa-ban"></span>
                                    Cancelar
                                </button>
                                <button id="pacientesBtnGuardarEditarpaciente" class="btn btn-primary">
                                    <span class="fa fa-save"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Fin Contenido Editar-->
        </div>
    </body>
</html>
