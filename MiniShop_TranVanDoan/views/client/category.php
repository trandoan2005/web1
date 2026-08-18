<?php ob_start(); ?>

<div class="breadcrumb-shop">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=home&action=index">Trang chủ</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($category->name) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0"><?= htmlspecialchars($category->name) ?></h2>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted"><?= $totalRecords ?> sản phẩm</span>
            <select class="form-select form-select-sm" style="width: auto;" onchange="location.href='index.php?area=client&controller=product&action=category&id=<?= $catId ?>&sort='+this.value">
                <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá thấp → cao</option>
                <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá cao → thấp</option>
                <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
            </select>
        </div>
    </div>

    <?php if (!empty($category->description)): ?>
        <p class="text-muted mb-4"><?= htmlspecialchars($category->description) ?></p>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <div class="alert alert-warning text-center py-4">
            <i class="bi bi-emoji-frown fs-1 d-block mb-2"></i>
            Chưa có sản phẩm nào trong danh mục này.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <?php include __DIR__ . '/partials/product_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
        <nav class="mt-4 d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=client&controller=product&action=category&id=<?= $catId ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">‹</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?area=client&controller=product&action=category&id=<?= $catId ?>&sort=<?= $sort ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=client&controller=product&action=category&id=<?= $catId ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">›</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/master.php';
?>
