<?php
require_once '../controllers/PersonalController.php';

header("Content-Type: application/json");

$controller = new PersonalController();

// Verifica el método de la solicitud
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Rutas disponibles
switch ($path) {
    case '/api/personal/crear':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (validarDatosCrear($data)) {
                $resultado = $controller->crearPersonal($data);
                if ($resultado) {
                    echo json_encode(['mensaje' => 'Personal creado exitosamente']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al crear el personal']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Datos inválidos']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    case '/api/personal/obtener':
        if ($method === 'GET') {
            $resultado = $controller->obtenerPersonal();
            echo json_encode($resultado);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    case '/api/personal/actualizar':
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (validarDatosActualizar($data)) {
                $resultado = $controller->actualizarPersonal($data);
                if ($resultado) {
                    echo json_encode(['mensaje' => 'Personal actualizado exitosamente']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al actualizar el personal']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Datos inválidos']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    case '/api/personal/eliminar':
        if ($method === 'DELETE') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['personal_id'])) {
                $resultado = $controller->borrarPersonal($data['personal_id']);
                if ($resultado) {
                    echo json_encode(['mensaje' => 'Personal eliminado exitosamente']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al eliminar el personal']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID del personal no proporcionado']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Ruta no encontrada']);
        break;
}

// Función para validar los datos al crear un personal
function validarDatosCrear($data) {
    return isset($data['nombre'], $data['apellidos'], $data['tipo_identificacion'], $data['numero_documento'], $data['perfil']);
}

// Función para validar los datos al actualizar un personal
function validarDatosActualizar($data) {
    return isset($data['personal_id'], $data['nombre'], $data['apellidos'], $data['tipo_identificacion'], $data['numero_documento'], $data['perfil']);
}
?>
