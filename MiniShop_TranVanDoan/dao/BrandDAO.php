<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Brand;

class BrandDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('brands');
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM brands";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE name LIKE ?";
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
                $list[] = new Brand($row['id'], $row['name'], $row['logo'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM brands WHERE id = ?";
            $stmt = $this->executePrepared($sql, "i", $id);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new Brand($row['id'], $row['name'], $row['logo'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(Brand $brand)
    {
        try {
            $sql = "INSERT INTO brands (name, logo, status) VALUES (?, ?, ?)";
            $stmt = $this->executePrepared($sql, "ssi", $brand->name, $brand->logo, $brand->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Brand $brand)
    {
        try {
            $sql = "UPDATE brands SET name = ?, logo = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "ssii", $brand->name, $brand->logo, $brand->status, $brand->id);
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
        $sql = "SELECT * FROM brands WHERE name LIKE ? ";
        
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
                $list[] = new Brand($row['id'], $row['name'], $row['logo'], $row['status'], $row['created_at'], $row['updated_at']);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
