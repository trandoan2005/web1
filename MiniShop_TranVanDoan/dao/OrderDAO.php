<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Order;

class OrderDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('orders');
    }

    private function mapRow($row)
    {
        $order = new Order($row['id'], $row['customer_id'], $row['total_amount'], $row['status'], $row['note'], $row['created_at'], $row['updated_at']);
        $order->customerName = $row['customer_name'] ?? '';
        return $order;
    }

    public function getAll($keyword = "", $status = "")
    {
        try {
            $sql = "SELECT o.*, c.fullname as customer_name 
                    FROM orders o 
                    LEFT JOIN customers c ON o.customer_id = c.id";

            $conditions = [];
            $params = [];
            $types = "";

            $keyword = trim($keyword);
            if (!empty($keyword)) {
                $conditions[] = "(o.id LIKE ? OR c.fullname LIKE ?)";
                $searchParam = "%" . $keyword . "%";
                $params[] = $searchParam;
                $params[] = $searchParam;
                $types .= "ss";
            }

            if ($status !== "") {
                $conditions[] = "o.status = ?";
                $params[] = $status;
                $types .= "i";
            }

            if (count($conditions) > 0) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " ORDER BY o.id DESC";

            if (count($params) > 0) {
                $stmt = $this->executePrepared($sql, $types, ...$params);
                $result = $stmt->get_result();
            } else {
                $result = $this->executeQuery($sql);
            }

            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = $this->mapRow($row);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT o.*, c.fullname as customer_name 
                    FROM orders o 
                    LEFT JOIN customers c ON o.customer_id = c.id 
                    WHERE o.id = ?";
            $stmt = $this->executePrepared($sql, "i", $id);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $this->mapRow($row);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(Order $o)
    {
        try {
            $sql = "INSERT INTO orders (customer_id, total_amount, status, note) VALUES (?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "idis", $o->customerId, $o->totalAmount, $o->status, $o->note);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Order $o)
    {
        try {
            $sql = "UPDATE orders SET customer_id = ?, total_amount = ?, status = ?, note = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "idisi", $o->customerId, $o->totalAmount, $o->status, $o->note, $o->id);
            return $stmt->affected_rows >= 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->deleteById($id);
    }

    public function updateStatus($id, $status)
    {
        try {
            $sql = "UPDATE orders SET status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "ii", $status, $id);
            return $stmt->affected_rows >= 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Dashboard: 5 đơn hàng mới nhất
    public function getLatest($limit = 5)
    {
        try {
            $sql = "SELECT o.*, c.fullname as customer_name FROM orders o LEFT JOIN customers c ON o.customer_id = c.id ORDER BY o.created_at DESC LIMIT ?";
            $stmt = $this->executePrepared($sql, "i", $limit);
            $result = $stmt->get_result();
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = $this->mapRow($row);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = "")
    {
        $sql = "SELECT o.*, c.fullname as customer_name 
                FROM orders o 
                LEFT JOIN customers c ON o.customer_id = c.id 
                WHERE c.fullname LIKE ? ";
        
        $orderClause = "ORDER BY o.id DESC";
        if ($sort === "amount_asc") $orderClause = "ORDER BY o.total_amount ASC";
        else if ($sort === "amount_desc") $orderClause = "ORDER BY o.total_amount DESC";
        else if ($sort === "oldest") $orderClause = "ORDER BY o.id ASC";

        $sql .= " $orderClause LIMIT ? OFFSET ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $kw = "%$keyword%";
            $stmt->bind_param("sii", $kw, $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = $this->mapRow($row);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    public function insertAndGetId($customerId, $totalAmount, $status, $note)
    {
        try {
            $sql = "INSERT INTO orders (customer_id, total_amount, status, note) VALUES (?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "idis", $customerId, $totalAmount, $status, $note);
            return $this->conn->insert_id;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function insertAndGetIdWithDiscount($customerId, $totalAmount, $discountAmount, $status, $note)
    {
        try {
            $sql = "INSERT INTO orders (customer_id, total_amount, discount_amount, status, note) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "iddds", $customerId, $totalAmount, $discountAmount, $status, $note);
            return $this->conn->insert_id;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>
