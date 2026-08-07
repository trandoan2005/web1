<?php
$pageTitle = "Chi tiết Người dùng";
require_once __DIR__ . '/../../../dao/UserDAO.php';
$userDAO = new UserDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$obj = $userDAO->findById($id);

if (!$obj) {
    header("Location: index.php");
    exit;
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Chi tiết người dùng</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 200px;" class="table-light">ID</th>
                    <td><?= $obj->id ?></td>
                </tr>
                <tr>
                    <th class="table-light">Tên đăng nhập</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->username) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Mật khẩu</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->password) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Họ tên</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->fullname) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Email</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->email) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Điện thoại</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->phone) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Vai trò (admin/staff)</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->role) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Trạng thái</th>
                    <td>
                        <span class="badge <?= $obj->status ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $obj->status ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th class="table-light">Ngày tạo</th>
                    <td><?= $obj->createdAt ?></td>
                </tr>
                <tr>
                    <th class="table-light">Cập nhật lần cuối</th>
                    <td><?= $obj->updatedAt ?></td>
                </tr>
            </tbody>
        </table>
        
        <div class="mt-3">
            <a href="edit.php?id=<?= $obj->id ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>