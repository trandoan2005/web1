<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Coupon;

class CouponDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('coupons');
    }

    private function mapRow($row)
    {
        return new Coupon(
            $row['id'], $row['code'], $row['discount_percent'],
            $row['max_usage'], $row['used_count'], $row['valid_until'],
            $row['status'], $row['created_at']
        );
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM coupons";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE code LIKE ?";
            }
            $sql .= " ORDER BY id DESC";
            
            if (!empty($keyword)) {
                $searchParam = "%" . $keyword . "%";
                $stmt = $this->executePrepared($sql, "s", $searchParam);
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
            $sql = "SELECT * FROM coupons WHERE id = ?";
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

    public function findByCode($code)
    {
        try {
            $sql = "SELECT * FROM coupons WHERE code = ?";
            $stmt = $this->executePrepared($sql, "s", $code);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $this->mapRow($row);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(Coupon $c)
    {
        try {
            $sql = "INSERT INTO coupons (code, discount_percent, max_usage, valid_until, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "siisi", $c->code, $c->discountPercent, $c->maxUsage, $c->validUntil, $c->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Coupon $c)
    {
        try {
            $sql = "UPDATE coupons SET code = ?, discount_percent = ?, max_usage = ?, valid_until = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "siisii", $c->code, $c->discountPercent, $c->maxUsage, $c->validUntil, $c->status, $c->id);
            return $stmt->affected_rows >= 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function incrementUsage($id)
    {
        try {
            $sql = "UPDATE coupons SET used_count = used_count + 1 WHERE id = ?";
            $stmt = $this->executePrepared($sql, "i", $id);
            return $stmt->affected_rows > 0;
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
