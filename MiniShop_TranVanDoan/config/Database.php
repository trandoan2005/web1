<?php
namespace Config;

class Database
{
    private $host = "localhost";
    private $database = "tranvandoan_database";
    private $username = "root";
    private $password = "";
    public $conn;
    
    private static $sharedConn = null;

    public function __construct()
    {
        if (self::$sharedConn === null) {
            try {
                self::$sharedConn = new \mysqli($this->host, $this->username, $this->password, $this->database);

                if (self::$sharedConn->connect_error) {
                    throw new \Exception("Kết nối thất bại: " . self::$sharedConn->connect_error);
                }

                self::$sharedConn->set_charset("utf8mb4");
            } catch (\Exception $e) {
                die("Lỗi kết nối CSDL: " . $e->getMessage());
            }
        }
        $this->conn = self::$sharedConn;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>
