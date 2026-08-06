<?php
class Database
{
    private $host = "localhost";
    private $database = "tranvandoan_database";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->conn->connect_error) {
                throw new Exception("Kết nối thất bại: " . $this->conn->connect_error);
            }

            $this->conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Lỗi kết nối Database: " . $e->getMessage());
        }
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
