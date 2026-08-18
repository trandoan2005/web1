<footer class="footer-shop mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>👟 ShoeShop</h5>
                <p>Cửa hàng giày chính hãng cao cấp. Cam kết 100% hàng chính hãng từ các thương hiệu Nike, Adidas, Jordan, New Balance, Puma.</p>
            </div>
            <div class="col-md-2 mb-3">
                <h5>Danh mục</h5>
                <ul class="list-unstyled">
                    <?php if (!empty($categories)): ?>
                        <?php foreach (array_slice($categories, 0, 5) as $cat): ?>
                            <li class="mb-1">
                                <a href="index.php?area=client&controller=product&action=category&id=<?= $cat->id ?>">
                                    <?= htmlspecialchars($cat->name) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h5>Thương hiệu</h5>
                <ul class="list-unstyled">
                    <?php if (!empty($brands)): ?>
                        <?php foreach (array_slice($brands, 0, 5) as $br): ?>
                            <li class="mb-1">
                                <a href="index.php?area=client&controller=product&action=brand&id=<?= $br->id ?>">
                                    <?= htmlspecialchars($br->name) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h5>Liên hệ</h5>
                <ul class="list-unstyled">
                    <li class="mb-1"><i class="bi bi-geo-alt"></i> 123 Nguyễn Trãi, Q.1, TP.HCM</li>
                    <li class="mb-1"><i class="bi bi-telephone"></i> 0901 234 567</li>
                    <li class="mb-1"><i class="bi bi-envelope"></i> contact@shoeshop.vn</li>
                </ul>
                <div class="mt-2">
                    <a href="#" class="me-2 fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-2 fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-2 fs-5"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0">&copy; 2026 👟 ShoeShop - Trần Văn Đoàn | Lab 12 - Lập Trình Web 1</p>
        </div>
    </div>
</footer>
