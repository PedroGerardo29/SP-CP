<?php

class configuracion {

    private $_base;
    private $_clave;
    private $_usuario;
    private $_puerto;
    private $_host;

    public function configuracion() {
        $this->setHost('127.0.0.1');
        $this->setPuerto('5432');
    }

    public function setBase($base) {
        $this->_base = $base;
    }

    public function getBase() {
        return $this->_base;
    }

    public function setClave($clave) {
        $this->_clave = $clave;
    }

    public function getClave() {
        return $this->_clave;
    }

    public function setUsuario($usuario) {
        $this->_usuario = $usuario;
    }

    public function getUsuario() {
        return $this->_usuario;
    }

    public function setPuerto($puerto) {
        $this->_puerto = $puerto;
    }

    public function getPuerto() {
        return $this->_puerto;
    }

    public function setHost($host) {
        $this->_host = $host;
    }

    public function getHost() {
        return $this->_host;
    }

    public function CargarConfiguracionLogin() {
        $this->setBase('db_turnos_hro');
        $this->setUsuario('postgres');
        $this->setClave('HRO');
    }

}

?>
