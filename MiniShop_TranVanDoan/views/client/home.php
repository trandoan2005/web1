<?php ob_start(); ?>

<!-- Hero Section / Banner Carousel -->
<?php if (!empty($banners)): ?>
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($banners as $index => $b): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($banners as $index => $b): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <a href="<?= htmlspecialchars($b->link ?: '#') ?>">
                    <img src="uploads/banners/<?= $b->image ?>" class="d-block w-100" alt="<?= htmlspecialchars($b->title) ?>" style="max-height: 500px; object-fit: cover;">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php else: ?>
<section class="hero-section">
    <div class="container">
        <h1>👟 Giày Chính Hãng Cao Cấp</h1>
        <p class="mb-4">Nike • Adidas • Jordan • New Balance • Puma — Cam kết 100% chính hãng, giá tốt nhất</p>
        <a href="index.php?area=client&controller=product&action=index" class="btn btn-accent btn-lg">
            <i class="bi bi-bag"></i> Xem tất cả sản phẩm
        </a>
    </div>
</section>
<?php endif; ?>

<!-- Danh mục nổi bật -->
<section class="container my-5">
    <h2 class="section-title">Danh mục nổi bật</h2>
    <div class="row g-3">
        <?php 
        $catIcons = ['bi-lightning', 'bi-trophy', 'bi-dribbble', 'bi-bullseye', 'bi-snow'];
        $i = 0;
        foreach ($categories as $cat): 
            if (!$cat->status) continue;
            $icon = $catIcons[$i % count($catIcons)];
            $i++;
        ?>
        <div class="col-6 col-md-4 col-lg">
            <div class="category-card">
                <a href="index.php?area=client&controller=product&action=category&id=<?= $cat->id ?>">
                    <i class="bi <?= $icon ?>"></i>
                    <?= htmlspecialchars($cat->name) ?>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Sản phẩm mới nhất -->
<section class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0">Sản phẩm mới nhất</h2>
        <a href="index.php?area=client&controller=product&action=index" class="btn btn-outline-dark btn-sm rounded-pill">
            Xem tất cả <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="row g-4">
        <?php foreach ($latestProducts as $product): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <?php include __DIR__ . '/partials/product_card.php'; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Sản phẩm giảm giá -->
<?php if (!empty($saleProducts)): ?>
<section class="py-5" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe0e6 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0"><i class="bi bi-fire text-danger"></i> Đang giảm giá</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($saleProducts as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <?php include __DIR__ . '/partials/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Thương hiệu -->
<section class="container my-5 text-center">
    <h2 class="section-title d-inline-block">Thương hiệu chính hãng</h2>
    <div class="row g-4 justify-content-center mt-2">
        <?php foreach ($brands as $br): ?>
            <?php if (!$br->status) continue; ?>
            <div class="col-4 col-md-2">
                <a href="index.php?area=client&controller=product&action=brand&id=<?= $br->id ?>" class="d-block category-card py-3">
                    <strong><?= htmlspecialchars($br->name) ?></strong>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/master.php';
?>
