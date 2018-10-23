<?php

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class Parametro {

    /**
     * Id del parametro.
     * @var String 
     */
    private $_id;

    /**
     * Nombre del parametro.
     * @var String
     */
    private $_nombre;

    /**
     * Valor del parametro.
     * @var String
     */
    private $_valor;

    /**
     * Método que permite enviar el id del parámetro.
     * @param String $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener  el id del parámetro.
     * @return String
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Método que permite enviar el nombre del parámetro.
     * @param String $nombre
     */
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }

    /**
     * Método que permite obtener el nombre del parámetro.
     * @return String
     */
    public function getNombre() {
        return $this->_nombre;
    }

    /**
     * Método que permite enviar el valor del parámetro.
     * @param String $valor
     */
    public function setValor($valor) {
        $this->_valor = $valor;
    }

    /**
     * Método que permite obtener el valor del parámetro.
     * @return String
     */
    public function getvalor() {
        return $this->_valor;
    }

    /**
     * Constructor de la clase.
     */
    public function Parametro() {
        
    }

    /**
     * Método que lista la información de videos.
     * @param Integer $pagina
     * @param String $busqueda
     */
    public function ListaInformacionVideos($pagina, $busqueda) {
        try {
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_parametros_contarregistrosbusquedavideos('" . $busqueda . "');");
            $registros = $consulta[0][0];
            $limite = 6;
            if (is_numeric($pagina)) {
                $inicio = (($pagina - 1) * $limite);
            } else {
                $pagina = 1;
                $inicio = 0;
            }
            if ($registros == 0) {
                $arreglo[0] = array(
                    'reg' => -1
                );
                echo '' . json_encode($arreglo) . '';
            } else {
                $informacionusuarios = $this->_conexionlogin->select("select * from fn_parametros_buscarvideos('" . $busqueda . "'," . $inicio . "," . $limite . ")as (id integer,nombre varchar,estado varchar);");
                $cont = 0;
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'nombre' => $informacionusuarios[$cont][1],
                        'estado' => $informacionusuarios[$cont][2],
                        'reg' => 1,
                        'pag' => ceil(($registros / $limite)),
                        'pagac' => $pagina
                    );
                    $cont++;
                }
                echo '' . json_encode($arreglo) . '';
            }
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite cambiar el estado del video.
     */
    public function CambiaEstadoVideo($video) {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_parametros_cambiarestadovideo(" . $video . "," . $_SESSION['usuid'] . ");");
            $arreglo[0] = array(
                'reg' => $consulta[0][0]
            );
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite la búsqueda de los parámetros.
     */
    public function ConsultarParametros() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_parametros_obtenerparametros() as (id varchar,nombre varchar,valor varchar);");
            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'id' => $consulta[$cont][0],
                    'nombre' => $consulta[$cont][1],
                    'valor' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'reg' => 1
                );
                $cont++;
            }
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite la edición de parámetros.
     */
    public function EditarParametros() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_parametros_editarparametros(" . $this->getId() . "," . $this->getvalor() . "," . $_SESSION['usuid'] . ");");
            if (count($consulta) == 0) {
                $arreglo[0] = array(
                    'reg' => -1);
            } else {

                $arreglo[0] = array('reg' => $consulta[0][0]);
                echo '' . json_encode($arreglo) . '';
            }
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite subir el video.
     */
    public function SubirVideo() {
        try {
            $fileTmpLoc = $_FILES["parametrosFilevideo"]["tmp_name"];
            $name = $_FILES["parametrosFilevideo"]["name"];
            $fileType = $_FILES["parametrosFilevideo"]["type"];
            $fileSize = $_FILES["parametrosFilevideo"]["size"];
            if ($_FILES["parametrosFilevideo"]["type"] != "video/mp4") {
                $arreglo[0] = array('reg' => -4);
            } else if ($_FILES["parametrosFilevideo"]["size"] > 41943040) {
                $arreglo[0] = array('reg' => -5);
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                if (move_uploaded_file($fileTmpLoc, "../../../includes/video/" . strtoupper($name))) {
                    $this->_conexion = ConexionLogin::getConnection();
                    $consulta = $this->_conexion->select("select fn_parametros_crearvideo('" . $name . "'," . $_SESSION['usuid'] . ");");
                    $arreglo[0] = array(
                        'reg' => $consulta[0][0],
                        'nombre' => strtoupper($name)
                    );
                    if ($arreglo[0] == 2) {
                        unlink($name);
                    }
                } else {
                    $arreglo[0] = array('reg' => -1);
                }
            }
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite subir el timbre.
     */
    public function SubirAudio() {
        try {
            $fileTmpLoc = $_FILES["parametrosFilTimbreSubirParametro"]["tmp_name"];
            $fileType = $_FILES["parametrosFilTimbreSubirParametro"]["type"];
            $fileSize = $_FILES["parametrosFilTimbreSubirParametro"]["size"];
            if ($_FILES["parametrosFilTimbreSubirParametro"]["type"] != "audio/mpeg") {
                $arreglo[0] = array('reg' => -4);
            } else if ($_FILES["parametrosFilTimbreSubirParametro"]["size"] > 1048576) {
                $arreglo[0] = array('reg' => -5);
            } else {
                if (move_uploaded_file($fileTmpLoc, "../../../includes/sounds/timbre.mp3")) {
                    $arreglo[0] = array('reg' => 1);
                } else {
                    $arreglo[0] = array('reg' => -1);
                }
            }
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite subir el logo.
     */
    public function SubirImagen() {
        try {
            $fileTmpLoc = $_FILES["parametrosFilFotoSubirParametro"]["tmp_name"];
            $fileType = $_FILES["parametrosFilFotoSubirParametro"]["type"];
            $fileSize = $_FILES["parametrosFilFotoSubirParametro"]["size"];
            if ($_FILES["parametrosFilFotoSubirParametro"]["type"] != "image/png") {
                $arreglo[0] = array('reg' => -4);
            } else if ($_FILES["parametrosFilFotoSubirParametro"]["size"] > 2097152) {
                $arreglo[0] = array('reg' => -5);
            } else {
                if (move_uploaded_file($fileTmpLoc, "../../../includes/img/logoinstitucion.png")) {
                    $arreglo[0] = array('reg' => 1);
                } else {
                    $arreglo[0] = array('reg' => -1);
                }
            }
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

}

?>
