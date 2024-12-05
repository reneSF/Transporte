<?php
require_once '../models/personal.php';
require_once '../interfaces/IPersonal.php';

class PersonalRepository implements IPersonal {
    private $db;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public function crearPersonal($personal) {
        $sql = "INSERT INTO personal (nombre, apellidos, tipo_identificacion, numero_documento, genero, fecha_nacimiento, numero_celular, direccion, perfil)
                VALUES (:nombre, :apellidos, :tipo_identificacion, :numero_documento, :genero, :fecha_nacimiento, :numero_celular, :direccion, :perfil)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $personal->nombre,
            ':apellidos' => $personal->apellidos,
            ':tipo_identificacion' => $personal->tipo_identificacion,
            ':numero_documento' => $personal->numero_documento,
            ':genero' => $personal->genero,
            ':fecha_nacimiento' => $personal->fecha_nacimiento,
            ':numero_celular' => $personal->numero_celular,
            ':direccion' => $personal->direccion,
            ':perfil' => $personal->perfil
        ]);
        return $this->db->lastInsertId();
    }

    public function actualizarPersonal($personal) {
        $sql = "UPDATE personal SET nombre = :nombre, apellidos = :apellidos, tipo_identificacion = :tipo_identificacion, numero_documento = :numero_documento, 
                genero = :genero, fecha_nacimiento = :fecha_nacimiento, numero_celular = :numero_celular, direccion = :direccion, perfil = :perfil 
                WHERE personal_id = :personal_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':personal_id' => $personal->personal_id,
            ':nombre' => $personal->nombre,
            ':apellidos' => $personal->apellidos,
            ':tipo_identificacion' => $personal->tipo_identificacion,
            ':numero_documento' => $personal->numero_documento,
            ':genero' => $personal->genero,
            ':fecha_nacimiento' => $personal->fecha_nacimiento,
            ':numero_celular' => $personal->numero_celular,
            ':direccion' => $personal->direccion,
            ':perfil' => $personal->perfil
        ]);
    }

    public function borrarPersonal($personal_id) {
        $sql = "DELETE FROM personal WHERE personal_id = :personal_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':personal_id' => $personal_id]);
    }

    public function obtenerPersonal() {
        $sql = "SELECT * FROM personal";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerPersonalPorID($personal_id) {
        $sql = "SELECT * FROM personal WHERE personal_id = :personal_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':personal_id' => $personal_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function obtenerPersonalporNombre($nombre) {
        $sql = "SELECT * FROM personal WHERE nombre LIKE :nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => "%$nombre%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerPersonalporApellidos($apellidos) {
        $sql = "SELECT * FROM personal WHERE apellidos LIKE :apellidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':apellidos' => "%$apellidos%"]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ObtenerEmpleadosPorRol($perfil) {
        $sql = "SELECT * FROM personal WHERE perfil = :perfil";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':perfil' => $perfil]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
