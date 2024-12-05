<?php
require_once '../services/TokenService.php';

class AuthMiddleware {
    public static function verificadorToken() {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            return [
                'codigo' => 401,
                'mensaje' => 'Token no proporcionado'
            ];
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $tokenService = new TokenService();

        if (!$tokenService->verificarToken($token)) {
            return [
                'codigo' => 403,
                'mensaje' => 'Token inválido o expirado'
            ];
        }

        return [
            'codigo' => 200,
            'mensaje' => 'Autorización exitosa'
        ];
    }
}
?>
