<?php
// Master layout: nhận $pageTitle và $content từ các trang con
// Auth đã được kiểm tra ở index.php, không cần gọi lại ở đây

$user = $_SESSION["user"] ?? null;
include __DIR__ . '/header.php';
?>
<div class="d-flex">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <div class="flex-grow-1">
        <!-- Header Bar -->
        <div class="container-fluid d-flex justify-content-between align-items-center bg-white shadow-sm p-3">
            <button id="btnMenu" class="btn btn-outline-secondary">
                <i class="bi bi-list"></i>
            </button>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                <span class="fw-bold">
                    <?= htmlspecialchars($user->fullname ?? '') ?>
                </span>
                <a href="index.php?area=admin&controller=auth&action=logout" class="text-decoration-none text-danger ms-3">
                    | <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
            </div>
        </div>
        <div class="p-4">
            <h2 class="mb-4"><?= $pageTitle ?></h2>
            <?= $content ?>
        </div>
        <?php include __DIR__ . '/footer.php'; ?>
    </div>
</div>
