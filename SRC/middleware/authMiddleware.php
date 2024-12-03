<?php 
    require_once '../services/tokenService.php';

    class AuthMiddleware {
        public static function verificadorToken() {
            $headers = apache_request_headers();
            if (!isset($headers['Authorization'])){
                return ['mensaje'  => 'Token no proporcionado', 'codigo' => 401];
            }
            $token = srt_replace('Bearer', '', $headers ['Authorization']);
            $tokenService = new TokenService();
            if (!tokenService->verificarToken($token))
            {
                return ['mensaje' => 'Token Valido', 'codigo' => 200];
            }
        }
    }
?>