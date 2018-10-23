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
        case 'consultarparametros':
            $controlador = new Parametro();
            $controlador->ConsultarParametros();
            break;
        case 'listarvideos':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new Parametro();
                $controlador->ListaInformacionVideos(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'cambiarestadovideo':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Parametro ();
                $controlador->CambiaEstadoVideo(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
            } else {
                errordeparametros();
            }
            break;
        case 'editarparametros':
            if (isset($_POST['id']) && isset($_POST['valor'])) {
                $cont = 0;
                $arrayparametros = $_POST['valor'];
                while ($cont < count($_POST['valor'])) {
                    $arrayparametros[$cont] = filter_var($arrayparametros[$cont], FILTER_SANITIZE_STRING);
                    $cont++;
                }
                $controlador = new Parametro();
                $controlador->setId("'" . '{"' . implode('", "', $_POST['id']) . '"}' . "'");
                $controlador->setValor("'" . '{"' . implode('", "', $arrayparametros) . '"}' . "'");
                $controlador->EditarParametros();
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

