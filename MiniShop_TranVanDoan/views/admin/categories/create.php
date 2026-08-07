<?php
$pageTitle = "Thêm Danh mục";
require_once __DIR__ . '/../../../dao/CategoryDAO.php';
$categoryDAO = new CategoryDAO();

$errors = [];
$cateName = $slug = $description = "";
$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cateName = trim($_POST["cateName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? 1;

    // Validation
    if ($cateName === "") {
        $errors[] = "Tên danh mục không được để trống.";
    }
    if ($slug === "") {
        $errors[] = "Slug không được để trống.";
    }

    if (empty($errors)) {
        $cat = new Category(0, $cateName, $description, '', $status);
        if ($categoryDAO->insert($cat)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Thêm danh mục thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Thêm mới danh mục</h5>
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
            <div class="mb-3">
                <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" name="cateName" class="form-control" value="<?= htmlspecialchars($cateName) ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($slug) ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả</label>
                <textarea name="description" rows="4" class="form-control"><?= htmlspecialchars($description) ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="1" <?= $status == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label">Hiển thị (Hoạt động)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="0" <?= $status == 0 ? 'checked' : '' ?>>
                    <label class="form-check-label">Ẩn (Ngừng hoạt động)</label>
                </div>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            <button type="reset" class="btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
