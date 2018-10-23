var Espera = (function () {
    var
            /**
             * Función que permite consultar últimos turnos atendidos.
             * @returns {void}
             */
            consultarTurnos = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarturnos'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $('#esperaTbdListaTurnos').empty();
                        $.each(datos, function (i) {
                            $("#esperaTbdListaTurnos").append(
                                    $("<tr>").attr("id", "idTurno" + datos[i].id).
                                    css({'height': '100px', 'font-size': '3.5em'})
                                    .append($("<td>").text(datos[i].numero).addClass("col-xs-6 text-center  text-bold"))
                                    .append($("<td>").text(datos[i].modulo).addClass("col-xs-6 text-center  text-bold"))
                                    );
                        });
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar turnos, por favor contactese con el proveedor del servicio', "error");
                    }
                    else if (datos[0].reg === -1) {
                        $('#esperaTbdListaTurnos').empty();
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar turnos, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            },
            /**
             * Función que permite buscar los últimos turnos atendidos y el llamado actual.
             * @param {integer} id
             * @returns {void}
             */
            consultarTurnosllamado = function (id) {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarturnosllamados',
                        id: id
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $('#esperaTbdListaTurnos').empty();
                        $.each(datos, function (i) {
                            $("#esperaTbdListaTurnos").append(
                                    $("<tr>").attr("id", "idTurno" + datos[i].id).
                                 css({'height': '100px', 'font-size': '3.5em'})
                                    .append($("<td>").text(datos[i].numero).addClass("col-xs-6 text-center  text-bold"))
                                    .append($("<td>").text(datos[i].modulo).addClass("col-xs-6 text-center  text-bold"))
                                    );
                        });
                        var f = new Date();
                        var audio = new Audio('includes/sounds/timbre.mp3?n=' + f);
                        audio.play();
                        var idturno = ("#idTurno" + id);
                        parpadea(idturno, "bg-red");
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar turnos, por favor contactese con el proveedor del servicio', "error");
                    }
                    else if (datos[0].reg === -1) {
                        $('#esperaTbdListaTurnos').empty();
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar turnos, por favor contactese con el proveedor del servicio", "error");
                    }

                });
            },
            /**
             * Función que muestra el reloj en pantalla.
             * @returns {void}
             */
            mostrarHoraFecha = function ()
            {
                var horaactural = ("#esperaTxtHoraActual");
                var fechaactural = ("#esperaTxtFechaActual");
                var now = new Date();
                var months = new Array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                var days = new Array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
                var date = now.getDate();
                var year = now.getFullYear();
                var month = now.getMonth();
                var day = now.getDay();
                var hour = now.getHours();
                var minute = now.getMinutes();
                var second = now.getSeconds();
                hour = (hour < 10) ? "0" + hour : hour;
                minute = (minute < 10) ? "0" + minute : minute;
                second = (second < 10) ? "0" + second : second;
                $(fechaactural).html(days[day] + '   ' + months[month] + ' ' + date + ' del ' + year + ' &nbsp; ');
                $(horaactural).html(hour + ':' + minute + ':' + second);
            },
            /**
             * Función que permite realizar el efecto parpadear al turno actual llamado.
             * @param {type} id
             * @param {type} clase
             * @returns {void}
             */
            parpadea = function (id, clase) {
                setTimeout(function () {
                    $(id).addClass(clase);
                    setTimeout(function () {
                        $(id).removeClass(clase);
                        setTimeout(function () {
                            $(id).addClass(clase);
                            setTimeout(function () {
                                $(id).removeClass(clase);
                            }, 1000);
                        }, 1000);
                    }, 1000);
                }, 1000);
            },
            /**
             * Función que permite escuchar eventos a través de la conexión de socket.
             * @returns {void}
             */
            escucharSocket = function () {
                try {
                    socket.onmessage = function (msg) {
                        var data = null;
                        data = JSON.parse(msg.data);
                        if (data.tipo == "LLAMARTURNO") {
                            consultarTurnosllamado(data.id);
                        }
                        else if (data.tipo == "ANULARTURNO" || data.tipo == "ATENDERTURNO" || data.tipo == "FINALIZARTURNO") {
                            consultarTurnos();
                        }
                        else if (data.tipo == "CAMBIARLOGO") {
                            cambiarLogo();
                        }
                        else if (data.tipo == "CAMBIARVIDEO" || data.tipo == "CAMBIARESTADOVIDEO") {
                            consultarVideos();
                        }
                        else if (data.tipo == "EDITARPARAMETROS") {
                            ActualizarInformacionInstitucion();
                        }
                    };
                }
                catch (ex) {
                    sweetAlert("Error", "Error de conexión en tiempo real", "error");
                }
            },
            /**
             * Función que permite actualizar el logo.
             * @returns {void}
             */
            cambiarLogo = function () {
                var f = new Date();
                $("#esperaFotoNuevoFoto").attr("src", url_relativa + "includes/img/logoinstitucion.png?n=" + f).css({'max-height': $("#esperaDivContenidoCabecera").height(), 'max-width': '100px'});
            },
            /**
             * Función que permite actualizar información de institución.
             * @returns {void}
             */
            ActualizarInformacionInstitucion = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarinformacionparametros'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $("#esperaWebInstitucion").text(datos[0].nombre);
                        $("#esperaNombreInstitucion").text(datos[0].sitioweb);
                        $("#esperaMensajeInstitucion").text(datos[0].mensaje);
                    }
                });
            },
            /**
             * Función que permite envíar estilos para que elemento se distribuyan de acuerdo a la resolución de pantalla.
             * @returns {void}
             */
            enviarEstilos = function () {

                var alto = $(window).height();
                var diez = (parseInt(alto) * 10) / 100;
                var noventa = (parseInt(alto) * 90) / 100;
                var cinco = (parseInt(alto) * 5) / 100;
                var setentacinco = (parseInt(alto) * 75) / 100;
                $("#esperaDivContenidoVideo").css({
                    'height': setentacinco + 'px',
                    'min-height': setentacinco + 'px',
                    'max-height': setentacinco + 'px'
                });
                $("#esperaDivContenidoMensaje").css({
                    'height': cinco + 'px',
                    'min-height': cinco + 'px',
                    'max-height': cinco + 'px'
                });
                $("#esperaDivContenidoCabecera,#esperaDivContenidoMensajeFooter").css({
                    'height': diez + 'px',
                    'min-height': diez + 'px',
                    'max-height': diez + 'px'
                });
                $("#esperaDivContenidoTurnos,#esperaDivContenidoInformacion").css({
                    'height': noventa + 'px',
                    'min-height': noventa + 'px',
                    'max-height': noventa + 'px'
                });
            },
            /**
             * Función que permite consultar los videos.
             * @returns {void}
             */
            consultarVideos = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarvideos'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    var alto = $("#esperaDivContenidoVideo").height();
                    if (datos[0].reg == 1) {
                        var videos = new Array(1);
                        $.each(datos, function (i) {
                            videos[i] = datos[i].nombre;
                        });
                        var playVideo = document.getElementById('esperaVideoNuevoVideo');
                        $("#esperaVideoNuevoVideo").css({'max-height': alto, 'min-height': alto, 'height': alto}).attr({
                            'data-videoactual': '0',
                            'src': url_relativa + 'includes/video/' + videos[0]
                        });
                        playVideo.addEventListener('ended', function () {
                            if (parseInt($("#esperaVideoNuevoVideo").attr('data-videoactual')) == videos.length - 1) {
                                $("#esperaVideoNuevoVideo").css({'max-height': alto, 'min-height': alto, 'height': alto}).attr({
                                    'data-videoactual': '0',
                                    'src': url_relativa + 'includes/video/' + videos[0]
                                });
                            } else {
                                $("#esperaVideoNuevoVideo").css({'max-height': alto, 'min-height': alto, 'height': alto}).
                                        attr({
                                            'data-videoactual': parseInt($("#esperaVideoNuevoVideo").attr('data-videoactual')) + 1,
                                            'src': url_relativa + 'includes/video/' + videos[parseInt($("#esperaVideoNuevoVideo").attr('data-videoactual')) + 1]
                                        });
                            }
                        }, false);

                        $(window).resize(function () {
                            if ($(window).width() >= 992) {
                                playVideo.play();
                            } else {
                                playVideo.pause();
                            }
                        }
                        );
                    }
                    else if (datos[0].reg === -1) {
                        $("#esperaVideoNuevoVideo").css({'max-height': alto, 'min-height': alto, 'height': alto}).attr('src', '');
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar videos, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar videos, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            },
            /**
             * Función que inicializa el módulo de espera.
             * @returns {void}
             */
            iniciar = function () {
                $("body").css({
                    'overflow-y': 'hidden'}).addClass(' background-gris');
                iniciarSocket();
                escucharSocket();
                enviarEstilos();
                setInterval(mostrarHoraFecha, 1000);
                consultarVideos();
                cambiarLogo();
                consultarTurnos();
                ActualizarInformacionInstitucion();
                $(window).resize(function () {
                    enviarEstilos();
                });
            }
    ;
    return {
        iniciar: iniciar
    };
})();
$(document).ready(function () {
    Espera.iniciar();
});