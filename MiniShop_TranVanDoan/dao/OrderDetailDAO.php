<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\OrderDetail;

class OrderDetailDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('order_details');
    }

    private function mapRow($row)
    {
        $detail = new OrderDetail($row['id'], $row['order_id'], $row['product_id'], $row['quantity'], $row['price'], $row['created_at']);
        $detail->productName = $row['product_name'] ?? '';
        $detail->productImage = $row['product_image'] ?? '';
        return $detail;
    }

    public function getByOrderId($orderId)
    {
        try {
            $sql = "SELECT od.*, p.name as product_name, p.image as product_image 
                    FROM order_details od 
                    INNER JOIN products p ON od.product_id = p.id 
                    WHERE od.order_id = ?";
            $stmt = $this->executePrepared($sql, "i", $orderId);
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

    public function insert(OrderDetail $od)
    {
        try {
            $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "iiid", $od->orderId, $od->productId, $od->quantity, $od->price);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function insertDetail($orderId, $productId, $quantity, $price)
    {
        try {
            $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "iiid", $orderId, $productId, $quantity, $price);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>
