<?php
require_once __DIR__ . '/BaseDAO.php';
require_once __DIR__ . '/../models/Product.php';

class ProductDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('products');
    }

    private function mapRow($row)
    {
        $product = new Product(
            $row['id'], $row['category_id'], $row['brand_id'],
            $row['name'], $row['slug'], $row['old_price'], $row['sale_price'],
            $row['quantity'], $row['description'], $row['image'],
            $row['status'], $row['created_at'], $row['updated_at']
        );
        $product->cateName = $row['cateName'] ?? '';
        $product->brandName = $row['brandName'] ?? '';
        return $product;
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                    FROM products p 
                    INNER JOIN categories c ON p.category_id = c.id 
                    INNER JOIN brands b ON p.brand_id = b.id";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE p.name LIKE ? OR c.name LIKE ? OR b.name LIKE ?";
            }
            $sql .= " ORDER BY p.id ASC";
            
            if (!empty($keyword)) {
                $searchParam = "%" . $keyword . "%";
                $stmt = $this->executePrepared($sql, "sss", $searchParam, $searchParam, $searchParam);
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
            $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                    FROM products p 
                    INNER JOIN categories c ON p.category_id = c.id 
                    INNER JOIN brands b ON p.brand_id = b.id 
                    WHERE p.id = ?";
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

    public function insert(Product $p)
    {
        try {
            $sql = "INSERT INTO products (category_id, brand_id, name, slug, old_price, sale_price, quantity, description, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "iissddissi", $p->categoryId, $p->brandId, $p->name, $p->slug, $p->oldPrice, $p->salePrice, $p->quantity, $p->description, $p->image, $p->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Product $p)
    {
        try {
            $sql = "UPDATE products SET category_id = ?, brand_id = ?, name = ?, slug = ?, old_price = ?, sale_price = ?, quantity = ?, description = ?, image = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "iissddissii", $p->categoryId, $p->brandId, $p->name, $p->slug, $p->oldPrice, $p->salePrice, $p->quantity, $p->description, $p->image, $p->status, $p->id);
            return $stmt->affected_rows >= 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->deleteById($id);
    }

    // Dashboard: 5 sản phẩm mới nhất
    public function getLatest($limit = 5)
    {
        try {
            $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT ?";
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
}
?>
