<?php
require_once '../repositories/vehiculoRepository.php';
require_once '../middlewares/AuthMiddleware.php';

$host = "tu_host";
$dbname = "tu_base_de_datos";
$username = "tu_usuario";
$password = "tu_contrasena";

$vehiculoRepo = new vehiculoRepository($host, $dbname, $username, $password);

// Middleware para validar autenticación
$auth = AuthMiddleware::verificadorToken();
if ($auth['codigo'] !== 200) {
    http_response_code($auth['codigo']);
    echo json_encode($auth['mensaje']);
    exit;
}

// Obtener todos los vehículos
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode($vehiculoRepo->obtenerVehiculo());
    exit;
}

// Obtener vehículo por ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $vehiculo_id = $_GET['id'];
    $vehiculo = $vehiculoRepo->obtenerVehiculoPorID($vehiculo_id);

    if ($vehiculo) {
        header('Content-Type: application/json');
        echo json_encode($vehiculo);
    } else {
        http_response_code(404);
        echo json_encode(['mensaje' => 'Vehículo no encontrado']);
    }
    exit;
}

// Crear un nuevo vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = json_decode(file_get_contents('php://input'));

    $vehiculo = new vehiculos();
    $vehiculo->nombre_propietario = $datos->nombre_propietario;
    $vehiculo->tarjeta_circulacion = $datos->tarjeta_circulacion;
    $vehiculo->numero_placa = $datos->numero_placa;
    $vehiculo->clase = $datos->clase;
    $vehiculo->marca = $datos->marca;
    $vehiculo->ano_fabricacion = $datos->ano_fabricacion;
    $vehiculo->modelo = $datos->modelo;
    $vehiculo->combustible = $datos->combustible;
    $vehiculo->carroceria = $datos->carroceria;
    $vehiculo->ejes = $datos->ejes;
    $vehiculo->color = $datos->color;
    $vehiculo->numero_motor = $datos->numero_motor;
    $vehiculo->cilindros = $datos->cilindros;
    $vehiculo->numero_serie = $datos->numero_serie;
    $vehiculo->cantidad_ruedas = $datos->cantidad_ruedas;
    $vehiculo->peso_seco = $datos->peso_seco;
    $vehiculo->peso_bruto = $datos->peso_bruto;
    $vehiculo->longitud = $datos->longitud;
    $vehiculo->altura = $datos->altura;
    $vehiculo->ancho = $datos->ancho;
    $vehiculo->total_pasajeros = $datos->total_pasajeros;

    $resultado = $vehiculoRepo->crearVehiculo($vehiculo);

    if ($resultado) {
        http_response_code(201);
        echo json_encode(['mensaje' => 'Vehículo creado exitosamente']);
    } else {
        http_response_code(500);
        echo json_encode(['mensaje' => 'Error al crear el vehículo']);
    }
    exit;
}

// Actualizar un vehículo
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $datos = json_decode(file_get_contents('php://input'));
    $vehiculo_id = $_GET['id'];

    $vehiculo = $vehiculoRepo->obtenerVehiculoPorID($vehiculo_id);
    if (!$vehiculo) {
        http_response_code(404);
        echo json_encode(['mensaje' => 'Vehículo no encontrado']);
        exit;
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

    $resultado = $vehiculoRepo->actualizarVehiculo($vehiculo);

    if ($resultado) {
        echo json_encode(['mensaje' => 'Vehículo actualizado exitosamente']);
    } else {
        http_response_code(500);
        echo json_encode(['mensaje' => 'Error al actualizar el vehículo']);
    }
    exit;
}

// Borrar un vehículo
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $vehiculo_id = $_GET['id'];
    $resultado = $vehiculoRepo->borrarVehiculo($vehiculo_id);

    if ($resultado) {
        echo json_encode(['mensaje' => 'Vehículo eliminado exitosamente']);
    } else {
        http_response_code(500);
        echo json_encode(['mensaje' => 'Error al eliminar el vehículo']);
    }
    exit;
}

// Si ninguna ruta coincide
http_response_code(405);
echo json_encode(['mensaje' => 'Método no permitido']);
?>
