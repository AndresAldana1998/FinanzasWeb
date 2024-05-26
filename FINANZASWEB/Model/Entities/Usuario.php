<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "finanzasweb/Libs/config.php";

class ActiveRecord {
    // Definición de la clase
}
class Usuario extends ActiveRecord{
    
    public $cedula;
    public $clave;
    public $nombre;
    public $email;
}
