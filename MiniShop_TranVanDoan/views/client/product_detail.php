<?php 
ob_start();
$baseUrl = '/TranVanDoan_LTW1/MiniShop_TranVanDoan/';
$imgSrc = !empty($product->image) ? $baseUrl . 'uploads/products/' . $product->image : 'https://placehold.co/500x400/eee/999?text=No+Image';
$hasSale = $product->oldPrice > $product->salePrice && $product->oldPrice > 0;
$discountPercent = $hasSale ? round(($product->oldPrice - $product->salePrice) / $product->oldPrice * 100) : 0;
?>

<div class="breadcrumb-shop">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=home&action=index">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=product&action=category&id=<?= $product->categoryId ?>"><?= htmlspecialchars($product->cateName) ?></a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($product->name) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-4">
    <div class="row g-4">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="bg-white rounded-4 p-3 shadow-sm">
                <img src="<?= $imgSrc ?>" class="img-fluid rounded-3 w-100" alt="<?= htmlspecialchars($product->name) ?>" id="mainImage" style="max-height: 450px; object-fit: cover;">
                
                <!-- Gallery thumbnails -->
                <?php if (!empty($galleryImages)): ?>
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <div class="border rounded-2 p-1" style="cursor:pointer; width:70px; height:70px;" onclick="document.getElementById('mainImage').src='<?= $imgSrc ?>'">
                        <img src="<?= $imgSrc ?>" class="img-fluid rounded" style="width:100%; height:100%; object-fit:cover;" alt="Main">
                    </div>
                    <?php foreach ($galleryImages as $img): ?>
                    <?php $galSrc = $baseUrl . 'uploads/products/' . $img['image_url']; ?>
                    <div class="border rounded-2 p-1" style="cursor:pointer; width:70px; height:70px;" onclick="document.getElementById('mainImage').src='<?= $galSrc ?>'">
                        <img src="<?= $galSrc ?>" class="img-fluid rounded" style="width:100%; height:100%; object-fit:cover;" alt="Gallery">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="bg-white rounded-4 p-4 shadow-sm h-100">
                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($product->cateName) ?></span>
                <span class="badge bg-dark mb-2"><?= htmlspecialchars($product->brandName) ?></span>
                
                <h1 class="fs-3 fw-bold mt-2 mb-3"><?= htmlspecialchars($product->name) ?></h1>

                <!-- Giá -->
                <div class="mb-3 p-3 rounded-3" style="background: linear-gradient(135deg, #fff5f5, #ffe0e6);">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-2 fw-bold" style="color: var(--accent);"><?= number_format($product->salePrice, 0, ',', '.') ?>₫</span>
                        <?php if ($hasSale): ?>
                            <span class="text-decoration-line-through text-muted fs-5"><?= number_format($product->oldPrice, 0, ',', '.') ?>₫</span>
                            <span class="badge bg-danger fs-6">-<?= $discountPercent ?>%</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Chi tiết -->
                <table class="table table-borderless mb-3">
                    <tr>
                        <td class="text-muted" style="width: 130px;"><i class="bi bi-award"></i> Thương hiệu</td>
                        <td class="fw-semibold"><?= htmlspecialchars($product->brandName) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="bi bi-tags"></i> Danh mục</td>
                        <td class="fw-semibold"><?= htmlspecialchars($product->cateName) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="bi bi-box-seam"></i> Tồn kho</td>
                        <td>
                            <?php if ($product->quantity > 0): ?>
                                <span class="badge bg-success">Còn <?= $product->quantity ?> sản phẩm</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Hết hàng</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <!-- Nút hành động -->
                <div class="d-flex gap-2 mb-3">
                    <button class="btn btn-accent btn-lg flex-grow-1" onclick="addToCart(<?= $product->id ?>)" <?= $product->quantity <= 0 ? 'disabled' : '' ?>>
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                    <button class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <!-- Cam kết -->
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 border rounded-3">
                            <i class="bi bi-shield-check text-success d-block"></i>
                            <small>Chính hãng 100%</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded-3">
                            <i class="bi bi-truck text-primary d-block"></i>
                            <small>Giao hàng nhanh</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded-3">
                            <i class="bi bi-arrow-counterclockwise text-warning d-block"></i>
                            <small>Đổi trả 30 ngày</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mô tả sản phẩm -->
    <div class="bg-white rounded-4 p-4 shadow-sm mt-4">
        <h3 class="section-title">Mô tả sản phẩm</h3>
        <div class="text-muted lh-lg">
            <?= nl2br(htmlspecialchars($product->description ?? 'Chưa có mô tả cho sản phẩm này.')) ?>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="mt-5">
        <h3 class="section-title">Sản phẩm liên quan</h3>
        <div class="row g-4">
            <?php foreach ($relatedProducts as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <?php include __DIR__ . '/partials/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/master.php';
?>
