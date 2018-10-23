<?php

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class paciente {

    /**
     * Id del paciente.
     * @var Integer
     */
    private $_id;

    /**
     * Nombre del paciente.
     * @var String 
     */
    private $_nombre;

    /**
     * Apellido del paciente.
     * @var String
     */
    private $_apellido;

    /**
     * Dirección del paciente.
     * @var String
     */
    private $_direccion;

    /**
     * Teléfono del paciente.
     * @var String 
     */
    private $_telefono;

    /**
     * Identificación del paciente.
     * @var String
     */
    private $_identificacion;

    /**
     * Estado del paciente.
     * @var String
     */
    private $_estado;

    /**
     * Método que permite obtener el nombre del paciente.
     * @return String
     */
    public function getNombre() {
        return $this->_nombre;
    }

    /**
     * Método que permite obtener el apellido del paciente.
     * @return String
     */
    public function getApellido() {
        return $this->_apellido;
    }

    /**
     * Método que permite obtener la dirección del paciente.
     * @return String
     */
    public function getDireccion() {
        return $this->_direccion;
    }

    /**
     * Método que permite obtener el teléfono del paciente.
     * @return String
     */
    public function getTelefono() {
        return $this->_telefono;
    }

    /**
     * Método que permite enviar el nombre del paciente.
     * @param String $nombre
     */
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }

    /**
     * Método que permite enviar el apellido del paciente.
     * @param String $apellido
     */
    public function setApellido($apellido) {
        $this->_apellido = $apellido;
    }

    /**
     * Método que permite enviar la dirección del paciente.
     * @param String $direccion
     */
    public function setDireccion($direccion) {
        $this->_direccion = $direccion;
    }

    /**
     * Método que permite enviar el teléfono del paciente.
     * @param String $telefono
     */
    public function setTelefono($telefono) {
        $this->_telefono = $telefono;
    }

    /**
     * Método que permite enviar el id del paciente.
     * @param Integer $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener  el id del paciente.
     * @return Integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Método que permite enviar la identificación del paciente.
     * @param String $identificacion
     */
    public function setIdentificacion($identificacion) {
        $this->_identificacion = $identificacion;
    }

    /**
     * Método que permite obtener la identificación del paciente.
     * @return String
     */
    public function getIdentificacion() {
        return $this->_identificacion;
    }

    /**
     * Método que permite enviar el estado del paciente.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener el estado del paciente.
     * @return String
     */
    public function getEstado() {
        return $this->_estado;
    }

    /**
     * Constructor de la clase.
     */
    public function paciente() {
        
    }

    /**
     * Método que lista la información de pacientes.
     * @param Integer $pagina
     * @param String $busqueda
     */
    public function ListaInformacionpacientes($pagina, $busqueda) {
        try {
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_pacientes_contarregistrosbusqueda('" . $busqueda . "');");
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
                $informacionusuarios = $this->_conexionlogin->select("select * from fn_pacientes_buscarpacientes('" . $busqueda . "'," . $inicio . "," . $limite . ")as (id integer,nombre varchar,apellido varchar,direccion varchar,telefono varchar,estado varchar,cedula varchar);");
                $cont = 0;
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'apellido' => htmlspecialchars_decode($informacionusuarios[$cont][2], ENT_QUOTES),
                        'direccion' => htmlspecialchars_decode($informacionusuarios[$cont][3], ENT_QUOTES),
                        'telefono' => htmlspecialchars_decode($informacionusuarios[$cont][4], ENT_QUOTES),
                        'estado' => $informacionusuarios[$cont][5],
                        'cedula' => htmlspecialchars_decode($informacionusuarios[$cont][6], ENT_QUOTES),
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
     * Método que permite cambiar el estado del paciente.
     */
    public function CambiaEstadopaciente() {
        try {
            if (!$_SESSION) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_pacientes_cambiarestadopaciente(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite crear un nuevo paciente.
     */
    public function Nuevopaciente() {
        try {
            if (!$_SESSION) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_pacientes_crearpaciente('" . $this->getNombre() . "','" . $this->getApellido() . "','" . $this->getIdentificacion() . "','" . $this->getDireccion() . "','" . $this->getTelefono() . "'," . $_SESSION['usuid'] . ");");
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
     * Método que permite editar pacientes.
     */
    public function Editarpaciente() {
        try {
            if (!$_SESSION) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_pacientes_editarpaciente(" . $this->getId() . ",'" . $this->getNombre() . "','" . $this->getApellido() . "','" . $this->getIdentificacion() . "','" . $this->getDireccion() . "','" . $this->getTelefono() . "'," . $_SESSION['usuid'] . ");");
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
