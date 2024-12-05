<?php
class TokenService {
    private $clave_secreta = "tu_clave_secreta";

    public function generarToken($datos) {
        return base64_encode(json_encode($datos));
    }

    public function verificarToken($token) {
        $datos = json_decode(base64_decode($token), true);
        return isset($datos); // Asegúrate de agregar más validaciones
    }
}
?>
