<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Mã Giảm Giá Mới</h1>
    <a href="index.php?area=admin&controller=coupon&action=index" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left"></i> Quay lại
    </a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $err): ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="index.php?area=admin&controller=coupon&action=create" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mã giảm giá (Code) <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control text-uppercase" value="<?= htmlspecialchars($_POST['code'] ?? '') ?>" placeholder="VD: SUMMER20" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Phần trăm giảm (%) <span class="text-danger">*</span></label>
                    <input type="number" name="discount_percent" class="form-control" value="<?= htmlspecialchars($_POST['discount_percent'] ?? '') ?>" min="1" max="100" placeholder="VD: 15" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Giới hạn số lần dùng</label>
                    <input type="number" name="max_usage" class="form-control" value="<?= htmlspecialchars($_POST['max_usage'] ?? '0') ?>" min="0">
                    <div class="form-text">Nhập 0 để không giới hạn.</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Ngày hết hạn</label>
                    <input type="date" name="valid_until" class="form-control" value="<?= htmlspecialchars($_POST['valid_until'] ?? '') ?>">
                    <div class="form-text">Bỏ trống nếu không có ngày hết hạn.</div>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?= (!isset($_POST['code']) || isset($_POST['status'])) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status">Hoạt động</label>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu Mã Giảm Giá</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
