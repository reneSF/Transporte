<?php
interface IEnvios {
    public function crearEnvios($Envios);
    public function actualizarEnvios($Envios);
    public function borrarEnvios($enivo_id);
    public function obtenerEnvio();
    public function obtenerEnvioPorID($envio_id);
}
?>