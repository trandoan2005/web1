<?php
$pageTitle = "Quản lý Người dùng";
require_once __DIR__ . '/../../../dao/UserDAO.php';
$userDAO = new UserDAO();
$users = $userDAO->getAll();

ob_start();
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Username</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $index => $u): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($u->username) ?></td>
                <td><?= htmlspecialchars($u->fullname) ?></td>
                <td><?= htmlspecialchars($u->email) ?></td>
                <td><?= htmlspecialchars($u->phone) ?></td>
                <td><span class="badge bg-info"><?= $u->role ?></span></td>
                <td>
                    <span class="badge <?= $u->status ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $u->status ? 'Hoạt động' : 'Khóa' ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
