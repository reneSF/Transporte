<?php
require_once '../controllers/PersonalController.php';
require_once '../vendor/autoload.php';

use Slim\Factory\AppFactory;



// Ruta para crear un personal
$app->post('/api/personal/crear', function ($request, $response, $args) {
    $controller = new PersonalController();
    $data = json_decode($request->getBody(), true);

    if (!$data) {
        $response->getBody()->write(json_encode(['error' => 'Datos inválidos']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $resultado = $controller->crearPersonal($data);

    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Personal creado exitosamente']));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al crear el personal']));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

// Ruta para obtener todos los registros de personal
$app->get('/api/personal/obtener', function ($request, $response, $args) {
    $controller = new PersonalController();
    $resultado = $controller->obtenerPersonal();

    $response->getBody()->write(json_encode($resultado));
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta para obtener un personal por ID
$app->get('/api/personal/{id}', function ($request, $response, $args) {
    $controller = new PersonalController();
    $personal_id = $args['id'];
    $resultado = $controller->obtenerPersonalPorID($personal_id);

    if ($resultado) {
        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Personal no encontrado']));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }
});

// Ruta para actualizar un personal
$app->put('/api/personal/actualizar', function ($request, $response, $args) {
    $controller = new PersonalController();
    $data = json_decode($request->getBody(), true);

    if (!$data || !isset($data['personal_id'])) {
        $response->getBody()->write(json_encode(['error' => 'Datos inválidos o falta el ID']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $resultado = $controller->actualizarPersonal($data);

    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Personal actualizado exitosamente']));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al actualizar el personal']));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

// Ruta para eliminar un personal
$app->delete('/api/personal/eliminar', function ($request, $response, $args) {
    $controller = new PersonalController();
    $data = json_decode($request->getBody(), true);

    if (!$data || !isset($data['personal_id'])) {
        $response->getBody()->write(json_encode(['error' => 'Falta el ID del personal']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $resultado = $controller->borrarPersonal($data['personal_id']);

    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Personal eliminado exitosamente']));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al eliminar el personal']));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

// Manejo de rutas no encontradas
$app->any('/{routes:.+}', function ($request, $response) {
    $response->getBody()->write(json_encode(['error' => 'Ruta no encontrada']));
    return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
});

$app->run();
?>
