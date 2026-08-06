<?php
require_once __DIR__ . '/../config/Database.php';

class BaseDAO extends Database
{
    protected $tableName;

    public function __construct($tableName)
    {
        parent::__construct();
        $this->tableName = $tableName;
    }

    // Thực thi câu lệnh SQL trả về kết quả
    protected function executeQuery($sql)
    {
        try {
            $result = $this->conn->query($sql);
            return $result;
        } catch (Exception $e) {
            die("Lỗi truy vấn: " . $e->getMessage());
        }
    }

    // Thực thi Prepared Statement với tham số
    protected function executePrepared($sql, $types, ...$params)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Lỗi prepare: " . $this->conn->error);
            }
            if (!empty($types)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            die("Lỗi Prepared Statement: " . $e->getMessage());
        }
    }

    // Đếm tổng số bản ghi
    public function count()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->tableName}";
            $result = $this->conn->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    // Xóa theo id
    public function deleteById($id)
    {
        try {
            $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            die("Lỗi xóa: " . $e->getMessage());
        }
    }

    // Bắt đầu Transaction
    public function beginTransaction()
    {
        $this->conn->begin_transaction();
    }

    // Commit Transaction
    public function commitTransaction()
    {
        $this->conn->commit();
    }

    // Rollback Transaction
    public function rollbackTransaction()
    {
        $this->conn->rollback();
    }
}
?>
