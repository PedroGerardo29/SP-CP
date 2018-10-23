var Parametros = (function () {
    var
            /**
             * Función que permite listar los videos.
             * @param {integer} pag
             * @returns {void}
             */
            listarVideos = function (pag) {
                $("#msgParametrosVerificandoListaParametros").removeClass('hide');
                $.ajax({
                    url: 'parametros/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listarvideos',
                        busqueda: $('#parametrosTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#parametrosUlPaginacionParametros').empty();
                    $('#parametrosTbdListaVideos').empty();
                    if (datos[0].reg === -1) {
                        $('#parametrosUlPaginacionParametros').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {
                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#parametrosUlPaginacionParametros').append($('<li>').append($('<a href="#">').text('Anterior')
                                        .on('click', function () {
                                            listarVideos(parseInt(datos[0].pagac) - 1);
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
                                    $('#parametrosUlPaginacionParametros').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listarVideos($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#parametrosUlPaginacionParametros').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listarVideos(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#parametrosUlPaginacionParametros li:first').addClass('active');
                            }
                            $('#parametrosUlPaginacionParametros li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        }
                        else {
                            $('#parametrosUlPaginacionParametros').empty();
                        }
                        $.each(datos, function (i) {
                            $('#parametrosTbdListaVideos').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].nombre))
                                    .append($('<td>')
                                            .addClass('btn-toolbar text-center')
                                            .append(
                                                    $('<video>').attr({'src': 'includes/video/' + datos[i].nombre, 'controls': 'true'}).css({
                                                'max-heigth': '100px', 'max-width': '120px'
                                            })
                                                    )
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
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de listar videos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", "Error al tratar listar videos, por favor comuniquese con el proveedor del servicio", "error");
                    }
                    $("#msgParametrosVerificandoListaParametros").addClass('hide');
                });
            },
            /**
             * Función que permite cambiar el estado de video.
             * @param {integer} vidvideo
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidvideo, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado del video?',
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
                            url: 'parametros/controlador/php/controlador.php',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                accion: 'cambiarestadovideo',
                                id: vidvideo
                            }
                        }).done(function (respuesta) {
                            var datos = JSON.parse(respuesta);
                            if (datos[0].reg !== -2 && datos[0].reg !== -3) {
                                send('{"tipo": "CAMBIARESTADOVIDEO", "id": ""}');
                                $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                        .text("")
                                        .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                        .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                        .attr('title', datos[0].estado === "A" ? "Activo" : "Inactivo");
                                datos[0].reg === 1 ? sweetAlert("Modificado", 'El video ha sido activado', "success") :
                                        sweetAlert("Modificado", 'El video ha sido desactivado', "success");
                            }
                            else if (datos[0].reg === -3) {
                                sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar el estado de video, por favor comuniquese con el proveedor del servicio', "error");
                            }
                            else {
                                sweetAlert("Error", 'Error al tratar de cambiar el estado de video, por favor comuniquese con el proveedor del servicio', "error");
                            }
                        });
                    } else {
                        sweetAlert("Cancelado", 'El estado del video no ha sido modificado', "warning");
                    }
                });
            },
            /**
             * Función que permite buscar videos mediante el filtro de búsqueda.
             * @returns {void}
             */
            buscarVideos = function () {
                $('#parametrosTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#parametrosTxtFiltroBusqueda').keyup(function () {
                    listarVideos(1);
                });
            },
            /**
             * Función que permite cargar el logo.
             * @returns {void}
             */
            cargarImagenNuevo = function () {
                $("#parametrosBtnSubirFotoNuevoParametro").off('click');
                $("#parametrosBtnSubirFotoNuevoParametro").click(
                        function () {
                            $("#parametrosFilFotoSubirParametro").trigger('click');
                        });
                $("#parametrosFilFotoSubirParametro").off('change');
                $("#parametrosFilFotoSubirParametro").change(function (e) {
                    if (validarExtension("image/png", e) && validartamanho(2097152, e)) {
                        subirLogo("parametrosFilFotoSubirParametro");
                    } else if (!validarExtension("image/png", e)) {
                        sweetAlert("Error", 'Error de formato de imagen, por favor seleccione una imagen de formato .png', "error");
                    } else if (!validartamanho(2097152, e)) {
                        sweetAlert("Error", 'Error de tamaño de imagen, por favor seleccione una imagen de maximo 2MB de peso', "error");
                    }
                });
            },
            /**
             * Función que permite cargar el video.
             * @returns {void}
             */
            cargarVideoNuevo = function () {
                $("#parametrosBtnSubirVideoNuevoParametro").off('click');
                $("#parametrosBtnSubirVideoNuevoParametro").click(function () {
                    $("#parametrosFilevideo").trigger('click');
                });
                $("#parametrosFilevideo").off('change');
                $("#parametrosFilevideo").change(function (e) {
                    if (validarExtension("video/mp4", e) && validartamanho(41943040, e)) {
                        subirVideo("parametrosFilevideo");
                    } else if (!validarExtension("video/mp4", e)) {
                        sweetAlert("Error", 'Error de formato de video, por favor seleccione un video de formato .mp4', "error");
                    } else if (!validartamanho(41943040, e)) {
                        sweetAlert("Error", 'Error de tamaño de video, por favor seleccione un video de maximo 40MB de peso', "error");
                    }
                });
            },
            /**
             * Función que permite cargar el timbre.
             * @returns {void}
             */
            cargarTimbreNuevo = function () {
                $("#parametrosBtnSubirTimbreNuevoParametro").off('click');
                $("#parametrosBtnSubirTimbreNuevoParametro").click(
                        function () {
                            $("#parametrosFilTimbreSubirParametro").trigger('click');
                        });
                $("#parametrosFilevideo").off('change');
                $("#parametrosFilTimbreSubirParametro").change(function (e) {
                    if (validarExtension("audio/mpeg", e) && validartamanho(1048576, e)) {
                        subirTimbre("parametrosFilTimbreSubirParametro");
                    } else if (!validarExtension("audio/mpeg", e)) {
                        sweetAlert("Error", 'Error de formato de audio, por favor seleccione un audio de formato .mp3', "error");
                    } else if (!validartamanho(1048576, e)) {
                        sweetAlert("Error", 'Error de tamaño de audio, por favor seleccione un audio de maximo 1MB de peso', "error");
                    }
                });
            },
            /**
             * Función que permite obtener los parámetros.
             * @returns {void}
             */
            consultarParametros = function () {
                $("#msgParametrosCargandoListadoParametrosInstitucion").removeClass('hide');
                $.ajax({
                    url: "parametros/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarparametros'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 1) {
                        $.each(datos, function (i) {
                            if ($("#parametrosIdParametros" + datos[i].id).attr('type') == 'text') {
                                $("#parametrosIdParametros" + datos[i].id).val(datos[i].valor);
                            } else if ($("#parametrosIdParametros" + datos[i].id).attr('type') == 'checkbox') {
                                if (datos[i].valor == "true") {
                                    $("#parametrosIdParametros" + datos[i].id).prop('checked', true);
                                } else {
                                    $("#parametrosIdParametros" + datos[i].id).prop('checked', false);
                                }
                            } else if ($("input[name=parametrosIdParametros" + datos[i].id + "]").attr('type') == 'radio') {
                                $.each($("input[name=parametrosIdParametros" + datos[i].id + "]"), function (j) {
                                    if ($(this).val() == datos[i].valor) {
                                        $(this).prop('checked', true);
                                    } else {
                                        $(this).prop('checked', false);
                                    }
                                });

                            }
                            else {
                                $("#parametrosIdParametros" + datos[i].id).text(datos[i].valor);
                            }
                        });
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de consultar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    else {
                        sweetAlert("Error", 'Error al tratar de consultar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                    }
                    $("#msgParametrosCargandoListadoParametrosInstitucion").addClass('hide');
                });
            },
            /**
             * Función que muestra la vista previa del ticket.
             * @returns {void}
             */
            generarVistaPrevia = function () {
                if (ValidarCamposVacios("#parametrosTabModuloInformacionTurno")) {
                    var referencia;
                    var valor;
                    var dato;
                    mostrarHoraFecha();
                    $("#parametrosTabModuloInformacionTurno .parametrosClsInput").each(function (i) {
                        referencia = $("#" + $(this).attr('data-ref'));
                        valor = $(this).attr('data-valor');
                        dato = $(this).val() + 'mm';
                        if ($(this).attr('data-tipo') == 'css') {
                            $(referencia).css(valor, dato);
                        } else if ($(this).attr('data-tipo') == 'boolean') {
                            if (!$(this).prop('checked')) {
                                $(referencia).siblings().css('display', '');
                                $(referencia).css('display', 'none');
                            } else {
                                $(referencia).siblings().css('display', 'none');
                                $(referencia).css('display', '');
                            }
                        }
                    });
                    $("#parametrosBtnGuardarParametrosTurnos").addClass('hide');
                    $("#parametrosBtnGuardarCerrarVistaPrevia").removeClass('hide');
                    $("#parametrosDivContenidoParametrosTurnos").fadeOut(function () {
                        $("#parametrosDivContenidoVistaPrevia").fadeIn('slow');
                    });
                }
                $("#parametrosBtnGuardarCerrarVistaPrevia").off('click');
                $("#parametrosBtnGuardarCerrarVistaPrevia").click(function () {
                    $("#parametrosBtnGuardarCerrarVistaPrevia").addClass('hide');
                    $("#parametrosBtnGuardarParametrosTurnos").removeClass('hide');
                    $("#parametrosDivContenidoVistaPrevia").fadeOut(function () {
                        $("#parametrosDivContenidoParametrosTurnos").fadeIn('slow');
                    });
                });
            },
            /**
             * Función que valida el ingreso solo de números.
             * @param {string} id
             * @returns {Boolean}
             */
            ValidarSoloNumerosEnteros = function (id) {
                $(id).keypress(function (event) {
                    tecla = event.which;
                    if ((tecla < 48 || tecla > 57) && tecla !== 8 && tecla !== 0)
                    {
                        event.preventDefault();
                    }
                });
                return true;
            },
            /**
             * Función que permite modificar la información de impresión de tickets.
             * @param {String} tipo
             * @returns {void}
             */

            EditarParametrosTurnos = function (tipo) {
                if (ValidarCamposVacios(tipo)) {
                    swal({
                        title: '¿Está seguro de modificar la información de Ticket?',
                        text: 'La información será modificada!',
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
                            $("#msgParametrosVerificandoNuevoParametros").removeClass('hide');
                            var id = new Array(1), valor = new Array(1);
                            $(tipo + " .parametrosClsInput").each(function (i) {
                                id [i] = $(this).attr('data-par');
                                valor[i] = $(this).val();
                            });
                            $(tipo + " .parametrosClsInput").each(function (i) {
                                if ($(this).attr('type') == 'text') {
                                    id [i] = $(this).attr('data-par');
                                    valor[i] = $(this).val();
                                } else if ($(this).attr('type') == 'checkbox') {
                                    valor[i] = $(this).prop('checked');
                                }
                            });
                            $.ajax({
                                url: "parametros/controlador/php/controlador.php",
                                type: 'post',
                                datatype: 'json',
                                data: {
                                    accion: 'editarparametros',
                                    id: id,
                                    valor: valor
                                }
                            }).done(function (respuesta) {
                                var datos = JSON.parse(respuesta);
                                if (datos[0].reg === 1) {
                                    send('{"tipo": "EDITARPARAMETROS", "id": ""}');
                                    swal({
                                        title: "Guardado",
                                        text: "La información de configuración ha sido guardada correctamente",
                                        type: "success"
                                    });
                                } else if (datos[0].reg === -3) {
                                    sweetAlert("Error", 'Error de envío de parámetros al tratar de guardar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                                }
                                else {
                                    sweetAlert("Error", 'Error al tratar de guardar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                                }
                            });
                        } else {
                            sweetAlert("Cancelado", 'La información no ha sido modificada', "warning");
                        }
                        $("#msgParametrosVerificandoNuevoParametros").addClass('hide');
                    });
                }

            },
            /**
             * Función que permite modificar la información de sistema.
             * @param {String} tipo
             * @returns {void}
             */

            EditarParametrosSistema = function (tipo) {
                if (ValidarCamposVacios(tipo)) {
                    swal({
                        title: '¿Está seguro de modificar la información de Sistema?',
                        text: 'La información será modificada!',
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
                            $("#msgParametrosVerificandoNuevoParametrosSistema").removeClass('hide');
                            var id = new Array(1), valor = new Array(1);

                            $(tipo + " .parametrosClsInput").each(function (i) {
                                if ($(this).attr('type') == 'text') {
                                    id [i] = $(this).attr('data-par');
                                    valor[i] = $(this).val();
                                } else if ($(this).attr('type') == 'radio' && $(this).prop('checked')) {
                                    id [i] = $(this).attr('data-par');
                                    valor[i] = $(this).val();
                                }
                            });
                            $.ajax({
                                url: "parametros/controlador/php/controlador.php",
                                type: 'post',
                                datatype: 'json',
                                data: {
                                    accion: 'editarparametros',
                                    id: id,
                                    valor: valor
                                }
                            }).done(function (respuesta) {
                                var datos = JSON.parse(respuesta);
                                if (datos[0].reg === 1) {
                                    send('{"tipo": "EDITARPARAMETROS", "id": ""}');
                                    swal({
                                        title: "Guardado",
                                        text: "La información de configuración ha sido guardada correctamente",
                                        type: "success"
                                    });
                                } else if (datos[0].reg === -3) {
                                    sweetAlert("Error", 'Error de envío de parámetros al tratar de guardar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                                }
                                else {
                                    sweetAlert("Error", 'Error al tratar de guardar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                                }
                            });
                        } else {
                            sweetAlert("Cancelado", 'La información no ha sido modificada', "warning");
                        }
                        $("#msgParametrosVerificandoNuevoParametrosSistema").addClass('hide');
                    });
                }

            },
            /**
             * Función que permite modificar la información de la institución.
             * @param {String} tipo
             * @returns {void}
             */
            EditarParametros = function (tipo) {
                if (ValidarCamposVacios(tipo)) {
                    swal({
                        title: '¿Está seguro de modificar la información de la institución?',
                        text: 'La información será modificada!',
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
                            $("#msgParametrosVerificandoNuevoParametros").removeClass('hide');
                            var id = new Array(1), valor = new Array(1);
                            $(tipo + " .parametrosClsInput").each(function (i) {
                                id [i] = $(this).attr('data-par');
                                valor[i] = $(this).val();
                            });
                            $.ajax({
                                url: "parametros/controlador/php/controlador.php",
                                type: 'post',
                                datatype: 'json',
                                data: {
                                    accion: 'editarparametros',
                                    id: id,
                                    valor: valor
                                }
                            }).done(function (respuesta) {
                                var datos = JSON.parse(respuesta);
                                if (datos[0].reg === 1) {
                                    send('{"tipo": "EDITARPARAMETROS", "id": ""}');
                                    swal({
                                        title: "Guardado",
                                        text: "La información de configuración ha sido guardada correctamente",
                                        type: "success"
                                    });
                                } else if (datos[0].reg === -3) {
                                    sweetAlert("Error", 'Error de envío de parámetros al tratar de guardar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                                }
                                else {
                                    sweetAlert("Error", 'Error al tratar de guardar información de configuración, por favor comuniquese con el proveedor del servicio', "error");
                                }
                            });
                        } else {
                            sweetAlert("Cancelado", 'La información no ha sido modificada', "warning");
                        }
                        $("#msgParametrosVerificandoNuevoParametros").addClass('hide');
                    });
                }

            },
            /**
             * Función que muestra el reloj en pantalla.
             * @returns {void}
             */
            mostrarHoraFecha = function ()
            {
                var horaactural = ("#ParametrosTurnosVistaPreviaHora");
                var fechaactural = ("#parametrosTurnosVistaPreviaFecha");
                var now = new Date();
                var date = now.getDate();
                var year = now.getFullYear();
                var month = now.getMonth() + 1;
                var hour = now.getHours();
                var minute = now.getMinutes();
                var second = now.getSeconds();
                hour = (hour < 10) ? "0" + hour : hour;
                minute = (minute < 10) ? "0" + minute : minute;
                second = (second < 10) ? "0" + second : second;
                month = (month < 10) ? "0" + month : month;
                date = (date < 10) ? "0" + date : date;
                $(fechaactural).html(date + '/' + (month) + '/' + year + ' &nbsp;');
                $(horaactural).html(hour + ':' + minute + ':' + second);
            },
            /**
             * Función que valida el email.
             * @param {string} email
             * @returns {Boolean}
             */
            ValidarEmail = function (email)
            {
                var em = $(email).val().trim();
                var resultado;
                resultado = true;
                expr = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
                if (!expr.test(em)) {
                    resultado = false;
                }
                return resultado;
            },
            /**
             * Función que valida los campos.
             * @param {String} tipo
             * @returns {Boolean}
             */
            ValidarCamposVacios = function (tipo) {
                var resultado = true;
                $(tipo + ' .form-group .parametrosClsCampoValidadoNuevo,.form-group .parametrosClsCampoValidadoFormatoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevoParametro').addClass('hide');
                    $(this).parent().siblings('.ParametrosClsMsgErrorEmailInvalidoNuevoParametro').addClass('hide');
                });
                $(tipo + ' .form-group .parametrosClsCampoValidadoNuevo,.form-group .parametrosClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevoParametro').addClass('hide');
                    $(this).parent().siblings('.ParametrosClsMsgErrorEmailInvalidoNuevoParametro').addClass('hide');
                });
                $(tipo + ' .form-group .parametrosClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevoParametro').removeClass('hide');
                    }
                    else {
                        $(this).parent().siblings('.msgErrorNuevoParametro').addClass('hide');
                    }
                });
                if (tipo === '#parametrosTabModuloInformacionInstitucion') {
                    $('#parametrosIdParametrosPAR_EMAINS').val($('#parametrosIdParametrosPAR_EMAINS').val().trim());
                    if ($('#parametrosIdParametrosPAR_EMAINS').val() !== "" && ValidarEmail('#parametrosIdParametrosPAR_EMAINS') === false) {
                        $("#msgErrorEmailInvalidoNuevoParametro").removeClass('hide');
                        resultado = false;
                    }
                }
                return resultado;
            },
            /**
             * Función que permite subir el video.
             * @param {file} video
             * @returns {void}
             */
            subirVideo = function (video) {
                var file = document.getElementById(video).files[0];
                var formdata = new FormData();
                formdata.append(video, file);
                $.ajax({
                    url: "parametros/controlador/php/controlador_video.php",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        var f = new Date();
                        if (datos[0].reg == 1) {
                            send('{"tipo": "CAMBIARVIDEO"}');
                            listarVideos(1);
                            $("#parametrosImgVideoParametro").attr("src", "includes/video/" + datos[0].nombre);
                            swal({
                                title: "Guardado",
                                text: "Video guardado correctamente",
                                type: "success"
                            });
                        }
                        else if (datos[0].reg === 2) {
                            swal({
                                title: "Error",
                                text: "Ya existe un video con el mismo nombre",
                                type: "error"
                            });
                        } else if (datos[0].reg === -3) {
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de guardar video, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else if (datos[0].reg === -4) {
                            sweetAlert("Error", 'Error de formato de video, por favor seleccione un video de formato .mp4', "error");
                        }
                        else if (datos[0].reg === -5) {
                            sweetAlert("Error", 'Error de tamaño de video, por favor seleccione un video de maximo 40MB de peso', "error");
                        }
                        else {
                            sweetAlert("Error", 'Error al tratar de guardar video, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    }
                });
            },
            /**
             * Función que permite subir el timbre.
             * @param {file} timbre
             * @returns {void}
             */
            subirTimbre = function (timbre) {
                var file = document.getElementById(timbre).files[0];
                var formdata = new FormData();
                formdata.append(timbre, file);
                $.ajax({
                    url: "parametros/controlador/php/controlador_audio.php",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        var f = new Date();
                        if (datos[0].reg == 1) {
                            $("#parametrosAudTimbreParametro").attr("src", "includes/sounds/timbre.mp3?n=" + f);
                            swal({
                                title: "Guardado",
                                text: "Timbre guardado correctamente",
                                type: "success"
                            });
                        } else if (datos[0].reg === -3) {
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de guardar timbre, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else if (datos[0].reg === -4) {
                            sweetAlert("Error", 'Error de formato de audio, por favor seleccione un audio de formato .mp3', "error");
                        }
                        else if (datos[0].reg === -5) {
                            sweetAlert("Error", 'Error de tamaño de audio, por favor seleccione un audio de maximo 1MB de peso', "error");
                        }
                        else {
                            sweetAlert("Error", 'Error al tratar de guardar timbre, por favor comuniquese con el proveedor del servicio', "error");
                        }

                    }
                });
            },
            /**
             * Función que permite guardar el logo.
             * @param {file} logo
             * @returns {void}
             */
            subirLogo = function (logo) {
                var file = document.getElementById(logo).files[0];
                var formdata = new FormData();
                formdata.append(logo, file);
                $.ajax({
                    url: "parametros/controlador/php/controlador_imagen.php",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        var f = new Date();
                        if (datos[0].reg == 1) {
                            send('{"tipo": "CAMBIARLOGO"}');
                            $("#parametrosImgFotoParametro").attr("src", "includes/img/logoinstitucion.png?n=" + f);
                            swal({
                                title: "Guardado",
                                text: "Logo guardado correctamente",
                                type: "success"
                            });
                        } else if (datos[0].reg === -3) {
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de guardar logo, por favor comuniquese con el proveedor del servicio', "error");
                        }
                        else if (datos[0].reg === -4) {
                            sweetAlert("Error", 'Error de formato de imagen, por favor seleccione una imagen de formato .png', "error");
                        }
                        else if (datos[0].reg === -5) {
                            sweetAlert("Error", 'Error de tamaño de imagen, por favor seleccione una imagen de maximo 2MB de peso', "error");
                        }
                        else {
                            sweetAlert("Error", 'Error al tratar de guardar logo, por favor comuniquese con el proveedor del servicio', "error");
                        }

                    }
                });
            },
            /**
             * Función que permite validar formato de archivos.
             * @param {string} extension
             * @param {evento} evento
             * @returns {Boolean}
             */
            validarExtension = function (extension, evento) {
                var resultado = true;
                var formato = evento.target.files[0];
                if (extension != formato.type) {
                    evento.preventDefault()
                    resultado = false;
                }
                return resultado;
            },
            /**
             * Función que permite validar tamaño de archivos.
             * @param {string} tamanho
             *  @param {evento} evento
             * @returns {Boolean}
             */
            validartamanho = function (tamanho, evento) {
                var resultado = true;
                var formato = evento.target.files[0];
                if (tamanho < formato.size) {
                    evento.preventDefault();
                    resultado = false;
                }
                return resultado;
            },
            /**
             * Función que inicializa el módulo de configuración.
             * @returns {void}
             */
            iniciar = function () {
                iniciarSocket();
                cargarImagenNuevo();
                cargarTimbreNuevo();
                cargarVideoNuevo();
                consultarParametros();
                ValidarSoloNumerosEnteros(".parametrosClsEntero");
                var f = new Date();
                $("#parametrosAudTimbreParametro").attr("src", "includes/sounds/timbre.mp3?n=" + f);
                $("#parametrosImgFotoParametro").attr("src", "includes/img/logoinstitucion.png?n=" + f);
                listarVideos(1);
                buscarVideos();
                $.AdminLTE.boxWidget.activate();
                $("#parametrosBtnGuardarParametros").off('click');
                $("#parametrosBtnGuardarParametros").click(function () {
                    EditarParametros("#parametrosTabModuloInformacionInstitucion");
                });
                $("#parametrosBtnGuardarParametrosTurnos").off('click');
                $("#parametrosBtnGuardarParametrosTurnos").click(function () {
                    EditarParametrosTurnos("#parametrosTabModuloInformacionTurno");
                });
                $("#parametrosBtnGuardarParametrosSistema").off('click');
                $("#parametrosBtnGuardarParametrosSistema").click(function () {
                    EditarParametrosSistema("#parametrosDivContenidoParametrosSistema");
                });
                $("#parametrosBtnVistaPreviaTicket").off('click');
                $("#parametrosBtnVistaPreviaTicket").click(function () {
                    generarVistaPrevia();
                });
            }
    ;
    return {
        iniciar: iniciar
    };
})();
$(document).ready(function () {
    Parametros.iniciar();
});
