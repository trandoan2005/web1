<?php
// Xác định trang hiện tại để highlight menu
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$currentDir = basename(dirname($_SERVER['PHP_SELF']));
$baseUrl = '/TranVanDoan_LTW1/MiniShop_TranVanDoan/views/admin';
?>
<div class="bg-dark text-white" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
    <div class="sidebar-heading text-center py-4 border-bottom">
        <h4>👟 ShoeShop</h4>
        <small>Shoe Store Admin</small>
    <div class="list-group list-group-flush">
        <a href="index.php?area=admin&controller=dashboard&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="index.php?area=admin&controller=category&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'category') ? 'active' : '' ?>">
            <i class="bi bi-grid"></i> Danh mục
        </a>
        <a href="index.php?area=admin&controller=brand&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'brand') ? 'active' : '' ?>">
            <i class="bi bi-bookmark-star"></i> Thương hiệu
        </a>
        <a href="index.php?area=admin&controller=product&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'product') ? 'active' : '' ?>">
            <i class="bi bi-box-seam"></i> Sản phẩm
        </a>
        <a href="index.php?area=admin&controller=customer&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'customer') ? 'active' : '' ?>">
            <i class="bi bi-people"></i> Khách hàng
        </a>
        <a href="index.php?area=admin&controller=user&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'user') ? 'active' : '' ?>">
            <i class="bi bi-person-gear"></i> Người dùng
        </a>
        <a href="index.php?area=admin&controller=banner&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'banner') ? 'active' : '' ?>">
            <i class="bi bi-images"></i> Banners
        </a>
        <a href="index.php?area=admin&controller=coupon&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'coupon') ? 'active' : '' ?>">
            <i class="bi bi-tags"></i> Khuyến mãi
        </a>
        <a href="index.php?area=admin&controller=order&action=index" class="list-group-item list-group-item-action bg-dark text-white <?= (isset($_GET['controller']) && $_GET['controller'] == 'order') ? 'active' : '' ?>">
            <i class="bi bi-cart3"></i> Đơn hàng
        </a>
    </div>
    </div>
</div>
