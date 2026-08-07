<?php
$pageTitle = "Thêm Sản phẩm";
require_once __DIR__ . '/../../../dao/ProductDAO.php';
require_once __DIR__ . '/../../../dao/CategoryDAO.php';
require_once __DIR__ . '/../../../dao/BrandDAO.php';

$productDAO = new ProductDAO();
$categoryDAO = new CategoryDAO();
$brandDAO = new BrandDAO();

$categories = $categoryDAO->getAll();
$brands = $brandDAO->getAll();

$errors = [];
$name = $slug = $description = $image = "";
$categoryId = $brandId = 0;
$oldPrice = $salePrice = $quantity = 0;
$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $categoryId = (int)($_POST["categoryId"] ?? 0);
    $brandId = (int)($_POST["brandId"] ?? 0);
    $oldPrice = (float)($_POST["oldPrice"] ?? 0);
    $salePrice = (float)($_POST["salePrice"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);
    $description = trim($_POST["description"] ?? "");
    $image = trim($_POST["image"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    // Validation
    if ($name === "") $errors[] = "Tên sản phẩm không được để trống.";
    if ($categoryId <= 0) $errors[] = "Vui lòng chọn danh mục.";
    if ($brandId <= 0) $errors[] = "Vui lòng chọn thương hiệu.";
    if ($salePrice <= 0) $errors[] = "Giá bán phải lớn hơn 0.";
    if ($quantity < 0) $errors[] = "Số lượng không hợp lệ.";

    if (empty($errors)) {
        $p = new Product(0, $categoryId, $brandId, $name, $slug, $oldPrice, $salePrice, $quantity, $description, $image, $status);
        if ($productDAO->insert($p)) {
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
        <h5 class="mb-0">Thêm mới sản phẩm</h5>
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
            
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh sản phẩm (Tên file)</label>
                <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($image) ?>">
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
