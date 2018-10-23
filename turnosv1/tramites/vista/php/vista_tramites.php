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
        $verificaropcion = $validar->VerificarMenuServidor('tramit');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="tramites/vista/js/script_tramites.js"></script>          
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
                            <a class="navbar-brand" href="#">Tipos de Padecimiento de Salud</a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                            </ul>
                            <form class="navbar-form navbar-right" role="search">
                                <button id="tramitesBtnNuevoTramite" class="btn btn-default">
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
            <section id="tramitessecListaTramites" class="content">
                <div >
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <span class="fa fa-server"></span>
                                <h3 class="box-title hidden-xs">Lista de problemas de salud</h3>
                                <div class="box-tools">
                                    <div class="input-group">
                                        <input id="tramitesTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right"  placeholder="Búsqueda"/>
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
                                            <th class="col-xs-8 text-center">Nombre</th>
                                            <th class="col-xs-1 text-center">Iniciales</th>
                                            <th class="col-xs-1 text-center">Opción</th>
                                            <th class="col-xs-1 text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tramitesTbdListaTramites">
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                                <div class="pull-left ">
                                    <div id="msgTramitessVerificandoListaTramite" class="col-xs-1 overlay hide">
                                        <i class="fa fa-refresh fa-spin "></i>
                                        <span >
                                            <span class="visible-xs">&nbsp;</span>                                    
                                            <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                        </span>                            
                                    </div>
                                </div>
                                <ul id="tramitesUlPaginacionTramites" class="pagination pagination-sm no-margin pull-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Fin contenido lista -->

            <!--Contenido Nuevo-->
            <section id="tramitesSecNuevoTramite" class="content tramitesClsCampoOculto " >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Ingreso de Tipo de padecimiento</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tramitesTxtNombreNuevoTramite">Nombre (*):</label>
                                    <label for="tramitesTxtNombreNuevoTramite" class="text-danger pull-right hide msgErrorNuevoTramite">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Nombre
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right tramitesClsCampoValidadoNuevo text-uppercase" id="tramitesTxtNombreNuevoTramite" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tramitesTxtInicialNuevoTramite">Iniciales (*):</label>
                                    <label for="tramitesTxtInicialNuevoTramite" class="text-danger pull-right hide msgErrorNuevoTramite">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Iniciales
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right tramitesClsCampoValidadoNuevo text-uppercase" id="tramitesTxtInicialNuevoTramite" maxlength="2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tramitesSelectNuevoModulo">Área/Subjefatura (*):</label>
                                    <label for="tramitesSelectNuevoModulo" class="text-danger pull-right hide msgErrorNuevoTramite">
                                        <i class="fa fa-times-circle-o"></i>
                                        Seleccione Área/Subjefatura
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <select id="tramitesSelectNuevoModulo" multiple class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tramitesCheckboxNuevoClienteRequerido">Paciente requerido (*):</label>                                   
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <label class="form-control " for="tramitesCheckboxNuevoClienteRequerido">
                                            <input type="checkbox"  id="tramitesCheckboxNuevoClienteRequerido" class="pull-right">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgTramitessVerificandoNuevoTramite" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="tramitesBtnCancelarNuevoTramite"  class="btn btn-default ">
                                    <span class="fa fa-ban"></span>
                                    Cancelar
                                </button>
                                <button id="tramitesBtnGuardarNuevoTramite" class="btn btn-primary">
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
            <section id="tramitesSecEditarTramite" class="content tramitesClsCampoOculto" >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edición de Tipo de Padecimiento</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tramitesTxtNombreEditarTramite">Nombre (*):</label>
                                    <label for="tramitesTxtNombreEditarTramite" class="text-danger pull-right hide msgErrorEditarTramite">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Nombre
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right tramitesClsCampoValidadoEditar text-uppercase" id="tramitesTxtNombreEditarTramite" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tramitesTxtInicialEditarTramite">Iniciales (*):</label>
                                    <label for="tramitesTxtInicialEditarTramite" class="text-danger pull-right hide msgErrorNuevoTramite">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Iniciales
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right tramitesClsCampoValidadoEditar text-uppercase" id="tramitesTxtInicialEditarTramite" maxlength="2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tramitesSelectEditarModulo">Área/Subjefatura (*):</label>
                                    <label for="tramitesSelectEditarModulo" class="text-danger pull-right hide msgErrorNuevoTramite">
                                        <i class="fa fa-times-circle-o"></i>
                                        Seleccione Área/Subjefatura
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <select id="tramitesSelectEditarModulo" multiple class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tramitesCheckboxEditarClienteRequerido">Paciente requerido (*):</label>                                   
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <label class="form-control " for="tramitesCheckboxEditarClienteRequerido">
                                            <input type="checkbox"  id="tramitesCheckboxEditarClienteRequerido" class="pull-right">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgTramitessVerificandoEditarTramite" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="tramitesBtnCancelarEditarTramite"  class="btn btn-default ">
                                    <span class="fa fa-ban"></span>
                                    Cancelar
                                </button>
                                <button id="tramitesBtnGuardarEditarTramite" class="btn btn-primary">
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
