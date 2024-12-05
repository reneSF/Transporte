<?php
require_once '../controllers/RutasController.php';
require_once '../middleware/middleware.php';
require_once '../vendor/autoload.php';

use Slim\Factory\AppFactory;



$app->post('/api/rutas/crear', function ($request, $response) {
    $controller = new RutasController('localhost', 'mi_base', 'mi_usuario', 'mi_password');
    $data = json_decode($request->getBody(), true);

    if (!Middleware::validarRutaData($data)) {
        $response->getBody()->write(json_encode(['error' => 'Datos inválidos']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $resultado = $controller->crearRuta($data);
    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Ruta creada exitosamente']));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al crear la ruta']));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

$app->get('/api/rutas/obtener', function ($request, $response) {
    $controller = new RutasController('localhost', 'mi_base', 'mi_usuario', 'mi_password');
    $resultado = $controller->obtenerRuta();

    $response->getBody()->write(json_encode($resultado));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/api/rutas/actualizar', function ($request, $response) {
    $controller = new RutasController('localhost', 'mi_base', 'mi_usuario', 'mi_password');
    $data = json_decode($request->getBody(), true);

    if (!Middleware::validarRutaData($data) || !isset($data['ruta_id'])) {
        $response->getBody()->write(json_encode(['error' => 'Datos inválidos o falta el ID']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $resultado = $controller->actualizarRuta($data);
    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Ruta actualizada exitosamente']));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al actualizar la ruta']));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

$app->delete('/api/rutas/eliminar', function ($request, $response) {
    $controller = new RutasController('localhost', 'mi_base', 'mi_usuario', 'mi_password');
    $data = json_decode($request->getBody(), true);

    if (!isset($data['ruta_id'])) {
        $response->getBody()->write(json_encode(['error' => 'Falta el ID de la ruta']));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $resultado = $controller->borrarRuta($data['ruta_id']);
    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Ruta eliminada exitosamente']));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al eliminar la ruta']));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
});

$app->run();
?>
