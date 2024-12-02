<?php
require_once '../repositories/boletoboletoRepository.php';


class BoletoController {
    private $boletoRepository;

    // Constructor que inicializa el repositorio
    public function __construct($host, $dbname, $username, $password) {
        $this->boletoRepository = new boletoRepository($host, $dbname, $username, $password);
    }

    // Crear un nuevo boleto
    public function crearBoleto($data) {
        $boleto = new boleto();
        $boleto->origen = $data['origen'];
        $boleto->nombre_vendedor = $data['nombre_vendedor'];
        $boleto->numero_serie = $data['numero_serie'];
        $boleto->terminal_id = $data['terminal_id'];
        $boleto->precio = $data['precio'];

        return $this->boletoRepository->crearBoleto($boleto);
    }

    // Actualizar un boleto existente
    public function actualizarBoleto($data) {
        $boleto = new boleto();
        $boleto->boleto_id = $data['boleto_id'];
        $boleto->origen = $data['origen'];
        $boleto->nombre_vendedor = $data['nombre_vendedor'];
        $boleto->numero_serie = $data['numero_serie'];
        $boleto->terminal_id = $data['terminal_id'];
        $boleto->precio = $data['precio'];

        return $this->boletoRepository->actualizarBoleto($boleto);
    }

    // Eliminar un boleto
    public function borrarBoleto($boleto_id) {
        return $this->boletoRepository->borrarBoleto($boleto_id);
    }

    // Obtener todos los boletos
    public function obtenerBoletos() {
        return $this->boletoRepository->obtenerBoleto();
    }

    // Obtener un boleto por ID
    public function obtenerBoletoPorID($boleto_id) {
        return $this->boletoRepository->obtenerBoletoPorID($boleto_id);
    }
}

// Ejemplo de uso del controlador
try {
    // Inicializar el controlador
    $controller = new BoletoController('localhost', 'Transportes', 'root', 'password');

    // Crear un boleto
    $nuevoBoleto = [
        'origen' => 'Ciudad A',
        'nombre_vendedor' => 'Pedro González',
        'numero_serie' => 'SER12345',
        'terminal_id' => 1,
        'precio' => 150.75
    ];
    $controller->crearBoleto($nuevoBoleto);

    // Obtener todos los boletos
    $boletos = $controller->obtenerBoletos();
    foreach ($boletos as $boleto) {
        echo "ID: {$boleto->boleto_id}, Origen: {$boleto->origen}, Precio: {$boleto->precio}\n";
    }

    // Actualizar un boleto
    $boletoActualizado = [
        'boleto_id' => 1,
        'origen' => 'Ciudad B',
        'nombre_vendedor' => 'Pedro González',
        'numero_serie' => 'SER12345',
        'terminal_id' => 1,
        'precio' => 200.00
    ];
    $controller->actualizarBoleto($boletoActualizado);

    // Eliminar un boleto
    $controller->borrarBoleto(1);

    // Obtener un boleto por ID
    $boletoPorID = $controller->obtenerBoletoPorID(2);
    if ($boletoPorID) {
        echo "Boleto encontrado: {$boletoPorID->origen}, Precio: {$boletoPorID->precio}\n";
    } else {
        echo "Boleto no encontrado.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
