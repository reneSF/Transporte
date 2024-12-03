<?php 
 /*   class TokenService {
        $secretKey = 'Hola';
        $expirationTime = 7200;

        public function generarToken($data) {
            $payload =[
                'data' => $data,
                'exp' => tome() + $this->$expirationTime
            ];
            return JWT::encode($payload, $this->secretKey);
        }

        public function verificarToken($Token) {
            try {
                    $decoded = JWT::decode($token, $this->secretKey, ['HS256']);
                    return(array) $decoded;
            }catch (Exception $e) {
                return falce;
            }
        }
    }*/


require_once 'vendor/autoload.php'; // Asegúrate de tener instalada la biblioteca Firebase JWT

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
    private $secretKey = 'Hola';
    private $expirationTime = 7200; // Tiempo de expiración en segundos

    // Generar un nuevo token
    public function generarToken($data) {
        $payload = [
            'data' => $data,
            'exp' => time() + $this->expirationTime // Tiempo de expiración
        ];
        return JWT::encode($payload, $this->secretKey, 'HS256'); // Codificar con algoritmo HS256
    }

    // Verificar y decodificar un token
    public function verificarToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256')); // Decodificar usando la clave secreta
            return (array) $decoded; // Convertir el objeto decodificado a un arreglo
        } catch (Exception $e) {
            return false; // Retornar false si hay un error en la validación
        }
    }
}
?>



