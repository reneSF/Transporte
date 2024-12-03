<?php 
   /* require_once '../services/tokenService.php';

    class AuthMiddleware {
        public static function verificadorToken() {
            $headers = apache_request_headers();
            if (!isset($headers['Authorization'])){
                return ['mensaje'  => 'Token no proporcionado', 'codigo' => 401];
            }
            $token = str_replace('Bearer', '', $headers ['Authorization']);
            $tokenService = new TokenService();
            if (!$tokenService->verificarToken($token))
            {
                return ['mensaje' => 'Token Valido', 'codigo' => 200];
            }
        }
    }*/

    require_once '../services/tokenService.php';

class AuthMiddleware {
    public static function verificadorToken() {
        // Obtener los encabezados de la solicitud
        $headers = apache_request_headers();

        // Validar si el encabezado Authorization está presente
        if (!isset($headers['Authorization'])) {
            return ['mensaje' => 'Token no proporcionado', 'codigo' => 401];
        }

        // Extraer el token del encabezado
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Verificar el token
        $tokenService = new TokenService();
        if (!$tokenService->verificarToken($token)) {
            return ['mensaje' => 'Token inválido', 'codigo' => 401];
        }

        // Si el token es válido, retornar éxito
        return ['mensaje' => 'Token válido', 'codigo' => 200];
    }
}
?>