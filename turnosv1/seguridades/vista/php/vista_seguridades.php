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
        $verificaropcion = $validar->VerificarMenuServidor('opcseg');
        if (isset($_GET['ref']) && $verificaropcion == 1) {
            ?>
            <script src="seguridades/vista/js/script_usuarios.js"></script>
            <script src="seguridades/vista/js/script_opciones.js"></script>        
            <script src="seguridades/vista/js/script_perfiles.js"></script>       
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
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#seguridadesTabModuloUsuarios" data-toggle="tab">Usuarios</a></li>                    
                    <li><a href="#seguridadesTabModuloPerfiles" data-toggle="tab">Perfiles</a></li>
                    <li ><a href="#seguridadesTabModuloOpciones" data-toggle="tab">Permisos</a></li>
                </ul>
                <div id="seguridadesTabPrincipal" class="tab-content">
                    <div class="tab-pane active" id="seguridadesTabModuloUsuarios">
                        <!-- Contenido Cabecera -->
                        <section class="content-header">
                            <div class="col-md-12 column">
                                <nav class="navbar navbar-default" role="navigation">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button> 
                                        <a class="navbar-brand" href="#">Usuarios</a>
                                    </div>
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav">
                                        </ul>
                                        <form class="navbar-form navbar-right" >
                                            <button id="usuariosBtnNuevoUsuario" class="btn btn-default">
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
                        <section id="usuariossecListaUsuarios" class="content">
                            <div >
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <span class="fa fa-user"></span>
                                            <h3 class="box-title hidden-xs">Lista de Usuarios</h3>
                                            <div class="box-tools">
                                                <div class="input-group">
                                                    <input id="usuariosTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right"  placeholder="Búsqueda"/>
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
                                                        <th class="col-xs-3 text-center">Nombres</th>
                                                        <th class="col-xs-2 hidden-xs text-center">CUI</th>
                                                        <th class="col-xs-2 hidden-xs text-center">Email</th>
                                                        <th class="col-xs-1 text-center">Opción</th>
                                                        <th class="col-xs-1 text-center">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="usuariosTbdListaUsuarios">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer clearfix">
                                            <div class="pull-left ">
                                                <div id="msgUsuariosVerificandoListaUsuarios" class="col-xs-1 overlay hide">
                                                    <i class="fa fa-refresh fa-spin "></i>
                                                    <span >
                                                        <span class="visible-xs">&nbsp;</span>                                    
                                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                                    </span>                            
                                                </div>
                                            </div>
                                            <ul id="usuariosUlPaginacionUsuarios" class="pagination pagination-sm no-margin pull-right">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- /Fin contenido lista -->

                        <!--Contenido Nuevo -->
                        <section id="usuariosSecNuevoUsuario" class="content usuariosClsCampoOculto" >
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Ingreso de Usuarios</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuariosTxtNombresNuevoUsuario">Nombres (*):</label>
                                                <label for="usuariosTxtNombresNuevoUsuario" class="text-danger pull-right hide msgErrorNuevoUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Nombres
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input id="usuariosTxtNombresNuevoUsuario" type="text" class="form-control pull-right text-uppercase usuariosClsCampoValidadoNuevo" maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosTxtApellidosNuevoUsuario">Apellidos (*):</label>
                                                <label for="usuariosTxtApellidosNuevoUsuario" class="text-danger pull-right hide msgErrorNuevoUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Apellidos
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right usuariosClsCampoValidadoNuevo text-uppercase" id="usuariosTxtApellidosNuevoUsuario" maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosTxtCedulaNuevoUsuario">CUI (*):</label>
                                                <label for="usuariosTxtCedulaNuevoUsuario" class="text-danger pull-right hide msgErrorNuevoUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese CUI
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase usuariosClsCampoValidadoNuevo" id="usuariosTxtCedulaNuevoUsuario" maxlength="13"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosSelModulosNuevoUsuario">Área/Subjefatura (*):</label>
                                                <label for="usuariosSelModulosNuevoUsuario" class="text-danger pull-right hide msgErrorNuevoUsuarioModulo">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione Área/Subjefatura
                                                </label>
                                                <select id="usuariosSelModulosNuevoUsuario" class="pull-right text-uppercase">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuariosTxtEmailNuevoUsuario">Email:</label>
                                                <label for="usuariosTxtEmailNuevoUsuario" class="text-danger pull-right hide UsuariosClsMsgErrorEmailInvalidoNuevoUsuario" id="msgErrorEmailInvalidoNuevoUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Email inválido
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right usuariosClsCampoValidadoFormatoNuevo text-lowercase" id="usuariosTxtEmailNuevoUsuario" maxlength="100"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosSelPerfilesNuevoUsuario">Perfíl (*):</label>
                                                <label for="usuariosSelPerfilesNuevoUsuario" class="text-danger pull-right hide msgErrorNuevoUsuarioPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione perfíl
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa  fa-group"></i>
                                                    </div>
                                                    <select id="usuariosSelPerfilesNuevoUsuario" class="pull-right text-uppercase" multiple>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <img id="usuariosImgFotoUsuario" class="pull-right " src="includes/img/imagenUsuarioDefecto.png" width="50" height="50"/>
                                                <label for="exampleInputFile" >Foto:</label><br>
                                                <button  class="btn btn-default" id="usuariosBtnSubirFotoNuevoUsuario">
                                                    <span class="fa fa-folder-open">
                                                    </span>
                                                    <span class="hidden-xs">  Subir Foto </span>
                                                </button>
                                                <button  class="btn btn-default" id="usuariosBtnAbrirTomarFotoNuevoUsuario">
                                                    <span class="fa fa-camera">
                                                    </span>
                                                    <span class="hidden-xs">  TomarFoto </span>
                                                </button>
                                                <input type="file" name="usuariosFilFotoSubirUsuario" id="usuariosFilFotoSubirUsuario" class="hide" accept="image/x-png,  image/jpeg" >
                                            </div>
                                        </div> </div>
                                    <div class="box-footer ">
                                        <div class="pull-left ">
                                            <div id="msgUsuariosVerificandoNuevoUsuarios" class="col-xs-1 overlay hide">
                                                <i class="fa fa-refresh fa-spin "></i>
                                                <span >
                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                                </span>                            
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button id="usuariosBtnCancelarNuevoUsuario"  class="btn btn-default ">
                                                <span class="fa fa-ban"></span>
                                                Cancelar
                                            </button>
                                            <button id="usuariosBtnGuardarNuevoUsuario" class="btn btn-primary">
                                                <span class="fa fa-save"></span>
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Fin Contenido Nuevo -->

                        <!-- Contenido Editar-->
                        <section id="usuariosSecEditarUsuario" class="content usuariosClsCampoOculto" >
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Edición de Usuarios</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuariosTxtNombresEditarUsuario">Nombres (*):</label>
                                                <label for="usuariosTxtNombresEditarUsuario" class="text-danger pull-right hide msgErrorEditarUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Nombres
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input id="usuariosTxtNombresEditarUsuario" type="text" class="form-control pull-right usuariosClsCampoValidadoEditar text-uppercase" maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosTxtApellidosEditarUsuario">Apellidos (*):</label>
                                                <label for="usuariosTxtApellidosEditarUsuario" class="text-danger pull-right hide msgErrorEditarUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Apellidos
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right usuariosClsCampoValidadoEditar text-uppercase" id="usuariosTxtApellidosEditarUsuario" maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosTxtCedulaEditarUsuario">CUI (*):</label>
                                                <label for="usuariosTxtCedulaEditarUsuario" class="text-danger pull-right hide msgErrorEditarUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese CUI
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right usuariosClsCampoValidadoEditar text-uppercase" id="usuariosTxtCedulaEditarUsuario"  maxlength="13"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosTxtEmailEditarUsuario">Email:</label>
                                                <label for="usuariosTxtEmailEditarUsuario" class="text-danger pull-right hide text-lowercase UsuariosClsMsgErrorEmailInvalidoEditarUsuario" id="msgErrorEmailInvalidoEditarUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Email inválido
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right  usuariosClsCampoValidadoFormatoEditar" id="usuariosTxtEmailEditarUsuario" maxlength="100"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosSelModulosEditarUsuario">Área/Subjefatura (*):</label>
                                                <label for="usuariosSelModulosEditarUsuario" class="text-danger pull-right hide msgErrorEditarUsuarioModulo">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione Área/Subjefatura
                                                </label>
                                                <select id="usuariosSelModulosEditarUsuario" class="pull-right text-uppercase">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                           
                                            <div class="form-group">
                                                <label for="usuariosTxtClaveEditarUsuario">Clave:</label>
                                                <label for="usuariosTxtClaveEditarUsuario" class="text-danger pull-right hide UsuariosClsMsgErrorClaveInvalidoEditarUsuario" id="msgErrorClaveInvalidoEditarUsuario">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Clave Inválida
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                    <input type="password" class="form-control pull-right " id="usuariosTxtClaveEditarUsuario" placeholder="**************************"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usuariosSelPerfilesEditarUsuario">Perfíl (*):</label>
                                                <label for="usuariosSelPerfilesEditarUsuario" class="text-danger pull-right hide msgErrorEditarUsuarioPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione perfíl
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa  fa-group"></i>
                                                    </div>
                                                    <select id="usuariosSelPerfilesEditarUsuario" class="pull-right text-uppercase" multiple>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <img id="usuariosImgFotoEditarUsuario" class="pull-right " src="includes/img/imagenUsuarioDefecto.png" width="50" height="50" />
                                                <label for="exampleInputFile" >Foto:</label><br>
                                                <button  class="btn btn-default" id="usuariosBtnSubirFotoEditarUsuario">
                                                    <span class="fa fa-folder-open">
                                                    </span>
                                                    <span class="hidden-xs">  Subir Foto </span>
                                                </button>
                                                <button  class="btn btn-default" id="usuariosBtnAbrirTomarFotoEditarUsuario">
                                                    <span class="fa fa-camera">
                                                    </span>
                                                    <span class="hidden-xs">  TomarFoto </span>
                                                </button>
                                                <input type="file" name="usuariosFilFotoSubirEditarUsuario" id="usuariosFilFotoSubirEditarUsuario" class="hide" accept="image/x-png,  image/jpeg" >
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="box-footer ">
                                        <div class="pull-left ">
                                            <div id="msgUsuariosVerificandoEditarUsuarios" class="col-xs-1 overlay hide">
                                                <i class="fa fa-refresh fa-spin "></i>
                                                <span >
                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                                </span>                            
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button id="usuariosBtnCancelarEditarUsuario" class="btn btn-default ">
                                                <span class="fa fa-ban"></span>
                                                Cancelar
                                            </button>
                                            <button id="usuariosBtnGuardarEditarUsuario"  class="btn btn-primary">
                                                <span class="fa fa-save"></span>
                                                Guardar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="tab-pane" id="seguridadesTabModuloPerfiles">

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
                                        <a class="navbar-brand" href="#">Perfiles</a>
                                    </div>
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav">
                                        </ul>
                                        <form class="navbar-form navbar-right" role="search">
                                            <button id="perfilesBtnNuevoPerfil" class="btn btn-default">
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
                        <section id="perfilessecListaPerfiles" class="content">
                            <div >
                                <div class="col-md-12">
                                    <div class="box box-primary">

                                        <div class="box-header with-border">
                                            <span class="fa fa-user"></span>
                                            <h3 class="box-title hidden-xs">Lista de Perfiles</h3>
                                            <div class="box-tools">
                                                <div class="input-group">
                                                    <input id="perfilesTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right"  placeholder="Búsqueda"/>
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
                                                        <th class="col-xs-7 text-center">Nombre</th>
                                                        <th class="col-xs-2 hidden-xs text-center">Acrónimo</th>
                                                        <th class="col-xs-1 text-center">Opción</th>
                                                        <th class="col-xs-1 text-center">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="perfilesTbdListaPerfiles">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer clearfix">

                                            <div class="pull-left ">
                                                <div id="msgPerfilessVerificandoListaPerfíl" class="col-xs-1 overlay hide">
                                                    <i class="fa fa-refresh fa-spin "></i>
                                                    <span >
                                                        <span class="visible-xs">&nbsp;</span>                                    
                                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                                    </span>                            
                                                </div>
                                            </div>
                                            <ul id="perfilesUlPaginacionPerfiles" class="pagination pagination-sm no-margin pull-right">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Fin contenido lista -->

                        <!--Contenido Nuevo-->
                        <section id="perfilesSecNuevoPerfil" class="content usuariosClsCampoOculto" >
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Ingreso de Perfiles</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="perfilesTxtNombreNuevoPerfil">Nombre (*):</label>
                                                <label for="perfilesTxtNombreNuevoPerfil" class="text-danger pull-right hide msgErrorNuevoPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Nombre
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right perfilesClsCampoValidadoNuevo text-uppercase" id="perfilesTxtNombreNuevoPerfil" maxlength="50"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="perfilesTxtAcronimoNuevoPerfil">Acrónimo (*):</label>
                                                <label for="perfilesTxtAcronimoNuevoPerfil" class="text-danger pull-right hide msgErrorNuevoPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Acrónimo
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase perfilesClsCampoValidadoNuevo" id="perfilesTxtAcronimoNuevoPerfil" maxlength="6" />
                                                </div>
                                            </div>
                                        </div> </div>
                                    <div class="box-footer ">
                                        <div class="pull-left ">
                                            <div id="msgPerfilessVerificandoNuevoPerfíl" class="col-xs-1 overlay hide">
                                                <i class="fa fa-refresh fa-spin "></i>
                                                <span >
                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                                </span>                            
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button id="perfilesBtnCancelarNuevoPerfil"  class="btn btn-default ">
                                                <span class="fa fa-ban"></span>
                                                Cancelar
                                            </button>
                                            <button id="perfilesBtnGuardarNuevoPerfil" class="btn btn-primary">
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
                        <section id="perfilesSecEditarPerfil" class="content usuariosClsCampoOculto" >
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Edición de Perfiles</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="perfilesTxtNombreEditarPerfil">Nombre (*):</label>
                                                <label for="perfilesTxtNombreEditarPerfil" class="text-danger pull-right hide msgErrorEditarPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Nombre
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right perfilesClsCampoValidadoEditar text-uppercase" id="perfilesTxtNombreEditarPerfil" maxlength="50"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="perfilesTxtAcronimoEditarPerfil">Acrónimo (*):</label>
                                                <label for="perfilesTxtAcronimoEditarPerfil" class="text-danger pull-right hide msgErrorEditarPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Acrónimo
                                                </label>
                                                <label for="perfilesTxtAcronimoEditarPerfil" class="text-danger pull-right hide msgErrorEspacioBlancoEditarPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    No se admite espacios en blanco
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase perfilesClsCampoValidadoEditar" id="perfilesTxtAcronimoEditarPerfil" maxlength="6" disabled/>
                                                </div>
                                            </div>  
                                        </div>
                                    </div> 
                                    <div class="box-footer ">
                                        <div class="pull-left ">
                                            <div id="msgPerfilessVerificandoEditarPerfíl" class="col-xs-1 overlay hide">
                                                <i class="fa fa-refresh fa-spin "></i>
                                                <span >
                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                                </span>                            
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button id="perfilesBtnCancelarEditarPerfil"  class="btn btn-default ">
                                                <span class="fa fa-ban"></span>
                                                Cancelar
                                            </button>
                                            <button id="perfilesBtnGuardarEditarPerfil" class="btn btn-primary">
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
                    <div class="tab-pane" id="seguridadesTabModuloOpciones">
                        <!-- Contenido Cabecera -->
                        <section class="content-header">
                            <div class="col-md-12 column">
                                <nav class="navbar navbar-default" role="navigation">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button> 
                                        <a class="navbar-brand" href="#">Permisos de los módulos del menú</a>
                                    </div>
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav">
                                        </ul>
                                        <form class="navbar-form navbar-right" role="search">
                                            <button id="opcionesBtnNuevoOpcion" class="btn btn-default">
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
                        <section id="opcionessecListaOpciones" class="content">
                            <div >
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <span class="fa fa-server"></span>
                                            <h3 class="box-title hidden-xs">Lista del Opciones</h3>
                                            <div class="box-tools">
                                                <div class="input-group">
                                                    <input id="opcionesTxtFiltroBusqueda" type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Búsqueda"/>
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
                                                        <th class="col-xs-1 text-center">Nombre</th>
                                                        <th class="col-xs-1 hidden-xs text-center">Acrónimo</th>
                                                        <th class="col-xs-1 hidden-xs text-center">Ícono</th>
                                                        <th class="col-xs-3  hidden-xs text-center">Vista</th>
                                                        <th class="col-xs-1 text-center">FullScreen</th>
                                                        <th class="col-xs-1 text-center">Opción</th>
                                                        <th class="col-xs-1 text-center">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="opcionesTbdListaOpciones">
                                                </tbody> </table>
                                        </div>
                                        <div class="box-footer clearfix">
                                            <div class="pull-left ">
                                                <div id="msgPerfilessVerificandoListaOpcion" class="col-xs-1 overlay hide">
                                                    <i class="fa fa-refresh fa-spin "></i>
                                                    <span >
                                                        <span class="visible-xs">&nbsp;</span>                                    
                                                        <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargando</span>                                    
                                                    </span>                            
                                                </div>
                                            </div>
                                            <ul id="opcionesUlPaginacionOpciones" class="pagination pagination-sm no-margin pull-right">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- /Fin contenido lista -->

                        <!--Contenido Nuevo-->
                        <section id="opcionesSecNuevoOpcion" class="content usuariosClsCampoOculto" >
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Ingreso de Opciones</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="opcionesTxtNombreNuevoOpcion">Nombre (*):</label>
                                                <label for="opcionesTxtNombreNuevoOpcion" class="text-danger pull-right hide msgErrorNuevoOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Nombre
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right opcionesClsCampoValidadoNuevo text-uppercase" id="opcionesTxtNombreNuevoOpcion" maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesTxtAcronimoNuevoOpcion">Acrónimo (*):</label>
                                                <label for="opcionesTxtAcronimoNuevoOpcion" class="text-danger pull-right hide msgErrorNuevoOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Acrónimo
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase opcionesClsCampoValidadoNuevo" id="opcionesTxtAcronimoNuevoOpcion" maxlength="6"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesTxtIconoNuevoOpcion">Icono (*):</label>
                                                <label for="opcionesTxtIconoNuevoOpcion" class="text-danger pull-right hide msgErrorNuevoOpcion" >
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Icono
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-simplybuilt"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase opcionesClsCampoValidadoNuevo" id="opcionesTxtIconoNuevoOpcion" maxlength="100"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="opcionesTxtVistaNuevoOpcion">Vista (*):</label>
                                                <label for="opcionesTxtVistaNuevoOpcion" class="text-danger pull-right hide msgErrorNuevoOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Vista
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                    <input id="opcionesTxtVistaNuevoOpcion" type="text" class="form-control pull-right text-lowercase opcionesClsCampoValidadoNuevo" maxlength="200"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesSelPerfilesNuevoOpcion">Perfíl (*):</label>
                                                <label for="opcionesSelPerfilesNuevoOpcion" class="text-danger pull-right hide msgErrorNuevoOpcionPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione perfíl
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa  fa-group"></i>
                                                    </div>
                                                    <select id="opcionesSelPerfilesNuevoOpcion" class="pull-right text-uppercase" multiple>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesTxtFullScreenNuevoOpcion">FullScreen (*):</label>
                                                <label for="opcionesTxtFullScreenNuevoOpcion" class="text-danger pull-right hide msgErrorNuevoOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione FullScreen
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                    <label class="form-control" for="opcionesTxtFullScreenNuevoOpcion">
                                                        <input id="opcionesTxtFullScreenNuevoOpcion" type="checkbox" class="checkbox pull-right text-lowercase " />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer ">
                                        <div class="pull-left ">
                                            <div id="msgPerfilessVerificandoNuevoOpcion" class="col-xs-1 overlay hide">
                                                <i class="fa fa-refresh fa-spin "></i>
                                                <span >
                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                                </span>                            
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button id="opcionesBtnCancelarNuevoOpcion"  class="btn btn-default ">
                                                <span class="fa fa-ban"></span>
                                                Cancelar
                                            </button>
                                            <button id="opcionesBtnGuardarNuevoOpcion" class="btn btn-primary">
                                                <span class="fa fa-save"></span>
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--Fin Contenido Nuevo-->

                        <!--Contenido Edición-->
                        <section id="opcionesSecEditarOpcion" class="content usuariosClsCampoOculto">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Edición de Opciones</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="opcionesTxtNombreEditarOpcion">Nombre (*):</label>
                                                <label for="opcionesTxtNombreEditarOpcion" class="text-danger pull-right hide msgErrorEditarOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Nombre
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right opcionesClsCampoValidadoEditar text-uppercase" id="opcionesTxtNombreEditarOpcion" maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesTxtAcronimoEditarOpcion">Acrónimo (*):</label>
                                                <label for="opcionesTxtAcronimoEditarOpcion" class="text-danger pull-right hide msgErrorEditarOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Acrónimo
                                                </label>
                                                <label for="opcionesTxtAcronimoEditarOpcion" class="text-danger pull-right hide msgErrorEspacioBlancoEditarOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    No se admite espacios en blanco
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-at"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase opcionesClsCampoValidadoEditar" id="opcionesTxtAcronimoEditarOpcion" disabled maxlength="6"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesTxtIconoEditarOpcion">Icono (*):</label>
                                                <label for="opcionesTxtIconoEditarOpcion" class="text-danger pull-right hide msgErrorEditarOpcion" >
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Icono
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-simplybuilt"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right text-lowercase opcionesClsCampoValidadoEditar" id="opcionesTxtIconoEditarOpcion" maxlength="100"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="opcionesTxtVistaEditarOpcion">Vista (*):</label>
                                                <label for="opcionesTxtVistaEditarOpcion" class="text-danger pull-right hide msgErrorEditarOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Ingrese Vista
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                    <input id="opcionesTxtVistaEditarOpcion" type="text" class="form-control pull-right text-lowercase opcionesClsCampoValidadoEditar" maxlength="200"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesSelPerfilesEditarOpcion">Perfíl (*):</label>
                                                <label for="opcionesSelPerfilesEditarOpcion" class="text-danger pull-right hide msgErrorEditarOpcionPerfil">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione perfíl
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa  fa-group"></i>
                                                    </div>
                                                    <select id="opcionesSelPerfilesEditarOpcion" class="pull-right text-uppercase" multiple>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="opcionesTxtFullScreenEditarOpcion">FullScreen (*):</label>
                                                <label for="opcionesTxtFullScreenEditarOpcion" class="text-danger pull-right hide msgErrorEditarOpcion">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    Seleccione FullScreen
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                    <label class="form-control" for="opcionesTxtFullScreenEditarOpcion">
                                                        <input id="opcionesTxtFullScreenEditarOpcion" type="checkbox" class="checkbox pull-right text-lowercase " />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="box-footer ">
                                        <div class="pull-left ">
                                            <div id="msgPerfilessVerificandoEditarOpcion" class="col-xs-1 overlay hide">
                                                <i class="fa fa-refresh fa-spin "></i>
                                                <span >
                                                    <span class="visible-xs">&nbsp;</span>                                    
                                                    <span class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardando</span>                                    
                                                </span>                            
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button id="opcionesBtnCancelarEditarOpcion"  class="btn btn-default ">
                                                <span class="fa fa-ban"></span>
                                                Cancelar
                                            </button>
                                            <button id="opcionesBtnGuardarEditarOpcion" class="btn btn-primary">
                                                <span class="fa fa-save"></span>
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--Fin Contenido Edición-->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
