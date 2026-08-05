<?php
require_once 'dao/StudentDAO.php';

$studentDAO = new StudentDAO();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra sinh viên có tồn tại không
$student = $studentDAO->getById($id);

if ($student) {
    // Thực hiện xóa
    $studentDAO->delete($id);
    header("Location: student_index.php?msg=delete");
    exit;
} else {
    header("Location: student_index.php");
    exit;
}
?>
