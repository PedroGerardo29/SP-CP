<?php
error_reporting(\E_ERROR);
include_once './configuracion/configuracion.php';
include_once './configuracion/conexionlogin.php';
include_once './seguridades/modelo/php/modelo.php';
$validar = new Usuario();
if ($validar->VerificarLogin()) {
    $validar->RedireccionarURL('menu.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Pre-clasificación y Control de pacientes</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="includes/AdminLTE-master/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/dist/css/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="includes/AdminLTE-master/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

        <link href="includes/sweetalert2-master/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
        <link href="includes/general/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="login-page" >
        <div class="login-box">
            <div class="login-box-msg" >
                <div  class="pull-left">
                    <img src="includes/img/logoinstitucion.png" class="user-image img-rounded" width="30" height="30"/>                    
                </div>
                <b>Acceso al sistema</b>
            </div>
            <div class="login-box-body">
                <div >
                    <div >
                        <label id="idUsuariosMsgLogin" for="txtUsuariosUsuarioLogin" class="text-danger pull-right hide msgErrorLogin">
                            <i class="fa fa-times-circle-o"></i>
                            Información Incorrecta
                        </label>
                        <label for="txtUsuariosUsuarioLogin" >&nbsp;</label>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div >
                        <label for="txtUsuariosUsuarioLogin" class="text-danger pull-right hide msgErrorLogin">
                            <i class="fa fa-times-circle-o"></i>
                            Ingrese Usuario
                        </label>
                        <label for="txtUsuariosUsuarioLogin" >Usuario :</label>
                        <input type="text" id="txtUsuariosUsuarioLogin" class="form-control clsUsuariosInputLogin"/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div >
                        <label for="txtUsuariosClaveLogin" class="text-danger pull-right hide msgErrorLogin">
                            <i class="fa fa-times-circle-o"></i>
                            Ingrese Clave
                        </label>
                        <label for="txtUsuariosClaveLogin">Clave :</label>
                        <input type="password" id="txtUsuariosClaveLogin" class="form-control clsUsuariosInputLogin"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-xs-6 col-sm-8">    
                        <div id="msgUsuariosVerificandoLogin" class="overlay hide">
                            <span >Verificando</span>
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4" >
                        <button  id="btnUsuariosIngresarLogin" class="btn btn-primary btn-block btn-flat" >
                            <span class="fa fa-sign-in"></span>
                            Ingresar</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="includes/AdminLTE-master/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="includes/AdminLTE-master/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <script src="includes/sha256/sha256.js" type="text/javascript"></script>        
        <script src="includes/sweetalert2-master/dist/sweetalert2.min.js" type="text/javascript"></script> 
        <script src="seguridades/vista/js/script_path.js"></script>
        <script src="seguridades/vista/js/script_login.js" type="text/javascript"></script>
    </body>
</html>