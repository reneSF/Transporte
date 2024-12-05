<?php
require_once '../controllers/RutasController.php';

class Middleware {
    public static function validarRutaData($data) {
        return isset($data['origen'], $data['destino']);
    }
}
?>
