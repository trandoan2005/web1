<?php ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Chi tiết danh mục</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 200px;" class="table-light">ID</th>
                    <td><?= $category->id ?></td>
                </tr>
                <tr>
                    <th class="table-light">Tên danh mục</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($category->name) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Hình ảnh</th>
                    <td>
                        <?php if ($category->image != "") { ?>
                            <img src="uploads/categories/<?= htmlspecialchars($category->image) ?>" class="img-thumbnail" width="150">
                        <?php } else { ?>
                            <span class="text-muted">No Image</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th class="table-light">Mô tả</th>
                    <td><?= nl2br(htmlspecialchars($category->description)) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Trạng thái</th>
                    <td>
                        <span class="badge <?= $category->status ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $category->status ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th class="table-light">Ngày tạo</th>
                    <td><?= $category->createdAt ?></td>
                </tr>
                <tr>
                    <th class="table-light">Cập nhật lần cuối</th>
                    <td><?= $category->updatedAt ?></td>
                </tr>
            </tbody>
        </table>
        
        <div class="mt-3">
            <a href="index.php?area=admin&controller=category&action=edit&id=<?= $category->id ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa danh mục</a>
            <a href="index.php?area=admin&controller=category&action=index" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
