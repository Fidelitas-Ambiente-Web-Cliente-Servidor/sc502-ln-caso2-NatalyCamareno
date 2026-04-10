
<?php
class Database {
    private $host = "db"; 
    private $port = "1521";
    private $db_name = "XE";
    private $username = "system";
    private $password = "system";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $tns = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$this->host})(PORT={$this->port}))(CONNECT_DATA=(SERVICE_NAME={$this->db_name})))";
            $this->conn = new PDO("oci:dbname=" . $tns . ";charset=UTF8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
        }
        return $this->conn;
    }
}