<?php
class TokenService {
    private $secretKey = 'clave_super_secreta';
    private $expirationTime = 3600;

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

    public function verificarToken($token) {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return false;
            }

            [$header, $payload, $signature] = $parts;

            $validSignature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
            $validSignature = base64_encode($validSignature);

            if ($signature !== $validSignature) {
                return false;
            }

            $decodedPayload = json_decode(base64_decode($payload), true);
            if (isset($decodedPayload['exp']) && $decodedPayload['exp'] < time()) {
                return false;
            }

            return $decodedPayload;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
