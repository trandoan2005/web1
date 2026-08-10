<?php
$pageTitle = "Cập nhật Thương hiệu";
require_once __DIR__ . '/../../../dao/BrandDAO.php';
$brandDAO = new BrandDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$brandOld = $brandDAO->findById($id);

if (!$brandOld) {
    header("Location: index.php");
    exit;
}

$errors = [];
$name = $brandOld->name;
$status = $brandOld->status;
$image = $brandOld->logo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = $brandOld->logo; // Giữ nguyên hình cũ

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

            // Xóa hình cũ
            if (!empty($brandOld->logo)) {
                $oldImage = __DIR__ . "/../../../uploads/brands/" . $brandOld->logo;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            move_uploaded_file($tmpName, $uploadPath);
        }

        $brandOld->name = $name;
        $brandOld->status = $status;
        $brandOld->logo = $image;

        if ($brandDAO->update($brandOld)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Cập nhật Thương hiệu</h5>
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
                <?php if ($image != "") { ?>
                    <img src="../../../uploads/brands/<?= htmlspecialchars($image) ?>" class="img-thumbnail" width="200">
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Logo (Hình ảnh) mới</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <div class="form-text">Bỏ trống nếu không muốn thay đổi logo hiện tại.</div>
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
                <a href="index.php" class="btn btn-secondary px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>