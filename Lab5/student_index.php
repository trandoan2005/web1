<?php
require_once 'dao/StudentDAO.php';

$studentDAO = new StudentDAO();
$students = $studentDAO->getAll();

include 'includes/header.php';
?>

<h2 class="mb-4">Danh sách Sinh viên</h2>

<a href="student_add.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Thêm sinh viên</a>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
        if ($_GET['msg'] == 'add') echo "Thêm sinh viên thành công!";
        if ($_GET['msg'] == 'update') echo "Cập nhật sinh viên thành công!";
        if ($_GET['msg'] == 'delete') echo "Xóa sinh viên thành công!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã SV</th>
            <th>Họ và tên</th>
            <th>Số điện thoại</th>
            <th>Giới tính</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($students) > 0): ?>
            <?php foreach ($students as $index => $sv): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($sv->studentcode) ?></td>
                    <td><?= htmlspecialchars($sv->fullname) ?></td>
                    <td><?= htmlspecialchars($sv->phone) ?></td>
                    <td><?= htmlspecialchars($sv->gender) ?></td>
                    <td><?= $sv->created_at ?></td>
                    <td>
                        <a href="student_detail.php?id=<?= $sv->id ?>" class="btn btn-info btn-sm btn-action text-white"><i class="bi bi-eye"></i> Chi tiết</a>
                        <a href="student_edit.php?id=<?= $sv->id ?>" class="btn btn-warning btn-sm btn-action"><i class="bi bi-pencil"></i> Sửa</a>
                        <a href="student_delete.php?id=<?= $sv->id ?>" class="btn btn-danger btn-sm btn-action" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')"><i class="bi bi-trash"></i> Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Không có sinh viên nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>
