var Perfiles = (function () {
    var
            /**
             * Función que permite listar los perfiles.
             * @param {integer} pag
             * @returns {void}
             */
            listar = function (pag) {
                $("#msgPerfilessVerificandoListaPerfíl").removeClass('hide');
                $.ajax({
                    url: url_relativa +  'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listarperfiles',
                        busqueda: $('#perfilesTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#perfilesUlPaginacionPerfiles').empty();
                    $('#perfilesTbdListaPerfiles').empty();
                    if (datos[0].reg === -1) {
                        $('#perfilesUlPaginacionPerfiles').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {
                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#perfilesUlPaginacionPerfiles').append($('<li>').append($('<a href="#">').text('Anterior')
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
                                    $('#perfilesUlPaginacionPerfiles').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listar($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#perfilesUlPaginacionPerfiles').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#perfilesUlPaginacionPerfiles li:first').addClass('active');
                            }
                            $('#perfilesUlPaginacionPerfiles li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        }
                        else {
                            $('#perfilesUlPaginacionPerfiles').empty();
                        }
                        $.each(datos, function (i) {
                            $('#perfilesTbdListaPerfiles').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].nombre))
                                    .append($('<td>').text(datos[i].acronimo).addClass('hidden-xs'))
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        Editarperfil(datos[i].id, datos[i].nombre, datos[i].acronimo, datos[i].pagac);
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
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de listar perfiles, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al tratar listar perfiles, por favor comuniquese con el proveedor del servicio", "error");
                    }
                    $("#msgPerfilessVerificandoListaPerfíl").addClass('hide');
                });
            },
            /**
             * Función que permite cambiar el estado de perfíl.
             * @param {integer} vidperfil
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidperfil, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado del perfíl?',
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
                            url: url_relativa +  'seguridades/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'cambiarestadoperfil',
                                id: vidperfil
                            }
                        }).done(function (respuesta) {
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg === 10) {
                                sweetAlert("Error", 'No se puede cambiar el estado al perfíl, este es un perfíl de administración del sistema', "error");
                            }
                            else if (datos[0].reg !== -2 && datos[0].reg !== -3) {
                                $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                        .text("")
                                        .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                        .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                        .attr('title', datos[0].estado === "A" ? "Activo" : "Inactivo");
                                datos[0].reg === 1 ? sweetAlert("Modificado", 'El perfíl ha sido activado', "success") :
                                        sweetAlert("Modificado", 'El perfíl ha sido desactivado, los usuarios que tengan solo este perfíl no podran acceder al sistema', "success");
                            }
                            else if (datos[0].reg === -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar el estado al perfíl, por favor comuniquese con el proveedor del servicio', "error");
                            }
                            else {
                                sweetAlert("Error", 'Error al tratar de cambiar el estado al perfíl, por favor comuniquese con el proveedor del servicio', "error");
                            }
                        });
                    } else {
                        sweetAlert("Cancelado", 'El estado del perfíl no ha sido modificado', "warning");
                    }
                });
            },
            /**
             * Función que permite crear un nuevo perfíl.
             * @returns {void}
             */
            nuevo = function () {
                $("#perfilesBtnNuevoPerfil").click(function (e) {
                    e.preventDefault();
                    limpiarCamposNuevo();
                    ValidarNoEspaciosBlanco("#perfilesTxtAcronimoNuevoPerfil");
                    $("#perfilesSelInstitucionNuevoPerfil").select2({width: "100%", heigth: "100%"});
                    $("#perfilesBtnNuevoPerfil").attr('disabled', 'disabled');
                    $("#perfilessecListaPerfiles").fadeOut(function () {
                        $("#perfilesSecNuevoPerfil").fadeIn('slow', function () {
                            $("#perfilesTxtNombreNuevoPerfil").focus();
                        });
                    });
                });
                $("#perfilesBtnCancelarNuevoPerfil").off('click');
                $("#perfilesBtnCancelarNuevoPerfil").click(function () {
                    listar(1);
                    $("#perfilesSecNuevoPerfil").fadeOut(function () {
                        $("#perfilessecListaPerfiles").fadeIn('slow');
                        $("#perfilesBtnNuevoPerfil").removeAttr('disabled');
                        limpiarCamposNuevo();
                    });
                });
                $("#perfilesBtnGuardarNuevoPerfil").off('click');
                $("#perfilesBtnGuardarNuevoPerfil").click(function () {
                    guardarNuevo();
                });
            },
            /**
             * Función que limpia los campos para nuevo perfíl.
             * @returns {void}
             */
            limpiarCamposNuevo = function () {
                $("#perfilesSecNuevoPerfil input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorNuevoPerfil").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que permite buscar perfiles mediante el filtro de búsqueda.
             * @returns {void}
             */
            buscar = function () {
                $('#perfilesTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#perfilesTxtFiltroBusqueda').keyup(function () {
                    listar(1);
                });
            },
            /**
             * Función que guarda información de nuevo perfíl.
             * @returns {void}
             */
            guardarNuevo = function () {
                if (ValidarCamposVaciosNuevo()) {
                    $("#msgPerfilessVerificandoNuevoPerfíl").removeClass('hide');
                    $.ajax({
                        url: url_relativa +  'seguridades/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevoperfil',
                            nombre: $('#perfilesTxtNombreNuevoPerfil').val(),
                            acronimo: $('#perfilesTxtAcronimoNuevoPerfil').val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgPerfilessVerificandoNuevoPerfíl").addClass('hide');
                            sweetAlert("Error", 'El perfíl ya existe', "error");
                        }
                        else if (datos[0].reg === 2) {
                            $("#msgPerfilessVerificandoNuevoPerfíl").addClass('hide');
                            listar(1);
                            $("#perfilesSecNuevoPerfil").fadeOut(function () {
                                $("#perfilessecListaPerfiles").fadeIn('slow');
                                $("#perfilesBtnNuevoPerfil").removeAttr('disabled');
                                limpiarCamposNuevo();
                            });
                            swal({
                                title: "Guardado",
                                text: "Perfil ingresado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgPerfilessVerificandoNuevoPerfíl").addClass('hide');
                            sweetAlert("Error", 'Error de envio de parámetros al tratar de crear perfíl, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgPerfilessVerificandoNuevoPerfíl").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de crear perfíl, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que valida los campos para nuevo perfíl.
             * @returns {Boolean}
             */
            ValidarCamposVaciosNuevo = function () {
                var resultado = true;
                $('.form-group .perfilesClsCampoValidadoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevoPerfil').addClass('hide');
                });
                $('.form-group .perfilesClsCampoValidadoNuevo,.form-group .perfilesClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevoPerfil').addClass('hide');
                });
                $('.form-group .perfilesClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevoPerfil').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorNuevoPerfil').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que permite editar perfíl.
             * @param {integer} id
             * @param {string} nombre
             * @param {string} acronimo
             * @param {integer} pagac
             * @returns {void}
             */
            Editarperfil = function (id, nombre, acronimo, pagac) {
                limpiarCamposEditar();
                ValidarNoEspaciosBlanco("#perfilesTxtAcronimoEditarPerfil");
                $("#perfilesBtnCancelarEditarPerfil").off('click');
                $("#perfilesBtnCancelarEditarPerfil").click(function () {
                    listar(pagac);
                    $("#perfilesSecEditarPerfil").fadeOut(function () {
                        $("#perfilessecListaPerfiles").fadeIn('slow');
                        $("#perfilesBtnNuevoperfil").removeAttr('disabled');
                    });
                });
                $("#perfilesTxtNombreEditarPerfil").val(nombre);
                $("#perfilesTxtAcronimoEditarPerfil").val(acronimo);
                $("#perfilesBtnNuevoperfil").attr('disabled', 'disabled');
                $("#perfilessecListaPerfiles").fadeOut(function () {
                    $("#perfilesSecEditarPerfil").fadeIn('slow', function () {
                        $("#perfilesTxtNombreEditarPerfil").focus();
                        $("#perfilesBtnGuardarEditarPerfil").off('click');
                        $("#perfilesBtnGuardarEditarPerfil").click(function () {
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
                $('.form-group .perfilesClsCampoValidadoEditar').click(function () {
                    $(this).parent().siblings('.msgErrorEditarPerfil').addClass('hide');
                    $(this).parent().siblings('.msgErrorEspacioBlancoEditarPerfil').addClass('hide');
                });
                if ($("#perfilesTxtAcronimoEditarPerfil").val().trim() !== "") {
                    if (/\s/.test($("#perfilesTxtAcronimoEditarPerfil").val().trim())) {
                        $('.msgErrorEspacioBlancoEditarPerfil').removeClass('hide');
                        resultado = false;
                    }
                }
                $('.form-group .perfilesClsCampoValidadoEditar,.form-group .perfilesClsCampoValidadoFormatoEditar').focusin(function () {
                    $(this).parent().siblings('.msgErrorEditarPerfil').addClass('hide');
                });
                $('.form-group .perfilesClsCampoValidadoEditar').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorEditarPerfil').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorEditarPerfil').addClass('hide');
                    }
                });
                return resultado;
            },
            /**
             * Función que guarda la edición de perfíl.
             * @param {integer} id
             * @param {integer} pagac
             * @returns {void}
             */
            guardarEditar = function (id, pagac) {
                if (ValidarCamposVaciosEditar()) {
                    $("#msgPerfilessVerificandoEditarPerfíl").removeClass('hide');
                    $.ajax({
                        url: url_relativa +  'seguridades/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'editarperfil',
                            id: id,
                            nombre: $('#perfilesTxtNombreEditarPerfil').val(),
                            acronimo: $('#perfilesTxtAcronimoEditarPerfil').val().trim()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgPerfilessVerificandoEditarPerfíl").addClass('hide');
                            listar(pagac);
                            $("#perfilesSecEditarPerfil").fadeOut(function () {
                                $("#perfilessecListaPerfiles").fadeIn('slow');
                            });
                            swal({
                                title: "Editado",
                                text: "Perfil editado exitosamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === 10) {
                            $("#msgPerfilessVerificandoEditarPerfíl").addClass('hide');
                            sweetAlert("Error", 'El perfíl ya existe', "error");
                        }
                        else if (datos[0].reg === -3) {
                            $("#msgPerfilessVerificandoEditarPerfíl").hide();
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de editar perfíl, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else {
                            $("#msgPerfilessVerificandoEditarPerfíl").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de editar perfíl, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que limpia los campos de edición.
             * @returns {void}
             */
            limpiarCamposEditar = function () {
                $("#perfilesSecEditarPerfil input").each(
                        function () {
                            $(this).val("");
                        });
                $(".msgErrorEditarPerfil").each(function () {
                    $(this).addClass('hide');
                });
            },
            /**
             * Función que restringe el ingreso de espacios en blanco.
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
             * Función que inicializa el módulo de perfiles.
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
    Perfiles.iniciar();
});