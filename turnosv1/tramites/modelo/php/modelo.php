<?php

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class Tramite {

    /**
     * Id del trámite.
     * @var Integer 
     */
    private $_id;

    /**
     * Nombre del trámite.
     * @var String
     */
    private $_nombre;

    /**
     * Estado del trámite.
     * @var String
     */
    private $_estado;

    /**
     * Inicial del trámite.
     * @var String 
     */
    private $_inicial;

    /**
     * Módulo del trámite.
     * @var Integer
     */
    private $_modulo;
    private $_clienterequerido;

    /**
     * Método que permite enviar el módulo.
     * @param Integer $modulo
     */
    public function setModulo($modulo) {
        $this->_modulo = $modulo;
    }

    /**
     * Método que permite obtener  el módulo.
     * @return Integer
     */
    public function getModulo() {
        return $this->_modulo;
    }

    /**
     * Método que permite enviar el id del trámite.
     * @param Integer $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener  el id del trámite.
     * @return Integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Método que permite enviar el nombre del trámite.
     * @param String $nombre
     */
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }

    /**
     * Método que permite obtener el nombre del trámite.
     * @return String
     */
    public function getNombre() {
        return $this->_nombre;
    }

    /**
     * Método que permite enviar la inicial del trámite.
     * @param String $inicial
     */
    public function setInicial($inicial) {
        $this->_inicial = $inicial;
    }

    /**
     * Método que permite obtener la inicial del trámite.
     * @return String
     */
    public function getInicial() {
        return $this->_inicial;
    }

    /**
     * Método que permite enviar el estado del trámite.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener el estado del trámite.
     * @return String
     */
    public function getEstado() {
        return $this->_estado;
    }

    /**
     * Método que permite obtener si es necesario solicitar cliente.
     * @return String
     */
    function getClienterequerido() {
        return $this->_clienterequerido;
    }

    /**
     * Método que permite enviar condicional si es necesario solicitar cliente.
     * @return String
     */
    function setClienterequerido($clienterequerido) {
        $this->_clienterequerido = $clienterequerido;
    }

    /**
     * Constructor de la clase.
     */
    public function Tramite() {
        
    }

    /**
     * Método que lista la información de trámites.
     * @param Integer $pagina
     * @param String $busqueda
     */
    public function ListaInformacionTramites($pagina, $busqueda) {
        try {
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_tramites_contarregistrosbusqueda('" . $busqueda . "');");
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
                $informacionusuarios = $this->_conexionlogin->select("select * from fn_tramites_buscartramites('" . $busqueda . "'," . $inicio . "," . $limite . ")as (id integer,nombre varchar,estado varchar,inicial varchar,clienterequerido varchar);");
                $cont = 0;
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'estado' => $informacionusuarios[$cont][2],
                        'inicial' => $informacionusuarios[$cont][3],
                        'clienterequerido' => htmlspecialchars_decode($informacionusuarios[$cont][4], ENT_QUOTES),
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
     * Metodo que permite cambiar el estado del trámite.
     */
    public function CambiaEstadoTramite() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_tramites_cambiarestadotramite(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite cargar los módulos para editar trámite.
     */
    public function ConsultarModulosEditar() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_tramites_cargarmoduloseditartramite(" . $this->getId() . ") as(id integer,estado integer)");
            if (count($consulta) == 0) {
                $arreglo[0] = array('reg' => -1);
            } else {
                $cont = 0;
                while ($cont < count($consulta)) {
                    $arreglo[$cont] = array(
                        'reg' => 1,
                        'id' => $consulta[$cont][0],
                        'estado' => $consulta [$cont][1]
                    );
                    $cont++;
                }
            }
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite consultar módulos.
     */
    public function ConsultarModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_tramites_buscarmodulos()as (id integer);");
            if (count($consulta) == 0) {
                $arreglo[0] = array(
                    'reg' => -1
                );
                echo '' . json_encode($arreglo) . '';
            } else {
                $cont = 0;
                while ($cont < count($consulta)) {
                    $arreglo[$cont] = array(
                        'id' => $consulta[$cont][0],
                        'reg' => 1
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
     * Método que permite crear un nuevo trámite.
     */
    public function NuevoTramite() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_tramites_creartramite('" . $this->getNombre() . "'," . $this->getModulo() . ",'" . $this->getInicial() . "','" . $this->getClienterequerido() . "'," . $_SESSION['usuid'] . ");");
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
     * Método que permite editar trámites.
     */
    public function EditarTramite() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_tramites_editartramite('" . $this->getNombre() . "'," . $this->getId() . "," . $this->getModulo() . ",'" . $this->getInicial() . "','" . $this->getClienterequerido() . "'," . $_SESSION['usuid'] . ");");
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
