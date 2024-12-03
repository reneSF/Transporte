<?php /*
    require_once '../controllers/boletoController.php';
    require_once '../middleware/authMiddleware.php';

    $BoletoControler = new BoletoControler();

    $app->post('/productos', function() use ($BoletoControler){
        $data = json_decode(file_get_contents("php://input"), true);
    })*/

    
require_once '../controllers/boletoController.php';
require_once '../middleware/authMiddleware.php';
require_once '../vendor/autoload.php';


use Slim\Factory\AppFactory;



// Instancia del controlador
$boletoController = new BoletoController();

// Ruta para crear un producto (en este caso, un boleto)
$app->post('/productos', function ($request, $response) use ($boletoController) {
    // Middleware: verifica el token antes de procesar la solicitud
    $authResult = AuthMiddleware::verificadorToken();
    if ($authResult['codigo'] !== 200) {
        $response->getBody()->write(json_encode(['error' => $authResult['mensaje']]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($authResult['codigo']);
    }

    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode($request->getBody(), true);

    // Validar datos (puedes personalizar esto según los campos requeridos)
    if (!isset($data['origen']) || !isset($data['nombre_vendedor']) || !isset($data['numero_serie']) || !isset($data['precio'])) {
        $response->getBody()->write(json_encode(['error' => 'Datos incompletos']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Crear el boleto usando el controlador
    $resultado = $boletoController->crearBoleto($data);

    // Retornar la respuesta
    if ($resultado) {
        $response->getBody()->write(json_encode(['mensaje' => 'Boleto creado exitosamente']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    } else {
        $response->getBody()->write(json_encode(['error' => 'Error al crear el boleto']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});

// Ejecutar la aplicación
$app->run();
?>