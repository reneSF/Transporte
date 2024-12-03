<?php 
    class TokenService {
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
                return falce
            }
        }
    }
?>