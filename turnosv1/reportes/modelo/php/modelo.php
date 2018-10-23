<?php

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class Reporte {

    /**
     * Id de Usuario.
     * @var Integer
     */
    private $_idusuario;

    /**
     * Id de Módulo.
     * @var Integer
     */
    private $_idmodulo;

    /**
     * Fecha de inicio del reporte.
     * @var Date
     */
    private $_fechainicio;

    /**
     * Fecha fin del reporte.
     * @var Date
     */
    private $_fechafin;

    /**
     * Método que permite enviar el id del módulo.
     * @param Integer $idmodulo
     */
    public function setModulo($idmodulo) {
        $this->_idmodulo = $idmodulo;
    }

    /**
     * Método que permite obtener  el id del módulo.
     * @return Integer
     */
    public function getModulo() {
        return $this->_idmodulo;
    }

    /**
     * Método que permite enviar el id del usuario.
     * @param Integer $idusuario
     */
    public function setUsuario($idusuario) {
        $this->_idusuario = $idusuario;
    }

    /**
     * Método que permite obtener  el id del usuario.
     * @return Integer
     */
    public function getUsuario() {
        return $this->_idusuario;
    }

    /**
     * Método que permite enviar la fecha de inicio del reporte.
     * @param Date $fechainicio
     */
    public function setFechaInicio($fechainicio) {
        $this->_fechainicio = $fechainicio;
    }

    /**
     * Método que permite obtener la fecha de inicio del reporte.
     * @return Date
     */
    public function getFechaInicio() {
        return $this->_fechainicio;
    }

    /**
     * Método que permite enviar la fecha final del reporte.
     * @param Date $fechafin
     */
    public function setFechaFin($fechafin) {
        $this->_fechafin = $fechafin;
    }

    /**
     * Método que permite obtener la fecha final del reporte.
     * @return Date
     */
    public function getFechaFin() {
        return $this->_fechafin;
    }

    /**
     * Constructor de la clase.
     */
    public function Reporte() {
        
    }

    /**
     * Método que permite consultar usuarios.
     */
    public function ConsultarUsuarios() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_consultarusuarios()as (id integer,nombre varchar,apellido varchar);");
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
                        'apellidos' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                        'nombres' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
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
     * Método que permite consultar usuarios.
     */
    public function Consultarpacientes() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_consultarpacientes()as (id integer,nombre varchar,apellido varchar);");
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
                        'apellidos' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                        'nombres' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
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
     * Método que permite consultar usuarios.
     */
    public function ConsultarModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_consultarmodulos()as (id integer);");
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
     * Método que genera el reportes de Turnos por usuario. 
     * @return type
     */
    public function GenerarReporteTurnosPorUsuarios() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnosporusuario('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getUsuario() . ") AS (id integer,nom varchar,ape varchar,fecha text,turnos integer);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombres' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'apellidos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes de Turnos por usuario. 
     * @return type
     */
    public function GenerarReporteTurnosPorpacientes() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnosporpaciente('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getUsuario() . ") AS (id integer,nom varchar,ape varchar,fecha text,turnos integer);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombres' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'apellidos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes de tiempo promedio de atención por usuario. 
     * @return type
     */
    public function GenerarReporteTiempoPromedioAtencionPorUsuarios() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnospromedioatencionporusuarios('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getUsuario() . ") AS (id integer,nom varchar,ape varchar,fecha text,turnos integer,promedio interval);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombres' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'apellidos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES),
                    'promedio' => htmlspecialchars_decode($consulta[$cont][5], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes general por usuario. 
     * @return type
     */
    public function GenerarReporteGeneralPorUsuarios() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from  fn_reportes_reportegeneralporusuarios('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getUsuario() . ") AS (id integer,nom varchar,ape varchar,promedioatendido interval,promedioespera interval, atendidos integer,anulados integer);");
            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombres' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'apellidos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'promedioatendido' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'promedioespera' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES),
                    'atendidos' => htmlspecialchars_decode($consulta[$cont][5], ENT_QUOTES),
                    'anulados' => htmlspecialchars_decode($consulta[$cont][6], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes general por módulos. 
     * @return type
     */
    public function GenerarReporteGeneralPorModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from  fn_reportes_reportegeneralpormodulos('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getModulo() . ") AS (id integer,promedioatendido interval,promedioespera interval, atendidos integer,anulados integer);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombre' => htmlspecialchars_decode($consulta[$cont][0], ENT_QUOTES),
                    'promedioatendido' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'promedioespera' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'atendidos' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'anulados' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes de tiempo promedio de atención por módulos. 
     * @return type
     */
    public function GenerarReporteTiempoPromedioEsperaPorModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnospromedioesperapormodulos('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getModulo() . ") AS (id integer,fecha text,turnos integer,promedio interval);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombre' => htmlspecialchars_decode($consulta[$cont][0], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'promedio' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes de tiempo promedio de atención por usuario. 
     * @return type
     */
    public function GenerarReporteTiempoPromedioEsperaPorUsuarios() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnospromedioesperaporusuarios('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getUsuario() . ") AS (id integer,nom varchar,ape varchar,fecha text,turnos integer,promedio interval);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombres' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'apellidos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES),
                    'promedio' => htmlspecialchars_decode($consulta[$cont][5], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes de Turnos por módulos. 
     * @return type
     */
    public function GenerarReporteTurnosPorModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnospormodulos('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getModulo() . ") AS (id integer,fecha text,turnos integer);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombre' => htmlspecialchars_decode($consulta[$cont][0], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES)
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que genera el reportes de tiempo promedio de atención por modulo. 
     * @return type
     */
    public function GenerarReporteTiempoPromedioAtencionPorModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_reportes_reporteturnospromedioatencionpormodulos('" . $this->getFechaInicio() . "','" . $this->getFechaFin() . "'," . $this->getModulo() . ") AS (id integer,fecha text,turnos integer,promedio interval);");

            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'reg' => 1,
                    'nombre' => htmlspecialchars_decode($consulta[$cont][0], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'turnos' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'promedio' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                );
                $cont++;
            }
            return '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

}

?>
