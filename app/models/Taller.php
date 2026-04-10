
<?php
class Taller {
    private $conn;
    private $table_name = "TALLER"; 

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllDisponibles() {
        try {
            $query = "SELECT ID_TALLER, NOMBRE, DESCRIPCION, FECHA, CUPO 
                      FROM " . $this->table_name . " 
                      WHERE CUPO > 0";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getAllDisponibles: " . $e->getMessage());
            return [];
        }
    }
}