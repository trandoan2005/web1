<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Product;

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

    // Lấy dữ liệu phân trang, tìm kiếm và sắp xếp
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = "")
    {
        $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id 
                WHERE p.name LIKE ? ";
                
        // Xử lý sắp xếp (Sort)
        $orderClause = "ORDER BY p.name ASC";
        if ($sort === "name_desc") $orderClause = "ORDER BY p.name DESC";
        else if ($sort === "price_asc") $orderClause = "ORDER BY p.sale_price ASC";
        else if ($sort === "price_desc") $orderClause = "ORDER BY p.sale_price DESC";
        else if ($sort === "newest") $orderClause = "ORDER BY p.id DESC";

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

    // Hàm thêm hình ảnh gallery
    public function insertImage($productId, $imageName) {
        try {
            $sql = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
            $stmt = $this->executePrepared($sql, "is", $productId, $imageName);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy danh sách gallery theo ID sản phẩm
    public function getImagesByProductId($productId) {
        try {
            $sql = "SELECT * FROM product_images WHERE product_id = ?";
            $stmt = $this->executePrepared($sql, "i", $productId);
            $result = $stmt->get_result();
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    // Xóa hình ảnh theo ID 
    public function deleteImage($id) {
        try {
            $sql = "DELETE FROM product_images WHERE id = ?";
            $stmt = $this->executePrepared($sql, "i", $id);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // ===== CLIENT METHODS =====

    // Lấy sản phẩm cho trang client (chỉ status = 1)
    public function getClientProducts(int $limit, int $offset, string $keyword = "", string $sort = "newest")
    {
        $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id 
                WHERE p.status = 1 AND p.name LIKE ?";
        
        $orderClause = "ORDER BY p.id DESC";
        if ($sort === "name_asc") $orderClause = "ORDER BY p.name ASC";
        else if ($sort === "name_desc") $orderClause = "ORDER BY p.name DESC";
        else if ($sort === "price_asc") $orderClause = "ORDER BY p.sale_price ASC";
        else if ($sort === "price_desc") $orderClause = "ORDER BY p.sale_price DESC";

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

    // Đếm sản phẩm client
    public function countClient(string $keyword = "")
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM products WHERE status = 1 AND name LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $kw = "%$keyword%";
            $stmt->bind_param("s", $kw);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            return (int)$row["total"];
        } catch (Exception $e) {
            return 0;
        }
    }

    // Sản phẩm đang giảm giá
    public function getSaleProducts(int $limit = 4)
    {
        try {
            $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                    FROM products p 
                    INNER JOIN categories c ON p.category_id = c.id 
                    INNER JOIN brands b ON p.brand_id = b.id 
                    WHERE p.status = 1 AND p.old_price > p.sale_price 
                    ORDER BY (p.old_price - p.sale_price) DESC LIMIT ?";
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

    // Sản phẩm theo danh mục
    public function getByCategory(int $catId, int $limit, int $offset, string $sort = "newest")
    {
        $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id 
                WHERE p.status = 1 AND p.category_id = ?";

        $orderClause = "ORDER BY p.id DESC";
        if ($sort === "price_asc") $orderClause = "ORDER BY p.sale_price ASC";
        else if ($sort === "price_desc") $orderClause = "ORDER BY p.sale_price DESC";
        else if ($sort === "name_asc") $orderClause = "ORDER BY p.name ASC";

        $sql .= " $orderClause LIMIT ? OFFSET ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $catId, $limit, $offset);
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

    public function countByCategory(int $catId)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM products WHERE status = 1 AND category_id = ?";
            $stmt = $this->executePrepared($sql, "i", $catId);
            $row = $stmt->get_result()->fetch_assoc();
            return (int)$row["total"];
        } catch (Exception $e) {
            return 0;
        }
    }

    // Sản phẩm theo thương hiệu
    public function getByBrand(int $brandId, int $limit, int $offset, string $sort = "newest")
    {
        $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id 
                WHERE p.status = 1 AND p.brand_id = ?";

        $orderClause = "ORDER BY p.id DESC";
        if ($sort === "price_asc") $orderClause = "ORDER BY p.sale_price ASC";
        else if ($sort === "price_desc") $orderClause = "ORDER BY p.sale_price DESC";
        else if ($sort === "name_asc") $orderClause = "ORDER BY p.name ASC";

        $sql .= " $orderClause LIMIT ? OFFSET ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $brandId, $limit, $offset);
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

    public function countByBrand(int $brandId)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM products WHERE status = 1 AND brand_id = ?";
            $stmt = $this->executePrepared($sql, "i", $brandId);
            $row = $stmt->get_result()->fetch_assoc();
            return (int)$row["total"];
        } catch (Exception $e) {
            return 0;
        }
    }

    // Sản phẩm liên quan (cùng danh mục, trừ sp hiện tại)
    public function getRelatedProducts(int $catId, int $excludeId, int $limit = 4)
    {
        try {
            $sql = "SELECT p.*, c.name as cateName, b.name as brandName 
                    FROM products p 
                    INNER JOIN categories c ON p.category_id = c.id 
                    INNER JOIN brands b ON p.brand_id = b.id 
                    WHERE p.status = 1 AND p.category_id = ? AND p.id != ? 
                    ORDER BY RAND() LIMIT ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $catId, $excludeId, $limit);
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
}
?>
