<?php 
    interface IPersonal {
        public function crearPersonal($personal_id);
        public function actualizarPersonal($personal);
        public function borrarPersonal($personal_id);
        public function obtenerPersonal();
        public function obtenerPersonalPorID($personal_id);
        public function obtenerPersonalporNombre($nombre);
        public function obtenerPersonalporApellidos($apellidos);
        public function ObtenerEmpleadosPorRol($perfil);
    }
?>