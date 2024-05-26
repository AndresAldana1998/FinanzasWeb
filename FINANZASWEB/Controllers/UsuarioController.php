<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "finanzasweb/Model/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "finanzasweb/Repositories/UsuarioRepository.php";

class UsuarioController{
    public static function recuperarAccion()
    {
        $accion = @$_REQUEST['accion'];
        $accion = strtolower($accion);
        switch ($accion) {
            case 'guardar':
                self::guardarUsuario();
                break;
            case 'buscar':
                self::buscarUsuario();
                break;
            case 'login':
                self::iniciarSesion();
                break;
            default:
                $mensaje = self::mensajeError(404, "Accion incorrecta");
                echo $mensaje;
                
        }
    }
    public static function guardarUsuario()
    {
        $cedula = @$_REQUEST['cedula'];
        $clave = @$_REQUEST['clave'];
        $nombre = @$_REQUEST['nombre'];
        $email = @$_REQUEST['email'];

        $usuario = new Usuario();
        $usuario->cedula = (isset($cedula) && !empty($cedula)) ? $cedula : NULL;
        $usuario->clave = (isset($clave) && !empty($clave)) ? $clave : NULL;
        $usuario->nombre = (isset($nombre) && !empty($nombre)) ? $nombre : NULL;
        $usuario->email = (isset($email) && !empty($email)) ? $email : NULL;

        try {
            UsuarioRepository::guardarUsuario($usuario);
            $mensaje = array("codigo" => "200", "mensaje" => "Usuario guardado");
            $mensaje = json_encode($mensaje);
            echo $mensaje;
        } catch (Exception $error) {
            $mensaje = self::mensajeError(500, $error->getMessage());
            echo $mensaje;
        }
    }
     public static function buscarUsuario()
     {
        try {
            $codigo =@$_REQUEST["cedula"];
            $usuario = UsuarioRepository::buscarUsuario($codigo);
            echo $usuario->to_json();
        } catch (Exception $error) {
            $mensaje = self::mensajeError(404, $error->getMessage());
            echo $mensaje;
        }
     }

     public static function mensajeError($codigo, $mensaje)
     {
        $mensaje = array("codigo" => $codigo, "mensaje" => $mensaje);
        $mensaje = json_encode($mensaje);
        return $mensaje;
     }

     public static function iniciarSesion()
     {
        try {
            $codigo =@$_REQUEST["cedula"];
            $clave =@$_REQUEST["pass"];
            $usuario = UsuarioRepository::buscarUsuario($codigo);
            if ($usuario->clave == $clave) {
                $respuesta = array("codigo" => 200, "mensaje" => "Saludos $usuario->nombre");
                echo json_encode($respuesta);
            } else {
                $respuesta = array("codigo" => 204, "mensaje" => "Datos de accesos incorrectos");
                echo json_encode($respuesta);
            }

        } catch (Exception $error) {
            $mensaje = self::mensajeError(404, $error->getMessage());
            echo $mensaje;
        }
     }
}

UsuarioController::recuperarAccion();