<?php error_reporting(\E_ERROR); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link href="includes/sweetalert2-master/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
    </head>
    <body>     

        <div id="loginCambioCredenciales" class="login-box">
            <div class="login-box-msg" >
                <b>Cambio de Credenciales</b>
            </div>
            <div class="login-box-body">
                <div class="login-box-body">
                    <div >
                        <label id="idUsuariosMsgClaveLogin" for="txtUsuariosClaveNuevaLogin" class="text-danger pull-right hide msgErrorLogin">
                            <i class="fa fa-times-circle-o"></i>
                            Las claves no coinciden
                        </label>
                        <label id="idUsuariosMsgClaveErroneaLogin" for="txtUsuariosClaveActualLogin" class="text-danger pull-right hide msgErrorLogin">
                            <i class="fa fa-times-circle-o"></i>
                            Clave actual inválida
                        </label>
                        <label id="msgUsuariosClaveInvalidaLogin" for="txtUsuariosClaveNuevaLogin" class="text-danger pull-right hide msgErrorLogin">
                            <i class="fa fa-times-circle-o"></i>
                            La clave debe tener mayúsculas, minúsculas, números y mínimo ocho carácteres
                        </label>
                        <label for="txtUsuariosUsuarioLogin" >&nbsp;</label>
                    </div>
                    <div class="form-group has-feedback">
                        <div  >
                            <label for="txtUsuariosClaveActualLogin" class="text-danger pull-right hide msgErrorLogin">
                                <i class="fa fa-times-circle-o"></i>
                                Ingrese  <label class="hidden-xs">Clave Actual</label>
                            </label>
                            <label for="txtUsuariosClaveActualLogin">Clave Actual :</label>
                            <input type="password" id="txtUsuariosClaveActualLogin" class="form-control clsUsuariosInputLogin"/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback" >
                        <div >
                            <label for="txtUsuariosClaveNuevaLogin" class="text-danger pull-right hide msgErrorLogin">
                                <i class="fa fa-times-circle-o"></i>
                                Ingrese  <label class="hidden-xs"> Clave Nueva</label>
                            </label>
                            <label for="txtUsuariosClaveNuevaLogin">Clave Nueva :</label>
                            <input type="password" id="txtUsuariosClaveNuevaLogin" class="form-control clsUsuariosInputLogin"/>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback"  >
                        <div >
                            <label for="txtUsuariosClaveNuevaConfirmarLogin" class="text-danger pull-right hide msgErrorLogin">
                                <i class="fa fa-times-circle-o"></i>
                                Confirme  <label class="hidden-xs">Clave Nueva</label>
                            </label>
                            <label for="txtUsuariosClaveNuevaConfirmarLogin">Clave Nueva :</label>
                            <input type="password" id="txtUsuariosClaveNuevaConfirmarLogin" class="form-control clsUsuariosInputLogin"/>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-xs-4 col-sm-6">    
                            <div id="msgUsuariosVerificandoClaveLogin" class="overlay hide">
                                <span class="hidden-xs">Verificando</span>
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-6" >
                            <button  id="btnUsuariosGuardarClaveLogin" class="btn btn-primary btn-block btn-flat" >
                                <span class="fa fa-save"></span>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>    
        </div>        
        <script src="includes/sweetalert2-master/dist/sweetalert2.min.js" type="text/javascript"></script> 
    </body>
</html>
