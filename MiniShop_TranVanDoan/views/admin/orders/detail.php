<?php ob_start();
?>

<div class="row">
    <!-- Thông tin đơn hàng -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Thông tin Đơn hàng</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th style="width: 40%">Mã đơn:</th>
                            <td class="fw-bold fs-5 text-primary">#<?= $order->id ?></td>
                        </tr>
                        <tr>
                            <th>Khách hàng:</th>
                            <td class="fw-bold"><?= htmlspecialchars($order->customerName) ?></td>
                        </tr>
                        <tr>
                            <th>Ngày đặt:</th>
                            <td><?= date('d/m/Y H:i:s', strtotime($order->createdAt)) ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái:</th>
                            <td>
                                <span class="badge <?= getStatusClass($order->status) ?> fs-6">
                                    <?= getStatusText($order->status) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Ghi chú:</th>
                            <td><?= nl2br(htmlspecialchars($order->note)) ?: '<em>Không có</em>' ?></td>
                        </tr>
                        <tr>
                            <th>Tổng tiền:</th>
                            <td class="text-danger fw-bold fs-5"><?= number_format($order->totalAmount, 0, ',', '.') ?> đ</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3 text-center border-top pt-3">
                    <a href="update_status.php?id=<?= $order->id ?>" class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> Cập nhật trạng thái</a>
                    <a href="index.php?area=admin&controller=order&action=index" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-box"></i> Chi tiết Sản phẩm</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orderDetails)): ?>
                                <tr>
                                    <td colspan="6" class="text-muted py-4">Không có sản phẩm nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php $sum = 0; foreach ($orderDetails as $index => $od): 
                                    $subtotal = $od->price * $od->quantity;
                                    $sum += $subtotal;
                                ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <?php if (!empty($od->productImage)): ?>
                                                <img src="uploads/products/<?= htmlspecialchars($od->productImage) ?>" alt="..." width="50" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted"><i class="bi bi-image"></i></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-start fw-bold"><?= htmlspecialchars($od->productName) ?></td>
                                        <td><?= number_format($od->price, 0, ',', '.') ?> đ</td>
                                        <td><?= $od->quantity ?></td>
                                        <td class="fw-bold text-danger"><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($orderDetails)): ?>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end fs-5">TỔNG CỘNG:</th>
                                <th class="text-danger fw-bold fs-5"><?= number_format($sum, 0, ',', '.') ?> đ</th>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
