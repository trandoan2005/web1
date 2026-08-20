<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quản lý Mã Giảm Giá</h1>
    <a href="index.php?area=admin&controller=coupon&action=create" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Thêm mã mới
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
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Mã Giảm Giá</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th>Mã (Code)</th>
                        <th>Giảm giá (%)</th>
                        <th>Đã dùng / Tối đa</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                        <th width="120">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($coupons)): ?>
                        <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                    <?php else: ?>
                        <?php foreach ($coupons as $c): ?>
                            <tr>
                                <td><?= $c->id ?></td>
                                <td><span class="badge bg-dark fs-6"><?= htmlspecialchars($c->code) ?></span></td>
                                <td><span class="text-danger fw-bold">-<?= $c->discountPercent ?>%</span></td>
                                <td><?= $c->usedCount ?> / <?= $c->maxUsage > 0 ? $c->maxUsage : '∞' ?></td>
                                <td>
                                    <?php 
                                    if ($c->validUntil) {
                                        $isExpired = strtotime($c->validUntil) < strtotime(date('Y-m-d'));
                                        echo '<span class="' . ($isExpired ? 'text-danger' : '') . '">' . date('d/m/Y', strtotime($c->validUntil)) . '</span>';
                                    } else {
                                        echo 'Vĩnh viễn';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($c->status == 1): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Đã khóa</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="index.php?area=admin&controller=coupon&action=edit&id=<?= $c->id ?>" class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="index.php?area=admin&controller=coupon&action=delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');" class="m-0">
                                            <input type="hidden" name="id" value="<?= $c->id ?>">
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
