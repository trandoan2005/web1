<?php
// $product: object Product
$baseUrl = '/TranVanDoan_LTW1/MiniShop_TranVanDoan/';
$imgSrc = !empty($product->image) ? $baseUrl . 'uploads/products/' . $product->image : 'https://placehold.co/300x220/eee/999?text=No+Image';
$hasSale = $product->oldPrice > $product->salePrice && $product->oldPrice > 0;
$discountPercent = $hasSale ? round(($product->oldPrice - $product->salePrice) / $product->oldPrice * 100) : 0;
?>
<div class="product-card">
    <div class="img-wrapper">
        <?php if ($hasSale && $discountPercent > 0): ?>
            <span class="badge-sale">-<?= $discountPercent ?>%</span>
        <?php endif; ?>
        <a href="index.php?area=client&controller=product&action=detail&id=<?= $product->id ?>">
            <img src="<?= $imgSrc ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
        </a>
    </div>
    <div class="card-body d-flex flex-column">
        <div class="product-brand">
            <i class="bi bi-award"></i> <?= htmlspecialchars($product->brandName ?? '') ?>
        </div>
        <div class="product-name flex-grow-1">
            <a href="index.php?area=client&controller=product&action=detail&id=<?= $product->id ?>">
                <?= htmlspecialchars($product->name) ?>
            </a>
        </div>
        <div class="mt-2 d-flex justify-content-between align-items-center">
            <div>
                <span class="price-sale"><?= number_format($product->salePrice, 0, ',', '.') ?>₫</span>
                <?php if ($hasSale): ?>
                    <span class="price-old d-block" style="font-size: 0.8rem;"><?= number_format($product->oldPrice, 0, ',', '.') ?>₫</span>
                <?php endif; ?>
            </div>
            <button class="btn btn-sm btn-outline-accent rounded-circle" onclick="addToCart(<?= $product->id ?>)" <?= $product->quantity <= 0 ? 'disabled' : '' ?> title="Thêm vào giỏ">
                <i class="bi bi-cart-plus"></i>
            </button>
        </div>
    </div>
</div>
