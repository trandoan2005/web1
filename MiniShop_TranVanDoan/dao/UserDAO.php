<?php
namespace DAO;
use Config\Database;
use Exception;
use Models\User;

class UserDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('users');
    }

    private function mapRow($row)
    {
        return new User($row['id'], $row['username'], $row['password'], $row['fullname'], $row['email'], $row['phone'], $row['role'], $row['status'], $row['created_at'], $row['updated_at']);
    }

    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM users";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE username LIKE ?";
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
            $sql = "SELECT * FROM users WHERE id = ?";
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

    public function findByUsername(string $username): ?User
    {
        try {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->executePrepared($sql, "s", $username);
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $this->mapRow($row);
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function insert(User $u)
    {
        try {
            $sql = "INSERT INTO users (username, password, fullname, email, phone, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->executePrepared($sql, "ssssssi", $u->username, $u->password, $u->fullname, $u->email, $u->phone, $u->role, $u->status);
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update(User $u)
    {
        try {
            $sql = "UPDATE users SET username = ?, password = ?, fullname = ?, email = ?, phone = ?, role = ?, status = ? WHERE id = ?";
            $stmt = $this->executePrepared($sql, "ssssssii", $u->username, $u->password, $u->fullname, $u->email, $u->phone, $u->role, $u->status, $u->id);
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
        $sql = "SELECT * FROM users WHERE fullname LIKE ? ";
        
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
                $list[] = $this->mapRow($row);
            }
            return $list;
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
