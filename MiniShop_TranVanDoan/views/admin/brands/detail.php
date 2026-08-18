<?php ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Chi tiết thương hiệu</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 200px;" class="table-light">ID</th>
                    <td><?= $obj->id ?></td>
                </tr>
                <tr>
                    <th class="table-light">Tên thương hiệu</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->name) ?></td>
                </tr>
                <tr>
                    <th class="table-light">Logo</th>
                    <td>
                        <?php if ($obj->logo != "") { ?>
                            <img src="uploads/brands/<?= htmlspecialchars($obj->logo) ?>" class="img-thumbnail" width="150">
                        <?php } else { ?>
                            <span class="text-muted">No Image</span>
                        <?php } ?>
                    </td>
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
            <a href="index.php?area=admin&controller=brand&action=edit&id=<?= $obj->id ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
            <a href="index.php?area=admin&controller=brand&action=index" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
