var ReportesTurnos = (function () {
    var
            /**
             * Función que permite generar el reporte general por módulos.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteGeneralPorModulos = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reportegeneralpormodulos.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reportegeneralpormodulos.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte general por usuarios.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteGeneralPorUsuarios = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reportegeneralporusuarios.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reportegeneralporusuarios.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de turnos por usuario.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteTurnosAtendidosPorUsuario = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reporteturnosatendidoporusuario.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reporteturnosatendidoporusuario.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de turnos por paciente.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteTurnosAtendidosPorpaciente = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reporteturnosatendidoporpaciente.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reporteturnosatendidoporpaciente.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de asignadas
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReportesTiempoPromedioPorModulos = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reportepromedioatencionpormodulo.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reportepromedioatencionpormodulo.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de horas laboradas
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteTiempoPromedioPorUsarios = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reportepromedioatencionporusuario.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reportepromedioatencionporusuario.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de promedio de tiempo de espera por usuarios.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteTiempoEsperaPorUsuarios = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reportepromedioesperaporusuario.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reportepromedioesperaporusuario.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&personal=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de tiempo promedio de espera por módulos.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteTiempoEsperaPorModulos = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reportepromedioesperapormodulo.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reportepromedioesperapormodulo.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite generar el reporte de turnos por módulo.
             * @param {Integer} tipo
             * @returns {void}
             */
            generarReporteTurnosAtendidosPorModulo = function (tipo) {
                var
                        fini = $("#reportesFechaInicioTurnosNuevo").val(),
                        ffin = $("#reportesFechaFinTurnosNuevo").val(),
                        persona = $("#reportesUsuarioModuloTurnosNuevo").val();
                $("#reportesFrmReportesTurnos").empty();
                if (tipo === 'pdf') {
                    $("#reportesFrmReportesTurnos").append(
                            $("<embed>").attr(
                            {
                                "height": 375,
                                "id": "reportesEmbTurnosNuevo",
                                "src": "reportes/vista/php/vista_reporteturnosatendidospormodulo.php?fecini=" + fini +
                                        "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo
                            }).
                            addClass('col-xs-12 box-primary').
                            css(
                                    {
                                        "border-bottom-color": "#D9D9D9",
                                        "border-bottom-style": "solid",
                                        "border-bottom": "1px",
                                        "padding-left": "0",
                                        "padding-right": "0"
                                    })
                            );
                } else if (tipo === 'excel') {
                    window.open("reportes/vista/php/vista_reporteturnosatendidospormodulo.php?fecini=" + fini +
                            "&fecfin=" + ffin + "&modulo=" + persona + "&tipo=" + tipo, '_blank');
                }
            },
            /**
             * Función que permite consultar los usuarios.
             * @param {type} selector
             * @returns {void}
             */
            consultarUsuarios = function (selector) {
                $(selector).empty();
                $(selector).select2();
                $.ajax({
                    url: "reportes/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarusuarios'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 1) {
                        $(selector).append(
                                $("<option>").val(0).text("Todos")
                                );
                        $.each(datos, function (i) {
                            $(selector).append(
                                    $("<option>").val(datos[i].id).text(datos[i].apellidos + ' ' + datos[i].nombres)
                                    );
                        });
                        $(selector).select2("val", 0);
                        $(selector).select2({width: "100%", heigth: "100%"});
                    }
                    else if (datos[0].reg === -1) {
                        sweetAlert("Error", 'No se han cargado usuarios', "error");
                    }
                    else {
                        sweetAlert("Error", 'Error al tratar de consultar usuarios', "error");
                    }
                });
            },
            /**
             * Función que permite consultar los usuarios.
             * @param {type} selector
             * @returns {void}
             */
            consultarpacientes = function (selector) {
                $(selector).empty();
                $(selector).select2();
                $.ajax({
                    url: "reportes/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarpacientes'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 1) {
                        $(selector).append(
                                $("<option>").val(0).text("Todos")
                                );
                        $.each(datos, function (i) {
                            $(selector).append(
                                    $("<option>").val(datos[i].id).text(datos[i].apellidos + ' ' + datos[i].nombres)
                                    );
                        });
                        $(selector).select2("val", 0);
                        $(selector).select2({width: "100%", heigth: "100%"});
                    }
                    else if (datos[0].reg === -1) {
                        sweetAlert("Error", 'No se han cargado Pacientes', "error");
                    }
                    else {
                        sweetAlert("Error", 'Error al tratar de consultar Pacientes', "error");
                    }
                });
            },
            /**
             * Función que permite consultar los módulos.
             * @param {string} selector
             * @returns {void}
             */
            consultarModulos = function (selector) {
                $(selector).empty();
                $(selector).select2();
                $.ajax({
                    url: "reportes/controlador/php/controlador.php",
                    type: 'post',
                    datatype: 'json',
                    data: {
                        accion: 'consultarmodulos'
                    }
                }).done(function (respuesta) {
                    var datos = JSON.parse(respuesta);
                    if (datos[0].reg === 1) {
                        $(selector).append(
                                $("<option>").val(0).text("Todos")
                                );
                        $.each(datos, function (i) {
                            $(selector).append(
                                    $("<option>").val(datos[i].id).text(datos[i].id)
                                    );
                        });
                        $(selector).select2("val", 0);
                        $(selector).select2({width: "100%", heigth: "100%"});
                    }
                    else if (datos[0].reg === -1) {
                        sweetAlert("Error", 'No se han cargado ÁREA/SUBJEFATURA', "error");
                    }
                    else {
                        sweetAlert("Error", 'Error al tratar de consultar ÁREA/SUBJEFATURA', "error");
                    }
                });
            },
            /**
             * Función que inicializa el módulo de reportes
             * @returns {void}
             */
            iniciar = function () {
                $("#reportesTipoReporteNuevo").change(function () {
                    var seleccion = $("option:selected", this);
                    if ($(seleccion).attr('data-tipo') == "U") {
                        $("#reportesLblUsuarioModulo").text("Usuario:");
                        consultarUsuarios("#reportesUsuarioModuloTurnosNuevo");
                    } else if ($(seleccion).attr('data-tipo') == "M") {
                        $("#reportesLblUsuarioModulo").text("Módulo:");
                        consultarModulos("#reportesUsuarioModuloTurnosNuevo");
                    }
                    else if ($(seleccion).attr('data-tipo') == "C") {
                        $("#reportesLblUsuarioModulo").text("paciente:");
                        consultarpacientes("#reportesUsuarioModuloTurnosNuevo");
                    }
                });
                $(".datepicker").datepicker({
                    format: 'yyyy-mm-dd'
                });
                $(".datepicker").datepicker("update", new Date());
                $('.input-daterange').datepicker({
                    format: 'yyyy-mm-dd'
                });
                $("#reportesBtnNuevoReporteTurnos").click(function () {
                    switch ($("#reportesTipoReporteNuevo").val()) {
                        case "1":
                            generarReporteTurnosAtendidosPorUsuario("pdf");
                            break;
                        case "2":
                            generarReporteTurnosAtendidosPorModulo("pdf");
                            break;
                        case "3":
                            generarReporteTiempoPromedioPorUsarios("pdf");
                            break;
                        case "4":
                            generarReportesTiempoPromedioPorModulos("pdf");
                            break;
                        case "5":
                            generarReporteTiempoEsperaPorUsuarios("pdf");
                            break;
                        case "6":
                            generarReporteTiempoEsperaPorModulos("pdf");
                            break;
                        case "7":
                            generarReporteGeneralPorUsuarios("pdf");
                            break;
                        case "8":
                            generarReporteGeneralPorModulos("pdf");
                            break;
                        case "9":
                            generarReporteTurnosAtendidosPorpaciente("pdf");
                            break;
                        default:
                            sweetAlert("Error", 'Tipo de reporte no especificado', "error");
                            break;
                    }
                });
                $("#reportesBtnNuevoReporteTurnosExcel").click(function () {
                    switch ($("#reportesTipoReporteNuevo").val()) {
                        case "1":
                            generarReporteTurnosAtendidosPorUsuario("excel");
                            break;
                        case "2":
                            generarReporteTurnosAtendidosPorModulo("excel");
                            break;
                        case "3":
                            generarReporteTiempoPromedioPorUsarios("excel");
                            break;
                        case "4":
                            generarReportesTiempoPromedioPorModulos("excel");
                            break;
                        case "5":
                            generarReporteTiempoEsperaPorUsuarios("excel");
                            break;
                        case "6":
                            generarReporteTiempoEsperaPorModulos("excel");
                            break;
                        case "7":
                            generarReporteGeneralPorUsuarios("excel");
                            break;
                        case "8":
                            generarReporteGeneralPorModulos("excel");
                            break;
                        case "9":
                            generarReporteTurnosAtendidosPorpaciente("excel");
                            break;
                        default:
                            sweetAlert("Error", 'Tipo de reporte no especificado', "error");
                            break;
                    }
                });
                $(".datepicker").change(function () {
                    if ($(this).val() === "") {
                        $(".datepicker").datepicker("update", new Date());
                    }
                });
                $("#reportesTipoReporteNuevo").select2({width: "100%", heigth: "100%"});
                consultarUsuarios("#reportesUsuarioModuloTurnosNuevo");
            }
    ;
    return {
        iniciar: iniciar
    };
})();

$(document).ready(function () {
    ReportesTurnos.iniciar();
});
