<?php ob_start(); ?>

<div class="breadcrumb-shop">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=home&action=index">Trang chủ</a></li>
                <li class="breadcrumb-item active">Tìm kiếm: "<?= htmlspecialchars($keyword) ?>"</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-search"></i> Kết quả cho "<?= htmlspecialchars($keyword) ?>"
        </h2>
        <span class="text-muted"><?= $totalRecords ?> sản phẩm</span>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-warning text-center py-5">
            <i class="bi bi-search fs-1 d-block mb-2"></i>
            <h5>Không tìm thấy sản phẩm nào phù hợp.</h5>
            <p class="text-muted">Thử tìm kiếm với từ khóa khác hoặc <a href="index.php?area=client&controller=product&action=index">xem tất cả sản phẩm</a>.</p>
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
                    <a class="page-link" href="index.php?area=client&controller=product&action=search&keyword=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>">‹</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?area=client&controller=product&action=search&keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=client&controller=product&action=search&keyword=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>">›</a>
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
