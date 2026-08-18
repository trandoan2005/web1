<?php ob_start();
?>
<div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Cập nhật Danh mục</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error) { ?>
                        <li><?= $error ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? '') ?>">
        <input type="hidden" name="id" value="<?= $catOld->id ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
            </div>
            
            <div class="text-center mb-3" id="preview">
                <?php if ($image != "") { ?>
                    <img src="uploads/categories/<?= htmlspecialchars($image) ?>" class="img-thumbnail" width="200">
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Hình ảnh mới</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <div class="form-text">Bỏ trống nếu không muốn thay đổi hình ảnh hiện tại.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả</label>
                <textarea name="description" rows="3" class="form-control"><?= htmlspecialchars($description) ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="1" <?= $status == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label">Hoạt động</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="0" <?= $status == 0 ? 'checked' : '' ?>>
                    <label class="form-check-label">Khóa</label>
                </div>
            </div>
            
            <hr>
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Cập nhật</button>
                <button type="reset" class="btn btn-warning px-4"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                <a href="index.php?area=admin&controller=category&action=index" class="btn btn-secondary px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
