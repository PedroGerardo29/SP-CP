var pacientes = (function () {
    var
            /**
             * Función que permite listar los pacientes.
             * @param {integer} pag
             * @returns {void}
             */
            listar = function (pag) {
                $("#msgpacientessVerificandoListapaciente").removeClass('hide');
                $.ajax({
                    url: url_relativa + 'pacientes/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listarpacientes',
                        busqueda: $('#pacientesTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#pacientesUlPaginacionpacientes').empty();
                    $('#pacientesTbdListapacientes').empty();
                    if (datos[0].reg === -1) {
                        $('#pacientesUlPaginacionpacientes').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {
                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#pacientesUlPaginacionpacientes').append($('<li>').append($('<a href="#">').text('Anterior')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) - 1);
                                        })));
                            }
                            if (datos[0].pag > 5 && pag > 3) {
                                inicio = parseInt(pag) - 2;
                                fin = parseInt(pag) + inicio;
                                if ((parseInt(pag) + 2) > datos[0].pag) {
                                    inicio = parseInt(datos[0].pag) - 4;
                                    fin = datos[0].pag;
                                }
                            }
                            else {
                                inicio = 1;
                                fin = 5;
                            }
                            while (pagac < datos[0].pag) {
                                pagac = pagac + 1;
                                if (pagac >= inicio && pagac <= fin) {
                                    $('#pacientesUlPaginacionpacientes').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listar($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#pacientesUlPaginacionpacientes').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#pacientesUlPaginacionpacientes li:first').addClass('active');
                            }
                            $('#pacientesUlPaginacionpacientes li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        }
                        else {
                            $('#pacientesUlPaginacionpacientes').empty();
                        }
                        $.each(datos, function (i) {
                            $('#pacientesTbdListapacientes').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].apellido + ' ' + datos[i].nombre))
                                    .append($('<td>').text(datos[i].cedula))
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        Editarpaciente(datos[i].id, datos[i].nombre, datos[i].apellido, datos[i].direccion, datos[i].telefono, datos[i].cedula, datos[i].pagac);
                                                    })
                                                    .addClass('btn btn-info col-xs-12')
                                                    .append($('<span>').addClass('glyphicon glyphicon-pencil'))
                                                    .attr('title', 'Editar'))
                                            )
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        cambiarestado(datos[i].id, $(this));
                                                    })
                                                    .addClass(datos[i].estado === "A" ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                                    .append($('<span>').addClass(datos[i].estado === "A" ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                                    .attr('title', datos[i].estado === "A" ? "Activo" : "Inactivo")
                                                    )
                                            )
                                    );
                        });
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de listar pacientes, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al tratar listar pacientes, por favor comuniquese con el proveedor del servicio", "error");
                    }
                    $("#msgpacientessVerificandoListapaciente").addClass('hide');
                });
            },
            /**
             * Función que permite cambiar el estado de paciente.
             * @param {integer} vidpaciente
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidpaciente, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado del paciente?',
                    text: 'El estado será modificado !',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si,Modificar',
                    cancelButtonText: 'No, Cancelar',
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: url_relativa + 'pacientes/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'cambiarestadopaciente',
                                id: vidpaciente
                            }
                        }).done(function (respuesta) {
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg !== -2 && datos[0].reg !== -3) {
                                send('{"tipo": "CAMBIARESTADOpaciente", "id": ""}');
                                $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                        .text("")
                                        .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                        .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                        .attr('title', datos[0].estado === "A" ? "Activo" : "Inactivo");
                                datos[0].reg === 1 ? sweetAlert("Modificado", 'El paciente ha sido activado', "success") :
                                        sweetAlert("Modificado", 'El paciente ha sido desactivado', "success");
                            }
                            else if (datos[0].reg === -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar el estado de paciente, por favor comuniquese con el proveedor del servicio', "error");
                            }
                            else {
                                sweetAlert("Error", 'Error al tratar de cambiar el estado de paciente, por favor comuniquese con el proveedor del servicio', "error");
                            }
                        });
                    } else {
                        sweetAlert("Cancelado", 'El estado del paciente no ha sido modificado', "warning");
                    }
                });
            },
            /**
             * Función que permite crear un nuevo paciente.
             * @returns {void}
             */
            nuevo = function () {
                $("#pacientesBtnNuevopaciente").click(function (e) {
                    e.preventDefault();
                    limpiarCamposNuevo();
                    $("#pacientesBtnNuevopaciente").attr('disabled', 'disabled');
                    $("#pacientessecListapacientes").fadeOut(function () {
                        $("#pacientesSecNuevopaciente").fadeIn('slow', function () {
                            $("#pacientesTxtNombreNuevopaciente").focus();
                        });
                    });
                });
                $("#pacientesBtnCancelarNuevopaciente").off('click');
                $("#pacientesBtnCancelarNuevopaciente").click(function () {
                    listar(1);
                    $("#pacientesSecNuevopaciente").fadeOut(function () {
                        $("#pacientessecListapacientes").fadeIn('slow');
                        $("#pacientesBtnNuevopaciente").removeAttr('disabled');
                        limpiarCamposNuevo();
                    });
                });
                $("#pacientesBtnGuardarNuevopaciente").off('click');
                $("#pacientesBtnGuardarNuevopaciente").click(function () {
                    guardarNuevo();
                });
            },
            /**
             * Función que limpia los campos para nuevo paciente.
             * @returns {void}
             */
            limpiarCamposNuevo = function () {
                $("#pacientesSecNuevopaciente input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorNuevopaciente, .msgErrorNuevopacienteCedula").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que permite buscar pacientes mediante el filtro de búsqueda.
             * @returns {void}
             */
            buscar = function () {
                $('#pacientesTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#pacientesTxtFiltroBusqueda').keyup(function () {
                    listar(1);
                });
            },
            /**
             * Función que guarda información de nuevo paciente.
             * @returns {void}
             */
            guardarNuevo = function () {
                if (ValidarCamposVaciosNuevo()) {
                    $("#msgpacientessVerificandoNuevopaciente").removeClass('hide');
                    $.ajax({
                        url: url_relativa + 'pacientes/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevopaciente',
                            nombre: $('#pacientesTxtNombreNuevopaciente').val(),
                            apellido: $('#pacientesTxtApellidoNuevopaciente').val(),
                            identificacion: $('#pacientesTxtIdentificacionNuevopaciente').val(),
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
                            $("#msgpacientessVerificandoNuevopaciente").addClass('hide');
                            listar(1);
                            $("#pacientesSecNuevopaciente").fadeOut(function () {
                                $("#pacientessecListapacientes").fadeIn('slow');
                                $("#pacientesBtnNuevopaciente").removeAttr('disabled');
                                limpiarCamposNuevo();
                            });
                            swal({
                                title: "Guardado",
                                text: "Paciente ingresado exitosamente",
                                type: "success"
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
            ValidarCamposVaciosNuevo = function () {
                var resultado = true;
                $('.form-group .pacientesClsCampoValidadoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevopaciente,.msgErrorNuevopacienteCedula').addClass('hide');
                });
                $('.form-group .pacientesClsCampoValidadoNuevo,.form-group .pacientesClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevopaciente,.msgErrorNuevopacienteCedula').addClass('hide');
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
             * Función que permite editar paciente.
             * @param {Integer} id
             * @param {String} tipo
             * @param {String} nombre
             * @param {String} apellido
             * @param {String} direccion
             * @param {String} telefono
             * @param {String} cedula
             * @param {Integer} pagac
             * @returns {void}
             */
            Editarpaciente = function Editarpaciente(id, nombre, apellido, direccion, telefono, cedula, pagac) {
                limpiarCamposEditar();
                $("#pacientesBtnCancelarEditarpaciente").off('click');
                $("#pacientesBtnCancelarEditarpaciente").click(function () {
                    listar(pagac);
                    $("#pacientesSecEditarpaciente").fadeOut(function () {
                        $("#pacientessecListapacientes").fadeIn('slow');
                        $("#pacientesBtnNuevopaciente").removeAttr('disabled');
                    });
                });
                $("#pacientesTxtIdEditarpaciente").val(id);
                $("#pacientesTxtNombreEditarpaciente").val(nombre);
                $("#pacientesTxtApellidoEditarpaciente").val(apellido);
                $("#pacientesTxtDireccionEditarpaciente").val(direccion);
                $("#pacientesTxtTelefonoEditarpaciente").val(telefono);
                $("#pacientesTxtIdentificacionEditarpaciente").val(cedula);
                $("#pacientesBtnNuevopaciente").attr('disabled', 'disabled');
                $("#pacientessecListapacientes").fadeOut(function () {
                    $("#pacientesSecEditarpaciente").fadeIn('slow', function () {
                        $("#pacientesTxtNombreEditarpaciente").focus();
                        $("#pacientesBtnGuardarEditarpaciente").off('click');
                        $("#pacientesBtnGuardarEditarpaciente").click(function () {
                            guardarEditar(id, pagac);
                        });
                    });
                });
            },
            /**
             * Función que valida los campos para edición.
             * @returns {Boolean}
             */
            ValidarCamposVaciosEditar = function () {
                var resultado = true;
                $('.form-group .pacientesClsCampoValidadoEditar').click(function () {
                    $(this).parent().siblings('.msgErrorEditarpaciente, .msgErrorEditarpacienteCedula, .msgErrorEspacioBlancoEditarpaciente').addClass('hide');
                });
                $('.form-group .pacientesClsCampoValidadoEditar,.form-group .pacientesClsCampoValidadoFormatoEditar').focusin(function () {
                    $(this).parent().siblings('.msgErrorEditarpaciente, .msgErrorEditarpacienteCedula').addClass('hide');
                });
                $('.form-group .pacientesClsCampoValidadoEditar').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorEditarpaciente').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorEditarpaciente').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que guarda la edición de paciente.
             * @param {integer} id
             * @param {integer} pagac
             * @returns {vacio}
             */
            guardarEditar = function (id, pagac) {
                if (ValidarCamposVaciosEditar()) {
                    $("#msgpacientessVerificandoEditarpaciente").removeClass('hide');
                    $.ajax({
                        url: url_relativa + 'pacientes/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'editarpaciente',
                            id: id,
                            nombre: $('#pacientesTxtNombreEditarpaciente').val(),
                            apellido: $('#pacientesTxtApellidoEditarpaciente').val(),
                            identificacion: $('#pacientesTxtIdentificacionEditarpaciente').val(),
                            direccion: $('#pacientesTxtDireccionEditarpaciente').val(),
                            telefono: $('#pacientesTxtTelefonoEditarpaciente').val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgpacientessVerificandoEditarpaciente").addClass('hide');
                            listar(pagac);
                            $("#pacientesSecEditarpaciente").fadeOut(function () {
                                $("#pacientessecListapacientes").fadeIn('slow');
                            });
                            swal({
                                title: "Editado",
                                text: "Paciente editado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === 2) {
                            $("#msgpacientessVerificandoEditarpaciente").addClass('hide');
                            sweetAlert("Error", 'El paciente ya existe', "error");
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgpacientessVerificandoEditarpaciente").hide();
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de editar paciente, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgpacientessVerificandoEditarpaciente").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de editar paciente, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que limpia los campos de edición.
             * @returns {void}
             */
            limpiarCamposEditar = function () {
                $("#pacientesSecEditarpaciente input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorEditarpaciente").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * función que inicializa el paciente de pacientes.
             * @returns {void}
             */
            iniciar = function () {
                listar(1);
                buscar();
                nuevo();
            }
    ;
    return {
        iniciar: iniciar
    };
})();

$(document).ready(function () {
    pacientes.iniciar();
});