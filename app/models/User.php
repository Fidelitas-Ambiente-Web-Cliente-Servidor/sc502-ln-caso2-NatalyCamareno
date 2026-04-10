
<?php
class User {
    private $conn;
    private $table_name = "USUARIOS";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar($nombre, $correo, $password, $rol = 'usuario') {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        $query = "INSERT INTO " . $this->table_name . " (NOMBRE, CORREO, PASSWORD, ROL) VALUES (:nombre, :correo, :password, :rol)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':rol', $rol);
        
        return $stmt->execute();
    }

    public function login($correo, $password) {
        $query = "SELECT ID, NOMBRE, PASSWORD, ROL FROM " . $this->table_name . " WHERE CORREO = :correo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['PASSWORD'])) {
                return $row;
            }
        }
        return false;
    }
}