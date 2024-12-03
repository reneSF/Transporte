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


/*require_once 'vendor/autoload.php'; // Asegúrate de tener instalada la biblioteca Firebase JWT

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
}*/



class TokenService {
    private $secretKey = 'secreto_super_seguro'; // Cambia por una clave más segura
    private $expirationTime = 7200; // Tiempo de expiración en segundos (2 horas)

    // Generar un nuevo token
    public function generarToken($data) {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode([
            'data' => $data,
            'exp' => time() + $this->expirationTime
        ]));

        $signature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    // Verificar y decodificar un token
    public function verificarToken($token) {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return false; // El token no tiene la estructura correcta
            }

            [$header, $payload, $signature] = $parts;

            // Verificar la firma
            $validSignature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
            $validSignature = base64_encode($validSignature);

            if ($signature !== $validSignature) {
                return false; // Firma no válida
            }

            // Decodificar el payload
            $decodedPayload = json_decode(base64_decode($payload), true);

            // Verificar si el token ha expirado
            if (isset($decodedPayload['exp']) && $decodedPayload['exp'] < time()) {
                return false; // Token expirado
            }

            return $decodedPayload; // Retornar el contenido del token si es válido
        } catch (Exception $e) {
            return false; // Retornar false si ocurre algún error
        }
    }
}
?>


?>



