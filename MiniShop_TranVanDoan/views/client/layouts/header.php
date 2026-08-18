<?php
$currentController = $_GET['controller'] ?? 'home';
$currentAction = $_GET['action'] ?? 'index';
?>
<nav class="navbar navbar-expand-lg navbar-shop sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php?area=client&controller=home&action=index">
            👟 ShoeShop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clientNav" style="border-color: rgba(255,255,255,0.3);">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="clientNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $currentController == 'home' ? 'active' : '' ?>" href="index.php?area=client&controller=home&action=index">
                        <i class="bi bi-house-door"></i> Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentController == 'product' && $currentAction == 'index') ? 'active' : '' ?>" href="index.php?area=client&controller=product&action=index">
                        <i class="bi bi-grid"></i> Sản phẩm
                    </a>
                </li>
                <!-- Dropdown Danh mục -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= ($currentController == 'product' && $currentAction == 'category') ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-tags"></i> Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <?php if ($cat->status): ?>
                                <li>
                                    <a class="dropdown-item" href="index.php?area=client&controller=product&action=category&id=<?= $cat->id ?>">
                                        <?= htmlspecialchars($cat->name) ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>
                <!-- Dropdown Thương hiệu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= ($currentController == 'product' && $currentAction == 'brand') ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-award"></i> Thương hiệu
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (!empty($brands)): ?>
                            <?php foreach ($brands as $br): ?>
                                <?php if ($br->status): ?>
                                <li>
                                    <a class="dropdown-item" href="index.php?area=client&controller=product&action=brand&id=<?= $br->id ?>">
                                        <?= htmlspecialchars($br->name) ?>
                                    </a>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
            <!-- Thanh tìm kiếm -->
            <form class="d-flex search-bar me-3" method="GET">
                <input type="hidden" name="area" value="client">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="search">
                <input type="text" name="keyword" placeholder="Tìm kiếm giày..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button type="submit"><i class="bi bi-search"></i></button>
            </form>

            <!-- Giỏ hàng -->
            <a href="index.php?area=client&controller=cart&action=index" class="btn position-relative p-2 me-2" style="color: #fff;">
                <i class="bi bi-cart3 fs-5"></i>
                <?php
                $cartCount = 0;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $cartCount += $item['quantity'];
                    }
                }
                ?>
                <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" <?= $cartCount == 0 ? 'style="display:none;"' : '' ?>>
                    <?= $cartCount ?>
                </span>
            </a>

            <!-- User Auth -->
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['customer'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-lg-inline"><?= htmlspecialchars($_SESSION['customer']['fullname']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bag-check me-2"></i>Đơn hàng của tôi</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person-gear me-2"></i>Tài khoản</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?area=client&controller=auth&action=logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?area=client&controller=auth&action=login" title="Đăng nhập">
                            <i class="bi bi-person fs-5"></i>
                            <span class="d-lg-none ms-2">Đăng nhập</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
