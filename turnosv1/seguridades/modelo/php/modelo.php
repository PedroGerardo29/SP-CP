<?php

include_once ('../../../configuracion/configuracion.php');
include_once ('../../../configuracion/conexionlogin.php');

class Usuario {

    /**
     * Modulo del usuario.
     * @var Integer 
     */
    private $_modulo;

    /**
     * Nombre del usuario.
     * @var String 
     */
    private $_nombre;

    /**
     * Apellido del usuario.
     * @var String 
     */
    private $_apellido;

    /**
     * Cédula del usuario.
     * @var String
     */
    private $_cedula;

    /**
     * Clave del usuario.
     * @var String 
     */
    private $_clave;

    /**
     * Email del usuario.
     * @var String 
     */
    private $_email;

    /**
     * Perfíl del usuario.
     * @var Integer
     */
    private $_perfil;

    /**
     * Nickname del usuario.
     * @var String 
     */
    private $_usuario;

    /**
     * Id del usuario.
     * @var Numeric
     */
    private $_id;

    /**
     * Clave del usuario.
     * @var String 
     */
    private $_clavenueva;

    /**
     * Estado del usuario.
     * @var String 
     */
    private $_estado;

    /**
     * Foto del usuario
     * @var Bytea 
     */
    private $_foto;

    /**
     * Método que permite enviar el módulo del usuario.
     * @param Integer $modulo
     */
    public function setModulo($modulo) {
        $this->_modulo = $modulo;
    }

    /**
     * Método que permite obtener el módulo del usuario.
     * @return Integer
     */
    public function getModulo() {
        return $this->_modulo;
    }

    /**
     * Método que permite enviar la foto del usuario.
     * @param String $foto
     */
    public function setFoto($foto) {
        $this->_foto = $foto;
    }

    /**
     * Método que permite obtener  la foto del usuario.
     * @return string
     */
    public function getFoto() {
        return $this->_foto;
    }

    /**
     * Método que permite enviar el estado del usuario.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener  el estado del usuario.
     * @return string
     */
    public function getEstado() {
        return $this->_estado;
    }

    /**
     * Método que permite enviar la clave del usuario.
     * @param String $clavenueva
     */
    public function setClaveNueva($clavenueva) {
        $this->_clavenueva = $clavenueva;
    }

    /**
     * Método que permite obtener la clave del usuario.
     * @return string
     */
    public function getClaveNueva() {
        return $this->_clavenueva;
    }

    /**
     * Método que permite enviar id del usuario.
     * @param Integer $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener el el id del usuario.
     * @return Integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Método que permite enviar nickname del usuario.
     * @param String $usuario
     */
    public function setUsuario($usuario) {
        $this->_usuario = $usuario;
    }

    /**
     * Método que permite obtener el el nickname del usuario.
     * @return String
     */
    public function getUsuario() {
        return $this->_usuario;
    }

    /**
     *  Método que permite enviar perfíl usuario.
     * @param Integer $perfil
     */
    public function setPerfil($perfil) {
        $this->_perfil = $perfil;
    }

    /**
     * Método que permite obtener el perfíl usuario.
     * @return Integer
     */
    public function getPerfil() {
        return $this->_perfil;
    }

    /**
     *  Método que permite enviar email del usuario.
     * @param String $email
     */
    public function setEmail($email) {
        $this->_email = $email;
    }

    /**
     * Método que permite obtener el email del usuario.
     * @return String
     */
    public function getEmail() {
        return $this->_email;
    }

    /**
     * Método que permite enviar la clave del usuario.
     * @param String $clave
     */
    public function setClave($clave) {
        $this->_clave = $clave;
    }

    /**
     * Método que permite obtener la clave del usuario.
     * @return String
     */
    public function getClave() {
        return $this->_clave;
    }

    /**
     * Método que permite enviar la cédula del  usuario.
     * @param String $cedula
     */
    public function setCedula($cedula) {
        $this->_cedula = $cedula;
    }

    /**
     * Método que permite obtener la cédula del usuario.
     * @return String
     */
    public function getCedula() {
        return $this->_cedula;
    }

    /**
     * Método que permite enviar el apellido del usuario.
     * @param String $apellido
     */
    public function setApellido($apellido) {
        $this->_apellido = $apellido;
    }

    /**
     * Método que permite obtener el apellido del usuario.
     * @return type
     */
    public function getApellido() {
        return $this->_apellido;
    }

    /**
     * Método que permite enviar el nombre del usuario.
     * @param String $nombre
     */
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }

    /**
     * Método que permite obtener el nombre del usuario.
     * @return String
     */
    public function getNombre() {
        return $this->_nombre;
    }

    /**
     * Constructor de la clase.
     */
    public function Usuario() {
        
    }

    /**
     * Método retorna información de usuarios.
     * @param Integer $pagina
     * @param String $busqueda
     */
    public function BuscarUsuarios($pagina, $busqueda) {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_usuarios_contarregistrosbusqueda('" . $busqueda . "');");
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
                $this->_conexion = ConexionLogin::getConnection();
                $resultado = $this->_conexion->select("select * from fn_usuarios_buscarusuarios('" . $busqueda . "'," . $inicio . ',' . $limite . ") as(usuario varchar,nombre varchar,apellido varchar,email varchar,estado boolean,id integer,modulo integer);");
                $cont = 0;
                while ($cont < count($resultado)) {
                    $arreglo[$cont] = array(
                        'cedula' => htmlspecialchars_decode($resultado[$cont][0], ENT_QUOTES),
                        'nombres' => htmlspecialchars_decode($resultado[$cont][1], ENT_QUOTES),
                        'apellidos' => htmlspecialchars_decode($resultado[$cont][2], ENT_QUOTES),
                        'email' => htmlspecialchars_decode($resultado[$cont][3], ENT_QUOTES),
                        'estado' => $resultado[$cont][4], 
                        'id' => $resultado[$cont][5],
                        'modulo' => $resultado[$cont][6], 
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
     * Método que cambia el estado de un usuario.
     */
    public function CambiarestadoUsuario() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_usuarios_cambiarestadousuario(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que guarda un nuevo usuario.
     */
    public function NuevoUsuario() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            if ($this->getFoto() == "") {
                $imagenDefecto = file_get_contents('../../../includes/img/imagenUsuarioDefecto.png');
                $imdata = base64_encode($imagenDefecto);
                $foto = 'data:image/x-png;base64,' . $imdata;
                $this->setFoto($foto);
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_usuarios_crearusuario('" . $this->getNombre() . "','" . $this->getApellido() . "','" . $this->getCedula() . "','" . $this->getClave() . "','" . $this->getEmail() . "','" . $this->getFoto() . "'," . $this->getPerfil() . "," . $this->getModulo() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite cargar los perfiles para editar.
     */
    public function ConsultarPerfileseEditar() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_usuarios_cargarperfileseditarusuario(" . $this->getId() . ") as(id integer,nombre varchar,estado integer)");
            if (count($consulta) == 0) {
                $arreglo[0] = array('reg' => -1);
            } else {
                $cont = 0;
                while ($cont < count($consulta)) {
                    $arreglo[$cont] = array(
                        'reg' => 1,
                        'id' => $consulta[$cont][0],
                        'nombre' => htmlspecialchars_decode($consulta [$cont][1], ENT_QUOTES),
                        'estado' => $consulta [$cont][2]
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
     * Método que permite guarda la edición de la información del usuario.
     */
    public function EditarUsuario() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_usuarios_editarusuario('" . $this->getNombre() . "','" . $this->getApellido() . "','" . $this->getCedula() . "','" . $this->getClave() . "','" . $this->getEmail() . "'," . $this->getId() . ",'" . $this->getFoto() . "'," . $this->getPerfil() . "," . $this->getModulo() . "," . $_SESSION['usuid'] . ");");
            if (count($consulta) == 0) {
                $arreglo[0] = array(
                    'reg' => -1);
            } else {
                $arreglo[0] = array('reg' => $consulta[0][0]);
                echo '' . json_encode($arreglo) . '';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que guarda la nueva clave del usuario.
     */
    public function EditarClave() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_usuarios_editarclave('" . $this->getUsuario() . "','" . $this->getClave() . "','" . $this->getClaveNueva() . "');");
            $arreglo[0] = array('reg' => $consulta[0][0]);
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => "-2");
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que verifica si el usuario para el inicio de sesión.
     * @return boolean
     */
    public function VerificarUsuario() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_usuarios_verificarusuario('" . $this->getUsuario() . "','" . $this->getClave() . "');");
            $resultado = $consulta[0][0];
            if ($resultado == 1) {
                $this->_conexion = ConexionLogin::getConnection();
                $resultado2 = $this->_conexion->select("select * from fn_usuarios_obtenerinformacion('" . $this->getUsuario() . "')as (usuid integer,usunom varchar,usuape varchar,foto text,email varchar);");
                $_SESSION['usuid'] = $resultado2[0][0];
                $_SESSION['nombre'] = htmlspecialchars_decode($resultado2[0][1], ENT_QUOTES);
                $_SESSION['apellido'] = htmlspecialchars_decode($resultado2[0][2], ENT_QUOTES);
                $_SESSION['usuario'] = htmlspecialchars_decode($this->getUsuario(), ENT_QUOTES);
                $_SESSION['foto'] = base64_decode($resultado2[0][3]);
                $_SESSION['email'] = htmlspecialchars_decode($resultado2[0][4], ENT_QUOTES);
                $arreglo[0] = array('reg' => 1);
                $_SESSION['vses_opciones'] = $this->ObtenerInformacionPermisos($this->getUsuario());
                $_SESSION[$this->obtenervarlogin()] = $this->getUsuario();
                $this->ActualizarParametros();
                echo '' . json_encode($arreglo) . '';
                return true;
            } else {
                $this->salir();
                $arreglo[0] = array('reg' => $resultado);
                echo '' . json_encode($arreglo) . '';
                return false;
            }
        } catch (Exception $e) {
            $this->salir();
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
            return false;
        }
    }

    /**
     * Método que actualiza la información de usuario en sesión.
     */
    public function ActualizarInformacionUsuario() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->_conexion = ConexionLogin::getConnection();
        $resultado2 = $this->_conexion->select("select * from fn_usuarios_obtenerinformacion('" . $_SESSION['usuario'] . "')as (usuid integer,usunom varchar,usuape varchar,foto text,email varchar);");
        $_SESSION['usuid'] = $resultado2[0][0];
        $_SESSION['nombre'] = htmlspecialchars_decode($resultado2[0][1], ENT_QUOTES);
        $_SESSION['apellido'] = htmlspecialchars_decode($resultado2[0][2], ENT_QUOTES);
        $_SESSION['foto'] = base64_decode($resultado2[0][3]);
        $_SESSION['email'] = htmlspecialchars_decode($resultado2[0][4], ENT_QUOTES);
    }

    /**
     * Método que actualiza la información de usuario en sesión.
     */
    public function ActualizarInformacionUsuarioSocket() {
        $this->ActualizarInformacionUsuario();
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->getId() == $_SESSION['usuid']) {
            $arreglo[0] = array(
                'reg' => 1,
                'nombre' => $_SESSION['nombre'],
                'apellido' => $_SESSION['apellido'],
                'foto' => $_SESSION['foto'],
                'email' => $_SESSION['email']
            );
        } else {
            $arreglo[0] = array(
                'reg' => -1
            );
        }
        echo '' . json_encode($arreglo) . '';
    }

    /**
     * Método que permite buscar perfiles .
     */
    public function ConsultarPerfiles() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_usuarios_buscarperfiles()as (id integer,nombre varchar);");
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
                        'nombre' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
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
     * Método que permite buscar módulos.
     */
    public function ConsultarModulos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_usuarios_buscarmodulos()as (id integer);");
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
     * Método que obtiene los permisos de usuario en sesión.
     * @return Integer
     */
    public function ObtenerInformacionPermisos() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $resultado3 = $this->_conexion->select("select * from fn_usuarios_cargaropcioneslogin('" . $this->getUsuario() . "') as(opc_id integer,opc_nom varchar,opc_acr varchar,opc_vis varchar,opc_ico varchar,opc_ful boolean);");
            $contadorperfiles = 0;
            while ($contadorperfiles < count($resultado3)) {
                $arregloperfiles[$contadorperfiles] = array(
                    'id' => $resultado3[$contadorperfiles][0],
                    'nombre' => htmlspecialchars_decode($resultado3[$contadorperfiles][1], ENT_QUOTES),
                    'acronimo' => htmlspecialchars_decode($resultado3[$contadorperfiles][2], ENT_QUOTES),
                    'vista' => htmlspecialchars_decode($resultado3[$contadorperfiles][3], ENT_QUOTES),
                    'icono' => htmlspecialchars_decode($resultado3[$contadorperfiles][4], ENT_QUOTES),
                    'fullscreen' => $resultado3[$contadorperfiles][5]
                );
                $contadorperfiles++;
            }
            return $arregloperfiles;
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite actualizar los permisos de usuarios en sesión.
     */
    public function ActualizarPermisos() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $resultado3 = $this->_conexion->select("select * from fn_usuarios_cargaropcioneslogin('" . $_SESSION['usuario'] . "') as(opc_id integer,opc_nom varchar,opc_acr varchar,opc_vis varchar,opc_ico varchar,opc_ful boolean);");
            $contadorperfiles = 0;
            while ($contadorperfiles < count($resultado3)) {
                $arregloperfiles[$contadorperfiles] = array(
                    'id' => $resultado3[$contadorperfiles][0],
                    'nombre' => htmlspecialchars_decode($resultado3[$contadorperfiles][1], ENT_QUOTES),
                    'acronimo' => htmlspecialchars_decode($resultado3[$contadorperfiles][2], ENT_QUOTES),
                    'vista' => htmlspecialchars_decode($resultado3[$contadorperfiles][3], ENT_QUOTES),
                    'icono' => htmlspecialchars_decode($resultado3[$contadorperfiles][4], ENT_QUOTES),
                    'fullscreen' => $resultado3[$contadorperfiles][5]
                );
                $contadorperfiles++;
            }
            $_SESSION['vses_opciones'] = $arregloperfiles;
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite verificar el módulo corrrespondiente.
     * @param type $opcion
     */
    public function VerificarMenu($opcion) {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $resultado3 = $this->_conexion->select("select * from fn_usuarios_cargaropcioneslogin('" . $_SESSION['usuario'] . "') as(opc_id integer,opc_nom varchar,opc_acr varchar,opc_vis varchar,opc_ico varchar,opc_ful boolean);");
            $contadorperfiles = 0;
            while ($contadorperfiles < count($resultado3)) {
                if ($resultado3[$contadorperfiles][2] == $opcion) {
                    $arreglo[0] = array('reg' => 1);
                    echo '' . json_encode($arreglo) . '';
                    die();
                }
                $contadorperfiles++;
            }
            $arreglo[0] = array('reg' => 0);
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite verificar el módulo corrrespondiente.
     * @param type $opcion
     */
    public function VerificarMenuServidor($opcion) {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $resultado3 = $this->_conexion->select("select * from fn_usuarios_cargaropcioneslogin('" . $_SESSION['usuario'] . "') as(opc_id integer,opc_nom varchar,opc_acr varchar,opc_vis varchar,opc_ico varchar,opc_ful boolean);");
            $contadorperfiles = 0;
            while ($contadorperfiles < count($resultado3)) {
                if ($resultado3[$contadorperfiles][2] == $opcion) {
                    return 1;
                    die();
                }
                $contadorperfiles++;
            }
            return 0;
        } catch (Exception $e) {
            return -2;
        }
    }

    /**
     * Método que permite obtener las opciones correspondientes a un usuario.
     */
    public function ObtenerOpciones() {
        if (!isset($_SESSION)) {
            session_start();
        }
        echo json_encode($_SESSION['vses_opciones']);
    }

    /**
     * Método que permite actualizar los parámetros.
     */
    public function ActualizarParametrosSocket() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consultapar = $this->_conexion->select("select * from fn_parametros_obtenerparametros() as (id varchar,nombre varchar,valor varchar);");
            $cont = 0;
            while ($cont < count($consultapar)) {
                $_SESSION[$consultapar[$cont][0]] = htmlspecialchars_decode($consultapar[$cont][2], ENT_QUOTES);
                $cont++;
            }
            $arreglo[0] = array('reg' => 1);
            echo '' . json_encode($arreglo) . '';
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite actualizar los parámetros.
     */
    public function ActualizarParametros() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexion = ConexionLogin::getConnection();
            $consultapar = $this->_conexion->select("select * from fn_parametros_obtenerparametros() as (id varchar,nombre varchar,valor varchar);");
            $cont = 0;
            while ($cont < count($consultapar)) {
                $_SESSION[$consultapar[$cont][0]] = htmlspecialchars_decode($consultapar[$cont][2], ENT_QUOTES);
                $cont++;
            }
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => -2);
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Función que permite la edición de la clave del usuario al loguearse.
     */
    public function EditarClaveLogin() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select fn_usuarios_editarclave('" . $this->getUsuario() . "','"
                    . $this->getClave() . "','" . $this->getClaveNueva() . "');");

            if ($consulta[0][0] == 1) {
                $this->setClave($this->getClaveNueva());
                $this->VerificarUsuario();
            } else {
                $arreglo2[0] = array('reg' => $consulta[0][0]);
                echo '' . json_encode($arreglo2) . '';
            }
        } catch (Exception $e) {
            $arreglo[0] = array('reg' => "-2");
            echo $e->getMessage();
            echo '' . json_encode($arreglo) . '';
        }
    }

    /**
     * Método que permite cargar la foto de un usuario para la edición.
     */
    public function CargarFotoEditar() {
        try {
            $this->_conexionLogin = ConexionLogin::getConnection();
            $consulta = $this->_conexionLogin->select("select * from fn_usuarios_cargarfotoeditarsuario(" . $this->getId() . ") as (foto text);");
            if (count($consulta) == 0) {
                $arreglo[0] = array('reg' => -1);
            } else {
                $cont = 0;
                while ($cont < count($consulta)) {
                    $arreglo[$cont] = array(
                        'reg' => 1,
                        'foto' => base64_decode($consulta[$cont][0])
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
     * Método que sirve para verficar la sesión del usuario.
     * @return string
     */
    private function obtenervarlogin() {
        $clave = 'sistema';
        $retvar = md5($clave);
        $retvar = 'clave_' . substr($retvar, 0, 15);
        return $retvar;
    }

    /**
     * Método que permite verificar si se ha iniciado sesión.
     * @return boolean
     */
    public function VerificarLogin() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sessionvar = $this->obtenervarlogin();
        if (empty($_SESSION[$sessionvar])) {
            return false;
        }
        return TRUE;
    }

    /**
     * Método que permite cerrar sesión.
     */
    public function salir() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sessionvar = $this->obtenervarlogin();
        $_SESSION[$sessionvar] = NULL;
        unset($_SESSION[$sessionvar]);
        session_destroy();
    }

    /**
     * Método que permite redireccionar página si se ha cerrado la sesión.
     * @param type $url
     */
    public function RedireccionarURL($url) {
        header("Location:$url");
        exit;
    }

}

class Perfil {

    /**
     * Nombre del perfíl.
     * @var String 
     */
    private $_nombre;

    /**
     * Acronimo del perfíl.
     * @var String 
     */
    private $_acronimo;

    /**
     * Estado del perfíl.
     * @var String 
     */
    private $_estado;

    /**
     * Id del perfíl.
     * @var Integer
     */
    private $_id;

    /**
     * Método que permite enviar id del perfíl.
     * @param Numeric $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener el id del perfíl.
     * @return Numeric
     */
    public function getId() {
        return $this->_id;
    }

    /**
     *  Método que permite enviar estado del perfíl.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener el estado del perfíl.
     * @return String
     */
    public function getEstado() {
        return $this->_estado;
    }

    /**
     * Método que permite enviar el acronimo del perfíl.
     * @param String $acronimo
     */
    public function setAcronimo($acronimo) {
        $this->_acronimo = $acronimo;
    }

    /**
     * Método que permite obtener el acronimo del perfíl.
     * @return String
     */
    public function getAcronimo() {
        return $this->_acronimo;
    }

    /**
     * Método que permite enviar el nombre del perfil.
     * @param String $nombre
     */
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }

    /**
     * Método que permite obtener el nombre del perfil.
     * @return String
     */
    public function getNombre() {
        return $this->_nombre;
    }

    /**
     * Constructor de la clase.
     */
    public function Perfil() {
        
    }

    /**
     *  Método que lista la información de perfiles.
     * @param int $pagina
     * @param type $busqueda
     */
    public function ListaInformacionPerfiles($pagina, $busqueda) {
        try {
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_perfiles_contarregistrosbusqueda('" . $busqueda . "');");
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
                $informacionusuarios = $this->_conexionlogin->select("select * from fn_perfiles_buscarperfiles('" . $busqueda . "'," . $inicio . "," . $limite . ")as (rol_id integer,rol_nom varchar,rol_acr varchar,rol_est varchar);");
                $cont = 0;
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'acronimo' => htmlspecialchars_decode($informacionusuarios[$cont][2], ENT_QUOTES),
                        'estado' => $informacionusuarios[$cont][3],
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
     * Metodo que permite cambiar el estado del perfíl.
     */
    public function CambiaEstadoPerfil() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_perfiles_cambiarestadoperfil(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite crear un nuevo perfíl.
     */
    public function NuevoPerfil() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select * from fn_perfiles_crearperfil('" . $this->getNombre() . "','" . $this->getAcronimo() . "'," . $_SESSION['usuid'] . ");");
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
     * Método que permite editar perfiles.
     */
    public function EditarPerfil() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionlogin = Conexionlogin::getConnection();
            $consulta = $this->_conexionlogin->select("select fn_perfiles_editarperfil('" . $this->getNombre() . "'," . $this->getId() . "," . $_SESSION['usuid'] . ");");
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

class Opciones {

    /**
     * Nombre de la opción.
     * @var String 
     */
    private $_nombre;

    /**
     * Perfíles de la opción.
     * @var String 
     */
    private $_perfil;

    /**
     * Acrónimo de la opción.
     * @var String 
     */
    private $_acronimo;

    /**
     * Icono del opción.
     * @var String
     */
    private $_icono;

    /**
     * Vista de la opción.
     * @var String 
     */
    private $_vista;

    /**
     * Estado de la opción.
     * @var String 
     */
    private $_estado;

    /**
     * Id de la opción
     * @var Integer
     */
    private $_id;

    /**
     * FullScreen de la opción
     * @var Boolean
     */
    private $_fullscreen;

    /**
     * Método que permite enviar los perfiles de la opción.
     * @param String $perfil
     */
    public function setPerfil($perfil) {
        $this->_perfil = $perfil;
    }

    /**
     * Método que permite obtener los perfiles de la opción.
     * @return string
     */
    public function getPerfil() {
        return $this->_perfil;
    }

    /**
     * Método que permite enviar la vista de la opción.
     * @param String $vista
     */
    public function setVista($vista) {
        $this->_vista = $vista;
    }

    /**
     * Método que permite obtener la vista de la opción.
     * @return String
     */
    public function getVista() {
        return $this->_vista;
    }

    /**
     * Método que permite enviar id de la opción.
     * @param Integer $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Método que permite obtener el id de la opción.
     * @return Integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     *  Método que permite enviar estado de la opción.
     * @param String $estado
     */
    public function setEstado($estado) {
        $this->_estado = $estado;
    }

    /**
     * Método que permite obtener el estado de la opción.
     * @return String
     */
    public function getEstado() {
        return $this->_estado;
    }

    /**
     * Método que permite enviar la cédula de la  opción.
     * @param String $icono
     */
    public function setIcono($icono) {
        $this->_icono = $icono;
    }

    /**
     * Método que permite obtener la cédula de la opción.
     * @return String
     */
    public function getIcono() {
        return $this->_icono;
    }

    /**
     * Método que permite enviar el acronimo de la opción.
     * @param String $acronimo
     */
    public function setAcronimo($acronimo) {
        $this->_acronimo = $acronimo;
    }

    /**
     * Método que permite obtener el acronimo de la opción.
     * @return String
     */
    public function getAcronimo() {
        return $this->_acronimo;
    }

    /**
     * Método que permite enviar el nombre del opción.
     * @param String $nombre
     */
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }

    /**
     * Método que permite obtener el nombre del opción.
     * @return String
     */
    public function getNombre() {
        return $this->_nombre;
    }

    /**
     * Método que permite enviar el fullscreen de la opcion.
     * @param Boolean $fullscreen
     */
    public function setFullScreen($fullscreen) {
        $this->_fullscreen = $fullscreen;
    }

    /**
     * Método que permite obtener el fullscreen de la opcion.
     * @return Boolean
     */
    public function getFullScreen() {
        return $this->_fullscreen;
    }

    /**
     * Constructor de la clase.
     */
    public function Opciones() {
        
    }

    /**
     * Función que carga la lista de opciones.
     * @param Integer $pagina
     * @param String $busqueda
     */
    public function ListaInformacionOpciones($pagina, $busqueda) {
        try {
            $this->_conexionLogin = ConexionLogin::getConnection();
            $consulta = $this->_conexionLogin->select("select * from fn_opciones_contarregistrosbusqueda('" . $busqueda . "');");
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
                $informacionusuarios = $this->_conexionLogin->select("select * from fn_opciones_buscaropciones('" . $busqueda . "'," . $inicio . "," . $limite . ")as (id integer,nombre varchar,acronimo varchar,icono varchar,vista varchar,estado varchar,ful boolean);");
                $cont = 0;
                while ($cont < count($informacionusuarios)) {
                    $arreglo[$cont] = array(
                        'id' => $informacionusuarios[$cont][0],
                        'nombre' => htmlspecialchars_decode($informacionusuarios[$cont][1], ENT_QUOTES),
                        'acronimo' => htmlspecialchars_decode($informacionusuarios[$cont][2], ENT_QUOTES),
                        'icono' => htmlspecialchars_decode($informacionusuarios[$cont][3], ENT_QUOTES),
                        'vista' => htmlspecialchars_decode($informacionusuarios[$cont][4], ENT_QUOTES),
                        'estado' => $informacionusuarios[$cont][5],
                        'full' =>$informacionusuarios[$cont][6],
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
     * Función que permite cambiar el estado de una opción.
     */
    public function CambiaEstadoOpcion() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionLogin = ConexionLogin::getConnection();
            $consulta = $this->_conexionLogin->select("select fn_opciones_cambiarestadoopcion(" . $this->getId() . "," . $_SESSION['usuid'] . ");");
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
     * Función que permite guardar una nueva opción.
     */
    public function NuevaOpcion() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionLogin = ConexionLogin::getConnection();
            $consulta = $this->_conexionLogin->select("select * from fn_opciones_crearopcion('" . $this->getNombre() . "','" . $this->getAcronimo() . "','" . $this->getIcono() . "','" . $this->getVista() . "'," . $this->getPerfil() . "," . $this->getFullScreen() . "," . $_SESSION['usuid'] . ");");
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
     * Método que permite ocnsultar perfiles para edición.
     */
    public function ConsultarPerfileseEditar() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_opciones_cargarperfileseditaropcion(" . $this->getId() . ") as(id integer,nombre varchar,estado integer)");
            if (count($consulta) == 0) {
                $arreglo[0] = array('reg' => -1);
            } else {
                $cont = 0;
                while ($cont < count($consulta)) {
                    $arreglo[$cont] = array(
                        'reg' => 1,
                        'id' => $consulta[$cont][0],
                        'nombre' => htmlspecialchars_decode($consulta [$cont][1], ENT_QUOTES),
                        'estado' => $consulta [$cont][2]
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
     * Método que permite consultar perfiles.
     */
    public function ConsultarPerfiles() {
        try {
            $this->_conexion = ConexionLogin::getConnection();
            $consulta = $this->_conexion->select("select * from fn_opciones_buscarperfiles()as (id integer,nombre varchar);");
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
                        'nombre' => htmlspecialchars_decode($consulta[$cont][1], ENT_QUOTES),
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
     * Función que permite guardar una nueva opción
     */
    public function EditarOpcion() {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->_conexionLogin = ConexionLogin::getConnection();
            $consulta = $this->_conexionLogin->select("select fn_opciones_editaropcion('" . $this->getNombre() . "','" . $this->getAcronimo() . "','" . $this->getIcono() . "','" . $this->getVista() . "'," . $this->getId() . "," . $this->getPerfil() . "," . $this->getFullScreen() . "," . $_SESSION['usuid'] . ");");
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