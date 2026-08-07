<?php
$pageTitle = "Cập nhật trạng thái Đơn hàng";
require_once __DIR__ . '/../../../dao/OrderDAO.php';
$orderDAO = new OrderDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$order = $orderDAO->findById($id);

if (!$order) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = (int)$_POST['status'];
    
    if ($orderDAO->updateStatus($id, $status)) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        $error = "Cập nhật trạng thái thất bại!";
    }
}

ob_start();
?>
<div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="bi bi-arrow-repeat"></i> Cập nhật trạng thái Đơn hàng #<?= $order->id ?></h5>
    </div>
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Khách hàng</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($order->customerName) ?>" disabled>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Trạng thái hiện tại / Mới</label>
                <select name="status" class="form-select form-select-lg">
                    <option value="0" <?= $order->status == 0 ? 'selected' : '' ?>>Chờ xác nhận</option>
                    <option value="1" <?= $order->status == 1 ? 'selected' : '' ?>>Đã xác nhận</option>
                    <option value="2" <?= $order->status == 2 ? 'selected' : '' ?>>Đang giao</option>
                    <option value="3" <?= $order->status == 3 ? 'selected' : '' ?>>Hoàn thành</option>
                    <option value="4" <?= $order->status == 4 ? 'selected' : '' ?>>Đã hủy</option>
                </select>
                <div class="form-text mt-2">Chọn trạng thái mới cho đơn hàng và nhấn "Cập nhật".</div>
            </div>
            
            <hr>
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Cập nhật</button>
                <a href="detail.php?id=<?= $order->id ?>" class="btn btn-secondary px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
