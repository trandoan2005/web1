<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tranvandoan_mydb1";
    private $port = 3306;
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8mb4");
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
