<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Student.php';

class StudentDAO
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách tất cả sinh viên
    public function getAll()
    {
        $sql = "SELECT * FROM students ORDER BY id ASC";
        $result = $this->conn->query($sql);

        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $student = new Student(
                    $row['id'],
                    $row['studentcode'],
                    $row['fullname'],
                    $row['phone'],
                    $row['gender'],
                    $row['created_at']
                );
                $students[] = $student;
            }
        }
        return $students;
    }

    // Tìm sinh viên theo id - sử dụng Prepared Statement
    public function getById(int $id)
    {
        $sql = "SELECT * FROM students WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Student(
                $row['id'],
                $row['studentcode'],
                $row['fullname'],
                $row['phone'],
                $row['gender'],
                $row['created_at']
            );
        }
        return null;
    }

    // Thêm sinh viên - sử dụng Prepared Statement
    public function insert(Student $student)
    {
        $sql = "INSERT INTO students (studentcode, fullname, phone, gender) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $student->studentcode, $student->fullname, $student->phone, $student->gender);
        return $stmt->execute();
    }

    // Cập nhật sinh viên - sử dụng Prepared Statement
    public function update(Student $student)
    {
        $sql = "UPDATE students SET studentcode = ?, fullname = ?, phone = ?, gender = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $student->studentcode, $student->fullname, $student->phone, $student->gender, $student->id);
        return $stmt->execute();
    }

    // Xóa sinh viên - sử dụng Prepared Statement
    public function delete(int $id)
    {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
