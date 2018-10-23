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
        <script src="seguridades/vista/js/script_perfil.js"></script>
    </head>
    <body>
        <section  class="content " >
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Perfíl de Usuario</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-2" id="perfilDivContenedorFoto" >
                            <div class="form-group"  id="perfilDivFormGroupFoto" >
                                <img id="perfilImgFotoUsuario" class="pull-right " src="includes/img/imagenUsuarioDefecto.png" />
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="perfilTxtNombresNuevoUsuario">Nombres :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input id="perfilTxtNombresNuevoUsuario" type="text" class="form-control pull-right text-uppercase"  maxlength="100" disabled 
                                           value=" <?php
                                           if (!isset($_SESSION)) {
                                               session_start();
                                           }
                                           echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                                           ?>
                                           "/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="perfilTxtCedulaNuevoUsuario">Cédula :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right text-lowercase " id="perfilTxtCedulaNuevoUsuario" maxlength="10" 
                                           disabled value="<?php echo $_SESSION['usuario'] ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="perfilTxtEmailNuevoUsuario">Email :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right  text-lowercase" id="perfilTxtEmailNuevoUsuario" maxlength="100"
                                           disabled value="<?php echo $_SESSION['email'] ?>"/>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="box-footer ">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="box box-default collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cambio de contraseña</h3>
                                    <div class="box-tools pull-right">
                                        <button id="perfilBtnCollapse" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div >
                                        <label id="idPerfilMsgClavePerfil" for="txtPerfilClaveNuevaPerfil" class="text-danger pull-right hide msgErrorPerfil">
                                            <i class="fa fa-times-circle-o"></i>
                                            Las claves no coinciden
                                        </label>
                                        <label id="idPerfilMsgClaveErroneaPerfil" for="txtPerfilClaveActualPerfil" class="text-danger pull-right hide msgErrorPerfil">
                                            <i class="fa fa-times-circle-o"></i>
                                            Clave actual inválida
                                        </label>
                                        <label id="msgPerfilClaveInvalidaPerfil" for="txtPerfilClaveNuevaPerfil" class="text-danger pull-right hide msgErrorPerfil">
                                            <i class="fa fa-times-circle-o"></i>
                                            La clave debe tener mayúsculas, minúsculas, números y mínimo ocho carácteres
                                        </label>
                                        <label for="txtPerfilUsuarioPerfil" >&nbsp;</label>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <div  >
                                            <label for="txtPerfilClaveActualPerfil" class="text-danger pull-right hide msgErrorPerfil">
                                                <i class="fa fa-times-circle-o"></i>
                                                Ingrese  <label class="hidden-xs">Clave Actual</label>
                                            </label>
                                            <label for="txtPerfilClaveActualPerfil">Clave Actual :</label>
                                            <input type="password" id="txtPerfilClaveActualPerfil" class="form-control clsPerfilInputPerfil"/>
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback" >
                                        <div >
                                            <label for="txtPerfilClaveNuevaPerfil" class="text-danger pull-right hide msgErrorPerfil">
                                                <i class="fa fa-times-circle-o"></i>
                                                Ingrese  <label class="hidden-xs"> Clave Nueva</label>
                                            </label>
                                            <label for="txtPerfilClaveNuevaPerfil">Clave Nueva :</label>
                                            <input type="password" id="txtPerfilClaveNuevaPerfil" class="form-control clsPerfilInputPerfil"/>
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback"  >
                                        <div >
                                            <label for="txtPerfilClaveNuevaConfirmarPerfil" class="text-danger pull-right hide msgErrorPerfil">
                                                <i class="fa fa-times-circle-o"></i>
                                                Confirme  <label class="hidden-xs">Clave Nueva</label>
                                            </label>
                                            <label for="txtPerfilClaveNuevaConfirmarPerfil">Clave Nueva :</label>
                                            <input type="password" id="txtPerfilClaveNuevaConfirmarPerfil" class="form-control clsPerfilInputPerfil"/>
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-xs-4 col-sm-6">    
                                            <div id="msgPerfilVerificandoClavePerfil" class="overlay hide">
                                                <span class="hidden-xs">Verificando</span>
                                                <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-8 col-sm-offset-2 col-sm-4" >
                                            <button  id="btnPerfilGuardarClavePerfil" class="btn btn-primary btn-block btn-flat" >
                                                <span class="fa fa-save"></span>
                                                Guardar
                                            </button>
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
