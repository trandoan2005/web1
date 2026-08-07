<?php
require_once __DIR__ . '/BaseDAO.php';
require_once __DIR__ . '/../models/Category.php';

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
}
?>
