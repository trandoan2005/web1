<?php
$pageTitle = "Cập nhật Sản phẩm";
require_once __DIR__ . '/../../../dao/ProductDAO.php';
require_once __DIR__ . '/../../../dao/CategoryDAO.php';
require_once __DIR__ . '/../../../dao/BrandDAO.php';

$productDAO = new ProductDAO();
$categoryDAO = new CategoryDAO();
$brandDAO = new BrandDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$productOld = $productDAO->findById($id);

if (!$productOld) {
    header("Location: index.php");
    exit;
}

// Code xử lý XÓA hình ảnh trong Gallery (nếu có)
if (isset($_GET['delete_image_id'])) {
    $imgId = (int)$_GET['delete_image_id'];
    $imgName = $_GET['image_name'];
    
    if ($productDAO->deleteImage($imgId)) {
        // Xóa file vật lý
        $filePath = __DIR__ . "/../../../uploads/products/" . $imgName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        header("Location: edit.php?id=$id&msg=img_deleted");
        exit;
    }
}

$categories = $categoryDAO->getAll();
$brands = $brandDAO->getAll();
$galleryImages = $productDAO->getImagesByProductId($id);

$errors = [];
$name = $productOld->name;
$slug = $productOld->slug;
$categoryId = $productOld->categoryId;
$brandId = $productOld->brandId;
$oldPrice = $productOld->oldPrice;
$salePrice = $productOld->salePrice;
$quantity = $productOld->quantity;
$description = $productOld->description;
$status = $productOld->status;
$image = $productOld->image;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $categoryId = (int)($_POST["categoryId"] ?? 0);
    $brandId = (int)($_POST["brandId"] ?? 0);
    $oldPrice = (float)($_POST["oldPrice"] ?? 0);
    $salePrice = (float)($_POST["salePrice"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);
    $description = trim($_POST["description"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = $productOld->image; // Giữ nguyên hình cũ

    // Validation
    if ($name === "") $errors[] = "Tên sản phẩm không được để trống.";
    if ($categoryId <= 0) $errors[] = "Vui lòng chọn danh mục.";
    if ($brandId <= 0) $errors[] = "Vui lòng chọn thương hiệu.";
    if ($salePrice <= 0) $errors[] = "Giá bán phải lớn hơn 0.";
    if ($quantity < 0) $errors[] = "Số lượng không hợp lệ.";

    $tmpName = "";
    if ($fileName != "") {
        $fileSize = $_FILES["image"]["size"] ?? 0;
        $error = $_FILES["image"]["error"] ?? 0;
        $tmpName = $_FILES["image"]["tmp_name"] ?? "";

        if ($error != UPLOAD_ERR_OK) {
            $errors[] = "Upload hình ảnh đại diện không thành công.";
        }
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) {
            $errors[] = "Ảnh đại diện: Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        }
        $maxSize = 200 * 1024;
        if ($fileSize > $maxSize) {
            $errors[] = "Ảnh đại diện: Kích thước <= 200 KB.";
        }
    }

    if (empty($errors)) {
        // Có chọn hình ảnh mới
        if ($fileName != "") {
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $image = time() . "_" . $slug . "." . $extension;
            $uploadPath = __DIR__ . "/../../../uploads/products/" . $image;

            // Xóa hình ảnh cũ (nếu có)
            if (!empty($productOld->image)) {
                $oldImage = __DIR__ . "/../../../uploads/products/" . $productOld->image;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            // Upload hình ảnh mới
            move_uploaded_file($tmpName, $uploadPath);
        }

        // Upload nhiều hình ảnh (Gallery)
        $images = $_FILES["images"] ?? null;
        if ($images && is_array($images['name'])) {
            for ($i = 0; $i < count($images['name']); $i++) {
                $galFileName = $images['name'][$i];
                if ($galFileName != "") {
                    $galTmpName = $images['tmp_name'][$i];
                    $ext = strtolower(pathinfo($galFileName, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $newImageName = time() . "_" . rand(100, 999) . "." . $ext;
                        $galUploadPath = __DIR__ . "/../../../uploads/products/" . $newImageName;
                        if (move_uploaded_file($galTmpName, $galUploadPath)) {
                            $productDAO->insertImage($id, $newImageName);
                        }
                    }
                }
            }
        }

        $productOld->name = $name;
        $productOld->slug = $slug;
        $productOld->categoryId = $categoryId;
        $productOld->brandId = $brandId;
        $productOld->oldPrice = $oldPrice;
        $productOld->salePrice = $salePrice;
        $productOld->quantity = $quantity;
        $productOld->description = $description;
        $productOld->image = $image;
        $productOld->status = $status;
        
        if ($productDAO->update($productOld)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Cập nhật sản phẩm</h5>
    </div>
    <div class="card-body">
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'img_deleted'): ?>
            <div class="alert alert-success">Đã xóa hình ảnh gallery thành công!</div>
        <?php endif; ?>
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
            <input type="hidden" name="id" value="<?= $productOld->id ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Slug</label>
                    <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($slug) ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                    <select name="categoryId" class="form-select">
                        <option value="0">-- Chọn danh mục --</option>
                        <?php foreach($categories as $item): ?>
                            <option value="<?= $item->id ?>" <?= $categoryId == $item->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($item->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                    <select name="brandId" class="form-select">
                        <option value="0">-- Chọn thương hiệu --</option>
                        <?php foreach($brands as $item): ?>
                            <option value="<?= $item->id ?>" <?= $brandId == $item->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($item->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá gốc</label>
                    <input type="number" name="oldPrice" class="form-control" value="<?= $oldPrice ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá bán <span class="text-danger">*</span></label>
                    <input type="number" name="salePrice" class="form-control" value="<?= $salePrice ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Số lượng <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="<?= $quantity ?>">
                </div>
            </div>
            
            <div class="text-center mb-3" id="preview">
                <?php if ($image != "") { ?>
                    <img src="../../../uploads/products/<?= htmlspecialchars($image) ?>" class="img-thumbnail" width="200">
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Hình ảnh đại diện mới</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <div class="form-text">Bỏ trống nếu không muốn thay đổi hình ảnh hiện tại.</div>
            </div>

            <hr>
            <!-- Hiển thị Gallery hiện tại -->
            <div class="mb-3">
                <label class="form-label fw-bold">Gallery hiện tại</label>
                <?php if (!empty($galleryImages)): ?>
                    <div class="d-flex flex-wrap gap-3">
                        <?php foreach ($galleryImages as $img): ?>
                            <div class="position-relative">
                                <img src="../../../uploads/products/<?= htmlspecialchars($img['image']) ?>" class="img-thumbnail" width="100">
                                <a href="edit.php?id=<?= $id ?>&delete_image_id=<?= $img['id'] ?>&image_name=<?= $img['image'] ?>" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="return confirm('Xóa hình này?');">X</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-muted fst-italic">Chưa có hình ảnh nào trong thư viện.</div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Thêm hình ảnh Gallery</label>
                <div class="text-center mb-3 d-flex flex-wrap gap-2 justify-content-center" id="preview-gallery"></div>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
            </div>
            <hr>

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
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <button type="reset" class="btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
