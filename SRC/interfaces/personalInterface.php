<?php 
    interface IPersonal {
        public function crearPersonal($boleto);
        public function actualizarPersonal($boleto);
        public function borrarPersonal($boleto_id);
        public function obtenerPersonal();
        public function obtenerPersonalPorID($boleto_id);
    }
?>