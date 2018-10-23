<?php

include_once './configuracion.php';

class ConexionLogin {

    private $_strcon;
    private $_con;
    private $_respuesta;
    private $_options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    static $_instance;

    protected function __construct() {
        try {
            $config = new configuracion();
            $config->CargarConfiguracionLogin();
            $this->_strcon = 'pgsql:host=' . $config->getHost() . ';dbname=' . $config->getBase() . ';port=' . $config->getPuerto() . ';';
            $this->_con = new PDO($this->_strcon, $config->getUsuario(), $config->getClave(), $this->_options);
            $this->_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $arreglo[0] = array('reg' => -4);
            echo '' . json_encode($arreglo) . '';
            exit();
        }
    }

    public static function getConnection() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        return false;
    }

    public function __wakeup() {
        return false;
    }

    public function beginTransaction() {
        $this->_con->beginTransaction();
    }

    public function commit() {
        $this->_con->commit();
    }

    public function rollBack() {
        $this->_con->rollBack();
    }

    public function errorCode() {
        return $this->_con->errorCode();
    }

    public function inTransaction() {
        return $this->_con->inTransaction();
    }

    public function lastInsertId() {
        return $this->_con->lastInsertId();
    }

    public function select($sqlQuery) {
        $this->_respuesta = $this->_con->prepare($sqlQuery);
        $this->_respuesta->execute();
        $array = $this->_respuesta->fetchAll(PDO::FETCH_NUM);
        return $array;
    }

    public function execute($sqlQuery) {
        $this->_respuesta = $this->_con->prepare($sqlQuery);
        $res = $this->_respuesta->execute();
        return $res;
    }

}

?>
