<?php
// Tách logic sang DashboardController
ob_start();
?>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-md">
        <div class="card stat-card bg-primary text-white text-center p-3">
            <h3><i class="bi bi-grid"></i></h3>
            <h4><?= $totalCategories ?></h4>
            <p class="mb-0">Danh mục</p>
        </div>
    </div>
    <div class="col-md">
        <div class="card stat-card bg-info text-white text-center p-3">
            <h3><i class="bi bi-bookmark-star"></i></h3>
            <h4><?= $totalBrands ?></h4>
            <p class="mb-0">Thương hiệu</p>
        </div>
    </div>
    <div class="col-md">
        <div class="card stat-card bg-success text-white text-center p-3">
            <h3><i class="bi bi-box-seam"></i></h3>
            <h4><?= $totalProducts ?></h4>
            <p class="mb-0">Sản phẩm</p>
        </div>
    </div>
    <div class="col-md">
        <div class="card stat-card bg-warning text-dark text-center p-3">
            <h3><i class="bi bi-people"></i></h3>
            <h4><?= $totalCustomers ?></h4>
            <p class="mb-0">Khách hàng</p>
        </div>
    </div>
    <div class="col-md">
        <div class="card stat-card bg-danger text-white text-center p-3">
            <h3><i class="bi bi-cart3"></i></h3>
            <h4><?= $totalOrders ?></h4>
            <p class="mb-0">Đơn hàng</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- 5 Sản phẩm mới nhất -->
    <div class="col-md-7">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> 5 Sản phẩm mới nhất</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestProducts as $p): ?>
                            <tr>
                                <td><?= $p->id ?></td>
                                <td><?= htmlspecialchars($p->name) ?></td>
                                <td class="text-danger fw-bold"><?= number_format($p->salePrice, 0, ',', '.') ?> đ</td>
                                <td><?= $p->quantity ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5 Đơn hàng mới nhất -->
    <div class="col-md-5">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-cart3"></i> 5 Đơn hàng mới nhất</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestOrders as $o): ?>
                            <tr>
                                <td><?= $o->id ?></td>
                                <td><?= htmlspecialchars($o->customerName ?? '') ?></td>
                                <td><?= number_format($o->totalAmount, 0, ',', '.') ?> đ</td>
                                <td>
                                    <?php
                                    $badgeClass = 'bg-secondary';
                                    if ($o->status == 'Đã giao') $badgeClass = 'bg-success';
                                    if ($o->status == 'Đang giao') $badgeClass = 'bg-info';
                                    if ($o->status == 'Chờ xử lý') $badgeClass = 'bg-warning text-dark';
                                    if ($o->status == 'Đã hủy') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $o->status ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layouts/master.php';
?>
