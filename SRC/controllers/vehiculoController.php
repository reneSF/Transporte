<?php
require_once '../repositories/vehiculoRepository.php';

class VehiculoController {
    private $vehiculoRepo;

    public function __construct($host, $dbname, $username, $password) {
        $this->vehiculoRepo = new vehiculoRepository($host, $dbname, $username, $password);
    }

    // Obtener todos los vehículos
    public function obtenerVehiculos() {
        try {
            $vehiculos = $this->vehiculoRepo->obtenerVehiculo();
            echo json_encode($vehiculos);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error al obtener los vehículos', 'error' => $e->getMessage()]);
        }
    }

    // Obtener un vehículo por ID
    public function obtenerVehiculoPorID($id) {
        try {
            $vehiculo = $this->vehiculoRepo->obtenerVehiculoPorID($id);
            if ($vehiculo) {
                echo json_encode($vehiculo);
            } else {
                http_response_code(404);
                echo json_encode(['mensaje' => 'Vehículo no encontrado']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error al obtener el vehículo', 'error' => $e->getMessage()]);
        }
    }

    // Crear un nuevo vehículo
    public function crearVehiculo($datos) {
        try {
            $vehiculo = new vehiculos();
            $vehiculo->nombre_propietario = $datos->nombre_propietario ?? null;
            $vehiculo->tarjeta_circulacion = $datos->tarjeta_circulacion ?? null;
            $vehiculo->numero_placa = $datos->numero_placa ?? null;
            $vehiculo->clase = $datos->clase ?? null;
            $vehiculo->marca = $datos->marca ?? null;
            $vehiculo->ano_fabricacion = $datos->ano_fabricacion ?? null;
            $vehiculo->modelo = $datos->modelo ?? null;
            $vehiculo->combustible = $datos->combustible ?? null;
            $vehiculo->carroceria = $datos->carroceria ?? null;
            $vehiculo->ejes = $datos->ejes ?? null;
            $vehiculo->color = $datos->color ?? null;
            $vehiculo->numero_motor = $datos->numero_motor ?? null;
            $vehiculo->cilindros = $datos->cilindros ?? null;
            $vehiculo->numero_serie = $datos->numero_serie ?? null;
            $vehiculo->cantidad_ruedas = $datos->cantidad_ruedas ?? null;
            $vehiculo->peso_seco = $datos->peso_seco ?? null;
            $vehiculo->peso_bruto = $datos->peso_bruto ?? null;
            $vehiculo->longitud = $datos->longitud ?? null;
            $vehiculo->altura = $datos->altura ?? null;
            $vehiculo->ancho = $datos->ancho ?? null;
            $vehiculo->total_pasajeros = $datos->total_pasajeros ?? null;

            $resultado = $this->vehiculoRepo->crearVehiculo($vehiculo);

            if ($resultado) {
                http_response_code(201);
                echo json_encode(['mensaje' => 'Vehículo creado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['mensaje' => 'Error al crear el vehículo']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error al crear el vehículo', 'error' => $e->getMessage()]);
        }
    }

    // Actualizar un vehículo
    public function actualizarVehiculo($id, $datos) {
        try {
            $vehiculo = $this->vehiculoRepo->obtenerVehiculoPorID($id);
            if (!$vehiculo) {
                http_response_code(404);
                echo json_encode(['mensaje' => 'Vehículo no encontrado']);
                return;
            }

            $vehiculo->nombre_propietario = $datos->nombre_propietario ?? $vehiculo->nombre_propietario;
            $vehiculo->tarjeta_circulacion = $datos->tarjeta_circulacion ?? $vehiculo->tarjeta_circulacion;
            $vehiculo->numero_placa = $datos->numero_placa ?? $vehiculo->numero_placa;
            $vehiculo->clase = $datos->clase ?? $vehiculo->clase;
            $vehiculo->marca = $datos->marca ?? $vehiculo->marca;
            $vehiculo->ano_fabricacion = $datos->ano_fabricacion ?? $vehiculo->ano_fabricacion;
            $vehiculo->modelo = $datos->modelo ?? $vehiculo->modelo;
            $vehiculo->combustible = $datos->combustible ?? $vehiculo->combustible;
            $vehiculo->carroceria = $datos->carroceria ?? $vehiculo->carroceria;
            $vehiculo->ejes = $datos->ejes ?? $vehiculo->ejes;
            $vehiculo->color = $datos->color ?? $vehiculo->color;
            $vehiculo->numero_motor = $datos->numero_motor ?? $vehiculo->numero_motor;
            $vehiculo->cilindros = $datos->cilindros ?? $vehiculo->cilindros;
            $vehiculo->numero_serie = $datos->numero_serie ?? $vehiculo->numero_serie;
            $vehiculo->cantidad_ruedas = $datos->cantidad_ruedas ?? $vehiculo->cantidad_ruedas;
            $vehiculo->peso_seco = $datos->peso_seco ?? $vehiculo->peso_seco;
            $vehiculo->peso_bruto = $datos->peso_bruto ?? $vehiculo->peso_bruto;
            $vehiculo->longitud = $datos->longitud ?? $vehiculo->longitud;
            $vehiculo->altura = $datos->altura ?? $vehiculo->altura;
            $vehiculo->ancho = $datos->ancho ?? $vehiculo->ancho;
            $vehiculo->total_pasajeros = $datos->total_pasajeros ?? $vehiculo->total_pasajeros;

            $resultado = $this->vehiculoRepo->actualizarVehiculo($vehiculo);

            if ($resultado) {
                echo json_encode(['mensaje' => 'Vehículo actualizado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['mensaje' => 'Error al actualizar el vehículo']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error al actualizar el vehículo', 'error' => $e->getMessage()]);
        }
    }

    // Borrar un vehículo
    public function borrarVehiculo($id) {
        try {
            $resultado = $this->vehiculoRepo->borrarVehiculo($id);

            if ($resultado) {
                echo json_encode(['mensaje' => 'Vehículo eliminado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['mensaje' => 'Error al eliminar el vehículo']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Error al eliminar el vehículo', 'error' => $e->getMessage()]);
        }
    }
}
?>
