var Usuarios = (function () {
    var
            _foto,
            /**
             * Función que permite enviar la foto del usuario
             * @returns {bytea}
             */
            getFoto = function () {
                return _foto;
            },
            /**
             * Función que permite obtener la foto del usuario
             * @param {bytea} foto
             * @returns {void}
             */
            setFoto = function (foto) {
                _foto = foto;
            },
            /**
             * Función que permite listar a los usuarios.
             * @param {type} pag
             * @returns {void}
             */
            listar = function (pag)
            {
                $("#msgUsuariosVerificandoListaUsuarios").removeClass('hide');
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'listarusuarios',
                        busqueda: $('#usuariosTxtFiltroBusqueda').val(),
                        pagina: pag
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#usuariosUlPaginacionUsuarios').empty();
                    $('#usuariosTbdListaUsuarios').empty();
                    if (datos[0].reg === -1) {
                        $('#usuariosUlPaginacionUsuarios').append($('<li>').text('No se encontraron resultados'));
                    } else if (datos[0].reg === 1) {

                        if (datos[0].pag > 1) {
                            var pagac = 0;
                            var inicio;
                            var fin;
                            if (datos[0].pagac > 1) {
                                $('#usuariosUlPaginacionUsuarios').append($('<li>').append($('<a href="#">').text('Anterior')
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
                            } else {
                                inicio = 1;
                                fin = 5;
                            }
                            while (pagac < datos[0].pag) {
                                pagac = pagac + 1;
                                if (pagac >= inicio && pagac <= fin) {
                                    $('#usuariosUlPaginacionUsuarios').append($('<li>').append($('<a href="#">').text(pagac)
                                            .on('click', function () {
                                                listar($(this).text());
                                            })));
                                }
                            }
                            if (datos[0].pagac < datos[0].pag) {
                                $('#usuariosUlPaginacionUsuarios').append($('<li>').append($('<a href="#">').text('Siguiente')
                                        .on('click', function () {
                                            listar(parseInt(datos[0].pagac) + 1);
                                        })));
                            }
                            if (pag === "") {
                                $('#usuariosUlPaginacionUsuarios li:first').addClass('active');
                            }
                            $('#usuariosUlPaginacionUsuarios li').each(function () {
                                if ($(this).text() === datos[0].pagac) {
                                    $(this).addClass('active');
                                }
                            });
                        } else {
                            $('#usuariosUlPaginacionUsuarios').empty();
                        }
                        $.each(datos, function (i) {
                            $('#usuariosTbdListaUsuarios').append($('<tr>')
                                    .append($('<td>').text((((parseInt(datos[0].pagac) * 5) - 4) + i + (parseInt(datos[0].pagac) - 1))).addClass('text-center hidden-xs'))
                                    .append($('<td>').text(datos[i].apellidos + ' ' + datos[i].nombres))
                                    .append($('<td>').text(datos[i].cedula).addClass('hidden-xs'))
                                    .append($('<td>').text(datos[i].email).addClass('hidden-xs'))
                                    .append($('<td>')
                                            .addClass('btn-toolbar')
                                            .append($('<button>')
                                                    .on('click', function () {
                                                        EditarUsuario(datos[i].id, datos[i].nombres, datos[i].apellidos, datos[i].cedula, datos[i].email, datos[i].pagac, datos[i].modulo);
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
                                                    .addClass(datos[i].estado === true ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                                    .append($('<span>').addClass(datos[i].estado === true ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                                    .attr('title', datos[i].estado === true ? "Activo" : "Inactivo")
                                                    )
                                            )
                                    );
                        });
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de listar usuarios, por favor contactese con el proveedor del servicio', "error");
                    } else {
                        sweetAlert("Error", "Error al intentar buscar usuarios, por favor contactese con el proveedor del servicio", "error");
                    }
                    $("#msgUsuariosVerificandoListaUsuarios").addClass('hide');
                });
            },
            /**
             * Función que permite modificar el estado del usuario.
             * @param {integer} vidusuario
             * @param {selector} vboton
             * @returns {void}
             */
            cambiarestado = function (vidusuario, vboton) {
                swal({
                    title: '¿Está seguro de modificar el estado del usuario?',
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
                                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                                    type: 'post',
                                    datatype: 'json',
                                    data: {
                                        accion: 'cambiarestadousuario',
                                        id: vidusuario
                                    }
                                }).done(function (respuesta) {
                                    var datos = JSON.parse(respuesta);
                                    if (datos[0].reg === 0 || datos[0].reg === 1) {
                                        $(vboton).removeClass(datos[0].reg === 1 ? "btn btn-danger col-xs-12" : "btn btn-success col-xs-12")
                                                .text("")
                                                .addClass(datos[0].reg === 1 ? "btn btn-success col-xs-12" : "btn btn-danger col-xs-12")
                                                .append($('<span>').addClass(datos[0].reg === 1 ? "glyphicon glyphicon-ok" : "glyphicon glyphicon-ban-circle"))
                                                .attr('title', datos[0].estado === 1 ? "Activo" : "Inactivo");
                                        datos[0].reg === 1 ? sweetAlert("Modificado", 'El usuario ha sido activado', "success") :
                                                sweetAlert("Modificado", 'El usuario ha sido desactivado', "success");
                                    } else if (datos[0].reg === -3) {
                                        sweetAlert("Error", 'Error de envío de parámetros al tratar de cambiar el estado del usuario, por favor comuniquese con el proveedor del servicio', "error");
                                    } else if (datos[0].reg === 10) {
                                        sweetAlert("Error", 'El usuario administrador no debe ser desactivado', "error");

                                    } else {
                                        sweetAlert("Error", 'Error al cambiar el estado del usuario, por favor comuniquese con el proveedor del servicio', "error");
                                    }
                                });
                            } else {
                                sweetAlert("Cancelado", 'El estado del usuario no ha sido modificado', "warning");
                            }
                        });
            },
            /**
             * Función que permite crear un nuevo usuario.
             * @returns {void}
             */
            nuevo = function () {
                $("#usuariosBtnNuevoUsuario").off('click');
                $("#usuariosBtnNuevoUsuario").click(function (e) {
                    IngresarCancelarGuardarNuevoUsuario('INGRESAR');
                    e.preventDefault();
                });
                $("#usuariosBtnCancelarNuevoUsuario").off('click');
                $("#usuariosBtnCancelarNuevoUsuario").click(function () {
                    IngresarCancelarGuardarNuevoUsuario('CANCELAR');
                });
                $("#usuariosBtnGuardarNuevoUsuario").click(function () {
                    IngresarCancelarGuardarNuevoUsuario('GUARDAR');
                });
            },
            /**
             * Función que ingresa formulario al crear nuevo usuario.
             * @param {integer} usuario
             * @returns {void}
             */
            IngresarCancelarGuardarNuevoUsuario = function (usuario) {
                switch (usuario) {
                    case 'INGRESAR':
                        limpiarCampos('NUEVO');
                        cargarPerfilesNuevo();
                        cargarModulosNuevo();
                        cargarImagenNuevo();
                        tomarFotoNuevo();
                        $('#usuariosSelModulosNuevoUsuario').select2();
                        $('#usuariosSelModulosNuevoUsuario').select2({
                            width: '100%',
                            height: '100%'
                        });
                        $("#usuariosBtnNuevoUsuario").attr('disabled', 'disabled');
                        $("#usuariossecListaUsuarios").fadeOut(function () {
                            $("#usuariosSecNuevoUsuario").fadeIn('slow', function () {
                                $("#usuariosTxtNombresNuevoUsuario").focus();
                            });
                        });
                        break;
                    case 'CANCELAR':
                        $("#usuariosBtnNuevoUsuario").removeAttr('disabled');
                        listar(1);
                        $("#usuariosSecNuevoUsuario").fadeOut(function () {
                            $("#usuariossecListaUsuarios").fadeIn('slow', function () {
                            });
                            limpiarCampos('NUEVO');
                        });
                        break;
                    case 'GUARDAR':
                        guardarnuevo();
                        break;
                    default:
                        break;
                }
            },
            /**
             * Función que permite cargar una imagen para un nuevo usuario.
             * @returns {void}
             */
            cargarImagenNuevo = function () {
                $("#usuariosBtnSubirFotoNuevoUsuario").click(
                        function () {
                            $("#usuariosFilFotoSubirUsuario").trigger('click');
                        });
                enviarImagen("#usuariosImgFotoUsuario", "#usuariosFilFotoSubirUsuario");
            },
            /**
             * Función que valida el email de usuario.
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
             * Función que valida los campos al crear un nuevo usuario.
             * @returns {Boolean}
             */
            ValidarCamposVaciosNuevo = function () {
                var resultado = true;
                var contadorperfiles = 0;
                $('option', $('#usuariosSelPerfilesNuevoUsuario')).each(function (element) {
                    if ($(this).prop('selected') === true) {
                        contadorperfiles = contadorperfiles + 1;
                    }
                });
                if (contadorperfiles === 0) {
                    $(".msgErrorNuevoUsuarioPerfil").removeClass('hide');
                    resultado = false;
                }
                $(".multiselect.dropdown-toggle.btn.btn-default").click(function () {
                    $('.msgErrorNuevoUsuarioPerfil').addClass('hide');
                });
                $('.form-group .usuariosClsCampoValidadoNuevo,.form-group .usuariosClsCampoValidadoFormatoNuevo').click(function () {
                    $(this).parent().siblings('.msgErrorNuevoUsuario').addClass('hide');
                    $(this).parent().siblings('.UsuariosClsMsgErrorEmailInvalidoNuevoUsuario').addClass('hide');
                });
                $('.form-group .usuariosClsCampoValidadoNuevo,.form-group .usuariosClsCampoValidadoFormatoNuevo').focusin(function () {
                    $(this).parent().siblings('.msgErrorNuevoUsuario').addClass('hide');
                    $(this).parent().siblings('.UsuariosClsMsgErrorEmailInvalidoNuevoUsuario').addClass('hide');
                });
                $('.form-group .usuariosClsCampoValidadoNuevo').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorNuevoUsuario').removeClass('hide');
                    } else {
                        $(this).parent().siblings('.msgErrorNuevoUsuario').addClass('hide');
                    }
                });
                $('#usuariosTxtEmailNuevoUsuario').val($('#usuariosTxtEmailNuevoUsuario').val().trim());
                if ($('#usuariosTxtEmailNuevoUsuario').val() !== "" && ValidarEmail('#usuariosTxtEmailNuevoUsuario') === false) {
                    $("#msgErrorEmailInvalidoNuevoUsuario").removeClass('hide');
                    resultado = false;
                }
                return resultado;
            },
            /**
             * Función que permite enviar la imagen de una etiqueta input file a una etiqueta img.
             * @param {bytea} ima
             * @param {file} file
             * @returns {void}
             */
            enviarImagen = function (ima, file) {
                $(file).change(function (e) {
                    var file = e.target.files[0];
                    canvasResize(file, {
                        width: 80,
                        height: 80,
                        crop: false,
                        quality: 80,
                        callback: function (data, width, height) {
                            setFoto(data);
                            $(ima).attr('src', data);
                        }
                    });
                });
            },
            /**
             * Función que guarda un nuevo usuario.
             * @returns {void}
             */
            guardarnuevo = function () {
                if (ValidarCamposVaciosNuevo())
                {
                    $("#msgUsuariosVerificandoNuevoUsuarios").removeClass('hide');
                    var perfiles = new Array(1);
                    var contador = 0;
                    $('option', $('#usuariosSelPerfilesNuevoUsuario')).each(function (element) {
                        if ($(this).prop('selected') === true) {
                            $(this).attr('selected', true);
                            perfiles[contador] = parseInt($(this).val());
                            contador = contador + 1;
                        }
                    });
                    var cedula = $('#usuariosTxtCedulaNuevoUsuario').val();
                    $.ajax({
                        url: url_relativa + 'seguridades/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'nuevousuario',
                            nombre: $('#usuariosTxtNombresNuevoUsuario').val(),
                            apellido: $('#usuariosTxtApellidosNuevoUsuario').val(),
                            email: $('#usuariosTxtEmailNuevoUsuario').val(),
                            cedula: cedula,
                            clave: CryptoJS.SHA256($('#usuariosTxtCedulaNuevoUsuario').val().trim()).toString(),
                            foto: getFoto(),
                            perfiles: perfiles,
                            modulo: $("#usuariosSelModulosNuevoUsuario").val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            $("#msgUsuariosVerificandoNuevoUsuarios").addClass('hide');
                            sweetAlert("Error", 'El usuario ya existe', "error");
                        } else if (datos[0].reg === 2) {
                            $("#msgUsuariosVerificandoNuevoUsuarios").addClass('hide');
                            listar(1);
                            $("#usuariosBtnNuevoUsuario").removeAttr('disabled');
                            $("#usuariosSecNuevoUsuario").fadeOut(function () {
                                $("#usuariossecListaUsuarios").fadeIn();
                            });
                            swal({
                                title: "Guardado",
                                text: "Usuario ingresado exitosamente",
                                type: "success",
                                allowOutsideClick: false
                            });
                            send('{"tipo": "CREARUSUARIO", "id":' + 0+ '}');
                        } else if (datos[0].reg === -3) {
                            $("#msgUsuariosVerificandoNuevoUsuarios").addClass('hide');
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de crear usuario, por favor comuniquese con el proveedor del servicio', "error");
                        } else {
                            $("#msgUsuariosVerificandoNuevoUsuarios").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de crear usuario, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que carga los perfiles de un usuario para edición.
             * @param {integer} idusuario
             * @returns {void}
             */
            cargarPerfilesEditar = function (idusuario) {
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarperfileseditarusuario',
                        usuario: idusuario
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#usuariosSelPerfilesEditarUsuario').multiselect('destroy');
                    $('#usuariosSelPerfilesEditarUsuario').empty();
                    if (datos[0].reg === 1) {
                        $.each(datos, function (i) {
                            $('#usuariosSelPerfilesEditarUsuario').append(
                                    $("<option>").val(datos[i].id).text((datos[i].nombre).toUpperCase())
                                    );
                        });
                        $('#usuariosSelPerfilesEditarUsuario').multiselect();
                        estilosMultiselect();
                        $('option', $('#usuariosSelPerfilesEditarUsuario')).each(function () {
                            $(this).attr('selected', false);
                        });
                        $('#usuariosSelPerfilesEditarUsuario').multiselect('refresh');
                        $('option', $('#usuariosSelPerfilesEditarUsuario')).each(function (i) {
                            if (datos[i].estado === 1) {
                                $(this).attr('selected', true);
                            }
                            if (datos[i].estado === 1 && $(this).prop('selected') === false) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('#usuariosSelPerfilesEditarUsuario').multiselect('refresh');
                    } else if (datos[0].reg === -1) {
                        $('#usuariosSelPerfilesEditarUsuario').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'No se han cargado perfiles por lo tanto no podrá editar usuarios', "error");
                    } else if (datos[0].reg === -3) {
                        $('#usuariosSelPerfilesEditarUsuario').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error de envio de parámetros,  por favor comuniquese con el proveedor del servicio', "error");
                    } else {
                        $('#usuariosSelPerfilesEditarUsuario').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error al tratar de cargar perfiles,  por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que inicializa la busqueda de usuarios al escribir el el filtro correspondiente.
             * @returns {void}
             */
            buscar = function () {
                $('#usuariosTxtFiltroBusqueda').keypress(function (event) {
                    tecla = event.which;
                    if (tecla === 13)
                    {
                        event.preventDefault();
                    }
                });
                $('#usuariosTxtFiltroBusqueda').keyup(function () {
                    listar(1);
                });
            },
            /**
             * Función que limpia los campos del formulario al crear un nuevo usuario.
             * @param {integer} usuario
             * @returns {void}
             */
            limpiarCampos = function (usuario) {
                switch (usuario) {
                    case 'NUEVO':
                        $("#usuariosSecNuevoUsuario input").each(
                                function () {
                                    $(this).val("");
                                });
                        setFoto("");
                        $("#usuariosImgFotoUsuario").attr('src', url_relativa + 'includes/img/imagenUsuarioDefecto.png');
                        $(".msgErrorNuevoUsuario,.UsuariosClsMsgErrorEmailInvalidoNuevoUsuario,.msgErrorNuevoUsuarioPerfil").each(function () {
                            $(this).addClass('hide');
                        });
                        break;
                    case 'EDITAR':
                        $("#usuariosSecEditarUsuario input").each(
                                function () {
                                    $(this).val("");
                                });
                        setFoto("");
                        $("#usuariosImgFotoEditarUsuario").attr('src', url_relativa + 'includes/img/imagenUsuarioDefecto.png');
                        $(".msgErrorEditarUsuario,.UsuariosClsMsgErrorEmailInvalidoEditarUsuario,.msgErrorEditarUsuarioPerfil").each(function () {
                            $(this).addClass('hide');
                        });
                        break;
                    default:
                        break;
                }
            },
            /**
             * Función que permite editar un usuario.
             * @param {integer} id
             * @param {string} nombres
             * @param {string} apellidos
             * @param {string} cedula
             * @param {string} email
             * @param {integer} pagac
             * @returns {void}
             */
            EditarUsuario = function (id, nombres, apellidos, cedula, email, pagac, modulo) {
                if (cedula === "9999999999") {
                    $("#usuariosSelPerfilesEditarUsuario").attr('disabled', 'disabled');
                    $("#usuariosTxtNombresEditarUsuario").attr('disabled', 'disabled');
                    $("#usuariosTxtApellidosEditarUsuario").attr('disabled', 'disabled');
                    $("#usuariosTxtEmailEditarUsuario").attr('disabled', 'disabled');
                    $("#usuariosBtnSubirFotoEditarUsuario").attr('disabled', 'disabled');
                    $("#usuariosBtnAbrirTomarFotoEditarUsuario").attr('disabled', 'disabled');
                } else {
                    $("#usuariosSelPerfilesEditarUsuario").removeAttr('disabled', 'disabled');
                    $("#usuariosTxtNombresEditarUsuario").removeAttr('disabled');
                    $("#usuariosTxtApellidosEditarUsuario").removeAttr('disabled');
                    $("#usuariosTxtEmailEditarUsuario").removeAttr('disabled');
                    $("#usuariosBtnSubirFotoEditarUsuario").removeAttr('disabled');
                    $("#usuariosBtnAbrirTomarFotoEditarUsuario").removeAttr('disabled');
                }
                limpiarCampos('EDITAR');
                cargarPerfilesEditar(id);
                cargarModulosEditar(modulo);
                cargarImagenEditar();
                cargarFotoEditar(id);
                tomarFotoEditar();
                $("#usuariosBtnCancelarEditarUsuario").off('click');
                $("#usuariosBtnCancelarEditarUsuario").click(function () {
                    listar(pagac);
                    $("#usuariosSecEditarUsuario").fadeOut(function () {
                        $("#usuariossecListaUsuarios").fadeIn('slow');
                        $("#usuariosBtnNuevoUsuario").removeAttr('disabled');
                        limpiarCampos('EDITAR');
                    });
                });
                $("#usuariosTxtNombresEditarUsuario").val(nombres);
                $("#usuariosTxtApellidosEditarUsuario").val(apellidos);
                $("#usuariosTxtCedulaEditarUsuario").val(cedula);
                $("#usuariosTxtEmailEditarUsuario").val(email);
                $("#usuariosBtnNuevoUsuario").attr('disabled', 'disabled');
                $("#usuariossecListaUsuarios").fadeOut(function () {
                    $("#usuariosSecEditarUsuario").fadeIn('slow', function () {
                        if (cedula === "9999999999") {
                            $("#usuariosTxtClaveEditarUsuario").focus();
                        } else {
                            $("#usuariosTxtNombresEditarUsuario").focus();
                        }
                        $("#usuariosBtnGuardarEditarUsuario").off('click');
                        $("#usuariosBtnGuardarEditarUsuario").click(function () {
                            guardarEditar(id, cedula, pagac);
                        });
                    });
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
             * Función que carga los perfiles para nuevo usuario.
             * @returns {void}
             */
            cargarPerfilesNuevo = function () {
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarperfilesnuevousuario'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#usuariosSelPerfilesNuevoUsuario').multiselect('destroy');
                    $('#usuariosSelPerfilesNuevoUsuario').empty();
                    if (datos[0].reg === 1) {
                        for (var i in datos) {
                            $('#usuariosSelPerfilesNuevoUsuario').append($("<option>").val(datos[i].id).text((datos[i].nombre).toUpperCase()));
                        }
                        $('#usuariosSelPerfilesNuevoUsuario').multiselect();
                        estilosMultiselect();
                        $('option', $('#usuariosSelPerfilesNuevoUsuario')).each(function (element) {
                            $(this).removeAttr('selected').prop('selected', false);
                        });
                        $('#usuariosSelPerfilesNuevoUsuario').multiselect('refresh');
                    } else if (datos[0].reg === -1) {
                        $('#usuariosSelPerfilesNuevoUsuario').multiselect();
                        estilosMultiselect();
                        sweetAlert("Precaución", 'No se han cargado perfiles, por lo tanto no podrá crear usuarios', "warning");
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de cargar perfiles para nuevo usuario, por favor comuniquese con el proveedor del servicio', "error");
                    } else {
                        $('#usuariosSelPerfilesNuevoUsuario').multiselect();
                        estilosMultiselect();
                        sweetAlert("Error", 'Error al tratar de cargar perfiles, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que carga los módulos para nuevo usuario.
             * @returns {void}
             */
            cargarModulosNuevo = function () {
                $('#usuariosSelModulosNuevoUsuario').append(
                        $("<option>").val("-1").text('Por Definir')
                        );
                $('#usuariosSelModulosNuevoUsuario').empty();
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarmodulosnuevousuario'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#usuariosSelModulosNuevoUsuario').empty();
                    $('#usuariosSelModulosNuevoUsuario').select2({
                        width: '100%',
                        height: '100%'
                    });
                    $('#usuariosSelModulosNuevoUsuario').append(
                            $("<option>").val("-1").text('Por Definir')
                            );
                    if (datos[0].reg == 1) {
                        $.each(datos, function (i) {
                            $('#usuariosSelModulosNuevoUsuario').append(
                                    $("<option>").val(datos[i].id).text((datos[i].id))
                                    );
                            if (i == 0) {
                                $('#usuariosSelModulosNuevoUsuario').select2({
                                    val: datos[i].id,
                                    width: "100%"
                                });
                            }
                        });
                    } else if (datos[0].reg === -1) {
                        sweetAlert("Precaución", 'No se han cargado módulos, por lo tanto no podrá crear usuarios', "warning");
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de cargar módulos para nuevo usuario, por favor comuniquese con el proveedor del servicio', "error");
                    } else {
                        sweetAlert("Error", 'Error al tratar de cargar módulos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que permite cargar la imagen para la edición del usuario.
             * @param {integer} idusuario
             * @returns {void}
             */
            cargarFotoEditar = function (idusuario) {
                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarfotoeditarusuario',
                        usuario: idusuario
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 1) {
                        $("#usuariosImgFotoEditarUsuario").attr('src', datos[0].foto);
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envío de parámetros al tratar de cargar la foto para editar, por favor comuniquese con el proveedor del servicio', "error");
                    } else {
                        sweetAlert("Error", 'Error al tratar de cargar la foto para editar, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que carga los módulos para editar usuario.
             * @param {Integer} id
             * @returns {void}
             */
            cargarModulosEditar = function (id) {
                $('#usuariosSelModulosEditarUsuario').append(
                        $("<option>").val("-1").text('Por Definir')
                        );
                $('#usuariosSelModulosEditarUsuario').empty();

                $.ajax({
                    url: url_relativa + 'seguridades/controlador/php/controlador.php',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'cargarmodulosnuevousuario',
                        usuario: id
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    $('#usuariosSelModulosEditarUsuario').empty();
                    $('#usuariosSelModulosEditarUsuario').append(
                            $("<option>").val("-1").text('Por Definir')
                            );
                    $('#usuariosSelModulosEditarUsuario').select2({
                        width: '100%',
                        height: '100%'
                    });
                    if (datos[0].reg == 1) {
                        $.each(datos, function (i) {
                            $('#usuariosSelModulosEditarUsuario').append(
                                    $("<option>").val(datos[i].id).text((datos[i].id)));
                        });
                        if (id === null || id === 'null') {
                            id = -1;
                        }
                        $('#usuariosSelModulosEditarUsuario').select2("val", id);

                    } else if (datos[0].reg === -1) {
                        sweetAlert("Precaución", 'No se han cargado módulos, por lo tanto no podrá editar usuarios', "warning");
                    } else if (datos[0].reg === -3) {
                        sweetAlert("Error", 'Error de envio de parámetros al tratar de cargar módulos para editar usuario, por favor comuniquese con el proveedor del servicio', "error");
                    } else {
                        sweetAlert("Error", 'Error al tratar de cargar módulos, por favor comuniquese con el proveedor del servicio', "error");
                    }
                });
            },
            /**
             * Función que permite guardar la información editada del usuario.
             * @param {integer} id
             * @param {string} usuario
             * @param {integer} pagac
             * @returns {void}
             */

            guardarEditar = function (id, usuario, pagac) {
                if (ValidarCamposVaciosEditar()) {
                    $("#msgUsuariosVerificandoEditar Usuarios").removeClass('hide');
                    var perfiles = new Array(1);
                    var contador = 0;
                    $('option', $('#usuariosSelPerfilesEditarUsuario')).each(function (element) {
                        if ($(this).prop('selected') === true) {
                            $(this).attr('selected', true);
                            perfiles[contador] = parseInt($(this).val());
                            contador = contador + 1;
                        }
                    });
                    $.ajax({
                        url: url_relativa + 'seguridades/controlador/php/controlador.php',
                        type: "post",
                        datatype: "json",
                        data: {
                            accion: 'editarusuario',
                            id: id,
                            usuario: usuario,
                            nombre: $('#usuariosTxtNombresEditarUsuario').val(),
                            apellido: $('#usuariosTxtApellidosEditarUsuario').val(),
                            email: $('#usuariosTxtEmailEditarUsuario').val(),
                            cedula: $('#usuariosTxtCedulaEditarUsuario').val(),
                            clave: CryptoJS.SHA256($('#usuariosTxtClaveEditarUsuario').val().trim()).toString(),
                            foto: getFoto(),
                            perfiles: perfiles,
                            modulo: $("#usuariosSelModulosEditarUsuario").val()
                        }
                    }).done(function (respuesta) {
                        var datos = JSON.parse(respuesta);
                        if (datos[0].reg === 1) {
                            send('{"tipo": "EDITARUSUARIO", "id":' + id + '}');
                            $("#msgUsuariosVerificandoEditar").addClass('hide');
                            listar(pagac);
                            $("#usuariosSecEditarUsuario").fadeOut(function () {
                                $("#usuariossecListaUsuarios").fadeIn('slow');
                                $("#usuariosBtnNuevoUsuario").removeAttr('disabled');
                            });
                            swal({
                                title: "Editado",
                                text: "Usuario editado exitosamente",
                                type: "success"
                            });
                        } else if (datos[0].reg === 10) {
                            $("#msgUsuariosVerificandoEditar").addClass('hide');
                            sweetAlert("Error", 'El usuario ya existe', "error");
                        } else if (datos[0].reg === -3) {
                            $("#msgUsuariosVerificandoEditar").addClass('hide');
                            sweetAlert("Error", 'Error de envío de parámetros al tratar de editar usuario, por favor comuniquese con el proveedor del servicio', "error");
                        } else if (datos[0].reg === -2) {
                            $("#msgUsuariosVerificandoEditar").addClass('hide');
                            sweetAlert("Error", 'Error al tratar de editar usuario, por favor comuniquese con el proveedor del servicio', "error");
                        }
                    });
                }
            },
            /**
             * Función que permite tomar una foto para un nuevo usuario.
             * @returns {void}
             */
            tomarFotoNuevo = function () {
                $("#usuariosBtnAbrirTomarFotoNuevoUsuario").click(function () {
                    swal({
                        title: 'FOTO DE USUARIO',
                        html:
                                '<video id="video" width="300" height="300" autoplay></video>' +
                                '<canvas id="canvas" width="300" height="300" style="border: #000 solid 1px;display: none"></canvas>',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Tomar foto',
                        cancelButtonText: 'Cancelar',
                        confirmButtonClass: 'confirm-class',
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    var canvas = $("#canvas")[0];
                                    var contenido2d = canvas.getContext("2d");
                                    var videom = $("#video")[0];
                                    enviarImagenWebCam(contenido2d, canvas, videom);
                                    var audio = new Audio('includes/sounds/camara.mp3');
                                    audio.play();
                                } else {
                                }
                            });
                    var video = $("#video")[0];
                    videoObj = {"video": true},
                            errBack = function (error) {
                                alert("Error en captura de video: ", error.code);
                            };
                    if (navigator.getUserMedia) {
                        navigator.getUserMedia(videoObj, function (stream) {
                            video.src = stream;
                            video.play();
                        }, errBack);
                    } else if (navigator.webkitGetUserMedia) {
                        navigator.webkitGetUserMedia(videoObj, function (stream) {
                            video.src = window.webkitURL.createObjectURL(stream);
                            video.play();
                        }, errBack);
                    } else if (navigator.mozGetUserMedia) {
                        navigator.mozGetUserMedia(videoObj, function (stream) {
                            video.src = window.URL.createObjectURL(stream);
                            video.play();
                        }, errBack);
                    }
                });
            },
            /**
             * Función que permite tomar foto para la edición de usuarios.
             * @returns {void}
             */
            tomarFotoEditar = function () {
                $("#usuariosBtnAbrirTomarFotoEditarUsuario").click(function () {
                    swal({
                        title: 'FOTO DE USUARIO',
                        html:
                                '<video id="video" width="300" height="300" autoplay></video>' +
                                '<canvas id="canvas" width="300" height="300" style="border: #000 solid 1px;display: none"></canvas>',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Tomar foto',
                        cancelButtonText: 'Cancelar',
                        confirmButtonClass: 'confirm-class',
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    var canvas = $("#canvas")[0];
                                    var contenido2d = canvas.getContext("2d");
                                    var videom = $("#video")[0];
                                    enviarImagenWebCamEditar(contenido2d, canvas, videom);
                                    var audio = new Audio('includes/sounds/camara.mp3');
                                    audio.play();
                                } else {
                                }
                            });
                    var video = $("#video")[0];
                    videoObj = {"video": true},
                            errBack = function (error) {
                                alert("Error en captura de video: ", error.code);
                            };
                    if (navigator.getUserMedia) {
                        navigator.getUserMedia(videoObj, function (stream) {
                            video.src = stream;
                            video.play();
                        }, errBack);
                    } else if (navigator.webkitGetUserMedia) {
                        navigator.webkitGetUserMedia(videoObj, function (stream) {
                            video.src = window.webkitURL.createObjectURL(stream);
                            video.play();
                        }, errBack);
                    } else if (navigator.mozGetUserMedia) {
                        navigator.mozGetUserMedia(videoObj, function (stream) {
                            video.src = window.URL.createObjectURL(stream);
                            video.play();
                        }, errBack);
                    }
                });
            },
            /**
             * Función que permite enviar la foto desde el stream de canvas a la etiqueta img para nuevo usuarios.
             * @param {stream} origen
             * @param {file} canvas
             * @param {stream} video
             * @returns {void}
             */
            enviarImagenWebCam = function (origen, canvas, video) {
                origen.drawImage(video, 0, 0, 300, 300);
                var dataURL = canvas.toDataURL('image/png');
                var imagen = document.getElementById("usuariosImgFotoUsuario");
                imagen.src = dataURL;
                setFoto(dataURL);
            },
            /**
             * Función que permite enviar la foto desde el stream de canvas a la etiqueta img para nuevo usuarios.
             * @param {stream} origen
             * @param {file} canvas
             * @param {stream} video
             * @returns {void}
             */
            enviarImagenWebCamEditar = function (origen, canvas, video) {
                origen.drawImage(video, 0, 0, 300, 300);
                var dataURL = canvas.toDataURL('image/png');
                var imagen = document.getElementById("usuariosImgFotoEditarUsuario");
                imagen.src = dataURL;
                setFoto(dataURL);
            },
            /**
             * Función que valida los campos al editar usuario.
             * @returns {Boolean}
             */
            ValidarCamposVaciosEditar = function () {
                var resultado = true;
                var contadorperfiles = 0;
                $('option', $('#usuariosSelPerfilesEditarUsuario')).each(function (element) {
                    if ($(this).prop('selected') === true) {
                        contadorperfiles = contadorperfiles + 1;
                    }
                });
                if (contadorperfiles === 0) {
                    $(".msgErrorEditarUsuarioPerfil").removeClass('hide');
                    resultado = false;
                }
                $('.form-group .usuariosClsCampoValidadoEditar,.form-group .usuariosClsCampoValidadoFormatoEditar').click(function () {
                    $(this).parent().siblings('.msgErrorEditarUsuario').addClass('hide');
                    $(this).parent().siblings('.UsuariosClsMsgErrorEmailInvalidoEditarUsuario').addClass('hide');
                });
                $('.form-group .usuariosClsCampoValidadoEditar,.form-group .usuariosClsCampoValidadoFormatoEditar').focusin(function () {
                    $(this).parent().siblings('.msgErrorEditarUsuario').addClass('hide');
                    $(this).parent().siblings('.UsuariosClsMsgErrorEmailInvalidoEditarUsuario').addClass('hide');
                });
                $(".multiselect.dropdown-toggle.btn.btn-default").click(function () {
                    $('.msgErrorEditarUsuarioPerfil,.UsuariosClsMsgErrorEmailInvalidoEditarUsuario').addClass('hide');
                });
                $('.form-group .usuariosClsCampoValidadoEditar').each(function () {
                    if ($(this).val() === '') {
                        resultado = false;
                        $(this).parent().siblings('.msgErrorEditarUsuario').removeClass('hide');
                    } else {
                        $(this).parent().siblings('.msgErrorEditarUsuario').addClass('hide');
                    }
                });
                $('#usuariosTxtEmailEditarUsuario').val($('#usuariosTxtEmailEditarUsuario').val().trim());
                if ($('#usuariosTxtEmailEditarUsuario').val() !== "" && ValidarEmail('#usuariosTxtEmailEditarUsuario') === false) {
                    $("#msgErrorEmailInvalidoEditarUsuario").removeClass('hide');
                    resultado = false;
                }
                return resultado;
            },
            /**
             * Función que permite cargar la imagen para edición de usuarios.
             * @returns {void}
             */
            cargarImagenEditar = function () {
                $("#usuariosBtnSubirFotoEditarUsuario").click(function () {
                    $("#usuariosFilFotoSubirEditarUsuario").trigger('click');
                });
                enviarImagen("#usuariosImgFotoEditarUsuario", "#usuariosFilFotoSubirEditarUsuario");
            },
            /**
             * Función que inicia el módulo de usuarios.
             * @returns {void}
             */
            iniciar = function () {
                iniciarSocket();
                setFoto("");
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
    Usuarios.iniciar();
});