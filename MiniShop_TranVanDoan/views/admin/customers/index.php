<?php
$pageTitle = "Quản lý Khách hàng";
require_once __DIR__ . '/../../../dao/CustomerDAO.php';
$customerDAO = new CustomerDAO();
$customers = $customerDAO->getAll();

ob_start();
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $index => $c): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($c->fullname) ?></td>
                <td><?= htmlspecialchars($c->email) ?></td>
                <td><?= htmlspecialchars($c->phone) ?></td>
                <td><?= htmlspecialchars($c->address) ?></td>
                <td>
                    <span class="badge <?= $c->status ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $c->status ? 'Hoạt động' : 'Khóa' ?>
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
