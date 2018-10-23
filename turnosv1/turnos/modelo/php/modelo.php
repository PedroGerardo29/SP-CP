<?php

error_reporting(\E_ERROR);

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class Turno {

    /**
     * Id del turno.
     * @var Integer 
     */
    private $_id;

    /**
     * Id del cliente.
     * @var Integer 
     */
    private $_idcliente;

    /**
     * Id del módulo.
     * @var Integer 
     */
    private $_idmodulo;

    /**
     * Número de turno.
     * @var Integer
     */
    private $_numero;

    /**
     * Estado del turno.
     * @var String
     */
    private $_estado;

    /**
     * Trámite del turno.
     * @var Integer
     */
    private $_idtramite;

    /**
     * Método que permite obtener el id del cliente.
     * @return Integer
     */
    public function getIdCliente() {
        return $this->_idcliente;
    }

    /**
     * Método que enviar el id del cliente.
     * @param Integer $idcliente
     */
    public function setIdCliente(Integer $idcliente) {
        $this->_idcliente = $idcliente;
    }

    /**
     * Método que permite enviar el id del trámite del turno.
     * @param Integer $tramite
     */
    public function setIdTramite($tramite) {
        $this->_idtramite = $tramite;
    }

    /**
     * Método que permite obtener  el id del trámite del turno.
     * @return Integer
     */
    public function getIdTramite() {
        return $this->_idtramite;
    }

    /**
     * Método que permite enviar el id del turno.
     * @param Integer $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener  el id del turno.
     * @return Integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Método que permite obtener  el id del módulo.
     * @return Integer
     */
    public function getIdModulo() {
        return $this->_idmodulo;
    }

    /**
     * Método que permite enviar el id del módulo.
     * @param Integer $idmodulo
     */
    public function setIdModulo($idmodulo) {
        $this->_idmodulo = $idmodulo;
    }

    /**
     * Método que permite enviar el numero del turno.
     * @param Integer $numero
     */
    public function setNumero($numero) {
        $this->_numero = $numero;
    }

    /**
     * Método que permite obtener el numero del turno.
     * @return Integer
     */
    public function getNumero() {
        return $this->_numero;
    }

    /**
     * Método que permite enviar el estado del turno.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener el estado del turno.
     * @return String
     */
    public function getestado() {
        return $this->_estado;
    }

    /**
     * Constructor de la clase.
     */
    public function Turno() {
        
    }

    /**
     * Método que permite consultar información de institución para actualizar al ocurri un evento escuchado a através del socket.
     */
    public function consultarInformacionParametros() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consultapar = $this->_conexion->select("select * from fn_parametros_obtenerparametros() as (id varchar,nombre varchar,valor varchar);");
            $cont = 0;
            while ($cont < count($consultapar)) {
                $_SESSION[$consultapar[$cont][0]] = $consultapar[$cont][2];
                $cont++;
            }
            $arreglo[0] = array(
                'reg' => 1,
                'nombre' => $_SESSION['PAR_NOMINS'],
                'sitioweb' => $_SESSION['PAR_WEBINS'],
                'mensaje' => $_SESSION['PAR_MEN'],
            );
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que lista los videos.
     */
    public function consultarVideos() {
        try {
            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_buscarvideos()as (id integer,nombre varchar);");
            $cont = 0;
            if ($cont < count($informacionusuarios) == 0) {
                $arreglo[$cont] = array(
                    'reg' => -1
                );
            } else {
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'reg' => 1
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
     * Método que lista los Ttrámites.
     */
    public function consultarTramites() {
        try {
            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_buscartramites()as (id integer,numero varchar);");
            $cont = 0;
            while ($cont < count($informacionusuarios)) {
                $arreglo[$cont] = array(
                    'id' => $informacionusuarios[$cont][0],
                    'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
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
     * Método que permite crear un nuevo turno.
     */
    public function crearTurno() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_turnos_crearturno(" . $this->getIdModulo() . "," . $_SESSION['usuid'] . ")as(modulo varchar,turno varchar,fecha TEXT,hora TEXT,espera integer) ;");
            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'tramite' => $consulta[$cont][0],
                    'turno' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'hora' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'espera' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES),
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
     * Método que permite crear un nuevo turno.
     */
    public function crearTurnoPublico() {
        try {
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_turnos_crearturno(" . $this->getIdModulo() . "," . 1 . ")as(modulo varchar,turno varchar,fecha TEXT,hora TEXT,espera integer) ;");
            $cont = 0;
            while ($cont < count($consulta)) {
                $arreglo[$cont] = array(
                    'tramite' => $consulta[$cont][0],
                    'turno' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
                    'fecha' => htmlspecialchars_decode($consulta[$cont][2], ENT_QUOTES),
                    'hora' => htmlspecialchars_decode($consulta[$cont][3], ENT_QUOTES),
                    'espera' => htmlspecialchars_decode($consulta[$cont][4], ENT_QUOTES),
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
     * Método que lista los Turnos
     */
    public function consultarTurnos() {
        try {
            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_buscarturnos()as(id integer,traid integer,numero varchar,nombre varchar,modulo integer);");
            $cont = 0;
            if ($cont < count($informacionusuarios) == 0) {
                $arreglo[$cont] = array(
                    'reg' => -1
                );
            } else {
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'idtramite' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'numero' => $informacionusuarios[$cont][2],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][3], ENT_QUOTES),
                        'modulo' => $informacionusuarios[$cont][4],
                        'reg' => 1
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
     * Método que consulta los turnos llamados.
     */
    public function consultarTurnosLlamados() {
        try {
            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_buscarturnosllamados(" . $this->getId() . ")as(id integer,traid integer,numero varchar,nombre varchar,modulo integer);");
            $cont = 0;
            if ($cont < count($informacionusuarios) == 0) {
                $arreglo[$cont] = array(
                    'reg' => -1
                );
            } else {
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'idtramite' => $informacionusuarios[$cont][1],
                        'numero' => $informacionusuarios[$cont][2],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][3], ENT_QUOTES),
                        'modulo' => $informacionusuarios[$cont][4],
                        'reg' => 1
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
     * Método que lista los Turnos del usuario actual.
     */
    public function consultarTurnosUsuario() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }

            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_buscarturnosusuario(" . $_SESSION['usuid'] . ")as(espera integer,iniciado integer,terminado integer,anulado integer,id integer,numero varchar,nombre varchar,estado varchar,idactual int,horaactual time,hoy date) ;");
            $cont = 0;
            while ($cont < count($informacionusuarios)) {
                $arreglo[$cont] = array(
                    'espera' => $informacionusuarios[$cont][0],
                    'iniciado' => $informacionusuarios[$cont][1],
                    'terminado' => $informacionusuarios[$cont][2],
                    'anulado' => $informacionusuarios[$cont][3],
                    'id' => $informacionusuarios[$cont][4],
                    'numero' => $informacionusuarios[$cont][5],
                    'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][6], ENT_QUOTES),
                    'estado' => $informacionusuarios[$cont][7],
                    'turnoiniciado' => $informacionusuarios[0][8],
                    'horaturnoiniciado' => $informacionusuarios[0][9],
                    'hoy' => $informacionusuarios[0][10],
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
     * Método que permite consultar los siguientes turnos de un usuario.
     */
    public function consultarTurnosUsuarioSiguiente() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_buscarturnossiguienteespera(" . $_SESSION['usuid'] . ")as(id integer,modid integer,numero varchar,nombre varchar,estado varchar)  ;");
            $cont = 0;
            if ($cont < count($informacionusuarios) == 0) {
                $arreglo[$cont] = array(
                    'reg' => -1
                );
            } else {
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'idmodulo' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'numero' => htmlspecialchars_decode($informacionusuarios[$cont][2], ENT_QUOTES),
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][3], ENT_QUOTES),
                        'estado' => htmlspecialchars_decode($informacionusuarios[$cont][4], ENT_QUOTES),
                        'reg' => 1
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
     * Método que permite llamar a un turno.
     */
    public function llamarturno() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = ConexionLogin::getConnection();
            $informacionusuarios = $this->_conexionlogin->select("select * from fn_turnos_llamarturno(" . $_SESSION['usuid'] . ")as(id integer,modid integer,numero varchar,nombre varchar,estado varchar)  ;");
            $cont = 0;
            if ($cont < count($informacionusuarios) == 0) {
                $arreglo[$cont] = array(
                    'reg' => -1
                );
            } else {
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'idmodulo' => $informacionusuarios[$cont][1],
                        'numero' => $informacionusuarios[$cont][2],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][3], ENT_QUOTES),
                        'estado' => $informacionusuarios[$cont][4],
                        'reg' => 1
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
     * Método que permite anular turnos.
     */
    public function anularTurno() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_turnos_anularturno(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite finalizar turnos.
     */
    public function finalizarTurno() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_turnos_finalizarturno(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite obtener la hora mínima de espera por usuario.
     */
    public function consultarinformacionMinimaEspera() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $informacionespera = $this->_conexion->select("select * from fn_turnos_buscarinformacionespera(" . $_SESSION['usuid'] . ")as(hora time,tiempoespera int,umbralespera int,promedioatencion interval,hoy date,turnoiniciado integer,horaturnoiniciado time);");
            $arreglo[0] = array(
                'hora' => $informacionespera[0][0],
                'tiempoespera' => $informacionespera[0][1],
                'umbral' => $informacionespera[0][2],
                'promedioatencion' => $informacionespera[0][3],
                'hoy' => $informacionespera[0][4],
                'turnoiniciado' => $informacionespera[0][5],
                'horaturnoiniciado' => $informacionespera[0][6],
                'reg' => 1
            );
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite obtener el tipo de validación de clientes.
     */
    public function obtenerValidacion() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_turnos_buscarvalidacion();");
            return $consulta[0][0];
        } catch (Exception $e) {
            return 'ERROR';
        }
    }

    /**
     * Método que permite atender turnos.
     */
    public function atenderTurno($cedulacliente) {
        $validacion = $this->obtenerValidacion();
        if ($validacion == 'WEBSERVICE') {
            //Aquí código para verificación por webservice
        } else if ($validacion == 'MANUAL') {
            try {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $this->_conexion = ConexionLogin::getConnection();
                $consulta = $this->_conexion->select("select fn_turnos_atenderturno(" . $this->getId() . ",'" . $cedulacliente . "'," . $_SESSION['usuid'] . ");");
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
    }

    /**
     * Método que permite validar si el tramite del turno actual requiere cliente.
     */
    public function verificarClienteRequerido() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_turnos_verificarclienterequerido(" . $this->getId() . ");");
            $arreglo[0] = array('reg' => $consulta[0][0]);
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite enviar estilo de ancho al ticket.
     */
    public function setEstilosTicket() {
        if (!isset($_SESSION)) {
            session_start();
        }
        echo 'width:' . $_SESSION['PAR_ANCTIC'] . 'mm;';
    }

    /**
     * Método que permite enviar estilos al logo del ticket.
     */
    public function setEstilosLogo() {
        if (!isset($_SESSION)) {
            session_start();
        }
        echo 'width:' . $_SESSION['PAR_ANCLOG'] . 'mm ;height:' . $_SESSION['PAR_ALTLOG'] . 'mm;';
        if ($_SESSION['PAR_LOGVIS'] == "false") {
            echo 'display:none;';
        }
    }

    /**
     * Método que permite enviar estilos a la división del turno del ticket.
     */
    public function setEstilosTurno() {
        if (!isset($_SESSION)) {
            session_start();
        }
        echo 'font-size:' . $_SESSION['PAR_FUETUR'] . 'mm;';
    }

    /**
     * Método que permite enviar estilos a la división del módulo del ticket.
     */
    public function setEstilosModulo() {
        echo 'font-size:' . $_SESSION['PAR_FUETRA'] . 'mm;';
        if ($_SESSION['PAR_TRAVIS'] == "false") {
            echo 'display:none;';
        }
    }

    /**
     * Método que permite enviar estilos a la división de turnos en espera del ticket.
     */
    public function setEstilosEspera() {
        echo 'font-size:' . $_SESSION['PAR_FUEESP'] . 'mm;';
        if ($_SESSION['PAR_ESPVIS'] == "false") {
            echo 'display:none ;';
        }
    }

    /**
     * Método que permite enviar estilos a la división de fecha del ticket.
     */
    public function setEstilosFecha() {
        echo 'font-size:' . $_SESSION['PAR_FUEFEC'] . 'mm;';
        if ($_SESSION['PAR_FECVIS'] == "false") {
            echo 'display:none ;';
        }
    }

    /**
     * Método que permite enviar estilos a la división de hora del ticket.
     */
    public function setEstilosHora() {
        echo 'font-size:' . $_SESSION['PAR_FUEHOR'] . 'mm;';
        if ($_SESSION['PAR_HORVIS'] == "false") {
            echo 'display:none ;';
        }
    }

    /**
     * Método que permite enviar estilos a la división del nombre de institución del ticket.
     */
    public function setEstilosNombre() {
        echo ';font-size:' . $_SESSION['PAR_FUENOM'] . 'mm;';
        if ($_SESSION['PAR_NOMVIS'] == "false") {
            echo 'display:none;';
        }
    }

    /**
     * Método que permite enviar estilos a la división del sitio web del ticket.
     */
    public function setEstilosSitioWeb() {
        echo ';font-size:' . $_SESSION['PAR_FUESIT'] . 'mm;';
        if ($_SESSION['PAR_SITVIS'] == "false") {
            echo 'display:none;';
        }
    }

    /**
     * Método que permite actualizar los parámetros.
     */
    public function obtenerParametros() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consultapar = $this->_conexion->select("select * from fn_parametros_obtenerparametros() as (id varchar,nombre varchar,valor varchar);");
            $cont = 0;
            $arrayParametros = Array();
            while ($cont < count($consultapar)) {
                $arrayParametros[$consultapar[$cont][0]] = htmlspecialchars_decode($consultapar[$cont][2], ENT_QUOTES);
                $cont++;
            }
            return $arrayParametros;
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

}

?>
