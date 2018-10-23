<?php

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class Modulo {

    /**
     * Id del módulo.
     * @var Integer
     */
    private $_id;

    /**
     * Nombre del módulo.
     * @var String
     */
    private $_descripcion;

    /**
     * Estado del módulo.
     * @var String
     */
    private $_estado;

    /**
     * Método que permite enviar el id del módulo.
     * @param Integer $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener  el id del módulo.
     * @return Integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Método que permite enviar la descripción del módulo.
     * @param String $descripcion
     */
    public function setDescripcion($descripcion) {
        $this->_descripcion = $descripcion;
    }

    /**
     * Método que permite obtener la descripción del módulo.
     * @return String
     */
    public function getDescripcion() {
        return $this->_descripcion;
    }

    /**
     * Método que permite enviar el estado del módulo.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener el estado del módulo.
     * @return String
     */
    public function getEstado() {
        return $this->_estado;
    }

    /**
     * Constructor de la clase.
     */
    public function Modulo() {
        
    }

    /**
     * Método que lista la información de módulos.
     * @param Integer $pagina
     * @param String $busqueda
     */
    public function ListaInformacionModulos($pagina, $busqueda) {
        try {
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_modulos_contarregistrosbusqueda('" . $busqueda . "');");
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
                $informacionusuarios = $this->_conexionlogin->select("select * from fn_modulos_buscarmodulos('" . $busqueda . "'," . $inicio . "," . $limite . ")as (id integer,descripcion varchar,estado varchar);");
                $cont = 0;
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'descripcion' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
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
     * Método que permite cambiar el estado del módulo.
     */
    public function CambiaEstadoModulo() {
        try {
            if (!$_SESSION) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_modulos_cambiarestadomodulo(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite crear un nuevo módulo.
     */
    public function NuevoModulo() {
        try {
            if (!$_SESSION) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_modulos_crearmodulo('" . $this->getDescripcion() . "'," . $_SESSION['usuid'] . ");");
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
     * Método que permite editar modulos.
     */
    public function EditarModulo() {
        try {
            if (!$_SESSION) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_modulos_editarmodulo('" . $this->getDescripcion() . "'," . $this->getId() . "," . $_SESSION['usuid'] . ");");
            $arreglo[0] = array(
                'reg' => $consulta[0][0]
            );
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

}

?>
