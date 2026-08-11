<?php
$pageTitle = "403 Forbidden";
ob_start();
?>
<div class="text-center mt-5">
    <h1 class="display-1 fw-bold text-danger">403</h1>
    <h2 class="mb-4">Truy cập bị từ chối</h2>
    <p class="lead">Bạn không có quyền truy cập vào trang này. Chỉ Admin mới được phép.</p>
    <a href="dashboard.php" class="btn btn-primary mt-3"><i class="bi bi-house"></i> Về trang tổng quan</a>
</div>
<?php
$content = ob_get_clean();
include 'layouts/master.php';
?>
