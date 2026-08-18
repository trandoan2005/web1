<?php ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Cập nhật khách hàng</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $obj->id ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($fullname) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Điện thoại <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Địa chỉ <span class="text-danger">*</span></label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="1" <?= $status == 1 ? "checked" : "" ?>>
                    <label class="form-check-label">Hiển thị (Hoạt động)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="0" <?= $status == 0 ? "checked" : "" ?>>
                    <label class="form-check-label">Ẩn (Ngừng hoạt động)</label>
                </div>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <button type="reset" class="btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            <a href="index.php?area=admin&controller=customer&action=index" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
