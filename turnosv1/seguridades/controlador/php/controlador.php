<?php

error_reporting(\E_ERROR);

/**
 * Función que valida el envio correcto de parámetros (A través del método POST)
 */
function errordeparametros() {
    $arreglo[0] = array('reg' => -3);
    echo '' . json_encode($arreglo) . '';
}

/**
 * Condición que recibe una petición de la vista para el modelo,
 * y recibe una respuesta del modelo para la vista.
 */
if (isset($_POST['accion'])) {
    include_once('../../modelo/php/modelo.php');
    switch ($_REQUEST['accion']) {
        case 'mantenersesion':
            $controlador = new Usuario();
            $controlador->ActualizarInformacionUsuario();
            break;
        //Usuarios
        case 'verificarmenu':
            if (isset($_POST['opcion'])) {
                $informacion = new Usuario();
                $informacion->VerificarMenu($_POST['opcion']);
            } else {
                errordeparametros();
            }
            break;
        case 'actualizarinformacionparametros':
            $controlador = new Usuario();
            $controlador->ActualizarParametrosSocket();
            break;
        case 'actualizarinformacionusuario':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Usuario();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->ActualizarInformacionUsuarioSocket();
            } else {
                errordeparametros();
            }
            break;
        case 'cargarperfilesnuevousuario':
            $controlador = new Usuario();
            $controlador->ConsultarPerfiles();
            break;
        case 'cargarmodulosnuevousuario':
            $controlador = new Usuario();
            $controlador->ConsultarModulos();
            break;
        case 'cargarmenu':
            $controlador = new Usuario();
            $controlador->ObtenerOpciones();
            break;
        case 'verificarusuario':
            if (isset($_POST['usuario']) && isset($_POST['clave'])) {
                $controlador = new Usuario();
                $controlador->setUsuario(filter_var($_POST['usuario'], FILTER_SANITIZE_STRING));
                $controlador->setClave(filter_var($_POST['clave'], FILTER_SANITIZE_STRING));
                $controlador->VerificarUsuario();
            } else {
                errordeparametros();
            }
            break;
        case 'editarclavelogin':
            if (isset($_POST['usuario']) && isset($_POST['clavenueva']) && isset($_POST['clave'])) {
                $controlador = new Usuario();
                $controlador->setUsuario(filter_var($_POST['usuario'], FILTER_SANITIZE_STRING));
                $controlador->setClaveNueva(filter_var($_POST['clavenueva'], FILTER_SANITIZE_STRING));
                $controlador->setClave(filter_var($_POST['clave'], FILTER_SANITIZE_STRING));
                $controlador->EditarClaveLogin();
            } else {
                errordeparametros();
            }
            break;
        case 'salir':
            $controlador = new Usuario();
            $controlador->salir();
            break;
        case 'cambiarestadousuario':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Usuario();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CambiarestadoUsuario();
            } else {
                errordeparametros();
            }
            break;
        case 'listarusuarios':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new Usuario();
                $controlador->BuscarUsuarios(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'nuevousuario':
            if (isset($_POST['modulo']) && isset($_POST['perfiles']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['cedula']) && isset($_POST['clave']) && isset($_POST['email']) && isset($_POST['foto'])) {
                if (((filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['email'] != "")) || $_POST['email'] == "") {
                    $controlador = new Usuario();
                    $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                    $controlador->setApellido(filter_var($_POST['apellido'], FILTER_SANITIZE_STRING));
                    $controlador->setCedula(filter_var($_POST['cedula'], FILTER_SANITIZE_STRING));
                    $controlador->setClave(filter_var($_POST['clave'], FILTER_SANITIZE_STRING));
                    $controlador->setEmail(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
                    $controlador->setFoto(filter_var($_POST['foto'], FILTER_SANITIZE_STRING));
                    $controlador->setPerfil("'" . '{"' . implode('", "', $_POST['perfiles']) . '"}' . "'");
                    $controlador->setModulo(filter_var($_POST['modulo'], FILTER_SANITIZE_NUMBER_INT));
                    $controlador->NuevoUsuario();
                } else {
                    errordeparametros();
                }
            } else {
                errordeparametros();
            }
            break;
        case 'cargarfotoeditarusuario':
            if (isset($_POST['usuario']) && filter_var($_POST['usuario'], FILTER_VALIDATE_INT)) {
                $controlador = new Usuario();
                $controlador->setId(filter_var($_POST['usuario'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CargarFotoEditar();
            } else {
                errordeparametros();
            }
            break;
        case 'cargarperfileseditarusuario':
            if (isset($_POST['usuario'])) {
                $controlador = new Usuario();
                $controlador->setId($_POST['usuario']);
                $controlador->ConsultarPerfileseEditar();
            } else {
                errordeparametros();
            }
            break;
        case 'cargarmoduloseditarusuario':
            if (isset($_POST['usuario'])) {
                $controlador = new Usuario();
                $controlador->setId($_POST['usuario']);
                $controlador->ConsultarPerfileseEditar();
            } else {
                errordeparametros();
            }
            break;
        case 'editarusuario':
            if (isset($_POST['modulo']) && isset($_POST['perfiles']) && isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['cedula']) && isset($_POST['clave']) && isset($_POST['email']) && isset($_POST['foto']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                if (((filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['email'] != "")) || $_POST['email'] == "") {
                    $controlador = new Usuario();
                    $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                    $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                    $controlador->setApellido(filter_var($_POST['apellido'], FILTER_SANITIZE_STRING));
                    $controlador->setCedula(filter_var($_POST['cedula'], FILTER_SANITIZE_STRING));
                    $controlador->setClave(filter_var($_POST['clave'], FILTER_SANITIZE_STRING));
                    $controlador->setEmail(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
                    $controlador->setFoto(filter_var($_POST['foto'], FILTER_SANITIZE_STRING));
                    $controlador->setPerfil("'" . '{"' . implode('", "', $_POST['perfiles']) . '"}' . "'");
                    $controlador->setModulo(filter_var($_POST['modulo'], FILTER_SANITIZE_NUMBER_INT));
                    $controlador->EditarUsuario();
                } else {
                    errordeparametros();
                }
            } else {
                errordeparametros();
            }
            break;
        //Perfiles
        case 'listarperfiles':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new Perfil ();
                $controlador->ListaInformacionPerfiles(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'cambiarestadoperfil':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Perfil ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CambiaEstadoPerfil();
            } else {
                errordeparametros();
            }
            break;
        case 'nuevoperfil':
            if (isset($_POST['nombre']) && isset($_POST['acronimo'])) {
                $controlador = new Perfil ();
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->setAcronimo(filter_var($_POST['acronimo'], FILTER_SANITIZE_STRING));
                $controlador->NuevoPerfil();
            } else {
                errordeparametros();
            }
            break;
        case 'editarperfil':
            if (isset($_POST['id']) && isset($_POST['nombre']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Perfil ();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->EditarPerfil();
            } else {
                errordeparametros();
            }
            break;

        //Opciones
        case 'cargarperfilesnuevo':
            $controlador = new Opciones();
            $controlador->ConsultarPerfiles();
            break;
        case 'cargarperfileseditar':
            if (isset($_POST['opcion'])) {
                $controlador = new Opciones();
                $controlador->setId($_POST['opcion']);
                $controlador->ConsultarPerfileseEditar();
            } else {
                errordeparametros();
            }
            break;
        case 'listaropciones':
            if (isset($_POST['busqueda']) && isset($_POST['pagina']) && filter_var($_POST['pagina'], FILTER_VALIDATE_INT)) {
                $controlador = new Opciones();
                $controlador->ListaInformacionOpciones(filter_var($_POST['pagina'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING));
            } else {
                errordeparametros();
            }
            break;
        case 'cambiarestadoopciones':
            if (isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Opciones();
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->CambiaEstadoOpcion();
            } else {
                errordeparametros();
            }
            break;
        case 'nuevaopcion':
            if (isset($_POST['fullscreen']) && isset($_POST['perfiles']) && isset($_POST['nombre']) && isset($_POST['acronimo']) && isset($_POST['vista']) && isset($_POST['icono'])) {
                $controlador = new Opciones();
                $controlador->setFullScreen(filter_var($_POST['fullscreen'], FILTER_SANITIZE_STRING));
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->setAcronimo(filter_var($_POST['acronimo'], FILTER_SANITIZE_STRING));
                $controlador->setIcono(filter_var($_POST['icono'], FILTER_SANITIZE_STRING));
                $controlador->setVista(filter_var($_POST['vista'], FILTER_SANITIZE_STRING));
                $controlador->setPerfil("'" . '{"' . implode('", "', $_POST['perfiles']) . '"}' . "'");
                $controlador->NuevaOpcion();
            } else {
                errordeparametros();
            }
            break;
        case 'editaropcion':
            if (isset($_POST['perfiles']) && isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['acronimo']) && isset($_POST['vista']) && isset($_POST['icono']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
                $controlador = new Opciones();
                $controlador->setFullScreen(filter_var($_POST['fullscreen'], FILTER_SANITIZE_STRING));
                $controlador->setId(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
                $controlador->setNombre(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
                $controlador->setAcronimo(filter_var($_POST['acronimo'], FILTER_SANITIZE_STRING));
                $controlador->setIcono(filter_var($_POST['icono'], FILTER_SANITIZE_STRING));
                $controlador->setVista(filter_var($_POST['vista'], FILTER_SANITIZE_STRING));
                $controlador->setPerfil("'" . '{"' . implode('", "', $_POST['perfiles']) . '"}' . "'");
                $controlador->EditarOpcion();
            } else {
                errordeparametros();
            }
            break;
        default:
            errordeparametros();
    }
}
?>

