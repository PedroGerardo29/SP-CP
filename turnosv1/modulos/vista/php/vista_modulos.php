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
        $verificaropcion = $validar->VerificarMenuServidor('modulo');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="modulos/vista/js/script_modulos.js"></script>       
            <?php
        } else {
            if ($verificaropcion == 0) {
                echo "Acceso denegado usted no tiene permisos para acceder a este módulo.";
                die();
            } else if ($verificaropcion == -2) {
                echo "Error al acceder al módulo de seguridades, por favor contactese con el proveedor del servicio.";
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
                            <a class="navbar-brand" href="#">Áreas fisicas dentro del departamento de Emergencias</a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                            </ul>
                            <form class="navbar-form navbar-right" role="search">
                                <button id="modulosBtnNuevoModulo" class="btn btn-default">
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
            <section id="modulossecListaModulos" class="content">
                <div >
                    <div class="col-md-12">
                        <div class="box box-primary" >
                            <div class="box-header with-border">
                                <span class="fa fa-server"></span>
                                <h3 class="box-title hidden-xs">Lista de Áreas/Subjefaturas</h3>
                                <div class="box-tools">
                                    <div class="input-group">
                                        <input id="modulosTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right"  placeholder="Búsqueda"/>
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
                                            <th class="col-xs-1 text-center">Id</th>                                            
                                            <th class="col-xs-8 text-center">Nombre de la Subjefatura</th>
                                            <th class="col-xs-1 text-center">Opción</th>
                                            <th class="col-xs-1 text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modulosTbdListaModulos">
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                                <div class="pull-left ">
                                    <div id="msgModulossVerificandoListaModulo" class="col-xs-1 overlay hide">
                                        <i class="fa fa-refresh fa-spin "></i>
                                        <span >
                                            <span class="visible-xs">&nbsp;</span>                                    
                                            <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                        </span>                            
                                    </div>
                                </div>
                                <ul id="modulosUlPaginacionModulos" class="pagination pagination-sm no-margin pull-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Fin contenido lista -->

            <!--Contenido Nuevo-->
            <section id="modulosSecNuevoModulo" class="content modulosClsCampoOculto" >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Ingreso de Áreas/Subjefaturas</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modulosTxtDescripcionNuevoModulo">Descripción (*):</label>
                                    <label for="modulosTxtDescripcionNuevoModulo" class="text-danger pull-right hide msgErrorNuevoModulo">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Descripción
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right modulosClsCampoValidadoNuevo text-uppercase" id="modulosTxtDescripcionNuevoModulo" maxlength="100"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgModulossVerificandoNuevoModulo" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="modulosBtnCancelarNuevoModulo"  class="btn btn-default ">
                                    <span class="fa fa-ban"></span>
                                    Cancelar
                                </button>
                                <button id="modulosBtnGuardarNuevoModulo" class="btn btn-primary">
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
            <section id="modulosSecEditarModulo" class="content modulosClsCampoOculto" >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edición de Áreas/Subjefaturas</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modulosTxtDescripcionEditarModulo">Descripción (*):</label>
                                    <label for="modulosTxtDescripcionEditarModulo" class="text-danger pull-right hide msgErrorEditarModulo">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Descripción
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right modulosClsCampoValidadoEditar text-uppercase" id="modulosTxtDescripcionEditarModulo" maxlength="100"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modulosTxtIdEditarModulo">Id (*):</label>
                                    <label for="modulosTxtIdEditarModulo" class="text-danger pull-right hide msgErrorEditarModulo">
                                        <i class="fa fa-times-circle-o"></i>
                                        Ingrese Id
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right text-uppercase " disabled id="modulosTxtIdEditarModulo" maxlength="100"/>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgModulossVerificandoEditarModulo" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="modulosBtnCancelarEditarModulo"  class="btn btn-default ">
                                    <span class="fa fa-ban"></span>
                                    Cancelar
                                </button>
                                <button id="modulosBtnGuardarEditarModulo" class="btn btn-primary">
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
