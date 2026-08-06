<?php
// Xác định trang hiện tại để highlight menu
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$currentDir = basename(dirname($_SERVER['PHP_SELF']));
$baseUrl = '/TranVanDoan_LTW1/MiniShop_TranVanDoan/views/admin';
?>
<div class="bg-dark text-white" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
    <div class="sidebar-heading text-center py-4 border-bottom">
        <h4><i class="bi bi-shop"></i> MiniShop</h4>
        <small>Admin Panel</small>
    </div>
    <div class="list-group list-group-flush">
        <a href="<?= $baseUrl ?>/dashboard.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="<?= $baseUrl ?>/categories/index.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentDir == 'categories') ? 'active' : '' ?>">
            <i class="bi bi-grid"></i> Danh mục
        </a>
        <a href="<?= $baseUrl ?>/brands/index.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentDir == 'brands') ? 'active' : '' ?>">
            <i class="bi bi-bookmark-star"></i> Thương hiệu
        </a>
        <a href="<?= $baseUrl ?>/products/index.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentDir == 'products') ? 'active' : '' ?>">
            <i class="bi bi-box-seam"></i> Sản phẩm
        </a>
        <a href="<?= $baseUrl ?>/customers/index.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentDir == 'customers') ? 'active' : '' ?>">
            <i class="bi bi-people"></i> Khách hàng
        </a>
        <a href="<?= $baseUrl ?>/users/index.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentDir == 'users') ? 'active' : '' ?>">
            <i class="bi bi-person-gear"></i> Người dùng
        </a>
        <a href="<?= $baseUrl ?>/orders/index.php" class="list-group-item list-group-item-action bg-dark text-white <?= ($currentDir == 'orders') ? 'active' : '' ?>">
            <i class="bi bi-cart3"></i> Đơn hàng
        </a>
    </div>
</div>
