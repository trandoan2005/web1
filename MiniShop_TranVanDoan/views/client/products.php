<?php ob_start(); ?>

<div class="breadcrumb-shop">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=home&action=index">Trang chủ</a></li>
                <li class="breadcrumb-item active">Tất cả sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm rounded-4 p-3 sticky-top" style="top: 20px;">
                <h5 class="fw-bold mb-3">Bộ lọc sản phẩm</h5>
                <form action="index.php" method="GET">
                    <input type="hidden" name="area" value="client">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="index">
                    <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">

                    <!-- Danh mục -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Danh mục</label>
                        <select class="form-select" name="category_id">
                            <option value="">Tất cả danh mục</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->id ?>" <?= (isset($filters['category_id']) && $filters['category_id'] == $cat->id) ? 'selected' : '' ?>><?= htmlspecialchars($cat->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Thương hiệu -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thương hiệu</label>
                        <select class="form-select" name="brand_id">
                            <option value="">Tất cả thương hiệu</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand->id ?>" <?= (isset($filters['brand_id']) && $filters['brand_id'] == $brand->id) ? 'selected' : '' ?>><?= htmlspecialchars($brand->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Khoảng giá -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Khoảng giá (VNĐ)</label>
                        <div class="d-flex gap-2">
                            <input type="number" class="form-control form-control-sm" name="min_price" placeholder="Từ" value="<?= isset($filters['min_price']) ? $filters['min_price'] : '' ?>">
                            <span class="align-self-center">-</span>
                            <input type="number" class="form-control form-control-sm" name="max_price" placeholder="Đến" value="<?= isset($filters['max_price']) ? $filters['max_price'] : '' ?>">
                        </div>
                    </div>

                    <!-- Khuyến mãi -->
                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="isSale" name="is_sale" value="1" <?= isset($filters['is_sale']) ? 'checked' : '' ?>>
                        <label class="form-check-label text-danger fw-semibold" for="isSale">Chỉ hiện sản phẩm giảm giá</label>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 rounded-pill">Áp dụng lọc</button>
                    <a href="index.php?area=client&controller=product&action=index" class="btn btn-outline-secondary w-100 rounded-pill mt-2">Xóa bộ lọc</a>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">Tất cả sản phẩm</h2>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted d-none d-md-inline"><?= $totalRecords ?> sản phẩm</span>
                    <select class="form-select form-select-sm border-0 bg-light rounded-pill px-3" style="width: auto; cursor:pointer;" onchange="this.form.submit()" form="filterForm" id="sortSelect">
                        <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá thấp → cao</option>
                        <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá cao → thấp</option>
                        <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                    </select>
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div class="alert alert-warning text-center py-5 rounded-4 border-0 shadow-sm">
                    <i class="bi bi-emoji-frown fs-1 d-block mb-3 text-warning"></i>
                    <h5 class="fw-bold mb-1">Không tìm thấy sản phẩm nào!</h5>
                    <p class="text-muted mb-0">Thử thay đổi tiêu chí lọc để xem thêm các sản phẩm khác.</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                        <div class="col-6 col-md-4 col-lg-4">
                            <?php include __DIR__ . '/partials/product_card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Phân trang -->
                <?php if ($totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php 
                        // Build query string for pagination links
                        $queryParams = $_GET;
                        unset($queryParams['page']);
                        $queryString = http_build_query($queryParams);
                        ?>
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link shadow-sm" href="index.php?<?= $queryString ?>&page=<?= $page - 1 ?>"><i class="bi bi-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link shadow-sm" href="index.php?<?= $queryString ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link shadow-sm" href="index.php?<?= $queryString ?>&page=<?= $page + 1 ?>"><i class="bi bi-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('sortSelect').addEventListener('change', function() {
        const form = document.querySelector('form[action="index.php"]');
        form.querySelector('input[name="sort"]').value = this.value;
        form.submit();
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/master.php';
?>
