<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Category;

class CategoryDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('categories');
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM categories";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE name LIKE ? OR description LIKE ?";
            }
            $sql .= " ORDER BY id ASC";
            
            if (!empty($keyword)) {
                $searchParam = "%" . $keyword . "%";
                $stmt = $this->executePrepared($sql, "ss", $searchParam, $searchParam);
                $result = $stmt->get_result();
            } else {
                $result = $this->executeQuery($sql);
            }
            
            $list = [];
            while ($row = $result->fetch_assoc()) {
                $list[] = new Category($row['id'], $row['name'], $row['description'], $row['image'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM categories WHERE id = ?";
            $stmt = $this->executePrepared($sql, "i", $id);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new Category($row['id'], $row['name'], $row['description'], $row['image'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(Category $cat)
    {
        try {
            $sql = "INSERT INTO categories (name, description, image, status) VALUES (?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "sssi", $cat->name, $cat->description, $cat->image, $cat->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Category $cat)
    {
        try {
            $sql = "UPDATE categories SET name = ?, description = ?, image = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "sssii", $cat->name, $cat->description, $cat->image, $cat->status, $cat->id);
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
        $sql = "SELECT * FROM categories WHERE name LIKE ? ";
        
        $orderClause = "ORDER BY name ASC";
        if ($sort === "name_desc") $orderClause = "ORDER BY name DESC";
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
                $list[] = new Category($row['id'], $row['name'], $row['description'], $row['image'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
