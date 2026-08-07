<?php
$pageTitle = "Thêm Thương hiệu";
require_once __DIR__ . '/../../../dao/BrandDAO.php';
$brandDAO = new BrandDAO();

$errors = [];
$name = "";
$logo = "";

$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $logo = trim($_POST["logo"] ?? "");

    $status = $_POST["status"] ?? 1;

    // Validation
    if ($name === "") { $errors[] = "Tên thương hiệu không được để trống."; }
    if ($logo === "") { $errors[] = "Logo (Tên file) không được để trống."; }


    if (empty($errors)) {
        $obj = new Brand(0, $name, $logo, $status);
        if ($brandDAO->insert($obj)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Thêm mới thương hiệu</h5>
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
                <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Logo (Tên file) <span class="text-danger">*</span></label>
                <input type="text" name="logo" class="form-control" value="<?= htmlspecialchars($logo) ?>">
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