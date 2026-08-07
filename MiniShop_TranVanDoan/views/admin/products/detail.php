<?php
$pageTitle = "Chi tiết Sản phẩm";
require_once __DIR__ . '/../../../dao/ProductDAO.php';
$productDAO = new ProductDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$product = $productDAO->findById($id);

if (!$product) {
    header("Location: index.php");
    exit;
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Chi tiết sản phẩm</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <?php if (!empty($product->image)): ?>
                    <img src="../../../uploads/products/<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="img-fluid rounded border" style="max-height: 300px;">
                <?php else: ?>
                    <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="height: 300px;">
                        <span class="text-muted"><i class="bi bi-image" style="font-size: 3rem;"></i><br>Chưa có ảnh</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 200px;" class="table-light">ID</th>
                            <td><?= $product->id ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Tên sản phẩm</th>
                            <td class="fw-bold text-primary fs-5"><?= htmlspecialchars($product->name) ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Danh mục</th>
                            <td><?= htmlspecialchars($product->cateName) ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Thương hiệu</th>
                            <td><?= htmlspecialchars($product->brandName) ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Giá gốc</th>
                            <td class="text-muted"><del><?= number_format($product->oldPrice, 0, ',', '.') ?> đ</del></td>
                        </tr>
                        <tr>
                            <th class="table-light">Giá bán</th>
                            <td class="text-danger fw-bold fs-5"><?= number_format($product->salePrice, 0, ',', '.') ?> đ</td>
                        </tr>
                        <tr>
                            <th class="table-light">Tồn kho</th>
                            <td><?= $product->quantity ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Slug</th>
                            <td><?= htmlspecialchars($product->slug) ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Trạng thái</th>
                            <td>
                                <span class="badge <?= $product->status ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= $product->status ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="table-light">Mô tả chi tiết</th>
                            <td><?= nl2br(htmlspecialchars($product->description)) ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Ngày tạo</th>
                            <td><?= $product->createdAt ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Cập nhật lần cuối</th>
                            <td><?= $product->updatedAt ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4 text-center border-top pt-3">
            <a href="edit.php?id=<?= $product->id ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa sản phẩm</a>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
