var Tramites = (function () {
    var
            /**
             * Función que permite listar los trámites.
             * @param {integer} pag
             * @returns {void}
             */
            listar = function (pag) {
                $("#msgTramitessVerificandoListaTrámite").removeClass('hide');
                $.ajax({
                    url: url_relativa + 'tramites/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listartramites',
                        busqueda: $('#tramitesTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#tramitesUlPaginacionTramites').empty();
                    $('#tramitesTbdListaTramites').empty();
                    if (datos[0].reg === -1) {
                        $('#tramitesUlPaginacionTramites').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {
                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#tramitesUlPaginacionTramites').append($('<li>').append($('<a href="#">').text('Anterior')
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
                                    $('#tramitesUlPaginacionTramites').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listar($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#tramitesUlPaginacionTramites').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#tramitesUlPaginacionTramites li:first').addClass('active');
                            }
                            $('#tramitesUlPaginacionTramites li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        }
                        else {
                            $('#tramitesUlPaginacionTramites').empty();
                        }
                        $.each(datos, function (i) {
                            $('#tramitesTbdListaTramites').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].nombre))
                                    .append($('<td>').text(datos[i].inicial))
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        Editartramite(datos[i].id, datos[i].nombre, datos[i].pagac, datos[i].inicial, datos[i].clienterequerido);
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
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de listar tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al tratar listar tipos de padecimiento, por favor comuniquese con el proveedor del servicio", "error");
                    }
                    $("#msgTramitessVerificandoListaTrámite").addClass('hide');
                });
            },
            /*
             * Función que agrega estilos a los selects de módulos.
             * @returns {void}
             */
            estilosMultiselect = function () {
                $(".multiselect.dropdown-toggle.btn.btn-default").parent().addClass("col-xs-12");
                $(".multiselect.dropdown-toggle.btn.btn-default").addClass("col-xs-12");
                $(".multiselect.dropdown-toggle.btn.btn-default").css({"padding-left": "0px", "padding-right": "0px"});
                $(".multiselect.dropdown-toggle.btn.btn-default").parent().css({"padding-left": "0px", "padding-right": "0px"});
                $(".multiselect-container.dropdown-menu").css("margin-left", "0%");
                $(".multiselect-container.dropdown-menu").css("width", "100%");
            },
            /**
             * Función que carga los módulos para nuevo trámite.
             * @returns {void}
             */
            cargarModulosNuevo = function () {
                $.ajax({
                    url: url_relativa + 'tramites/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarmodulos'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#tramitesSelectNuevoModulo').multiselect('destroy');
                    $('#tramitesSelectNuevoModulo').empty();
                    if (datos[0].reg === 1) {
                        for (var i in datos) {
                            $('#tramitesSelectNuevoModulo').append($("<option>").val(datos[i].id).text((datos[i].id)));
                        }
                        $('#tramitesSelectNuevoModulo').multiselect();
                        estilosMultiselect();
                        $('option', $('#tramitesSelectNuevoModulo')).each(function (element) {
                            $(this).removeAttr('selected').prop('selected', false);
                        });
                        $('#tramitesSelectNuevoModulo').multiselect('refresh');
                    } else if (datos[0].reg === -1) {
                        $('#tramitesSelectNuevoModulo').multiselect();
                        estilosMultiselect();
                        sweetAlert("Precaución", 'No se han cargado módulos, por lo tanto no podrá crear tipos de padecimiento', "warning");
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de cargar módulos para nuevo tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        $('#tramitesSelectNuevoModulo').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error al tratar de cargar módulos para nuevo tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que permite cambiar el estado de trámite.
             * @param {integer} vidtramite
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidtramite, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado del tipos de padecimiento?',
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
                            url: url_relativa + 'tramites/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'cambiarestadotramite',
                                id: vidtramite
                            }
                        }).done(function (respuesta) {
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg !== -2 && datos[0].reg !== -3) {
                                send('{"tipo": "CAMBIARESTADOTRAMITE", "id": ""}');
                                $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                        .text("")
                                        .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                        .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                        .attr('title', datos[0].estado === "A" ? "Activo" : "Inactivo");
                                datos[0].reg === 1 ? sweetAlert("Modificado", 'El trámite ha sido activado', "success") :
                                        sweetAlert("Modificado", 'El tipos de padecimiento ha sido desactivado', "success");
                            }
                            else if (datos[0].reg === -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar el estado al tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                            }
                            else {
                                sweetAlert("Error", 'Error al tratar de cambiar el estado al tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                            }
                        });
                    } else {
                        sweetAlert("Cancelado", 'El estado del tipos de padecimiento no ha sido modificado', "warning");
                    }
                });
            },
            /**
             * Función que permite crear un nuevo trámite.
             * @returns {void}
             */
            nuevo = function () {
                $("#tramitesBtnNuevoTramite").click(function (e) {
                    e.preventDefault();
                    cargarModulosNuevo();
                    limpiarCamposNuevo();
                    $("#tramitesBtnNuevoTramite").attr('disabled', 'disabled');
                    $("#tramitessecListaTramites").fadeOut(function () {
                        $("#tramitesSecNuevoTramite").fadeIn('slow', function () {
                            $("#tramitesTxtNombreNuevoTramite").focus();
                        });
                    });
                });
                $("#tramitesBtnCancelarNuevoTramite").off('click');
                $("#tramitesBtnCancelarNuevoTramite").click(function () {
                    listar(1);
                    $("#tramitesSecNuevoTramite").fadeOut(function () {
                        $("#tramitessecListaTramites").fadeIn('slow');
                        $("#tramitesBtnNuevoTramite").removeAttr('disabled');
                        limpiarCamposNuevo();
                    });
                });
                $("#tramitesBtnGuardarNuevoTramite").off('click');
                $("#tramitesBtnGuardarNuevoTramite").click(function () {
                    guardarNuevo();
                });
            },
            /**
             * Función que limpia los campos para nuevo trámite.
             * @returns {void}
             */
            limpiarCamposNuevo = function () {
                $("#tramitesSecNuevoTramite input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorNuevoTramite").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que permite buscar trámites mediante el filtro de búsqueda.
             * @returns {void}
             */
            buscar = function () {
                $('#tramitesTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#tramitesTxtFiltroBusqueda').keyup(function () {
                    listar(1);
                });
            },
            /**
             * Función que guarda información de nuevo trámite.
             * @returns {void}
             */
            guardarNuevo = function () {
                if (ValidarCamposVaciosNuevo()) {
                    $("#msgTramitessVerificandoNuevoTramite").removeClass('hide');
                    var modulos = new Array(1);
                    var contador = 0;
                    $('option', $('#tramitesSelectNuevoModulo')).each(function (element) {
                        if ($(this).prop('selected') === true) {
                            $(this).attr('selected', true);
                            modulos[contador] = parseInt($(this).val());
                            contador = contador + 1;
                        }
                    });
                    if (contador == 0) {
                        modulos[0] = -1;
                    }
                    $.ajax({
                        url: url_relativa + 'tramites/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevotramite',
                            nombre: $('#tramitesTxtNombreNuevoTramite').val(),
                            modulos: modulos,
                            iniciales: $('#tramitesTxtInicialNuevoTramite').val(),
                            clienterequerido: $('#tramitesCheckboxNuevoClienteRequerido').prop('checked') === true ? 'R' : 'N'
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgTramitessVerificandoNuevoTramite").addClass('hide');
                            sweetAlert("Error", 'Ya existe un tipo de padecimiento con la inicial y/o nombre enviado', "error");
                        }
                        else if (datos[0].reg === 2) {
                            send('{"tipo": "CREARTRAMITE", "id": ""}');
                            $("#msgTramitessVerificandoNuevoTramite").addClass('hide');
                            listar(1);
                            $("#tramitesSecNuevoTramite").fadeOut(function () {
                                $("#tramitessecListaTramites").fadeIn('slow');
                                $("#tramitesBtnNuevoTramite").removeAttr('disabled');
                                limpiarCamposNuevo();
                            });
                            swal({
                                title: "Guardado",
                                text: "Tipo de padecimiento ingresado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgTramitessVerificandoNuevoTramite").addClass('hide');
                            sweetAlert("Error", 'Error de envio de parámetros al tratar de crear tipo de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgTramitessVerificandoNuevoTramite").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de crear tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que valida los campos para nuevo trámite.
             * @returns {Boolean}
             */
            ValidarCamposVaciosNuevo = function () {
                var resultado = true;
                $('.form-group .tramitesClsCampoValidadoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevoTramite').addClass('hide');
                });
                $('.form-group .tramitesClsCampoValidadoNuevo,.form-group .tramitesClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevoTramite').addClass('hide');
                });
                $('.form-group .tramitesClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevoTramite').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorNuevoTramite').addClass('hide');
                    }
                });

                return resultado;
            },
            /**
             * Función que permite editar trámite.
             * @param {integer} id
             * @param {string} nombre
             * @param {integer} pagac
             * @param {string} inicial
             * * @param {string} clienterequerido
             * @returns {void}
             */
            Editartramite = function (id, nombre, pagac, inicial, clienterequerido) {
                limpiarCamposEditar();
                cargarModulosEditar(id);
                $("#tramitesBtnCancelarEditarTramite").off('click');
                $("#tramitesBtnCancelarEditarTramite").click(function () {
                    listar(pagac);
                    $("#tramitesSecEditarTramite").fadeOut(function () {
                        $("#tramitessecListaTramites").fadeIn('slow');
                        $("#tramitesBtnNuevotramite").removeAttr('disabled');
                    });
                });
                $("#tramitesTxtNombreEditarTramite").val(nombre);
                $("#tramitesTxtInicialEditarTramite").val(inicial);
                $("#tramitesCheckboxEditarClienteRequerido").prop('checked', clienterequerido === "R" ? true : false);
                $("#tramitesBtnNuevotramite").attr('disabled', 'disabled');
                $("#tramitessecListaTramites").fadeOut(function () {
                    $("#tramitesSecEditarTramite").fadeIn('slow', function () {
                        $("#tramitesTxtNombreEditarTramite").focus();
                        $("#tramitesBtnGuardarEditarTramite").off('click');
                        $("#tramitesBtnGuardarEditarTramite").click(function () {
                            guardarEditar(id, pagac);
                        });
                    });
                });
            },
            /**
             * Función que carga los módulos de un tipos de padecimiento para edición.
             * @param {integer} idtramite
             * @returns {void}
             */
            cargarModulosEditar = function (idtramite) {
                $.ajax({
                    url: url_relativa + 'tramites/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarmoduloseditarusuario',
                        tramite: idtramite
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#tramitesSelectEditarModulo').multiselect('destroy');
                    $('#tramitesSelectEditarModulo').empty();
                    if (datos[0].reg === 1) {
                        $.each(datos, function (i) {
                            $('#tramitesSelectEditarModulo').append(
                                    $("<option>").val(datos[i].id).text(datos[i].id)
                                    );
                        });
                        $('#tramitesSelectEditarModulo').multiselect();
                        estilosMultiselect();
                        $('option', $('#tramitesSelectEditarModulo')).each(function () {
                            $(this).attr('selected', false);
                        });
                        $('#tramitesSelectEditarModulo').multiselect('refresh');
                        $('option', $('#tramitesSelectEditarModulo')).each(function (i) {
                            if (datos[i].estado === 1) {
                                $(this).attr('selected', true);
                            }
                            if (datos[i].estado === 1 && $(this).prop('selected') === false) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('#tramitesSelectEditarModulo').multiselect('refresh');
                    } else if (datos[0].reg === -1) {
                        $('#tramitesSelectEditarModulo').multiselect();
                        estilosMultiselect();
                    } else if (datos[0].reg === -3) {
                        $('#tramitesSelectEditarModulo').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de consultar módulos para edición de tipos de padecimiento,  por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        $('#tramitesSelectEditarModulo').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error al tratar de cargar módulos para edición de trámites,  por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que valida los campos para edición.
             * @returns {Boolean}
             */
            ValidarCamposVaciosEditar = function () {
                var resultado = true;
                $('.form-group .tramitesClsCampoValidadoEditar').click(function () {
                    $(this).parent().siblings('.msgErrorEditarTramite').addClass('hide');
                    $(this).parent().siblings('.msgErrorEspacioBlancoEditarTramite').addClass('hide');
                });
                $('.form-group .tramitesClsCampoValidadoEditar,.form-group .tramitesClsCampoValidadoFormatoEditar').focusin(function () {
                    $(this).parent().siblings('.msgErrorEditarTramite').addClass('hide');
                });
                $('.form-group .tramitesClsCampoValidadoEditar').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorEditarTramite').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorEditarTramite').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que guarda la edición de trámite.
             * @param {integer} id
             * @param {integer} pagac
             * @returns {vacio}
             */
            guardarEditar = function (id, pagac) {
                if (ValidarCamposVaciosEditar()) {
                    $("#msgTramitessVerificandoEditarTrámite").removeClass('hide');
                    var modulos = new Array(1);
                    var contador = 0;
                    $('option', $('#tramitesSelectEditarModulo')).each(function (element) {
                        if ($(this).prop('selected') === true) {
                            $(this).attr('selected', true);
                            modulos[contador] = parseInt($(this).val());
                            contador = contador + 1;
                        }
                    });
                    if (contador == 0) {
                        modulos[0] = -1;
                    }
                    $.ajax({
                        url: url_relativa + 'tramites/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'editartramite',
                            id: id,
                            nombre: $('#tramitesTxtNombreEditarTramite').val(),
                            modulos: modulos,
                            iniciales: $("#tramitesTxtInicialEditarTramite").val(),
                            clienterequerido: $('#tramitesCheckboxEditarClienteRequerido').prop('checked') === true ? 'R' : 'N'
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgTramitessVerificandoEditarTrámite").addClass('hide');
                            listar(pagac);
                            $("#tramitesSecEditarTramite").fadeOut(function () {
                                $("#tramitessecListaTramites").fadeIn('slow');
                            });
                            swal({
                                title: "Editado",
                                text: "Tramite editado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === 2) {
                            $("#msgTramitessVerificandoEditarTrámite").addClass('hide');
                            sweetAlert("Error", 'Ya existe un tipo de padecimiento con la inicial y/o nombre enviado', "error");
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgTramitessVerificandoEditarTrámite").hide();
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de editar tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgTramitessVerificandoEditarTrámite").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de editar tipos de padecimiento, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que limpia los campos de edición.
             * @returns {void}
             */
            limpiarCamposEditar = function () {
                $("#tramitesSecEditarTramite input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorEditarTramite").each(function () {
                    $(this).addClass('hide');
                });
            },
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
    Tramites.iniciar();
});