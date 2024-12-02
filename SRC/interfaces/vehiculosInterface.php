<?php 
interface IVehiculo {
    public function crearVehiculo($vehiculo);
    public function actualizarVehiculo($vehiculo);
    public function borrarVehiculo($vehiculo_id);
    public function obtenerVehiculo();
    public function obtenerVehiculoPorID($vehiculo_id);
}
?>