var Perfil = (function () {
    var
            /**
             * Función que inicializa el logín.
             * @returns {void}
             */
            iniciar = function () {
                $("#perfilBtnCollapse").click(function () {
                    LimpiarCamposPerfil();
                });
                $.AdminLTE.boxWidget.activate();
                $('#btnPerfilGuardarClavePerfil').click(function () {
                    cambiarclave($("#perfilTxtCedulaNuevoUsuario").val());
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
                        url: url_relativa +  "seguridades/controlador/php/controlador.php",
                        type: "post",
                        dataType: "json",
                        data: {
                            accion: 'editarclavelogin',
                            usuario: vusuario,
                            clave: CryptoJS.SHA256($('#txtPerfilClaveActualPerfil').val()).toString(),
                            clavenueva: CryptoJS.SHA256($('#txtPerfilClaveNuevaPerfil').val()).toString()
                        }
                    }).done(function (respuesta) {
                        var varres = respuesta[0].reg;
                        if (varres === 10) {
                            $('#idPerfilMsgClaveErroneaPerfil').removeClass('hide');
                        }
                        else if (varres === 1) {
                            LimpiarCamposPerfil();
                            $("#perfilBtnCollapse").trigger('click');
                            swal({
                                title: "Guardado",
                                text: "Clave modificada exitosamente",
                                type: "success"});
                        }
                        else if (varres === -3) {
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar la clave de usuario, por favor comuniquese con el proveedor del servicio', "error");
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
                if ($('#txtPerfilClaveNuevaPerfil').val() !== $('#txtPerfilClaveNuevaConfirmarPerfil').val() && $('#txtPerfilClaveNuevaConfirmarPerfil').val() !== '' && $('#txtPerfilClaveNuevaPerfil').val() !== '') {
                    $('#idPerfilMsgClavePerfil').removeClass('hide');
                    resultado = false;
                }
                if ($('#txtPerfilClaveNuevaPerfil').val() === $('#txtPerfilClaveNuevaConfirmarPerfil').val() && $('#txtPerfilClaveNuevaConfirmarPerfil').val() !== '' && validarClave('#txtPerfilClaveNuevaPerfil') === false) {
                    $('#msgPerfilClaveInvalidaPerfil').removeClass('hide');
                    resultado = false;
                }
                $('.form-group input.clsPerfilInputPerfil').click(function () {
                    $(this).siblings('.msgErrorPerfil').addClass('hide');
                    $('#idPerfilMsgClavePerfil').addClass('hide');
                    $('#msgPerfilClaveInvalidaPerfil').addClass('hide');
                    $('#idPerfilMsgClaveErroneaPerfil').addClass('hide');
                });
                $('.form-group input.clsPerfilInputPerfil').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).siblings('.msgErrorPerfil').removeClass('hide');
                    }
                    else {
                        $(this).siblings('.msgErrorPerfil').addClass('hide');
                    }
                });

                return resultado;
            },
            /**
             * Función que limpia los campos del perfíl de usuario.
             * @returns {void}
             */
            LimpiarCamposPerfil = function () {
                $('.form-group input.clsPerfilInputPerfil').each(function () {
                    $(this).val("");
                });
                $('.msgErrorPerfil').addClass('hide');
            },
            /**
             * Función que valida una clave segura.
             * @param {String} clave
             * @returns {Boolean} */
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
            };
    return {
        iniciar: iniciar
    };
})();

$(document).ready(function () {
    Perfil.iniciar();
});