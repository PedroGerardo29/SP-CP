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
        $verificaropcion = $validar->VerificarMenuServidor('opcon');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="parametros/vista/js/script_parametros.js"></script>        
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
    <body >
        <div class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#parametrosTabModuloInformacionInstitucion" data-toggle="tab">Información de Institución</a></li>                    
                    <li><a href="#parametrosTabModuloInformacionMultimedia" data-toggle="tab">Información Multimedia</a></li>
                    <li><a href="#parametrosTabModuloInformacionTurno" data-toggle="tab">Información de Turnos</a></li>
                    <li><a href="#parametrosTabModuloInformacionSistema" data-toggle="tab">Información de Sistema</a></li>
                </ul>
                <div id="parametrosTabPrincipal" class="tab-content">
                    <div class="tab-pane active" id="parametrosTabModuloInformacionInstitucion">
                        <div id="parametrosTabModuloInformacionInstitucion">
                            <section class="content">
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_NOMINS">Nombre (*):</label>
                                                    <label for="parametrosIdParametrosPAR_NOMINS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Nombre
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-at"></i>
                                                        </div>
                                                        <input id="parametrosIdParametrosPAR_NOMINS" data-par="PAR_NOMINS" type="text" class="parametrosClsInput form-control pull-right  parametrosClsCampoValidadoNuevo" maxlength="45" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_SIGINS">Siglas:</label>
                                                    <label for="parametrosIdParametrosPAR_SIGINS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Siglas
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-at"></i>
                                                        </div>
                                                        <input type="text" id="parametrosIdParametrosPAR_SIGINS" data-par="PAR_SIGINS" class="parametrosClsInput  form-control pull-right  "  maxlength="6"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_DIRINS">Dirección (*):</label>
                                                    <label for="parametrosIdParametrosPAR_DIRINS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Dirección
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-street-view"></i>
                                                        </div>
                                                        <input type="text" class="parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo " id="parametrosIdParametrosPAR_DIRINS" data-par="PAR_DIRINS" maxlength="100"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_UBIINS">Ubicación (*):</label>
                                                    <label for="parametrosIdParametrosPAR_UBIINS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Ubicación
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-street-view"></i>
                                                        </div>
                                                        <input type="text" class="parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo" id="parametrosIdParametrosPAR_UBIINS" data-par="PAR_UBIINS" maxlength="50"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_TELINS">Teléfono (*):</label>
                                                    <label for="parametrosIdParametrosPAR_TELINS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Teléfono
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </div>
                                                        <input type="text" class="parametrosClsInput form-control pull-right  parametrosClsCampoValidadoNuevo" id="parametrosIdParametrosPAR_TELINS" data-par="PAR_TELINS" maxlength="20"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_EMAINS">Email:</label>
                                                    <label for="parametrosIdParametrosPAR_EMAINS" id="msgErrorEmailInvalidoNuevoParametro" class="text-danger pull-right hide ParametrosClsMsgErrorEmailInvalidoNuevoParametro" >
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Email inválido
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </div>
                                                        <input type="text" class="parametrosClsInput form-control pull-right parametrosClsCampoValidadoFormatoNuevo text-lowercase" id="parametrosIdParametrosPAR_EMAINS" data-par="PAR_EMAINS" maxlength="150"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_WEBINS">Sitio Web:</label>
                                                    <label for="parametrosIdParametrosPAR_WEBINS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Sitio Web
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-at"></i>
                                                        </div>
                                                        <input type="text" class="parametrosClsInput form-control pull-right text-lowercase" id="parametrosIdParametrosPAR_WEBINS" data-par="PAR_WEBINS"  maxlength="100"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parametrosIdParametrosPAR_MEN">Mensaje (*):</label>
                                                    <label for="parametrosIdParametrosPAR_MEN" class="text-danger pull-right hide msgErrorNuevoParametro">
                                                        <i class="fa fa-times-circle-o"></i>
                                                        Ingrese Mensaje
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-at"></i>
                                                        </div>
                                                        <textarea  class="parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo" rows="7"id="parametrosIdParametrosPAR_MEN" data-par="PAR_MEN">
                                                
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer ">
                                            <div class="pull-left ">
                                                <div id="msgParametrosVerificandoNuevoParametros" class="col-xs-1 overlay hide">
                                                    <i class="fa fa-refresh fa-spin "></i>
                                                    <span >
                                                        <span class="visible-xs">&nbsp;</span>                                    
                                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                                    </span>                            
                                                </div>
                                            </div>
                                            <div class="pull-left ">
                                                <div id="msgParametrosCargandoListadoParametrosInstitucion" class="col-xs-1 overlay hide">
                                                    <i class="fa fa-refresh fa-spin "></i>
                                                    <span >
                                                        <span class="visible-xs">&nbsp;</span>                                    
                                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                                    </span>                            
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                                <button id="parametrosBtnGuardarParametros" class="btn btn-primary">
                                                    <span class="fa fa-save"></span>
                                                    Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="tab-pane " id="parametrosTabModuloInformacionMultimedia">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div id="parametrosDivContenedorLogo">
                                                <img id="parametrosImgFotoParametro" class="pull-right " src="includes/img/logoinstitucion.png" />
                                            </div>
                                            <label for="parametrosFilFotoSubirParametro" >Logo (.png - Max. 2MB):</label><br>
                                            <button  class="btn btn-default" id="parametrosBtnSubirFotoNuevoParametro">
                                                <span class="fa fa-folder-open">
                                                </span>
                                                <span class="hidden-xs">Subir Logo </span>
                                            </button>
                                            <input type="file" name="parametrosFilFotoSubirParametro" id="parametrosFilFotoSubirParametro" class="hide" accept="image/x-png" >
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <div class="pull-right"  id="parametrosDivContenedorTimbre">                                           
                                                <audio id="parametrosAudTimbreParametro" controls src="includes/sounds/timbre.mp3"  class="thumb"></audio>
                                            </div>                                        
                                            <label for="exampleInputFile" >Timbre (.mp3 - Max. 1MB):</label><br>
                                            <button  class="btn btn-default" id="parametrosBtnSubirTimbreNuevoParametro">
                                                <span class="fa fa-folder-open">
                                                </span>
                                                <span class="hidden-xs">Subir Timbre </span>
                                            </button>
                                            <input type="file" name="parametrosFilTimbreSubirParametro" id="parametrosFilTimbreSubirParametro" class="hide" accept="audio/mp3" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <div class="pull-right " id="parametrosDivContenedorVideo">
                                                <video id="parametrosImgVideoParametro"   controls class="thumb" >
                                                    Tu navegador no implementa el elemento <code>video</code>.
                                                </video>
                                            </div>
                                            <label for="exampleInputFile" id="parametrosLblVideo" >Video (.mp4 - Max. 40MB):</label>
                                            <input type="file" name="parametrosFilevideo" id="parametrosFilevideo" class="hide" accept="video/mp4"><br>
                                            <button  class="btn btn-default" id="parametrosBtnSubirVideoNuevoParametro">
                                                <span class="fa fa-folder-open">
                                                </span>
                                                <span class="hidden-xs">  Subir Video </span>
                                            </button>                                  
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box box-primary collapsed-box">
                                            <div class="box-header with-border">
                                                <span class="fa fa-video-camera"></span>
                                                <h3 class="box-title">Lista de Videos</h3>
                                                <div class="box-tools pull-right">
                                                    <button id="parametrosBtnCollapse" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body">

                                                <div class="box box-primary" >
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">&nbsp;</h3>
                                                        <div class="box-tools">
                                                            <div class="input-group">
                                                                <input id="parametrosTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right"  placeholder="Búsqueda"/>
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
                                                                    <th class="col-xs-2 hidden-xs text-center">Vista previa</th>
                                                                    <th class="col-xs-1 text-center">Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="parametrosTbdListaVideos">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="box-footer clearfix">
                                                        <div class="pull-left ">
                                                            <div id="msgParametrosVerificandoListaParametros" class="col-xs-1 overlay hide">
                                                                <i class="fa fa-refresh fa-spin "></i>
                                                                <span >
                                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                                                </span>                            
                                                            </div>
                                                        </div>
                                                        <ul id="parametrosUlPaginacionParametros" class="pagination pagination-sm no-margin pull-right">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="parametrosTabModuloInformacionTurno">
                        <div class=" box-body">
                            <div id="parametrosDivContenidoParametrosTurnos">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_ANCTIC">Ancho Ticket (*):</label>
                                        <label for="parametrosIdParametrosPAR_ANCTIC" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Ancho Ticket
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-file-text-o"></i>
                                            </div>
                                            <input type="text" id="parametrosIdParametrosPAR_ANCTIC" data-tipo="css" data-valor="width" data-ref="parametrosIdTurnosVistaPreviaTicket" placeholder="Valor en milímetros" data-par="PAR_ANCTIC" class="parametrosClsEntero parametrosClsInput  form-control pull-right   parametrosClsCampoValidadoNuevo"  maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_ANCLOG">Ancho Logo (*):</label>
                                        <label for="parametrosIdParametrosPAR_ANCLOG" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Ancho Logo
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa   fa-file-image-o"></i>
                                            </div>
                                            <input type="text" id="parametrosIdParametrosPAR_ANCLOG" data-tipo="css" data-valor="width" data-ref="parametrosTurnosVistaPreviaLogo" placeholder="Valor en milímetros"  class="parametrosClsEntero parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo "  data-par="PAR_ANCLOG" maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_ALTLOG">Alto Logo (*):</label>
                                        <label for="parametrosIdParametrosPAR_ALTLOG" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Alto Logo 
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa  fa-file-image-o"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="height" data-ref="parametrosTurnosVistaPreviaLogo" class="parametrosClsEntero parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo" placeholder="Valor en milímetros" id="parametrosIdParametrosPAR_ALTLOG" data-par="PAR_ALTLOG" maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_LOGVIS">Logo Visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_LOGVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Logo Visible
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa  fa-file-image-o"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_LOGVIS">
                                                <input type="checkbox" data-tipo="boolean" data-valor="visible" data-ref="parametrosTurnosVistaPreviaLogo" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_LOGVIS" data-par="PAR_LOGVIS" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUETUR">Fuente Turno (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUETUR" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Turno
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-sort-numeric-asc"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="font-size" data-ref="parametrosTurnosVistaPreviaTurno" class="parametrosClsEntero parametrosClsInput form-control pull-right  parametrosClsCampoValidadoNuevo" placeholder="Valor en milímetros" id="parametrosIdParametrosPAR_FUETUR" data-par="PAR_FUETUR" maxlength="3"/>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUETRA">Fuente Trámite (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUETRA" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Trámite
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-server"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="font-size" data-ref="parametrosTurnosVistaPreviaModulo" id="parametrosIdParametrosPAR_FUETRA" data-par="PAR_FUETRA" placeholder="Valor en milímetros" class="parametrosClsEntero parametrosClsInput  form-control pull-right  "  maxlength="3"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_TRAVIS">Trámite visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_TRAVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Trámite visible
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-server"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_TRAVIS">
                                                <input type="checkbox" data-tipo="boolean" data-valor="visible" data-ref="parametrosTurnosVistaPreviaModulo" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_TRAVIS" data-par="PAR_TRAVIS" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUEESP">Fuente Espera (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUEESP" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Espera
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-desktop"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="font-size" data-ref="turnosVistaPreviaEspera" placeholder="Valor en milímetros" class="parametrosClsEntero parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo " id="parametrosIdParametrosPAR_FUEESP" data-par="PAR_FUEESP" maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_ESPVIS">Espera visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_ESPVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Espera visible
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-desktop"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_ESPVIS">
                                                <input type="checkbox" data-tipo="boolean" data-valor="visible" data-ref="turnosVistaPreviaEspera" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_ESPVIS" data-par="PAR_ESPVIS" />
                                            </label>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUEHOR">Fuente Hora (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUEHOR" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Hora 
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="font-size" data-ref="ParametrosTurnosVistaPreviaHora" placeholder="Valor en milímetros" class="parametrosClsEntero parametrosClsInput form-control pull-right  parametrosClsCampoValidadoNuevo" id="parametrosIdParametrosPAR_FUEHOR" data-par="PAR_FUEHOR" maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_HORVIS">Hora Visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_HORVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Hora Visible
                                        </label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_HORVIS">
                                                <input type="checkbox" data-tipo="boolean" data-valor="visible" data-ref="ParametrosTurnosVistaPreviaHora" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_HORVIS" data-par="PAR_HORVIS" />
                                            </label>  
                                        </div>  
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUEFEC">Fuente Fecha (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUEFEC" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Fecha
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="font-size" data-ref="parametrosTurnosVistaPreviaFecha" placeholder="Valor en milímetros" class="parametrosClsEntero parametrosClsInput form-control pull-right  parametrosClsCampoValidadoNuevo" id="parametrosIdParametrosPAR_FUEFEC" data-par="PAR_FUEFEC" maxlength="3"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FECVIS">Fecha Visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_FECVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Fecha Visible 
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_FECVIS">
                                                <input type="checkbox" data-tipo="boolean" data-valor="visible" data-ref="parametrosTurnosVistaPreviaFecha" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_FECVIS" data-par="PAR_FECVIS" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUENOM">Fuente Nombre (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUENOM" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Nombre
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i>
                                            </div>
                                            <input type="text" data-tipo="css" data-valor="font-size" data-ref="parametrosTurnosVistaPreviaNombre" placeholder="Valor en milímetros" class="parametrosClsEntero parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo " id="parametrosIdParametrosPAR_FUENOM" data-par="PAR_FUENOM" maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_NOMVIS">Nombre Visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_NOMVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Nombre Visible 
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_NOMVIS">
                                                <input type="checkbox"  data-tipo="boolean" data-valor="visible" data-ref="parametrosTurnosVistaPreviaNombre" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_NOMVIS" data-par="PAR_NOMVIS" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_FUESIT">Fuente Sitio Web (*):</label>
                                        <label for="parametrosIdParametrosPAR_FUESIT" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Fuente Sitio Web
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i>
                                            </div>
                                            <input type="text" data-par="PAR_FUESIT" data-tipo="css" data-valor="font-size" data-ref="parametrosTurnosVistaPreviaSitioWeb" placeholder="Valor en milímetros" class="parametrosClsInput parametrosClsEntero  form-control pull-right  parametrosClsCampoValidadoNuevo" id="parametrosIdParametrosPAR_FUESIT" maxlength="3"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_SITVIS">Sitio Web  Visible (*):</label>
                                        <label for="parametrosIdParametrosPAR_SITVIS" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Sitio Web Visible
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i>
                                            </div>
                                            <label class="form-control" for="parametrosIdParametrosPAR_SITVIS">
                                                <input type="checkbox" data-tipo="boolean" data-valor="visible" data-ref="parametrosTurnosVistaPreviaSitioWeb" class="parametrosClsInput pull-right" id="parametrosIdParametrosPAR_SITVIS" data-par="PAR_SITVIS" />
                                            </label>    
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <br>
                                        <button  class="btn btn-default col-xs-12" id="parametrosBtnVistaPreviaTicket">
                                            <span class="fa fa-eye">
                                            </span>
                                            <span class="hidden-xs">  Vista Previa </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="parametrosDivContenidoVistaPrevia" >
                                <div id="parametrosDivContenedorTicket">
                                    <div id="parametrosIdTurnosVistaPreviaTicket" >
                                        <div id="parametrosIdTurnosVistaPreviaDivContenedorLogo" >
                                            <img id="parametrosTurnosVistaPreviaLogo" src="includes/img/logoinstitucion.png" >
                                        </div>
                                        <div id="parametrosTurnosDivContenedoPrincipalTurno">
                                            <b>
                                                <div>
                                                    <div id="parametrosTurnosVistaPreviaTurno" class="parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviacentrado">TURNO</div>
                                                </div>
                                                <div>
                                                    <div id="parametrosTurnosVistaPreviaModulo" class="parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviacentrado">TRÁMITE</div> 
                                                </div>
                                            </b> 
                                        </div> 
                                        <div id="parametrosTurnosDivContenedorFooter" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal">                                           
                                            <div id="turnosVistaPreviaEspera" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatextoizquierda">
                                                Turnos en espera: 0
                                            </div>
                                        </div>
                                        <div id="parametrosTurnosDivContenedorFooter2" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal">
                                            <div  class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoizquierda">                                                
                                                <div id="parametrosTurnosVistaPreviaFecha" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoizquierda parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal">

                                                </div>
                                                <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                                    &nbsp;
                                                </div>
                                            </div>
                                            <div class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha">
                                                <div id="ParametrosTurnosVistaPreviaHora" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal">

                                                </div>
                                                <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                                    &nbsp;
                                                </div>
                                            </div>                                                                                               
                                        </div>
                                        <div id="ParametrosparametrosTurnosDivContenedorFooterInfo" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal">
                                            <div class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviatextoizquierda">
                                                <div id="parametrosTurnosVistaPreviaNombre" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoizquierda parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal">
                                                    <?php
                                                    if (!$_SESSION) {
                                                        session_start();
                                                    }
                                                    echo $_SESSION['PAR_NOMINS'];
                                                    ?>
                                                </div>
                                                <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                                    &nbsp;
                                                </div>
                                            </div>
                                            <div class="parametorsClsTicketVistaPreviamedio parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha">
                                                <div id="parametrosTurnosVistaPreviaSitioWeb" class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal">
                                                    <?php
                                                    if (!$_SESSION) {
                                                        session_start();
                                                    }
                                                    echo $_SESSION['PAR_WEBINS'];
                                                    ?>
                                                </div>
                                                <div  class="parametorsClsTicketVistaPreviaflotaizquierda parametorsClsTicketVistaPreviatextoderecha parametorsClsTicketVistaPreviapading2 parametorsClsTicketVistaPreviatotal parametorsClsTicketVistaPreviaoculto">
                                                    &nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgParametrosVerificandoNuevoParametrosTurnos" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-left ">
                                <div id="msgParametrosCargandoListadoParametrosTurnos" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="parametrosBtnGuardarParametrosTurnos" class="btn btn-primary">
                                    <span class="fa fa-save"></span>
                                    Guardar
                                </button>
                                <button id="parametrosBtnGuardarCerrarVistaPrevia" class="btn btn-primary hide" >
                                    <span class="fa fa-close"></span>
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="parametrosTabModuloInformacionSistema">
                        <div class=" box-body">
                            <div id="parametrosDivContenidoParametrosSistema">

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label >Tipo de validación (*):</label>
                                        <label  class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Seleccione Tipo de validación
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-server"></i>
                                            </div>
                                            <label class="form-control" >
                                                <div class="pull-left">
                                                    <label class="hidden-xs" for="parametrosIdParametrosPAR_TIPVALMANUAL">Manual &nbsp;</label>
                                                    <label class="hidden-sm hidden-md hidden-lg" for="parametrosIdParametrosPAR_TIPVALMANUAL">M&nbsp;</label>
                                                    <input type="radio" name="parametrosIdParametrosPAR_TIPVAL"  id="parametrosIdParametrosPAR_TIPVALMANUAL" value="MANUAL" class="parametrosClsInput pull-right"  data-par="PAR_TIPVAL" checked/>
                                                </div>
                                                <div class="pull-right">
                                                    <label class="hidden-xs" for="parametrosIdParametrosPAR_TIPVALWEBSERVICE">Web Service &nbsp;</label>
                                                    <label class="hidden-sm hidden-md hidden-lg" for="parametrosIdParametrosPAR_TIPVALWEBSERVICE">WS&nbsp;</label>
                                                    <input type="radio" name="parametrosIdParametrosPAR_TIPVAL" id="parametrosIdParametrosPAR_TIPVALWEBSERVICE" value="WEBSERVICE" class="parametrosClsInput pull-right"  data-par="PAR_TIPVAL" />
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_TIEESP">Tiempo de espera (*):</label>
                                        <label for="parametrosIdParametrosPAR_TIEESP" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Tiempo de espera
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input type="text" class="parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo parametrosClsEntero" id="parametrosIdParametrosPAR_TIEESP" data-par="PAR_TIEESP"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="parametrosIdParametrosPAR_UMBESP">Umbral de espera (*):</label>
                                        <label for="parametrosIdParametrosPAR_UMBESP" class="text-danger pull-right hide msgErrorNuevoParametro">
                                            <i class="fa fa-times-circle-o"></i>
                                            Ingrese Umbral de Espera
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input type="text" class="parametrosClsInput form-control pull-right parametrosClsCampoValidadoNuevo parametrosClsEntero" id="parametrosIdParametrosPAR_UMBESP" data-par="PAR_UMBESP"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer ">
                            <div class="pull-left ">
                                <div id="msgParametrosVerificandoNuevoParametrosSistema" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-left ">
                                <div id="msgParametrosCargandoListadoParametrosSistema" class="col-xs-1 overlay hide">
                                    <i class="fa fa-refresh fa-spin "></i>
                                    <span >
                                        <span class="visible-xs">&nbsp;</span>                                    
                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                    </span>                            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button id="parametrosBtnGuardarParametrosSistema" class="btn btn-primary">
                                    <span class="fa fa-save"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>
