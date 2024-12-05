<?php
require_once '../interfaces/IVehiculo.php';
require_once '../models/vehiculos.php';

class vehiculoRepository implements IVehiculo {
    private $db;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public function crearVehiculo($vehiculo) {
        $query = "INSERT INTO vehiculos (nombre_propietario, tarjeta_circulacion, numero_placa, clase, marca, ano_fabricacion, modelo, combustible, carroceria, ejes, color, numero_motor, cilindros, numero_serie, cantidad_ruedas, peso_seco, peso_bruto, longitud, altura, ancho, total_pasajeros) 
                  VALUES (:nombre_propietario, :tarjeta_circulacion, :numero_placa, :clase, :marca, :ano_fabricacion, :modelo, :combustible, :carroceria, :ejes, :color, :numero_motor, :cilindros, :numero_serie, :cantidad_ruedas, :peso_seco, :peso_bruto, :longitud, :altura, :ancho, :total_pasajeros)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':nombre_propietario' => $vehiculo->nombre_propietario,
            ':tarjeta_circulacion' => $vehiculo->tarjeta_circulacion,
            ':numero_placa' => $vehiculo->numero_placa,
            ':clase' => $vehiculo->clase,
            ':marca' => $vehiculo->marca,
            ':ano_fabricacion' => $vehiculo->ano_fabricacion,
            ':modelo' => $vehiculo->modelo,
            ':combustible' => $vehiculo->combustible,
            ':carroceria' => $vehiculo->carroceria,
            ':ejes' => $vehiculo->ejes,
            ':color' => $vehiculo->color,
            ':numero_motor' => $vehiculo->numero_motor,
            ':cilindros' => $vehiculo->cilindros,
            ':numero_serie' => $vehiculo->numero_serie,
            ':cantidad_ruedas' => $vehiculo->cantidad_ruedas,
            ':peso_seco' => $vehiculo->peso_seco,
            ':peso_bruto' => $vehiculo->peso_bruto,
            ':longitud' => $vehiculo->longitud,
            ':altura' => $vehiculo->altura,
            ':ancho' => $vehiculo->ancho,
            ':total_pasajeros' => $vehiculo->total_pasajeros,
        ]);
    }

    public function actualizarVehiculo($vehiculo) {
        $query = "UPDATE vehiculos SET nombre_propietario = :nombre_propietario, tarjeta_circulacion = :tarjeta_circulacion, numero_placa = :numero_placa, clase = :clase, marca = :marca, ano_fabricacion = :ano_fabricacion, modelo = :modelo, combustible = :combustible, carroceria = :carroceria, ejes = :ejes, color = :color, numero_motor = :numero_motor, cilindros = :cilindros, numero_serie = :numero_serie, cantidad_ruedas = :cantidad_ruedas, peso_seco = :peso_seco, peso_bruto = :peso_bruto, longitud = :longitud, altura = :altura, ancho = :ancho, total_pasajeros = :total_pasajeros WHERE vehiculo_id = :vehiculo_id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':vehiculo_id' => $vehiculo->vehiculo_id,
            ':nombre_propietario' => $vehiculo->nombre_propietario,
            ':tarjeta_circulacion' => $vehiculo->tarjeta_circulacion,
            ':numero_placa' => $vehiculo->numero_placa,
            ':clase' => $vehiculo->clase,
            ':marca' => $vehiculo->marca,
            ':ano_fabricacion' => $vehiculo->ano_fabricacion,
            ':modelo' => $vehiculo->modelo,
            ':combustible' => $vehiculo->combustible,
            ':carroceria' => $vehiculo->carroceria,
            ':ejes' => $vehiculo->ejes,
            ':color' => $vehiculo->color,
            ':numero_motor' => $vehiculo->numero_motor,
            ':cilindros' => $vehiculo->cilindros,
            ':numero_serie' => $vehiculo->numero_serie,
            ':cantidad_ruedas' => $vehiculo->cantidad_ruedas,
            ':peso_seco' => $vehiculo->peso_seco,
            ':peso_bruto' => $vehiculo->peso_bruto,
            ':longitud' => $vehiculo->longitud,
            ':altura' => $vehiculo->altura,
            ':ancho' => $vehiculo->ancho,
            ':total_pasajeros' => $vehiculo->total_pasajeros,
        ]);
    }

    public function borrarVehiculo($vehiculo_id) {
        $query = "DELETE FROM vehiculos WHERE vehiculo_id = :vehiculo_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':vehiculo_id' => $vehiculo_id]);
    }

    public function obtenerVehiculo() {
        $query = "SELECT * FROM vehiculos";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerVehiculoPorID($vehiculo_id) {
        $query = "SELECT * FROM vehiculos WHERE vehiculo_id = :vehiculo_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':vehiculo_id' => $vehiculo_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
?>
