<?php
$pageTitle = "Quản lý Đơn hàng";
require_once __DIR__ . '/../../../dao/OrderDAO.php';
$orderDAO = new OrderDAO();

$keyword = "";
$statusFilter = "";

if (isset($_GET["keyword"])) {
    $keyword = trim($_GET["keyword"]);
}
if (isset($_GET["status"]) && $_GET["status"] !== "") {
    $statusFilter = $_GET["status"];
}

$orders = $orderDAO->getAll($keyword, $statusFilter);

function getStatusBadge($status) {
    switch ($status) {
        case 0: return '<span class="badge bg-secondary">Chờ xác nhận</span>';
        case 1: return '<span class="badge bg-info text-dark">Đã xác nhận</span>';
        case 2: return '<span class="badge bg-warning text-dark">Đang giao</span>';
        case 3: return '<span class="badge bg-success">Hoàn thành</span>';
        case 4: return '<span class="badge bg-danger">Đã hủy</span>';
        default: return '<span class="badge bg-dark">Không xác định</span>';
    }
}

ob_start();
?>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] == 'updated'): ?>
        <div class="alert alert-success">Cập nhật trạng thái đơn hàng thành công!</div>
    <?php endif; ?>
<?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form class="row gx-3 gy-2 align-items-center" method="GET">
            <div class="col-sm-4">
                <label class="visually-hidden">Từ khóa</label>
                <input type="text" name="keyword" class="form-control" placeholder="Mã đơn hàng, tên khách hàng..." value="<?= htmlspecialchars($keyword) ?>">
            </div>
            <div class="col-sm-3">
                <label class="visually-hidden">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="0" <?= $statusFilter === "0" ? 'selected' : '' ?>>Chờ xác nhận</option>
                    <option value="1" <?= $statusFilter === "1" ? 'selected' : '' ?>>Đã xác nhận</option>
                    <option value="2" <?= $statusFilter === "2" ? 'selected' : '' ?>>Đang giao</option>
                    <option value="3" <?= $statusFilter === "3" ? 'selected' : '' ?>>Hoàn thành</option>
                    <option value="4" <?= $statusFilter === "4" ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
            </div>
            <?php if ($keyword !== "" || $statusFilter !== ""): ?>
                <div class="col-auto">
                    <a href="index.php" class="btn btn-secondary">Hủy lọc</a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if (empty($orders)): ?>
    <div class="alert alert-warning">Không tìm thấy dữ liệu.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td class="fw-bold">#<?= $o->id ?></td>
                        <td><?= htmlspecialchars($o->customerName) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($o->createdAt)) ?></td>
                        <td class="text-danger fw-bold"><?= number_format($o->totalAmount, 0, ',', '.') ?> đ</td>
                        <td><?= getStatusBadge($o->status) ?></td>
                        <td>
                            <a href="detail.php?id=<?= $o->id ?>" class="btn btn-sm btn-info text-white" title="Chi tiết"><i class="bi bi-eye"></i></a>
                            <a href="update_status.php?id=<?= $o->id ?>" class="btn btn-sm btn-warning" title="Cập nhật trạng thái"><i class="bi bi-arrow-repeat"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
