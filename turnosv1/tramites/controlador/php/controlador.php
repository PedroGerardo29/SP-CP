<?php

error_reporting(\E_ERROR);

/**
 * Función que valida el envio correcto de parámetros (A través del método POST)
 */
function errordeparametros() {
    $arreglo[0] = array('reg' => -3);
    echo '' . json_encode($arreglo) . '';
}

/**
 * Condición que recibe una petición de la vista para el modelo,
 * y recibe una respuesta del modelo para la vista.
 */
if (isset($_POST['accion'])) {
    include_once('../../modelo/php/modelo.php');
    switch ($_REQUEST['accion']) {
        case 'listartramites':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new Tramite ();
                $controlador->ListaInformacionTramites(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'cambiarestadotramite':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Tramite ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CambiaEstadoTramite();
            } else {
                errordeparametros();
            }
            break;
        case 'consultarmodulos':
            $controlador = new Tramite ();
            $controlador->ConsultarModulos();
            break;

        case 'cargarmoduloseditarusuario':
            if (isset($_POST['tramite']) && filter_var($_POST['tramite'], FILTER_VALIDATE_INT)) {
                $controlador = new Tramite ();
                $controlador->setId(filter_var($_POST['tramite'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->ConsultarModulosEditar();
            } else {
                errordeparametros();
            }
            break;
        case 'nuevotramite':
            if (isset($_POST['nombre']) && isset($_POST['iniciales']) && isset($_POST['clienterequerido'])) {
                $controlador = new Tramite ();
                $controlador->setModulo("'" . '{"' . implode('", "', $_POST['modulos']) . '"}' . "'");
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->setInicial(filter_var($_POST['iniciales'], FILTER_SANITIZE_STRING));
                $controlador->setClienterequerido(filter_var($_POST['clienterequerido'], FILTER_SANITIZE_STRING));
                $controlador->NuevoTramite();
            } else {
                errordeparametros();
            }
            break;
        case 'editartramite':
            if (isset($_POST['id']) && isset($_POST['nombre'])&& isset($_POST['iniciales']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)&& isset($_POST['clienterequerido'])) {
                $controlador = new Tramite ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                 $controlador->setInicial(filter_var($_POST['iniciales'], FILTER_SANITIZE_STRING));
                $controlador->setModulo("'" . '{"' . implode('", "', $_POST['modulos']) . '"}' . "'");
                 $controlador->setClienterequerido(filter_var($_POST['clienterequerido'], FILTER_SANITIZE_STRING));
                $controlador->EditarTramite();
            } else {
                errordeparametros();
            }
            break;
    }
} else {
    errordeparametros();
}
?>

