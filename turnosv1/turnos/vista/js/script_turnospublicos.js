var Turnos = (function () {
    var
            /**
             * Función que permite consultar módulos.
             * @returns {void}
             */
            consultarModulos = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarmodulos'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#turnossecListaturno').empty();
                    if (datos[0].reg == 1) {
                        $('#turnossecListaturno').empty();
                        $.each(datos, function (i) {
                            $("#turnossecListaturno").append(
                                    $("<div>").append(
                                    $("<button>").addClass("turnosBotones col-xs-12").on({
                                click: function () {
                                    crearTurno(datos[i].id);
                                }
                            }
                            ).
                                    addClass("bg-botonturno text-white turnosClsTurno").append(
                                    $("<span>").append(
                                    $("<b>").text(datos[i].nombre).addClass(' text-center turnosClsTurno')
                                    ))
                                    ).addClass('col-xs-12 col-md-4')
                                    );
                        });
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar módulos, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar módulos, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            },
            /**
             * Función que muestra el reloj en pantalla.
             * @returns {void}
             */
            mostrarHoraFecha = function ()
            {
                var horaactural = ("#turnosDivContenedorHora");
                var fechaactural = ("#turnosDivContenedorFecha");
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
                $(fechaactural).html(days[day] + ',   ' + months[month] + ' ' + date + ' del ' + year + ' &nbsp;');
                $(horaactural).html(hour + ':' + minute + ':' + second);
            },
            /**
             * Función que permite crear turno.
             * @param {integer} modulo
             * @returns {void}
             */
            crearTurno = function (modulo) {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: "post",
                    datatype: "json",
                    data: {
                        accion: 'nuevoturnopublico',
                        modulo: modulo
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        send('{"tipo": "CREARTURNO", "id": ""}');

//                        $("#turnosDivContenedorEnlaceTicket").removeClass('hide');
                        $("#turnosFrameTicket").attr('src', url_relativa + 'turnos/vista/php/vista_ticketpublico.php?turno=' + datos[0].turno + '&tramite=' + datos[0].tramite + '&fecha=' + datos[0].fecha + '&hora=' + datos[0].hora + '&espera=' + datos[0].espera);

//                        $("#turnosDivContenedorEnlaceTicket").addClass('hide');
                    }
                    else if (datos[0].reg == -3) {
                        $("#msgPerfilessVerificandoNuevoPerfíl").addClass('hide');
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de crear turno, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        $("#msgPerfilessVerificandoNuevoPerfíl").addClass('hide');
                        sweetAlert("Error", 'Error al tratar de crear turno, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que permite actualizar el logo.
             * @returns {void}
             */
            cambiarLogo = function () {
                var f = new Date();
                $("#turnosImgLogoInstitucion").attr("src", url_relativa + "includes/img/logoinstitucion.png?n=" + f).css({'height': '50px', 'width': '50px'});
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
                        if (data.tipo == "CAMBIARESTADOMODULO" || data.tipo == "CREARMODULO" || data.tipo == "CREARTRAMITE" || data.tipo == "CAMBIARESTADOTRAMITE") {
                            consultarModulos();
                        }
                        else if (data.tipo == "CAMBIARLOGO") {
                            cambiarLogo();
                        }
                    };
                }
                catch (ex) {
                    sweetAlert("Error", "Error de conexión en tiempo real", "error");
                }
            },
            /**
             * Función que permite inicializar el módulo de turnos.
             * @returns {void}
             */
            iniciar = function () {
                $("body").css({
                    'overflow-y': 'hidden'});
                iniciarSocket();
                escucharSocket();
                setInterval(mostrarHoraFecha, 1000);
                consultarModulos();
            }
    ;
    return {
        iniciar: iniciar
    };
})();

$(document).ready(function () {
    Turnos.iniciar();
});