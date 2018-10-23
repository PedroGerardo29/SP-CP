var Opciones = (function () {
    var
            /**
             * Función que permite listar las opciones.
             * @param {integer} pag
             * @returns {void}
             */
            listar = function (pag) {
                $("#msgPerfilessVerificandoListaOpcion").removeClass('hide');
                $.ajax({
                    url: url_relativa +  'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listaropciones',
                        busqueda: $('#opcionesTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#opcionesUlPaginacionOpciones').empty();
                    $('#opcionesTbdListaOpciones').empty();
                    if (datos[0].reg === -1) {
                        $('#opcionesUlPaginacionOpciones').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {
                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#opcionesUlPaginacionOpciones').append($('<li>').append($('<a href="#">').text('Anterior')
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
                                    $('#opcionesUlPaginacionOpciones').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listar($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#opcionesUlPaginacionOpciones').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#opcionesUlPaginacionOpciones li:first').addClass('active');
                            }
                            $('#opcionesUlPaginacionOpciones li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        }
                        else {
                            $('#opcionesUlPaginacionOpciones').empty();
                        }
                        $.each(datos, function (i) {
                            $('#opcionesTbdListaOpciones').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].nombre))
                                    .append($('<td>').text(datos[i].acronimo).addClass('hidden-xs'))
                                    .append($('<td>').append($("<span>").addClass(datos[i].icono).addClass('text-center'))
                                            .append($("<span>").text(" " + datos[i].icono).addClass('text-center')).
                                            addClass('hidden-xs'))
                                    .append($('<td>').text(datos[i].vista).addClass('hidden-xs'))
                                    .append($('<td>').append(
                                            $('<input>').attr({'type': 'checkbox', 'checked': datos[i].full, 'disabled': 'disabled'}).addClass('col-xs-12 checkbox')
                                            ))
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        Editaropcion(datos[i].id, datos[i].nombre, datos[i].acronimo, datos[i].icono, datos[i].vista, datos[i].pagac, datos[i].full);
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
                    }
                    else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de listar Permisos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al tratar de listar permisos, por favor comuniquese con el proveedor del servicio", "error");
                    }
                    $("#msgPerfilessVerificandoListaOpcion").addClass('hide');
                });
            },
            /**
             * Función que permite cambiar el estado de la opción.
             * @param {integer} vidopcion
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidopcion, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado de el permiso?',
                    text: 'El estado será modificado!',
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
                            url: url_relativa +  'seguridades/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'cambiarestadoopciones',
                                id: vidopcion
                            }
                        }).done(function (respuesta) {
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg === 10) {
                                sweetAlert("Error", 'La opción de administración de persmisos no debe ser desactivada', "error");
                            }
                            else if (datos[0].reg !== -2) {
                                $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                        .text("")
                                        .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                        .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                        .attr('title', datos[0].estado === "A" ? "Activo" : "Inactivo");
                                datos[0].reg === 1 ? sweetAlert("Modificado", 'El permiso ha sido activada', "success") :
                                        sweetAlert("Modificado", 'La opción ha sido desactivada', "success");
                            }
                            else if (datos[0].reg !== -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar cambiar el estado de el permiso, por favor comuniquese con el proveedor del servicio', "error");
                            } else {
                                sweetAlert("Error", 'Error al tratar de cambiar el estado de la permiso, por favor comuniquese con el proveedor del servicio', "error");
                            }
                        });
                    } else {
                        sweetAlert("Cancelado", 'El estado del permiso no ha sido modificado', "warning");
                    }
                });
            },
            /**
             * Función que permite crear una nueva opción.
             * @returns {void}
             */
            nuevo = function () {
                $("#opcionesBtnNuevoOpcion").click(function (e) {
                    e.preventDefault();
                    limpiarCamposNuevo();
                    cargarPerfilesNuevo();
                    ValidarNoEspaciosBlanco("#opcionesTxtAcronimoNuevoOpcion");
                    ValidarNoEspaciosBlanco("#opcionesTxtVistaNuevoOpcion");
                    $("#opcionesSelInstitucionNuevoOpcion").select2({width: "100%", heigth: "100%"});
                    $("#opcionesBtnNuevoOpcion").attr('disabled', 'disabled');
                    $("#opcionessecListaOpciones").fadeOut(function () {
                        $("#opcionesSecNuevoOpcion").fadeIn('slow', function () {
                            $("#opcionesTxtNombreNuevoOpcion").focus();
                        });
                    });
                });
                $("#opcionesBtnCancelarNuevoOpcion").off('click');
                $("#opcionesBtnCancelarNuevoOpcion").click(function () {
                    listar(1);
                    $("#opcionesSecNuevoOpcion").fadeOut(function () {
                        $("#opcionessecListaOpciones").fadeIn('slow');
                        $("#opcionesBtnNuevoOpcion").removeAttr('disabled');
                        limpiarCamposNuevo();
                    });
                });
                $("#opcionesBtnGuardarNuevoOpcion").off('click');
                $("#opcionesBtnGuardarNuevoOpcion").click(function () {
                    guardarNuevo();
                });
            },
            /**
             * Función que limpia los campos para nueva opción.
             * @returns {void}
             */
            limpiarCamposNuevo = function () {
                $("#opcionesSecNuevoOpcion input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorNuevoOpcion,.msgErrorNuevoOpcionPerfil").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que permite buscar opciones mediante el filtro de búsqueda.
             * @returns {void}
             */
            buscar = function () {
                $('#opcionesTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#opcionesTxtFiltroBusqueda').keyup(function () {
                    listar(1);
                });
            },
            /**
             * Función que carga los perfiles para nueva opción.
             * @returns {void}
             */
            cargarPerfilesNuevo = function () {
                $.ajax({
                    url: url_relativa +  'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarperfilesnuevo'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#opcionesSelPerfilesNuevoOpcion').multiselect('destroy');
                    $('#opcionesSelPerfilesNuevoOpcion').empty();
                    if (datos[0].reg === 1) {
                        for (var i in datos) {
                            $('#opcionesSelPerfilesNuevoOpcion').append($("<option>").val(datos[i].id).text((datos[i].nombre).toUpperCase()));
                        }
                        $('#opcionesSelPerfilesNuevoOpcion').multiselect();
                        estilosMultiselect();
                        $('option', $('#opcionesSelPerfilesNuevoOpcion')).each(function (element) {
                            $(this).removeAttr('selected').prop('selected', false);
                        });
                        $('#opcionesSelPerfilesNuevoOpcion').multiselect('refresh');
                    } else if (datos[0].reg === -1) {
                        $('#opcionesSelPerfilesNuevoOpcion').multiselect();
                        estilosMultiselect();
                        sweetAlert("Precaución", 'No se han cargado perfiles, por lo tanto no podrá crear permisos', "warning");
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de cargar perfiles para ingreso de permisos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        $('#opcionesSelPerfilesNuevoOpcion').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error al tratar de cargar perfiles para ingreso de permisos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que agrega estilos a los selects de perfíles.
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
             * Función que permite guardar la información de nueva opción.
             * @returns {void}
             */
            guardarNuevo = function () {
                if (ValidarCamposVaciosNuevo()) {
                    $("#msgPerfilessVerificandoNuevoOpcion").removeClass('hide');
                    var perfiles = new Array(1);
                    var contador = 0;
                    $('option', $('#opcionesSelPerfilesNuevoOpcion')).each(function (element) {
                        if ($(this).prop('selected') === true) {
                            $(this).attr('selected', true);
                            perfiles[contador] = parseInt($(this).val());
                            contador = contador + 1;
                        }
                    });
                    $.ajax({
                        url: url_relativa +  'seguridades/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevaopcion',
                            nombre: $('#opcionesTxtNombreNuevoOpcion').val(),
                            acronimo: $('#opcionesTxtAcronimoNuevoOpcion').val(),
                            icono: $('#opcionesTxtIconoNuevoOpcion').val(),
                            vista: $('#opcionesTxtVistaNuevoOpcion').val(),
                            perfiles: perfiles,
                            fullscreen: $("#opcionesTxtFullScreenNuevoOpcion").prop("checked")
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgPerfilessVerificandoNuevoOpcion").addClass('hide');
                            sweetAlert("Error", 'La opción ya existe', "error");
                        }
                        else if (datos[0].reg === 2) {
                            $("#msgPerfilessVerificandoNuevoOpcion").addClass('hide');
                            listar(1);
                            $("#opcionesSecNuevoOpcion").fadeOut(function () {
                                $("#opcionessecListaOpciones").fadeIn('slow');
                                $("#opcionesBtnNuevoOpcion").removeAttr('disabled');
                                limpiarCamposNuevo();
                            });
                            swal({
                                title: "Guardado",
                                text: "Opcion ingresada exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgPerfilessVerificandoNuevoOpcion").addClass('hide');
                            sweetAlert("Error", 'Error de envio de parámetros al tratar de crear opción, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgPerfilessVerificandoNuevoOpcion").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de crear opción, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que valida campos para nueva opción.
             * @returns {Boolean}
             */
            ValidarCamposVaciosNuevo = function () {
                var resultado = true;
                var contadorperfiles = 0;
                $('option', $('#opcionesSelPerfilesNuevoOpcion')).each(function (element) {
                    if ($(this).prop('selected') === true) {
                        contadorperfiles = contadorperfiles + 1;
                    }
                });
                if (contadorperfiles === 0) {
                    $(".msgErrorNuevoOpcionPerfil").removeClass('hide');
                    resultado = false;
                }
                $(".multiselect.dropdown-toggle.btn.btn-default").click(function () {
                    $('.msgErrorNuevoOpcionPerfil').addClass('hide');
                });
                $('.form-group .opcionesClsCampoValidadoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevoOpcion').addClass('hide');
                });
                $('.form-group .opcionesClsCampoValidadoNuevo,.form-group .opcionesClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevoOpcion').addClass('hide');
                });
                $('.form-group .opcionesClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevoOpcion').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorNuevoOpcion').addClass('hide');
                    }
                });

                return resultado;
            },
            /**
             * Función que permite editar opción.
             * @param {integer} id
             * @param {string} nombre
             * @param {string} acronimo
             * @param {string} icono
             * @param {string} vista
             * @param {integer} pagac
             * * @param {boolean} fullscreen
             * @returns {void}
             */
            Editaropcion = function (id, nombre, acronimo, icono, vista, pagac, fullscreen) {
                cargarPerfilesEditar(id);
                ValidarNoEspaciosBlanco("#opcionesTxtAcronimoEditarOpcion");
                ValidarNoEspaciosBlanco("#opcionesTxtVistaEditarOpcion");
                $("#opcionesTxtFullScreenEditarOpcion").prop("checked", fullscreen);
                $("#opcionesBtnCancelarEditarOpcion").off('click');
                $("#opcionesBtnCancelarEditarOpcion").click(function () {
                    listar(pagac);
                    limpiarCamposEditar();
                    $("#opcionesSecEditarOpcion").fadeOut(function () {
                        $("#opcionessecListaOpciones").fadeIn('slow');
                        $("#opcionesBtnNuevoopcion").removeAttr('disabled');
                    });
                });
                $("#opcionesTxtNombreEditarOpcion").val(nombre);
                $("#opcionesTxtAcronimoEditarOpcion").val(acronimo);
                $("#opcionesTxtIconoEditarOpcion").val(icono);
                $("#opcionesTxtVistaEditarOpcion").val(vista);
                $("#opcionesBtnNuevoopcion").attr('disabled', 'disabled');
                $("#opcionessecListaOpciones").fadeOut(function () {
                    $("#opcionesSecEditarOpcion").fadeIn('slow', function () {
                        $("#opcionesTxtNombreEditarOpcion").focus();
                        $("#opcionesBtnGuardarEditarOpcion").off('click');
                        $("#opcionesBtnGuardarEditarOpcion").click(function () {
                            guardarEditar(id, pagac);
                        });
                    });
                });
            },
            /**
             * Función que carga los perfiles para edición de opción.
             * @param {integer} idopcion
             * @returns {void}
             */
            cargarPerfilesEditar = function (idopcion) {
                $.ajax({
                    url: url_relativa +  'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarperfileseditar',
                        opcion: idopcion
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#opcionesSelPerfilesEditarOpcion').multiselect('destroy');
                    $('#opcionesSelPerfilesEditarOpcion').empty();
                    if (datos[0].reg === 1) {
                        $.each(datos, function (i) {
                            $('#opcionesSelPerfilesEditarOpcion').append(
                                    $("<option>").val(datos[i].id).text((datos[i].nombre).toUpperCase())
                                    );
                        });
                        $('#opcionesSelPerfilesEditarOpcion').multiselect();
                        estilosMultiselect();
                        $('option', $('#opcionesSelPerfilesEditarOpcion')).each(function () {
                            $(this).attr('selected', false);
                        });
                        $('#opcionesSelPerfilesEditarOpcion').multiselect('refresh');
                        $('option', $('#opcionesSelPerfilesEditarOpcion')).each(function (i) {
                            if (datos[i].estado === 1) {
                                $(this).attr('selected', true);
                            }
                            if (datos[i].estado === 1 && $(this).prop('selected') === false) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('#opcionesSelPerfilesEditarOpcion').multiselect('refresh');
                    } else if (datos[0].reg === -1) {
                        $('#opcionesSelPerfilesEditarOpcion').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'No se han cargado perfiles por lo tanto no podrá editar permisos', "error");
                    } else if (datos[0].reg === -3) {
                        $('#opcionesSelPerfilesEditarOpcion').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de cargar perfiles para editar permisos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        $('#opcionesSelPerfilesEditarOpcion').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error al tratar de cargar perfiles para editar permisos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que valida los campos para editar opción.
             * @returns {Boolean}
             */
            ValidarCamposVaciosEditar = function () {
                var resultado = true;
                var contadorperfiles = 0;
                $('option', $('#opcionesSelPerfilesEditarOpcion')).each(function (element) {
                    if ($(this).prop('selected') === true) {
                        contadorperfiles = contadorperfiles + 1;
                    }
                });
                if (contadorperfiles === 0) {
                    $(".msgErrorEditarOpcionPerfil").removeClass('hide');
                    resultado = false;
                }
                $(".multiselect.dropdown-toggle.btn.btn-default").click(function () {
                    $('.msgErrorEditarOpcionPerfil').addClass('hide');
                });
                $('.form-group .opcionesClsCampoValidadoEditar').click(function () {
                    $(this).parent().siblings('.msgErrorEditarOpcion').addClass('hide');
                    $(this).parent().siblings('.msgErrorEspacioBlancoEditarOpcion').addClass('hide');
                });
                if ($("#opcionesTxtAcronimoEditarOpcion").val().trim() !== "") {
                    if (/\s/.test($("#opcionesTxtAcronimoEditarOpcion").val().trim())) {
                        $('.msgErrorEspacioBlancoEditarOpcion').removeClass('hide');
                        resultado = false;
                    }
                }
                $('.form-group .opcionesClsCampoValidadoEditar,.form-group .opcionesClsCampoValidadoFormatoEditar').focusin(function () {
                    $(this).parent().siblings('.msgErrorEditarOpcion').addClass('hide');
                });
                $('.form-group .opcionesClsCampoValidadoEditar').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorEditarOpcion').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorEditarOpcion').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que guarda la información de edición de opción.
             * @param {integer} id
             * @param {integer} pagac
             * @returns {void}
             */
            guardarEditar = function (id, pagac) {
                if (ValidarCamposVaciosEditar()) {
                    $("#msgPerfilessVerificandoEditarOpcion").removeClass('hide');
                    var perfiles = new Array(1);
                    var contador = 0;
                    $('option', $('#opcionesSelPerfilesEditarOpcion')).each(function (element) {
                        if ($(this).prop('selected') === true) {
                            $(this).attr('selected', true);
                            perfiles[contador] = parseInt($(this).val());
                            contador = contador + 1;
                        }
                    });
                    $.ajax({
                        url: url_relativa +  'seguridades/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'editaropcion',
                            id: id,
                            nombre: $('#opcionesTxtNombreEditarOpcion').val(),
                            acronimo: $('#opcionesTxtAcronimoEditarOpcion').val().trim(),
                            icono: $('#opcionesTxtIconoEditarOpcion').val(),
                            vista: $('#opcionesTxtVistaEditarOpcion').val(),
                            perfiles: perfiles,
                            fullscreen: $("#opcionesTxtFullScreenEditarOpcion").prop("checked")
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgPerfilessVerificandoEditarOpcion").addClass('hide');
                            limpiarCamposEditar();
                            listar(pagac);
                            $("#opcionesSecEditarOpcion").fadeOut(function () {
                                $("#opcionessecListaOpciones").fadeIn('slow');
                            });
                            swal({
                                title: "Editado",
                                text: "Opcion editada exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === 10) {
                            $("#msgPerfilessVerificandoEditarOpcion").addClass('hide');
                            sweetAlert("Error", 'La opción ya existe', "error");
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgPerfilessVerificandoEditarOpcion").addClass('hide');
                            sweetAlert("Error", 'Error de envio de parámetros al tratar de editar permisos, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgPerfilessVerificandoEditarOpcion").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de editar permisos, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que limpia campos para edición de opción.
             * @returns {void}
             */
            limpiarCamposEditar = function () {
                $("#opcionesSecEditarOpcion input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorEditarOpcion,.msgErrorEditarOpcionPerfil").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que restringe escribir espacios en blanco.
             * @param {integer} id
             * @returns {Boolean}
             */
            ValidarNoEspaciosBlanco = function (id) {
                $(id).keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 32)
                    {
                        event.preventDefault();
                    }
                });
                return true;
            },
            /**
             * Función que inicializa el módulo de opciones.
             * @returns {void}
             */
            iniciar = function () {
                listar(1);
                nuevo();
                buscar();
            }
    ;
    return {
        iniciar: iniciar

    };
})();

$(document).ready(function () {
    Opciones.iniciar();
});