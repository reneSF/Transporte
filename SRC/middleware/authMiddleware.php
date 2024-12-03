<?php 
    require_once '../services/tokenService.php';

    class AuthMiddleware {
        public static function verificadorToken() {
            $headers = apache_request_headers();
            if (!isset($headers['Authorization'])){
                return ['mensaje'  => 'Token no proporcionado', 'codigo' => 401];
            }
            
        }
    }
?>