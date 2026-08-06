<?php
$pageTitle = "Quản lý Sản phẩm";
require_once __DIR__ . '/../../../dao/ProductDAO.php';
$productDAO = new ProductDAO();
$products = $productDAO->getAll();

ob_start();
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Giá gốc</th>
            <th>Giá bán</th>
            <th>Tồn kho</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $index => $p): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($p->name) ?></td>
                <td class="text-muted"><del><?= number_format($p->oldPrice, 0, ',', '.') ?> đ</del></td>
                <td class="text-danger fw-bold"><?= number_format($p->salePrice, 0, ',', '.') ?> đ</td>
                <td><?= $p->quantity ?></td>
                <td>
                    <span class="badge <?= $p->status ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $p->status ? 'Hiện' : 'Ẩn' ?>
                    </span>
                </td>
                <td><?= $p->createdAt ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
