var Login = (function () {
    var
            //Selectores del formulario de login
            $idTxtLoginUsuario = $("#txtUsuariosUsuarioLogin"),
            $idTxtLoginClave = $("#txtUsuariosClaveLogin"),
            $idBtnLoginIngresar = $("#btnUsuariosIngresarLogin"),
            /**
             * Función que inicializa el logín.
             * @returns {void}
             */
            iniciar = function () {
                $idTxtLoginUsuario.focus();
                $idBtnLoginIngresar.off('click');
                $idBtnLoginIngresar.click(function () {
                    $("#idUsuariosMsgLogin").addClass('hide');
                    if (validarCampos()) {
                        verificar();
                    }
                });
                $idTxtLoginUsuario.keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        if (validarCampos()) {
                            verificar();
                        }
                    }
                });
                $idTxtLoginClave.keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        if (validarCampos()) {
                            verificar();
                        }
                    }
                });
            },
            /**
             * Función que valida los campos del login.
             * @returns {Boolean} */
            validarCampos = function () {
                var resultado = true;
                $('.form-group .clsUsuariosInputLogin').on({
                    click: function () {
                        $(this).parent().removeClass('has-error');
                        $(this).siblings('.msgErrorLogin').addClass('hide');
                        $("#idUsuariosMsgLogin").addClass('hide');
                    },
                    focus: function () {
                        $(this).parent().removeClass('has-error');
                        $(this).siblings('.msgErrorLogin').addClass('hide');
                        $("#idUsuariosMsgLogin").addClass('hide');
                    }
                });
                $('.form-group .clsUsuariosInputLogin').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().addClass('has-error');
                        $(this).siblings('.msgErrorLogin').removeClass('hide');
                    }
                    else {
                        $(this).parent().removeClass('has-error');
                        $(this).siblings('.msgErrorLogin').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que verfíca los datos del usuario para el inicio de sesión.
             * @returns {void}
             */
            verificar = function () {
                $("#msgUsuariosVerificandoLogin").removeClass('hide');
                $.ajax({
                    url: url_relativa + "seguridades/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'verificarusuario',
                        usuario: $idTxtLoginUsuario.val(),
                        clave: CryptoJS.SHA256($idTxtLoginClave.val()).toString()
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 1) {
                        $(window).attr('location', 'menu.php');
                    }
                    else if (datos[0].reg === 2) {
                        var usuario = $idTxtLoginUsuario.val();
                        $(".login-box").remove();
                        swal({
                            title: "Bienvenido a Sistema de Pre-clasificación y Control de pacientes",
                            text: "Por favor cambie su clave de ingreso al sistema",
                            type: "success"},
                        function () {
                            $("body").load('seguridades/vista/php/vista_credencialeslogin.php', function () {
                                $('#btnUsuariosGuardarClaveLogin').click(function () {
                                    cambiarclave(usuario);
                                });
                            });
                        });
                    }
                    else if (datos[0].reg === -1) {
                        $('#idUsuariosMsgLogin').removeClass('hide');
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", "Error de envío de parámetros al tratar de acceder al sistema, por favor comuniquese con el proveedor del servicio", "error");
                    } else if (datos[0].reg === -4) {
                        sweetAlert("Error", 'Error de conexión a la base de datos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", 'Error al intentar acceder al sistema, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    $("#msgUsuariosVerificandoLogin").addClass('hide');
                });
            },
            /**
             * Función que permite el cambio de clave por primera vez.
             * @param {integer} vusuario
             * @returns {void}
             */
            cambiarclave = function (vusuario) {
                if (validarCamposCambiarClave()) {
                    $.ajax({
                        url: url_relativa + "seguridades/controlador/php/controlador.php",
                        type: "post",
                        dataType: "json",
                        data: {
                            accion: 'editarclavelogin',
                            usuario: vusuario,
                            clave: CryptoJS.SHA256($('#txtUsuariosClaveActualLogin').val()).toString(),
                            clavenueva: CryptoJS.SHA256($('#txtUsuariosClaveNuevaLogin').val()).toString()
                        }
                    }).done(function (respuesta) {
                        var varres = respuesta[0].reg;
                        if (varres === 10) {
                            $('#idUsuariosMsgClaveErroneaLogin').removeClass('hide');
                        }
                        else if (varres === 1) {
                            swal({
                                title: "Guardado",
                                text: "Clave modificada exitosamente",
                                type: "success"},
                            function () {
                                $(window).attr('location', 'menu.php');
                            });
                        }
                        else if (varres === 2) {
                            sweetAlert("Advertencia", 'Por favor Cambie de clave para acceder al sistema', "warning");
                        }
                        else if (varres === -3) {
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar la clave de usuario, por favor comuniquese con el proveedor del servicio', "error");
                        } else if (varres === -4) {
                            sweetAlert("Error", 'Error de conexión a la base de datos, por favor comuniquese con el proveedor del servicio', "error");
                        } else {
                            sweetAlert("Error", 'Error al tratar de cambiar la clave de usuario, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que valida los campos al cambiar la clave al ingresar por primera vez.
             * @returns {Boolean}
             */
            validarCamposCambiarClave = function () {
                var resultado = true;
                if ($('#txtUsuariosClaveNuevaLogin').val() !== $('#txtUsuariosClaveNuevaConfirmarLogin').val() && $('#txtUsuariosClaveNuevaConfirmarLogin').val() !== '' && $('#txtUsuariosClaveNuevaLogin').val() !== '') {
                    $('#idUsuariosMsgClaveLogin').removeClass('hide');
                    resultado = false;
                }
                if ($('#txtUsuariosClaveNuevaLogin').val() === $('#txtUsuariosClaveNuevaConfirmarLogin').val() && $('#txtUsuariosClaveNuevaConfirmarLogin').val() !== '' && validarClave('#txtUsuariosClaveNuevaLogin') === false) {
                    $('#msgUsuariosClaveInvalidaLogin').removeClass('hide');
                    resultado = false;
                }
                $('.form-group input').click(function () {
                    $(this).siblings('.msgErrorLogin').addClass('hide');
                    $('#idUsuariosMsgClaveLogin').addClass('hide');
                    $('#msgUsuariosClaveInvalidaLogin').addClass('hide');
                    $('#idUsuariosMsgClaveErroneaLogin').addClass('hide');
                });
                $('.form-group input').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).siblings('.msgErrorLogin').removeClass('hide');
                    }
                    else {
                        $(this).siblings('.msgErrorLogin').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que valida una clave segura.
             * @param {String} clave
             * @returns {Boolean} 
             */
            validarClave = function (clave)
            {
                var cla = $(clave).val();
                var resultado;
                resultado = true;
                expr = /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
                if (!expr.test(cla)) {
                    resultado = false;
                }
                return resultado;
            },
            /**
             * Función que cierra sesión de usuario.
             * @returns {void}
             */
            salir = function () {
                $.ajax({
                    url: url_relativa + "seguridades/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'salirusuarios'
                    }
                }).done(function () {
                    $(window).attr('location', 'index.php');
                });
            };
    return {
        iniciar: iniciar,
        salir: salir
    };
})();

$(document).ready(function () {
    Login.iniciar();
});