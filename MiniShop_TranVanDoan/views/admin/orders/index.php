<?php
$pageTitle = "Quản lý Đơn hàng";
require_once __DIR__ . '/../../../dao/OrderDAO.php';
require_once __DIR__ . '/../../../dao/CustomerDAO.php';
$orderDAO = new OrderDAO();
$customerDAO = new CustomerDAO();
$orders = $orderDAO->getAll();

ob_start();
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã ĐH</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th>Ngày đặt</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $index => $o): ?>
            <?php $customer = $customerDAO->findById($o->customerId); ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td>#<?= $o->id ?></td>
                <td><?= $customer ? htmlspecialchars($customer->fullname) : 'N/A' ?></td>
                <td class="text-danger fw-bold"><?= number_format($o->totalAmount, 0, ',', '.') ?> đ</td>
                <td>
                    <?php
                    $badgeClass = 'bg-secondary';
                    if ($o->status == 'Đã giao') $badgeClass = 'bg-success';
                    if ($o->status == 'Đang giao') $badgeClass = 'bg-info';
                    if ($o->status == 'Chờ xử lý') $badgeClass = 'bg-warning text-dark';
                    if ($o->status == 'Đã hủy') $badgeClass = 'bg-danger';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $o->status ?></span>
                </td>
                <td><?= htmlspecialchars($o->note ?? '') ?></td>
                <td><?= $o->createdAt ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
