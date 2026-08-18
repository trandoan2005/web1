<?php ob_start();
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
                <?php 
                    $currStatus = (int)$order->status; 
                    $isLocked = ($currStatus == 3 || $currStatus == 4);
                ?>
                <select name="status" class="form-select form-select-lg" <?= $isLocked ? 'disabled' : '' ?>>
                    <?php if ($currStatus == 0): ?>
                        <option value="0" selected>Chờ xác nhận</option>
                        <option value="1">Đã xác nhận</option>
                        <option value="4">Đã hủy</option>
                    <?php elseif ($currStatus == 1): ?>
                        <option value="1" selected>Đã xác nhận</option>
                        <option value="2">Đang giao</option>
                        <option value="4">Đã hủy</option>
                    <?php elseif ($currStatus == 2): ?>
                        <option value="2" selected>Đang giao</option>
                        <option value="3">Hoàn thành</option>
                    <?php elseif ($currStatus == 3): ?>
                        <option value="3" selected>Hoàn thành</option>
                    <?php elseif ($currStatus == 4): ?>
                        <option value="4" selected>Đã hủy</option>
                    <?php endif; ?>
                </select>
                <?php if ($isLocked): ?>
                    <input type="hidden" name="status" value="<?= $currStatus ?>">
                    <div class="form-text mt-2 text-danger">Đơn hàng đã chốt trạng thái cuối cùng, không thể thay đổi.</div>
                <?php else: ?>
                    <div class="form-text mt-2">Chọn trạng thái mới cho đơn hàng và nhấn "Cập nhật". Khi đơn hàng đang giao thì không thể hủy.</div>
                <?php endif; ?>
            </div>
            
            <hr>
            <div class="text-center">
                <?php if (!$isLocked): ?>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Cập nhật</button>
                <?php endif; ?>
                <a href="index.php?area=admin&controller=order&action=detail&id=<?= $order->id ?>" class="btn btn-secondary px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
