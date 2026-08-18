<?php ob_start();
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
                    <img src="uploads/products/<?= htmlspecialchars($image) ?>" class="img-thumbnail" width="200">
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
                                <img src="uploads/products/<?= htmlspecialchars($img['image_url']) ?>" class="img-thumbnail" width="100">
                                <a href="index.php?area=admin&controller=product&action=edit&id=<?= $id ?>&delete_image_id=<?= $img['id'] ?>&image_name=<?= $img['image_url'] ?>" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="return confirm('Xóa hình này?');">X</a>
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
            <a href="index.php?area=admin&controller=product&action=index" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
