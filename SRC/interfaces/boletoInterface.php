<?php 
interface IBoleto {
    public function crearBoleto($boleto);
    public function actualizarBoleto($boleto);
    public function borrarBoleto($boleto_id);
    public function obtenerBoleto();
    public function obtenerBoletoPorID($boleto_id);
}
?>