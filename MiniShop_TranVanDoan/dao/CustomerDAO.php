<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Customer;

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
                $list[] = new Customer($row['id'], $row['fullname'], $row['password'] ?? '', $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
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
                return new Customer($row['id'], $row['fullname'], $row['password'] ?? '', $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(Customer $c)
    {
        try {
            $sql = "INSERT INTO customers (fullname, password, email, phone, address, status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "sssssi", $c->fullname, $c->password, $c->email, $c->phone, $c->address, $c->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Customer $c)
    {
        try {
            $sql = "UPDATE customers SET fullname = ?, password = ?, email = ?, phone = ?, address = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "sssssii", $c->fullname, $c->password, $c->email, $c->phone, $c->address, $c->status, $c->id);
            return $stmt->affected_rows >= 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->deleteById($id);
    }

    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = "")
    {
        $sql = "SELECT * FROM customers WHERE fullname LIKE ? ";
        
        $orderClause = "ORDER BY fullname ASC";
        if ($sort === "name_desc") $orderClause = "ORDER BY fullname DESC";
        else if ($sort === "newest") $orderClause = "ORDER BY id DESC";

        $sql .= " $orderClause LIMIT ? OFFSET ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $kw = "%$keyword%";
            $stmt->bind_param("sii", $kw, $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = new Customer($row['id'], $row['fullname'], $row['password'] ?? '', $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    // Tìm customer theo số điện thoại
    public function findByPhone($phone)
    {
        try {
            $sql = "SELECT * FROM customers WHERE phone = ?";
            $stmt = $this->executePrepared($sql, "s", $phone);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new Customer($row['id'], $row['fullname'], $row['password'] ?? '', $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Insert và trả về ID
    public function insertAndGetId($fullname, $phone, $address)
    {
        try {
            $sql = "INSERT INTO customers (fullname, phone, address, status) VALUES (?, ?, ?, 1)";
            $stmt = $this->executePrepared($sql, "sss", $fullname, $phone, $address);
            return $this->conn->insert_id;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByPhoneOrEmail($contact)
    {
        try {
            $sql = "SELECT * FROM customers WHERE phone = ? OR email = ?";
            $stmt = $this->executePrepared($sql, "ss", $contact, $contact);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new Customer($row['id'], $row['fullname'], $row['password'], $row['email'], $row['phone'], $row['address'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }
}
?>
