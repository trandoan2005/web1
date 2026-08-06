<?php
$pageTitle = "Quản lý Danh mục";
require_once __DIR__ . '/../../../dao/CategoryDAO.php';
$categoryDAO = new CategoryDAO();
$categories = $categoryDAO->getAll();

ob_start();
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $index => $cat): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($cat->name) ?></td>
                <td><?= htmlspecialchars($cat->description) ?></td>
                <td>
                    <span class="badge <?= $cat->status ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $cat->status ? 'Hiện' : 'Ẩn' ?>
                    </span>
                </td>
                <td><?= $cat->createdAt ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
