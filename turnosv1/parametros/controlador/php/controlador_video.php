<?php

error_reporting(\E_ERROR);

function errordeparametros() {
    $arreglo[0] = array('reg' => -3);
    echo '' . json_encode($arreglo) . '';
}

if (isset($_FILES["parametrosFilevideo"])) {
    include_once('../../modelo/php/modelo.php');
    $controlador = new Parametro();
    $controlador->SubirVideo();
} else {
    errordeparametros();
}
?>

