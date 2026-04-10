
<?php
class Solicitud {
    private $conn;
    private $table_name = "SOLICITUDES";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($usuario_id, $taller_id) {
        $query = "SELECT count(*) as TOTAL FROM " . $this->table_name . " WHERE USUARIO_ID = :u AND TALLER_ID = :t";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':u', $usuario_id);
        $stmt->bindParam(':t', $taller_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['TOTAL'] > 0) return false;

        $query = "INSERT INTO " . $this->table_name . " (USUARIO_ID, TALLER_ID, ESTADO) VALUES (:u, :t, 'pendiente')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':u', $usuario_id);
        $stmt->bindParam(':t', $taller_id);
        return $stmt->execute();
    }

    public function actualizarEstado($id, $estado) {
        $query = "UPDATE " . $this->table_name . " SET ESTADO = :estado WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function listarPendientes() {
        $query = "SELECT s.ID, u.NOMBRE as USUARIO, t.NOMBRE as TALLER, t.ID as TALLER_ID, s.ESTADO 
                  FROM " . $this->table_name . " s
                  JOIN USUARIOS u ON s.USUARIO_ID = u.ID
                  JOIN TALLERES t ON s.TALLER_ID = t.ID
                  WHERE s.ESTADO = 'pendiente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}