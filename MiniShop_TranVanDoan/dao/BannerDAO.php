<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\Banner;

class BannerDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('banners');
    }

    private function mapRow($row)
    {
        return new Banner(
            $row['id'], $row['title'], $row['image'],
            $row['link'], $row['sort_order'], $row['status'],
            $row['created_at'], $row['updated_at']
        );
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM banners";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE title LIKE ?";
            }
            $sql .= " ORDER BY sort_order ASC, id DESC";
            
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

    public function getActiveBanners()
    {
        try {
            $sql = "SELECT * FROM banners WHERE status = 1 ORDER BY sort_order ASC, id DESC";
            $result = $this->executeQuery($sql);
            
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
            $sql = "SELECT * FROM banners WHERE id = ?";
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

    public function insert(Banner $b)
    {
        try {
            $sql = "INSERT INTO banners (title, image, link, sort_order, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "sssii", $b->title, $b->image, $b->link, $b->sortOrder, $b->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(Banner $b)
    {
        try {
            $sql = "UPDATE banners SET title = ?, image = ?, link = ?, sort_order = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "sssiii", $b->title, $b->image, $b->link, $b->sortOrder, $b->status, $b->id);
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
