<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quản lý Banner</h1>
    <a href="index.php?area=admin&controller=banner&action=create" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Thêm banner mới
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Banner</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th width="150">Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Link</th>
                        <th width="100">Thứ tự</th>
                        <th width="100">Trạng thái</th>
                        <th width="120">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($banners)): ?>
                        <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                    <?php else: ?>
                        <?php foreach ($banners as $b): ?>
                            <tr>
                                <td><?= $b->id ?></td>
                                <td>
                                    <?php if (!empty($b->image)): ?>
                                        <img src="uploads/banners/<?= $b->image ?>" alt="<?= htmlspecialchars($b->title) ?>" class="img-fluid rounded" style="max-height:60px;">
                                    <?php else: ?>
                                        <span class="text-muted">Không có ảnh</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($b->title) ?></td>
                                <td>
                                    <?php if (!empty($b->link)): ?>
                                        <a href="<?= htmlspecialchars($b->link) ?>" target="_blank" class="text-truncate d-inline-block" style="max-width: 150px;">
                                            <?= htmlspecialchars($b->link) ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $b->sortOrder ?></td>
                                <td>
                                    <?php if ($b->status == 1): ?>
                                        <span class="badge bg-success">Hiển thị</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="index.php?area=admin&controller=banner&action=edit&id=<?= $b->id ?>" class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="index.php?area=admin&controller=banner&action=delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');" class="m-0">
                                            <input type="hidden" name="id" value="<?= $b->id ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
