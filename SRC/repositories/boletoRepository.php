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
}
?>

