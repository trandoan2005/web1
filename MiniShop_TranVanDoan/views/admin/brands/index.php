<?php
$pageTitle = "Quản lý Thương hiệu";
require_once __DIR__ . '/../../../dao/BrandDAO.php';
$brandDAO = new BrandDAO();
$brands = $brandDAO->getAll();

ob_start();
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Tên thương hiệu</th>
            <th>Logo</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($brands as $index => $brand): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($brand->name) ?></td>
                <td><?= htmlspecialchars($brand->logo) ?></td>
                <td>
                    <span class="badge <?= $brand->status ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $brand->status ? 'Hiện' : 'Ẩn' ?>
                    </span>
                </td>
                <td><?= $brand->createdAt ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
