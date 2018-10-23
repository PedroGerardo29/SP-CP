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
        case 'consultarusuarios':
            $controlador = new Reporte();
            $controlador->ConsultarUsuarios();
            break;
        case 'consultarpacientes':
            $controlador = new Reporte();
            $controlador->Consultarpacientes();
            break;
        case 'consultarmodulos':
            $controlador = new Reporte();
            $controlador->ConsultarModulos();
            break;
        default:
            errordeparametros();
    }
} else {
    errordeparametros();
}
?>

