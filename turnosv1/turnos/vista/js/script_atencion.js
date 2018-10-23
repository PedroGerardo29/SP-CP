globalInterval = [];
globalIntervalActual = [];
var Atencion = (function () {
    var
            /**
             * Función que permite consultar los turnos del usuario actual.
             * @returns {void}
             */
            consultarTurnosUsuario = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarturnosusuario'
                    }
                }).done(function (respuesta) {
                    clearAllInterval();
                    $("#esperaTxtTurnoTiempoEspera").removeClass("bg-orange bg-red");
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $("#esperaTxtTramiteActual").val(datos[0].nombre);
                        $("#esperaTxtTurnoActual").val(datos[0].numero);
                        $("#esperaTxtTramiteActual").attr("data-turno", datos[0].id);
                        $("#esperaTxtEstadoTurnoActual").val("");
                        if (datos[0].estado == "L") {
                            $("#esperaTxtEstadoTurnoActual").val("Llamado");
                            $("#esperaTxtTurnoTiempoActual").val("00:00:00");
                            clearAllIntervalActual();
                        } else if (datos[0].estado == "I") {
                            $("#esperaTxtEstadoTurnoActual").val("En proceso");
                            resetIntervalTurnoActual(datos[0].hoy + ' ' + datos[0].horaturnoiniciado);
                        } else {
                            $("#esperaTxtTurnoTiempoActual").val("00:00:00");
                            clearAllIntervalActual();


                        }
                        $("#esperaTxtTurnoEspera").val(datos[0].espera);
                        $("#esperaTxtTurnoAtendidos").val(datos[0].terminado);
                        $("#esperaTxtTurnoAnulados").val(datos[0].anulado);
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar turnos, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar turnos, por favor contactese con el proveedor del servicio", "error");
                    }

                    consultarinformacionMinimaEspera(datos[0].espera);

                });
            },
            /**
             * Función que permite consultar los turnos de usuario que haya sido definido como el siguiente turno.
             * @returns {void}
             */
            consultarTurnosUsuarioSiguiente = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarturnosusuariosiguiente'
                    }
                }).done(function (respuesta) {
                    clearAllInterval();
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $("#esperaTxtTramiteActual").val(datos[0].nombre);
                        $("#esperaTxtTurnoActual").val(datos[0].numero);
                        $("#esperaTxtTramiteActual").attr("data-turno", datos[0].id);
                        $("#esperaTxtEstadoTurnoActual").val("");
                        if (datos[0].estado == "L") {
                            $("#esperaTxtEstadoTurnoActual").val("En espera");
                        } else if (datos[0].estado == "I") {
                            $("#esperaTxtEstadoTurnoActual").val("En proceso");
                        }
                        send('{"tipo": "SIGUIENTETURNO", "id": "' + datos[0].id + '"}');
                    }
                    else if (datos[0].reg === -1) {
                        $("#esperaTxtTramiteActual").attr("data-turno", -1);
                        $(".atencionTxtClassCampos").val("");
                        sweetAlert("Información", 'Usted no tiene turnos en espera', "warning");
                        send('{"tipo": "SIGUIENTETURNO", "id": "' + datos[0].id + '"}');
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar turno siguiente, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar turno siguiente, por favor contactese con el proveedor del servicio", "error");
                    }

                });
            },
            /**
             * Función que permite llamar al turno actual.
             * @returns {void}
             */
            llamarTurno = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'llamarturno'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $("#esperaTxtTramiteActual").val(datos[0].nombre);
                        $("#esperaTxtTurnoActual").val(datos[0].numero);
                        $("#esperaTxtTramiteActual").attr("data-turno", datos[0].id);
                        send('{"tipo": "LLAMARTURNO", "id": "' + datos[0].id + '"}');
                    }
                    else if (datos[0].reg === -1) {
                        clearAllInterval();
                        consultarTurnosUsuario();
                        $(".atencionTxtClassCampos").val("");
                        $("#esperaTxtTramiteActual").attr("data-turno", -1);
                        sweetAlert("Error", 'Seleccione el turno', "error");
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar turnos para llamada, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar consultar turnos para llamada, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            },
            /**
             * Función que permite anular turno.
             * @returns {void}
             */
            anularTurno = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'anularturno',
                        id: $("#esperaTxtTramiteActual").attr("data-turno")
                    }
                }).done(function (respuesta) {
                    clearAllInterval();
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $(".atencionTxtClassCampos").val("");
                        sweetAlert("Anulado", 'Turno anulado correctamente', "success");
                        consultarTurnosUsuario();
                        send('{"tipo": "ANULARTURNO", "id": "' + datos[0].id + '"}');
                    }
                    else if (datos[0].reg === 2) {
                        sweetAlert("Error", 'El turno ya habia sido anulado', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 3) {
                        sweetAlert("Error", 'No puede anular un turno que está siendo atendido', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 4) {
                        sweetAlert("Error", 'No puede anular un turno que fué atendido', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 5) {
                        sweetAlert("Error", 'El turno no existe', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de anular turno, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar anular turno, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            },
            /**
             * Función que permite anular turno.
             * @returns {void}
             */
            finalizarTurno = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'finalizarturno',
                        id: $("#esperaTxtTramiteActual").attr("data-turno")
                    }
                }).done(function (respuesta) {
                    clearAllInterval();
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $(".atencionTxtClassCampos").val("");
                        sweetAlert("Finalizado", 'Turno finalizado correctamente', "success");
                        consultarTurnosUsuario();
                        send('{"tipo": "FINALIZARTURNO", "id": "' + datos[0].id + '"}');
                    }
                    else if (datos[0].reg === 2) {
                        sweetAlert("Error", 'El turno ya habia sido finalizado', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 3) {
                        sweetAlert("Error", 'No se puede finalizar un turno que no ha sido atendido', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 4) {
                        sweetAlert("Error", 'El turno no existe', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de finalizar turno, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar finalizar turno, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            },
            /**
             Función que permite atender turno.
             * @param {String} tipo
             * @returns {void}
             */
            atenderTurno = function () {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'verificarpacienterequerido',
                        id: $("#esperaTxtTramiteActual").attr("data-turno")
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 'R') {
                        swal({
                            title: 'INGRESE DOCUMENTO',
                            html: '<input type="text" id="atencionTxtCedulapaciente" maxlength="14">',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Cancelar',
                            confirmButtonClass: 'confirm-class',
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                var cedula = $("#atencionTxtCedulapaciente").val();
                                $.ajax({
                                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                                    type: 'post',
                                    datatype: 'json',
                                    data: {
                                        accion: 'atenderturno',
                                        id: $("#esperaTxtTramiteActual").attr("data-turno"),
                                        cedula: cedula
                                    }
                                }).done(function (respuesta) {
                                    clearAllInterval();
                                    var datos = JSON.parse(respuesta);
                                    if (datos[0].reg == 1) {
                                        $(".atencionTxtClassCampos").val("");
                                        sweetAlert("Atendiendo", 'Atendiendo turno', "success");
                                        consultarTurnosUsuario();
                                        send('{"tipo": "ATENDERTURNO", "id": "' + datos[0].id + '"}');
                                    }
                                    else if (datos[0].reg === 2) {
                                        sweetAlert("Error", 'No se puede atender un turno anulado', "error");
                                        consultarTurnosUsuario();
                                    }
                                    else if (datos[0].reg === 3) {
                                        sweetAlert("Error", 'El turno ya está siendo atendido', "error");
                                        consultarTurnosUsuario();
                                    }
                                    else if (datos[0].reg === 4) {
                                        sweetAlert("Error", 'El turno ya fué atendido', "error");
                                        consultarTurnosUsuario();
                                    }
                                    else if (datos[0].reg === 5) {
                                        sweetAlert("Error", 'El turno no existe', "error");
                                        consultarTurnosUsuario();
                                    }
                                    else if (datos[0].reg === 10) {
                                        sweetAlert({
                                            title: 'INFORMACIÓN',
                                            text: 'El paciente no existe, por favor ingrese paciente',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                            confirmButtonClass: 'confirm-class',
                                            type: 'warning'
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                crearpaciente(cedula);
                                            }
                                        });
                                    }
                                    else if (datos[0].reg === -3) {
                                        sweetAlert("Error", 'Error de envío de parámetros al tratar de atender turno, por favor contactese con el proveedor del servicio', "error");
                                    }
                                    else {
                                        sweetAlert("Error", "Error al intentar atender turno, por favor contactese con el proveedor del servicio", "error");
                                    }
                                });
                            } else {

                            }
                        });
                        $("#atencionTxtCedulapaciente").focus();
                    }

                    else if (datos[0].reg === 'N') {
                        $.ajax({
                            url: url_relativa + 'turnos/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'atenderturno',
                                id: $("#esperaTxtTramiteActual").attr("data-turno"),
                                cedula: 'NULL'
                            }
                        }).done(function (respuesta) {
                            clearAllInterval();
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg === 1) {
                                $(".atencionTxtClassCampos").val("");
                                sweetAlert("Atendiendo", 'Atendiendo turno', "success");
                                consultarTurnosUsuario();
                                send('{"tipo": "ATENDERTURNO", "id": "' + datos[0].id + '"}');
                            }
                            else if (datos[0].reg === 2) {
                                sweetAlert("Error", 'No se puede atender un turno anulado', "error");
                                consultarTurnosUsuario();
                            }
                            else if (datos[0].reg === 3) {
                                sweetAlert("Error", 'El turno ya está siendo atendido', "error");
                                consultarTurnosUsuario();
                            }
                            else if (datos[0].reg === 4) {
                                sweetAlert("Error", 'El turno ya fué atendido', "error");
                                consultarTurnosUsuario();
                            }
                            else if (datos[0].reg === 5) {
                                sweetAlert("Error", 'El turno no existe', "error");
                                consultarTurnosUsuario();
                            }
                            else if (datos[0].reg === -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar de atender turno, por favor contactese con el proveedor del servicio', "error");
                            }
                            else {
                                sweetAlert("Error", "Error al intentar atender turno, por favor contactese con el proveedor del servicio", "error");
                            }
                        });
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de atender turno, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar atender turno, por favor contactese con el proveedor del servicio", "error");
                    }
                });

            },
            /**
             Función que permite atender turno al crear un paciente.
             * @param {String} tipo
             * @returns {void}
             */
            atenderTurnopaciente = function (cedula) {
                $.ajax({
                    url: url_relativa + 'turnos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'atenderturno',
                        id: $("#esperaTxtTramiteActual").attr("data-turno"),
                        cedula: cedula
                    }
                }).done(function (respuesta) {
                    clearAllInterval();
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg == 1) {
                        $(".atencionTxtClassCampos").val("");
                        sweetAlert("Atendiendo", 'Paciente creado, Atendiendo turno', "success");
                        consultarTurnosUsuario();
                        send('{"tipo": "ATENDERTURNO", "id": "' + datos[0].id + '"}');
                    }
                    else if (datos[0].reg === 2) {
                        sweetAlert("Error", 'No se puede atender un turno anulado', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 3) {
                        sweetAlert("Error", 'El turno ya está siendo atendido', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 4) {
                        sweetAlert("Error", 'El turno ya fué atendido', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 5) {
                        sweetAlert("Error", 'El turno no existe', "error");
                        consultarTurnosUsuario();
                    }
                    else if (datos[0].reg === 10) {
                        sweetAlert({
                            title: 'INFORMACIÓN',
                            text: 'El Paciente no existe, por favor ingrese Paciente',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                            confirmButtonClass: 'confirm-class',
                            type: 'warning'
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                crearpaciente(cedula);
                            }
                        });
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de atender turno, por favor contactese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al intentar atender turno, por favor contactese con el proveedor del servicio", "error");
                    }
                });
            }
    ,
            /**
             * 
             * @param {String} cedula
             * @returns {void}
             */
            crearpaciente = function (cedula) {
                limpiarCamposNuevopaciente();
                $("#atencionSecAtencionturnos").fadeOut(function () {
                    $("#pacientesSecNuevopaciente").fadeIn('slow', function () {
                        $("#pacientesTxtNombreNuevopaciente").focus();
                        $("#pacientesTxtIdentificacionNuevopaciente").val(cedula);
                    });
                });
                $("#pacientesBtnCancelarNuevopaciente").off('click');
                $("#pacientesBtnCancelarNuevopaciente").click(function () {
                    $("#pacientesSecNuevopaciente").fadeOut(function () {
                        $("#atencionSecAtencionturnos").fadeIn('slow');
                        limpiarCamposNuevopaciente();
                    });
                });
                $("#pacientesBtnGuardarNuevopaciente").off('click');
                $("#pacientesBtnGuardarNuevopaciente").click(function () {
                    guardarNuevopaciente();
                });

            },
            /**
             * Función que guarda información de nuevo paciente.
             * @returns {void}
             */
            guardarNuevopaciente = function () {
                if (ValidarCamposVaciosNuevopaciente()) {
                    $("#msgpacientessVerificandoNuevopaciente").removeClass('hide');
                    var cedula = $('#pacientesTxtIdentificacionNuevopaciente').val();
                    $.ajax({
                        url: url_relativa + 'pacientes/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevopaciente',
                            nombre: $('#pacientesTxtNombreNuevopaciente').val(),
                            apellido: $('#pacientesTxtApellidoNuevopaciente').val(),
                            identificacion: cedula,
                            direccion: $('#pacientesTxtDireccionNuevopaciente').val(),
                            telefono: $('#pacientesTxtTelefonoNuevopaciente').val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgpacientessVerificandoNuevopaciente").addClass('hide');
                            sweetAlert("Error", 'El paciente ya existe', "error");
                        }
                        else if (datos[0].reg === 2) {
                            clearAllInterval();
                            $("#msgpacientessVerificandoNuevopaciente").addClass('hide');
                            $("#pacientesSecNuevopaciente").fadeOut(function () {
                                $("#atencionSecAtencionturnos").fadeIn('slow');
                                limpiarCamposNuevopaciente();
                                atenderTurnopaciente(cedula);
                            });
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgpacientessVerificandoNuevopaciente").addClass('hide');
                            sweetAlert("Error", 'Error de envio de parámetros al tratar de crear paciente, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgpacientessVerificandoNuevopaciente").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de crear paciente, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que valida los campos para nuevo paciente.
             * @returns {Boolean}
             */
            ValidarCamposVaciosNuevopaciente = function () {
                var resultado = true;
                $('.form-group .pacientesClsCampoValidadoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevopaciente').addClass('hide');
                });
                $('.form-group .pacientesClsCampoValidadoNuevo,.form-group .pacientesClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevopaciente').addClass('hide');
                });
                $('.form-group .pacientesClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevopaciente').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorNuevopaciente').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que limpia los campos para nuevo paciente.
             * @returns {void}
             */
            limpiarCamposNuevopaciente = function () {
                $("#pacientesSecNuevopaciente input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorNuevopaciente, .msgErrorNuevopacienteCedula").each(function () {
                    $(this).addClass('hide');
                });
            },
            segundoTiempo = function (timeInSeconds) {
                var pad = function (num, size) {
                    return ('000' + num).slice(size * -1);
                },
                        time = parseFloat(timeInSeconds).toFixed(3),
                        hours = Math.floor(time / 60 / 60),
                        minutes = Math.floor(time / 60) % 60,
                        seconds = Math.floor(time - minutes * 60);
//                        milliseconds = time.slice(-3);

                return pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
            },
            /**
             * Función que inicializa el módulo de atención.
             * @returns {void}
             */
            iniciar = function () {
                $("#esperaTxtTurnoTiempoEspera").removeClass("bg-orange bg-red");
                clearAllInterval();
                clearAllIntervalActual();
                iniciarSocket();
                escucharSocket();
                $("#atencionBtnSiguiente").off('click').click(function () {
                    consultarTurnosUsuarioSiguiente();
                });
                $("#atencionBtnAnular").off('click').click(function () {
                    if (!$("#esperaTxtTramiteActual").attr("data-turno")) {
                        sweetAlert("Error", "Seleccione el turno a anular", "error");

                    } else {
                        anularTurno();
                    }
                });
                $("#atencionBtnAtender").off('click').click(function () {
                    if (!$("#esperaTxtTramiteActual").attr("data-turno")) {
                        sweetAlert("Error", "Seleccione el turno a atender", "error");
                    } else {
                        atenderTurno();
                    }
                });
                $("#atencionBtnFinalizar").off('click').click(function () {
                    if (!$("#esperaTxtTramiteActual").attr("data-turno")) {
                        sweetAlert("Error", "Seleccione el turno a finalizar", "error");
                    } else {
                        finalizarTurno();
                    }
                });
                $("#atencionBtnLlamar").off('click').click(function () {
                    if (!$("#esperaTxtTramiteActual").attr("data-turno")) {
                        sweetAlert("Error", "Seleccione el turno a llamar", "error");
                    } else {
                        llamarTurno();
                    }
                });
                for (var i = 1; i < 99999; i++) {
                    window.clearInterval(i);
                }
                ;
                consultarTurnosUsuario();
            },
            mostrarTiempoPromedioEspera = function (hora, tiempoespera, umbral) {

                $("#esperaTxtTurnoTiempoEspera").removeClass("bg-orange bg-red");
                var fecha1 = moment(hora);
                var fecha2 = moment();
                var ms = (fecha2.diff(fecha1, 'seconds'));

                $("#esperaTxtTurnoTiempoEspera").empty().val(segundoTiempo(ms));

                if ((ms / 60) >= (tiempoespera - umbral) && (ms / 60) < tiempoespera) {
                    $("#esperaTxtTurnoTiempoEspera").addClass("bg-orange");
                } else if ((ms / 60) >= tiempoespera) {
                    $("#esperaTxtTurnoTiempoEspera").addClass("bg-red");
                }
            },
            mostrarTiempoAtencionTurnoActual = function (hora) {
                var f1 = moment(hora);
                var f2 = moment();
                var ms = (f2.diff(f1, 'seconds'));
                $("#esperaTxtTurnoTiempoActual").empty().val(segundoTiempo(ms));

            },
            resetIntervalTurnoActual = function (hora) {
                $("#esperaTxtTurnoTiempoActual").val("00:00:00");
                clearAllIntervalActual();
                globalIntervalActual.push(setInterval(mostrarTiempoAtencionTurnoActual, 1000, hora));

            },
            resetInterval = function (hora, tiempoespera, umbral) {
                $("#esperaTxtTurnoTiempoEspera").removeClass("bg-orange bg-red");
                clearAllInterval;
                globalInterval.push(setInterval(mostrarTiempoPromedioEspera, 1000, hora, tiempoespera, umbral));

            },
            clearAllInterval = function () {
                $.each(globalInterval, function (i) {
                    clearInterval(parseInt(globalInterval[i]));
                });
                globalInterval = [];
            },
            clearAllIntervalActual = function () {
                $.each(globalIntervalActual, function (i) {
                    clearInterval(parseInt(globalIntervalActual[i]));
                });
                globalIntervalActual = [];
            };
    /**
     * Función que permite consultar últimos turnos atendidos.
     * @returns {void}
     */
    consultarinformacionMinimaEspera = function (datosespera) {

        $.ajax({
            url: url_relativa + 'turnos/controlador/php/controlador.php',
            type: 'post',
            datatype: 'json',
            data: {
                accion: 'consultarinformacionminimaespera'
            }
        }).done(function (respuesta) {
            clearAllInterval();
            var datos = JSON.parse(respuesta);
            if (datos[0].reg === 1) {
                $("#esperaTxtTurnoTiempoPromedioAtendidos").val(datos[0].promedioatencion);
                if (datosespera > 0) {
                    resetInterval(datos[0].hoy + ' ' + datos[0].hora, datos[0].tiempoespera, datos[0].umbral);
                } else {
                    $("#esperaTxtTurnoTiempoEspera").val("00:00:00");
                    $("#esperaTxtTurnoTiempoEspera").removeClass("bg-orange bg-red");
                }


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
             * Función que permite escuchar eventos a traves de la conexión de socket.
             * @returns {void}
             */
            escucharSocket = function () {
                try {
                    socket.onmessage = function (msg) {
                        var data = null;
                        data = JSON.parse(msg.data);
                        if (data.tipo == "CREARTURNO") {
                            consultarTurnosUsuario();
                        }
                        else if (data.tipo == "EDITARUSUARIO" || data.tipo == "CREARUSUARIO" ||data.tipo == "ANULARTURNO" || data.tipo == "ATENDERTURNO" || data.tipo == "FINALIZARTURNO" || data.tipo == "SIGUIENTETURNO") {
                            consultarTurnosUsuario();
                        }
                    };
                }
                catch (ex) {
                    sweetAlert("Error", "Error de conexión en tiempo real", "error");
                }
            }
    ;
    return {
        iniciar: iniciar
    };
})();
$(document).ready(function () {
    Atencion.iniciar();
});
