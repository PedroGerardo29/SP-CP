var Modulos = (function () {
    var
            /**
             * Función que permite listar los módulos.
             * @param {integer} pag
             * @returns {void}
             */
            listar = function (pag) {
                $("#msgModulossVerificandoListaMódulo").removeClass('hide');
                $.ajax({
                    url: url_relativa +  'modulos/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listarmodulos',
                        busqueda: $('#modulosTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#modulosUlPaginacionModulos').empty();
                    $('#modulosTbdListaModulos').empty();
                    if (datos[0].reg === -1) {
                        $('#modulosUlPaginacionModulos').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {
                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#modulosUlPaginacionModulos').append($('<li>').append($('<a href="#">').text('Anterior')
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
                                    $('#modulosUlPaginacionModulos').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listar($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#modulosUlPaginacionModulos').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#modulosUlPaginacionModulos li:first').addClass('active');
                            }
                            $('#modulosUlPaginacionModulos li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        }
                        else {
                            $('#modulosUlPaginacionModulos').empty();
                        }
                        $.each(datos, function (i) {
                            $('#modulosTbdListaModulos').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].id))
                                    .append($('<td>').text(datos[i].descripcion))
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        Editarmodulo(datos[i].id, datos[i].descripcion, datos[i].pagac);
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
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de listar Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al tratar listar Área/Subjefatura, por favor comuniquese con el proveedor del servicio", "error");
                    }
                    $("#msgModulossVerificandoListaMódulo").addClass('hide');
                });
            },
            /**
             * Función que permite cambiar el estado de Área/Subjefatura.
             * @param {integer} vidmodulo
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidmodulo, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado del Área/Subjefatura?',
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
                            url: url_relativa +  'modulos/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'cambiarestadomodulo',
                                id: vidmodulo
                            }
                        }).done(function (respuesta) {
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg !== -2 && datos[0].reg !== -3) {
                                send('{"tipo": "CAMBIARESTADOMODULO", "id": ""}');
                                $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                        .text("")
                                        .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                        .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                        .attr('title', datos[0].estado === "A" ? "Activo" : "Inactivo");
                                datos[0].reg === 1 ? sweetAlert("Modificado", 'El Área/Subjefatura ha sido activado', "success") :
                                        sweetAlert("Modificado", 'El Área/Subjefatura ha sido desactivado', "success");
                            }
                            else if (datos[0].reg === -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar el estado de Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                            }
                            else {
                                sweetAlert("Error", 'Error al tratar de cambiar el estado de Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                            }
                        });
                    } else {
                        sweetAlert("Cancelado", 'El estado del Área/Subjefatura no ha sido modificado', "warning");
                    }
                });
            },
            /**
             * Función que permite crear un nuevo módulo.
             * @returns {void}
             */
            nuevo = function () {
                $("#modulosBtnNuevoModulo").click(function (e) {
                    e.preventDefault();
                    limpiarCamposNuevo();
                    $("#modulosBtnNuevoModulo").attr('disabled', 'disabled');
                    $("#modulossecListaModulos").fadeOut(function () {
                        $("#modulosSecNuevoModulo").fadeIn('slow', function () {
                            $("#modulosTxtDescripcionNuevoModulo").focus();
                        });
                    });
                });
                $("#modulosBtnCancelarNuevoModulo").off('click');
                $("#modulosBtnCancelarNuevoModulo").click(function () {
                    listar(1);
                    $("#modulosSecNuevoModulo").fadeOut(function () {
                        $("#modulossecListaModulos").fadeIn('slow');
                        $("#modulosBtnNuevoModulo").removeAttr('disabled');
                        limpiarCamposNuevo();
                    });
                });
                $("#modulosBtnGuardarNuevoModulo").off('click');
                $("#modulosBtnGuardarNuevoModulo").click(function () {
                    guardarNuevo();
                });
            },
            /**
             * Función que limpia los campos para nuevo módulo.
             * @returns {void}
             */
            limpiarCamposNuevo = function () {
                $("#modulosSecNuevoModulo input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorNuevoModulo").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que permite buscar modulos mediante el filtro de búsqueda.
             * @returns {void}
             */
            buscar = function () {
                $('#modulosTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#modulosTxtFiltroBusqueda').keyup(function () {
                    listar(1);
                });
            },
            /**
             * Función que guarda información de nuevo Área/Subjefatura.
             * @returns {void}
             */
            guardarNuevo = function () {
                if (ValidarCamposVaciosNuevo()) {
                    $("#msgModulossVerificandoNuevoMódulo").removeClass('hide');
                    $.ajax({
                        url: url_relativa +  'modulos/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevomodulo',
                            descripcion: $('#modulosTxtDescripcionNuevoModulo').val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                             send('{"tipo": "CREARMODULO", "id": ""}');
                            $("#msgModulossVerificandoNuevoMódulo").addClass('hide');
                            sweetAlert("Error", 'El Área/Subjefatura ya existe', "error");
                        }
                        else if (datos[0].reg === 2) {
                            $("#msgModulossVerificandoNuevoMódulo").addClass('hide');
                            listar(1);
                            $("#modulosSecNuevoModulo").fadeOut(function () {
                                $("#modulossecListaModulos").fadeIn('slow');
                                $("#modulosBtnNuevoModulo").removeAttr('disabled');
                                limpiarCamposNuevo();
                            });
                            swal({
                                title: "Guardado",
                                text: "Área/Subjefatura ingresado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgModulossVerificandoNuevoMódulo").addClass('hide');
                            sweetAlert("Error", 'Error de envio de parámetros al tratar de crear Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgModulossVerificandoNuevoMódulo").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de crear Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que valida los campos para nuevo Área/Subjefatura.
             * @returns {Boolean}
             */
            ValidarCamposVaciosNuevo = function () {
                var resultado = true;
                $('.form-group .modulosClsCampoValidadoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevoModulo').addClass('hide');
                });
                $('.form-group .modulosClsCampoValidadoNuevo,.form-group .modulosClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevoModulo').addClass('hide');
                });
                $('.form-group .modulosClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevoModulo').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorNuevoModulo').addClass('hide');
                    }
                });
                return resultado;
            }, 
             /**
             * Función que permite editar Área/Subjefatura.
             * @param {integer} id
             * @param {string} descripcion
             * @param {integer} pagac
             * @returns {void}
             */
            Editarmodulo = function (id, descripcion, pagac) {
                limpiarCamposEditar();
                $("#modulosBtnCancelarEditarModulo").off('click');
                $("#modulosBtnCancelarEditarModulo").click(function () {
                    listar(pagac);
                    $("#modulosSecEditarModulo").fadeOut(function () {
                        $("#modulossecListaModulos").fadeIn('slow');
                        $("#modulosBtnNuevomodulo").removeAttr('disabled');
                    });
                });
                $("#modulosTxtIdEditarModulo").val(id);
                $("#modulosTxtDescripcionEditarModulo").val(descripcion);
                $("#modulosBtnNuevomodulo").attr('disabled', 'disabled');
                $("#modulossecListaModulos").fadeOut(function () {
                    $("#modulosSecEditarModulo").fadeIn('slow', function () {
                        $("#modulosTxtDescripcionEditarModulo").focus();
                        $("#modulosBtnGuardarEditarModulo").off('click');
                        $("#modulosBtnGuardarEditarModulo").click(function () {
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
                $('.form-group .modulosClsCampoValidadoEditar').click(function () {
                    $(this).parent().siblings('.msgErrorEditarModulo').addClass('hide');
                    $(this).parent().siblings('.msgErrorEspacioBlancoEditarModulo').addClass('hide');
                });
                $('.form-group .modulosClsCampoValidadoEditar,.form-group .modulosClsCampoValidadoFormatoEditar').focusin(function () {
                    $(this).parent().siblings('.msgErrorEditarModulo').addClass('hide');
                });
                $('.form-group .modulosClsCampoValidadoEditar').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorEditarModulo').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorEditarModulo').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que guarda la edición de Área/Subjefatura.
             * @param {integer} id
             * @param {integer} pagac
             * @returns {vacio}
             */
            guardarEditar = function (id, pagac) {
                if (ValidarCamposVaciosEditar()) {
                    $("#msgModulossVerificandoEditarMódulo").removeClass('hide');
                    $.ajax({
                        url: url_relativa +  'modulos/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'editarmodulo',
                            id: id,
                            descripcion: $('#modulosTxtDescripcionEditarModulo').val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgModulossVerificandoEditarMódulo").addClass('hide');
                            listar(pagac);
                            $("#modulosSecEditarModulo").fadeOut(function () {
                                $("#modulossecListaModulos").fadeIn('slow');
                            });
                            swal({
                                title: "Editado",
                                text: "Área/Subjefatura editado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === 2) {
                            $("#msgModulossVerificandoEditarMódulo").addClass('hide');
                            sweetAlert("Error", 'El Área/Subjefatura ya existe', "error");
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgModulossVerificandoEditarMódulo").hide();
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de editar Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgModulossVerificandoEditarMódulo").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de editar Área/Subjefatura, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que limpia los campos de edición.
             * @returns {void}
             */
            limpiarCamposEditar = function () {
                $("#modulosSecEditarModulo input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorEditarModulo").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * función que inicializa el módulo de Área/Subjefatura.
             * @returns {void}
             */
            iniciar = function () {
                iniciarSocket();
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
    Modulos.iniciar();
});