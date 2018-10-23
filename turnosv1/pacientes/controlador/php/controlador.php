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
        case 'listarpacientes':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new paciente ();
                $controlador->ListaInformacionpacientes(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'cambiarestadopaciente':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new paciente ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CambiaEstadopaciente();
            } else {
                errordeparametros();
            }
            break;
        case 'nuevopaciente':
            if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['identificacion']) && isset($_POST['direccion']) && isset($_POST['telefono'])) {
                $controlador = new paciente ();
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->setApellido(filter_var($_POST['apellido'], FILTER_SANITIZE_STRING));
                $controlador->setIdentificacion(filter_var($_POST['identificacion'], FILTER_SANITIZE_STRING));
                $controlador->setDireccion(filter_var($_POST['direccion'], FILTER_SANITIZE_STRING));
                $controlador->setTelefono(filter_var($_POST['telefono'], FILTER_SANITIZE_STRING));
                $controlador->Nuevopaciente();
            } else {
                errordeparametros();
            }
            break;
        case 'editarpaciente':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['identificacion'])  && isset($_POST['direccion']) && isset($_POST['telefono'])) {
                $controlador = new paciente ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->setApellido(filter_var($_POST['apellido'], FILTER_SANITIZE_STRING));
                $controlador->setIdentificacion(filter_var($_POST['identificacion'], FILTER_SANITIZE_STRING));
                $controlador->setDireccion(filter_var($_POST['direccion'], FILTER_SANITIZE_STRING));
                $controlador->setTelefono(filter_var($_POST['telefono'], FILTER_SANITIZE_STRING));
                $controlador->Editarpaciente();
            } else {
                errordeparametros();
            }
            break;
    }
} else {
    errordeparametros();
}
?>

