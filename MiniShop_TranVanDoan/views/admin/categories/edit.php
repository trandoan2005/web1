<?php
$pageTitle = "Cập nhật Danh mục";
require_once __DIR__ . '/../../../dao/CategoryDAO.php';
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$categoryDAO = new CategoryDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$catOld = $categoryDAO->findById($id);

if (!$catOld) {
    header("Location: index.php");
    exit;
}

$errors = [];
$name = $catOld->name;
$description = $catOld->description;
$status = $catOld->status;
$image = $catOld->image;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = $catOld->image; // Giữ nguyên hình cũ

    if ($name === "") {
        $errors[] = "Tên danh mục không được để trống.";
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
            $uploadPath = __DIR__ . "/../../../uploads/categories/" . $image;

            // Xóa hình cũ
            if (!empty($catOld->image)) {
                $oldImage = __DIR__ . "/../../../uploads/categories/" . $catOld->image;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            move_uploaded_file($tmpName, $uploadPath);
        }

        $catOld->name = $name;
        $catOld->description = $description;
        $catOld->image = $image;
        $catOld->status = $status;

        if ($categoryDAO->update($catOld)) {
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
                    <img src="../../../uploads/categories/<?= htmlspecialchars($image) ?>" class="img-thumbnail" width="200">
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
                <a href="index.php" class="btn btn-secondary px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
