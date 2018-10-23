
var Menu = (function () {
    var
            /**
             * Función que cargar el menú.
             * @returns {void}
             */
            cargarmenu = function () {
                $.ajax({
                    url: url_relativa + "seguridades/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarmenu'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $.each(datos, function (i) {
                        $('#idMenuUsuarios').append(
                                $('<li>').append(
                                $('<a>').attr('href', 'javascript:void(0);').
                                addClass(datos[i].fullscreen == true ? 'menuClaseFullScreen' : '').
                                append(
                                        $('<i>').addClass(datos[i].icono)).append(
                                $('<span>').text(' ' + datos[i].nombre))).
                                attr('id', datos[i].acronimo)
                                .off('click')
                                .on('click', function () {
                                    $("#stop").trigger('click');
                                    UsuariosMenuUsuarios(datos[i].acronimo, datos[i].vista, datos[i].fullscreen);
                                })
                                );
                    });
                    $('.menuClaseFullScreen').click(function () {
                        $(document).fullScreen(true);
                    });
                });
            },
            /**
             * Función que genera el menú al usuario y valida el ingreso al mismo.
             * @param {string} opcion
             * @param {string} ruta
             * @param {boolean} fullscreen
             * @returns {void}
             */
            UsuariosMenuUsuarios = function (opcion, ruta, fullscreen) {
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'verificarmenu',
                        opcion: opcion
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 0) {
                        swal({
                            title: "Acceso Denegado",
                            text: "Usted no tiene permiso para ingresar a este módulo",
                            type: "warning"},
                                function () {
                                    $(window).attr('location', 'menu.php');
                                });
                    } else if (datos[0].reg === 1) {
                        if (fullscreen) {
                            $("#menuFullScreen").remove();
                            $("body").css("background-color", "#ecf0f5");
                            $(".wrapper").removeClass("wrapper");
                            $(".content-wrapper").removeClass("content-wrapper");
                        }
                        $('#frame').load(url_relativa + ruta + '?ref=0');
                    }
                });
            },
            /**
             * Función que permite actualizar información de usuario al ecuchar un evento a tavés del socket.
             * @param {Integer} id
             * @returns {void}
             */
            ActualizarInformacionUsuarioSocket = function (id) {
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'actualizarinformacionusuario',
                        id: id
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $(".imagenPerfilUsuario").attr('src', datos[0].foto);
                        $(".menuNombresApellidosusuario").text(datos[0].nombre + ' ' + datos[0].apellido);
                    }
                });
            },
            /**
             * Función que permite cerrar sesión.
             * @returns {void}
             */
            salir = function () {
                $.ajax({
                    url: url_relativa + "seguridades/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'salir'
                    }
                }).done(function () {
                    $(window).attr('location', 'index.php');
                });
            },
            /**
             * Función que permite escuchar eventos atraves de la conexión de socket.
             * @returns {void}
             */
            escucharSocket = function () {
                try {
                    socket.onmessage = function (msg) {
                        var data = null;
                        data = JSON.parse(msg.data);
                        if (data.tipo == "EDITARPARAMETROS") {
                            actualizarInformacionParametros();
                        } else if (data.tipo == "CAMBIARLOGO") {
                            cambiarLogo();
                        } else if (data.tipo == "EDITARUSUARIO") {
                            ActualizarInformacionUsuarioSocket(data.id);
                        }
                    };
                } catch (ex) {
                    sweetAlert("Error", "Error de conexión en tiempo real", "error");
                }
            },
            /**
             * Función que permite cambiar el logo al escuchar el evento mediante socket.
             * @returns {void}
             */
            cambiarLogo = function () {
                var fecha = new Date();
                $("#menuImgLogoInstitucion").attr('src', url_relativa + "includes/img/logoinstitucion.png?" + fecha);
            },
            /**
             * Función que permite actualizar información de parámetros al escuhcar un evento mediante el socket.
             * @returns {void}
             */
            actualizarInformacionParametros = function () {
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'actualizarinformacionparametros'
                    }
                }).done(function (respuesta) {
                });
            },
            llamada = function () {
                setInterval(mantenerSesion, 600000);
            },
            mantenerSesion = function () {
                $("#datatable_wrapper").trigger('click');
                $.ajax({
                    url: url_relativa + "seguridades/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    async: false,
                    data: {
                        accion: 'mantenersesion'
                    }
                }).done(function () {
                }).fail(function (jqXHR) {
                });
            },
            /**
             * Función que inicializa el prototipo menú.
             * @returns {void}
             */
            iniciar = function () {
                setSocket();
                escucharSocket();
                $("#frame").css({"min-height": "3500px"});
                $(window).resize(function () {
                    $("#frame").css({"min-height": "3500px"});
                });
                cargarmenu();
                $("#btnMenuOpcionSalir").click(function () {
                    salir();
                });
                $("#btnMenuOpcionPerfil").click(function () {
                    $("#frame").load(url_relativa + 'seguridades/vista/php/vista_perfil.php');
                });
            llamada();
            }
    ;
    return {
        iniciar: iniciar,
        salir: salir
    };
})();

$(document).ready(function () {
    Menu.iniciar();
});
