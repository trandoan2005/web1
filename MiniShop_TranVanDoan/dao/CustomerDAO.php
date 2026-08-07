<?php
require_once __DIR__ . '/BaseDAO.php';
require_once __DIR__ . '/../models/Customer.php';

class CustomerDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('customers');
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM customers";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE fullname LIKE ?";
            }
            $sql .= " ORDER BY id ASC";
            
            if (!empty($keyword)) {
                $searchParam = "%" . $keyword . "%";
                $stmt = $this->executePrepared($sql, "s", $searchParam);
                $result = $stmt->get_result();
            } else {
                $result = $this->executeQuery($sql);
            }
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = new Customer($row['id'], $row['fullname'], $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM customers WHERE id = ?";
            $stmt = $this->executePrepared($sql, "i", $id);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new Customer($row['id'], $row['fullname'], $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(Customer $c)
    {
        try {
            $sql = "INSERT INTO customers (fullname, email, phone, address, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "ssssi", $c->fullname, $c->email, $c->phone, $c->address, $c->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Customer $c)
    {
        try {
            $sql = "UPDATE customers SET fullname = ?, email = ?, phone = ?, address = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "ssssii", $c->fullname, $c->email, $c->phone, $c->address, $c->status, $c->id);
            return $stmt->affected_rows >= 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->deleteById($id);
    }
}
?>
