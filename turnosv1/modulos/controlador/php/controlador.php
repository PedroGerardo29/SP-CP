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
        case 'listarmodulos':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new Modulo ();
                $controlador->ListaInformacionModulos(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'cambiarestadomodulo':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Modulo ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CambiaEstadoModulo();
            } else {
                errordeparametros();
            }
            break;
        case 'nuevomodulo':
            if (isset($_POST['descripcion'])) {
                $controlador = new Modulo ();
                $controlador->setDescripcion(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));
                $controlador->NuevoModulo();
            } else {
                errordeparametros();
            }
            break;
        case 'editarmodulo':
            if (isset($_POST['id']) && isset($_POST['descripcion']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Modulo ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->setDescripcion(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));
                $controlador->EditarModulo();
            } else {
                errordeparametros();
            }
            break;
    }
} else {
    errordeparametros();
}
?>

