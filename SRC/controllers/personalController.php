<?php
require_once '../repositories/PersonalRepository.php';

class PersonalController {
    private $repository;

    public function __construct() {
        $this->repository = new PersonalRepository('localhost', 'mi_base_datos', 'mi_usuario', 'mi_password');
    }

    public function crearPersonal($data) {
        $personal = new personal();
        $personal->nombre = $data['nombre'];
        $personal->apellidos = $data['apellidos'];
        $personal->tipo_identificacion = $data['tipo_identificacion'];
        $personal->numero_documento = $data['numero_documento'];
        $personal->genero = $data['genero'];
        $personal->fecha_nacimiento = $data['fecha_nacimiento'];
        $personal->numero_celular = $data['numero_celular'];
        $personal->direccion = $data['direccion'];
        $personal->perfil = $data['perfil'];

        return $this->repository->crearPersonal($personal);
    }

    public function actualizarPersonal($data) {
        $personal = new personal();
        $personal->personal_id = $data['personal_id'];
        $personal->nombre = $data['nombre'];
        $personal->apellidos = $data['apellidos'];
        $personal->tipo_identificacion = $data['tipo_identificacion'];
        $personal->numero_documento = $data['numero_documento'];
        $personal->genero = $data['genero'];
        $personal->fecha_nacimiento = $data['fecha_nacimiento'];
        $personal->numero_celular = $data['numero_celular'];
        $personal->direccion = $data['direccion'];
        $personal->perfil = $data['perfil'];

        return $this->repository->actualizarPersonal($personal);
    }

    public function borrarPersonal($personal_id) {
        return $this->repository->borrarPersonal($personal_id);
    }

    public function obtenerPersonal() {
        return $this->repository->obtenerPersonal();
    }

    public function obtenerPersonalPorID($personal_id) {
        return $this->repository->obtenerPersonalPorID($personal_id);
    }

    public function obtenerPersonalporNombre($nombre) {
        return $this->repository->obtenerPersonalporNombre($nombre);
    }

    public function obtenerPersonalporApellidos($apellidos) {
        return $this->repository->obtenerPersonalporApellidos($apellidos);
    }

    public function ObtenerEmpleadosPorRol($perfil) {
        return $this->repository->ObtenerEmpleadosPorRol($perfil);
    }
}
?>
