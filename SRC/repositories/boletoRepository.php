<?php /*
require_once '../config/database.php';
require_once '../interfaces/boletoInterface.php';

class boletoRepository implements IBoleto
{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crearBoleto($boleto) {
        $sql = "INSERT INTO Boletos (ID, Origen, Vendedor, Serie, Terminal) Values(:ID, :Origen,:Vendedor, :Serie, :Terminal)";
    }
}
*/

require_once '../config/database.php';
require_once '../interfaces/boletoInterface.php';

class Repository implements IBoleto {
    private $conexion;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método para crear un nuevo boleto
    public function crearBoleto($boleto) {
        $sql = "INSERT INTO Boletos (origen, nombre_vendedor, numero_serie, terminal_id, precio) 
                VALUES (:origen, :nombre_vendedor, :numero_serie, :terminal_id, :precio)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':origen', $boleto->origen);
        $stmt->bindParam(':nombre_vendedor', $boleto->nombre_vendedor);
        $stmt->bindParam(':numero_serie', $boleto->numero_serie);
        $stmt->bindParam(':terminal_id', $boleto->terminal_id);
        $stmt->bindParam(':precio', $boleto->precio);
        return $stmt->execute();
    }

    // Método para actualizar un boleto existente
    public function actualizarBoleto($boleto) {
        $sql = "UPDATE Boletos 
                SET origen = :origen, nombre_vendedor = :nombre_vendedor, 
                    numero_serie = :numero_serie, terminal_id = :terminal_id, precio = :precio 
                WHERE boleto_id = :boleto_id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':origen', $boleto->origen);
        $stmt->bindParam(':nombre_vendedor', $boleto->nombre_vendedor);
        $stmt->bindParam(':numero_serie', $boleto->numero_serie);
        $stmt->bindParam(':terminal_id', $boleto->terminal_id);
        $stmt->bindParam(':precio', $boleto->precio);
        $stmt->bindParam(':boleto_id', $boleto->boleto_id);
        return $stmt->execute();
    }

    // Método para borrar un boleto
    public function borrarBoleto($boleto_id) {
        $sql = "DELETE FROM Boletos WHERE boleto_id = :boleto_id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':boleto_id', $boleto_id);
        return $stmt->execute();
    }

    // Método para obtener todos los boletos
    public function obtenerBoleto() {
        $sql = "SELECT * FROM Boletos";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'boleto');
    }

    // Método para obtener un boleto por su ID
    public function obtenerBoletoPorID($boleto_id) {
        $sql = "SELECT * FROM Boletos WHERE boleto_id = :boleto_id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':boleto_id', $boleto_id);
        $stmt->execute();
        return $stmt->fetchObject('boleto');
    }
}
/*
class boletoRepository implements IBoleto {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Crear un nuevo boleto
    public function crearBoleto($boleto) {
        $sql = "INSERT INTO Boletos (ID, Origen, Vendedor, Serie, Terminal) 
                VALUES (:ID, :Origen, :Vendedor, :Serie, :Terminal)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID', $boleto['ID']);
        $stmt->bindParam(':Origen', $boleto['Origen']);
        $stmt->bindParam(':Vendedor', $boleto['Vendedor']);
        $stmt->bindParam(':Serie', $boleto['Serie']);
        $stmt->bindParam(':Terminal', $boleto['Terminal']);
        
        if ($stmt->execute()) {
            return "Boleto creado correctamente.";
        } else {
            return "Error al crear el boleto.";
        }
    }

    // Actualizar un boleto existente
    public function actualizarBoleto($boleto) {
        $sql = "UPDATE Boletos 
                SET Origen = :Origen, Vendedor = :Vendedor, Serie = :Serie, Terminal = :Terminal 
                WHERE ID = :ID";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID', $boleto['ID']);
        $stmt->bindParam(':Origen', $boleto['Origen']);
        $stmt->bindParam(':Vendedor', $boleto['Vendedor']);
        $stmt->bindParam(':Serie', $boleto['Serie']);
        $stmt->bindParam(':Terminal', $boleto['Terminal']);

        if ($stmt->execute()) {
            return "Boleto actualizado correctamente.";
        } else {
            return "Error al actualizar el boleto.";
        }
    }

    // Borrar un boleto por ID
    public function borrarBoleto($boleto_id) {
        $sql = "DELETE FROM Boletos WHERE ID = :ID";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID', $boleto_id);

        if ($stmt->execute()) {
            return "Boleto eliminado correctamente.";
        } else {
            return "Error al eliminar el boleto.";
        }
    }

    // Obtener todos los boletos
    public function obtenerBoleto() {
        $sql = "SELECT * FROM Boletos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un boleto por ID
    public function obtenerBoletoPorID($boleto_id) {
        $sql = "SELECT * FROM Boletos WHERE ID = :ID";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID', $boleto_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}*/
?>

