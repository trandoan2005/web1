<?php
$pageTitle = "Thêm Thương hiệu";
require_once __DIR__ . '/../../../dao/BrandDAO.php';
$brandDAO = new BrandDAO();

$errors = [];
$name = "";
$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = "";

    if ($name === "") {
        $errors[] = "Tên thương hiệu không được để trống.";
    }

    $tmpName = "";
    if ($fileName != "") {
        $fileSize = $_FILES["image"]["size"] ?? 0;
        $error = $_FILES["image"]["error"] ?? 0;
        $tmpName = $_FILES["image"]["tmp_name"] ?? "";

        if ($error != UPLOAD_ERR_OK) {
            $errors[] = "Upload hình ảnh không thành công.";
        }
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) {
            $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        }
        $maxSize = 200 * 1024;
        if ($fileSize > $maxSize) {
            $errors[] = "Kích thước hình ảnh <= 200 KB.";
        }
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $image = time() . "_" . rand(1000, 9999) . "." . $extension;
            $uploadPath = __DIR__ . "/../../../uploads/brands/" . $image;
            move_uploaded_file($tmpName, $uploadPath);
        }

        $b = new Brand(0, $name, $image, $status);
        if ($brandDAO->insert($b)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Thêm mới Thương hiệu</h5>
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
            <div class="mb-3">
                <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
            </div>

            <div class="text-center mb-3" id="preview">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Logo (Hình ảnh)</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
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
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Lưu</button>
                <button type="reset" class="btn btn-warning px-4"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
                <a href="index.php" class="btn btn-secondary px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>