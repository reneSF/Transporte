<?php 
interface IRutas {
    public function crearRuta($Rutas);
    public function actualizarRuta($Rutas);
    public function borrarRuta($ruta_id);
    public function obtenerRuta();
    public function obtenerRutaPorID($ruta_id);

}
?>