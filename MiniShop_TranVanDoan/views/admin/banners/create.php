<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Banner Mới</h1>
    <a href="index.php?area=admin&controller=banner&action=index" class="btn btn-secondary shadow-sm">
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
        <form action="index.php?area=admin&controller=banner&action=create" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề Banner <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Đường dẫn (Link)</label>
                        <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($_POST['link'] ?? '') ?>" placeholder="https://...">
                        <div class="form-text">Khi click vào banner sẽ chuyển hướng đến link này.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Thứ tự sắp xếp</label>
                            <input type="number" name="sort_order" class="form-control" value="<?= htmlspecialchars($_POST['sort_order'] ?? '0') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?= (!isset($_POST['title']) || isset($_POST['status'])) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="status">Hiển thị</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" id="imageInput" accept="image/*" required>
                    </div>
                    <div class="mb-3 text-center">
                        <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded border d-none" style="max-height: 200px;">
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu Banner</button>
        </form>
    </div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('imagePreview');
            img.src = e.target.result;
            img.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
