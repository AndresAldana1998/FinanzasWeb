<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "finanzasweb/Model/Entities/Usuario.php";
require 'vendor/autoload.php';

class UsuarioRepository{
    public static function guardarUsuario($usuario){
        try{
            $usuario->save();
        } catch (Exception $e){
            $msj = explode("\n", $e->getMessage())[0];
            if (strstr($msj, "cannot be null")) {
                $ini = strpos($msj, "'");
                $end = strpos($msj, "'", $ini  + 1);
                $total = $end - $ini;
                $campo = substr($msj, $ini + 1, $total - 1);
                $msj = "El campo" . strtoupper($campo) . "no puede ser null";    
            } else if (strstr($msj, "primary")) {
                $msj = "El usuario con cedula: $usuario->cedula ya existe";
            } else {
                $msj = "Error al guardar el usuario";
            }
            throw new Exception($msj);
        }
    }
    
    public static function buscarUsuario($codigo){
        
        try {
            return Usuario::find($codigo);
        } catch (Exception $e) {
            throw new Exception("El usuario Codigo: $codigo no existe");
        }
    }
}
