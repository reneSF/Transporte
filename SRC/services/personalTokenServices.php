<?php
class TokenService {
    private $secretKey = 'clave_super_segura'; // Cambiar por una clave segura
    private $expirationTime = 3600; // Tiempo de expiración en segundos (1 hora)

    // Generar un nuevo token
    public function generarToken($data) {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode([
            'data' => $data,
            'exp' => time() + $this->expirationTime // Agregar tiempo de expiración
        ]));

        $signature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    // Verificar un token
    public function verificarToken($token) {
        try {
            $parts = explode('.', $token);

            if (count($parts) !== 3) {
                return false; // Token mal formado
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

            return $decodedPayload; // Retorna el contenido del token si es válido
        } catch (Exception $e) {
            return false; // Retornar false en caso de cualquier error
        }
    }

    // Refrescar un token antes de que expire
    public function refrescarToken($token) {
        $decoded = $this->verificarToken($token);
        if ($decoded) {
            return $this->generarToken($decoded['data']); // Generar un nuevo token con los mismos datos
        }
        return false; // Retornar false si el token no es válido
    }
}
?>
