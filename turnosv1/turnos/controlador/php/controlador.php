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
        case 'consultarmodulos':
            $controlador = new Turno();
            $controlador->consultarTramites();
            break;
        case 'consultarvideos':
            $controlador = new Turno();
            $controlador->consultarVideos();
            break;
        case 'consultarinformacionparametros':
            $controlador = new Turno();
            $controlador->consultarInformacionParametros();
            break;
        case 'nuevoturno':
            if (isset($_POST['modulo']) && filter_var($_POST['modulo'], FILTER_VALIDATE_INT)) {
                $informacion = new Turno();
                $informacion->setIdModulo(filter_var($_POST['modulo'], FILTER_SANITIZE_NUMBER_INT));
                $informacion->crearTurno();
            } else {
                errordeparametros();
            }
            break;
        case 'nuevoturnopublico':
            if (isset($_POST['modulo']) && filter_var($_POST['modulo'], FILTER_VALIDATE_INT)) {
                $informacion = new Turno();
                $informacion->setIdModulo(filter_var($_POST['modulo'], FILTER_SANITIZE_NUMBER_INT));
                $informacion->crearTurnoPublico();
            } else {
                errordeparametros();
            }
            break;
        case 'consultarturnos':
            $controlador = new Turno();
            $controlador->consultarTurnos();
            break;
        case 'consultarinformacionminimaespera':
            $controlador = new Turno();
            $controlador->consultarinformacionMinimaEspera();
            break;
        case 'consultarturnosllamados':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Turno();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->consultarTurnosLlamados();
            } else {
                errordeparametros();
            }
            break;
        case 'consultarturnosusuario':
            $controlador = new Turno();
            $controlador->consultarTurnosUsuario();
            break;
        case 'consultarturnosusuariosiguiente':
            $controlador = new Turno();
            $controlador->consultarTurnosUsuarioSiguiente();
            break;
        case 'llamarturno':
            $controlador = new Turno();
            $controlador->llamarturno();
            break;
        case 'anularturno':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Turno();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->anularTurno();
            } else {
                errordeparametros();
            }
            break;
        case 'finalizarturno':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Turno();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->finalizarTurno();
            } else {
                errordeparametros();
            }
            break;
        case 'atenderturno':
            if (isset($_POST['cedula']) && isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Turno();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->atenderTurno(filter_var($_POST['cedula'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'verificarpacienterequerido':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Turno();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->verificarpacienteRequerido();
            } else {
                errordeparametros();
            }
            break;
        default:
            errordeparametros();
    }
} else {
    errordeparametros();
}
?>

