<?php
require_once 'dao/StudentDAO.php';

$studentDAO = new StudentDAO();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$student = $studentDAO->getById($id);

include 'includes/header.php';
?>

<?php if ($student): ?>
    <h2 class="mb-4">Chi tiết Sinh viên</h2>
    <div class="card shadow" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin sinh viên: <?= htmlspecialchars($student->fullname) ?></h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 40%;">ID</th>
                    <td><?= $student->id ?></td>
                </tr>
                <tr>
                    <th>Mã sinh viên</th>
                    <td><?= htmlspecialchars($student->studentcode) ?></td>
                </tr>
                <tr>
                    <th>Họ và tên</th>
                    <td><?= htmlspecialchars($student->fullname) ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><?= htmlspecialchars($student->phone) ?></td>
                </tr>
                <tr>
                    <th>Giới tính</th>
                    <td><?= htmlspecialchars($student->gender) ?></td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td><?= $student->created_at ?></td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="student_index.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
            <a href="student_edit.php?id=<?= $student->id ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger">
        <h4>Lỗi!</h4>
        <p>Không tìm thấy sinh viên với ID = <?= $id ?></p>
        <a href="student_index.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Quay lại</a>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
