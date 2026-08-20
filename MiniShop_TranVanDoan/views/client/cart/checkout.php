<?php ob_start(); ?>

<div class="breadcrumb-shop">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=home&action=index">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=cart&action=index">Giỏ hàng</a></li>
                <li class="breadcrumb-item active">Thanh toán</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <?php if (isset($success) && $success): ?>
        <div class="alert alert-success text-center py-5">
            <i class="bi bi-check-circle-fill fs-1 text-success d-block mb-3"></i>
            <h3>Đặt hàng thành công!</h3>
            <p>Cảm ơn bạn đã mua sắm tại ShoeShop. Đơn hàng của bạn đang được xử lý.</p>
            <a href="index.php?area=client&controller=home&action=index" class="btn btn-primary mt-3">Quay về trang chủ</a>
        </div>
    <?php else: ?>
        <h2 class="section-title mb-4">Thông tin thanh toán</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?area=client&controller=cart&action=checkout">
            <div class="row">
                <!-- Cột thông tin khách hàng -->
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 bg-light p-4">
                        <h4 class="mb-4">Thông tin giao hàng</h4>
                        <?php 
                        $sessCustomer = $_SESSION['customer'] ?? null;
                        ?>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="fullname" required value="<?= htmlspecialchars($_POST['fullname'] ?? $sessCustomer['fullname'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" required value="<?= htmlspecialchars($_POST['phone'] ?? $sessCustomer['phone'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" rows="3" required><?= htmlspecialchars($_POST['address'] ?? $sessCustomer['address'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú (Tùy chọn)</label>
                            <textarea class="form-control" name="note" rows="2" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng..."><?= htmlspecialchars($_POST['note'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Cột tóm tắt đơn hàng -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm p-4">
                        <h4 class="mb-4">Đơn hàng của bạn</h4>
                        <div class="order-items mb-4">
                            <?php foreach ($cart as $item): ?>
                                <div class="d-flex justify-content-between mb-3 align-items-center border-bottom pb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="position-relative">
                                            <?php $imgSrc = !empty($item['image']) ? 'uploads/products/'.$item['image'] : 'https://placehold.co/50'; ?>
                                            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($item['productName']) ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                                <?= $item['quantity'] ?>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fs-6"><?= htmlspecialchars($item['productName']) ?></h6>
                                        </div>
                                    </div>
                                    <div class="fw-bold">
                                        <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php 
                        $discount = 0;
                        if (isset($_SESSION['coupon'])) {
                            $discount = ($total * $_SESSION['coupon']['discount_percent']) / 100;
                        }
                        $finalTotal = $total - $discount;
                        ?>

                        <!-- Nơi nhập mã giảm giá -->
                        <div class="mb-4 pb-3 border-bottom">
                            <div class="input-group">
                                <input type="text" id="couponCode" class="form-control" placeholder="Mã giảm giá" value="<?= htmlspecialchars($_SESSION['coupon']['code'] ?? '') ?>" <?= isset($_SESSION['coupon']) ? 'disabled' : '' ?>>
                                <?php if (isset($_SESSION['coupon'])): ?>
                                    <button class="btn btn-outline-danger" type="button" id="btnRemoveCoupon">Gỡ</button>
                                <?php else: ?>
                                    <button class="btn btn-dark" type="button" id="btnApplyCoupon">Áp dụng</button>
                                <?php endif; ?>
                            </div>
                            <div id="couponMessage" class="mt-2 small"></div>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Tạm tính</span>
                            <span><?= number_format($total, 0, ',', '.') ?>₫</span>
                        </div>
                        <?php if (isset($_SESSION['coupon'])): ?>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Giảm giá (<?= $_SESSION['coupon']['discount_percent'] ?>%)</span>
                            <span>-<?= number_format($discount, 0, ',', '.') ?>₫</span>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Phí vận chuyển</span>
                            <span>Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold">Tổng cộng</span>
                            <span class="fs-4 fw-bold text-danger"><?= number_format($finalTotal, 0, ',', '.') ?>₫</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Hoàn tất đặt hàng</button>
                            <a href="index.php?area=client&controller=cart&action=index" class="btn btn-link text-decoration-none">Quay lại giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();

// Add scripts for Coupon
ob_start();
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnApply = document.getElementById('btnApplyCoupon');
    const btnRemove = document.getElementById('btnRemoveCoupon');
    const codeInput = document.getElementById('couponCode');
    const messageDiv = document.getElementById('couponMessage');

    if (btnApply) {
        btnApply.addEventListener('click', function() {
            const code = codeInput.value.trim();
            if (code === "") {
                messageDiv.innerHTML = '<span class="text-danger">Vui lòng nhập mã giảm giá.</span>';
                return;
            }

            const formData = new FormData();
            formData.append('code', code);

            fetch('index.php?area=client&controller=cart&action=applyCoupon', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to calculate total
                } else {
                    messageDiv.innerHTML = '<span class="text-danger">' + data.message + '</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    if (btnRemove) {
        btnRemove.addEventListener('click', function() {
            fetch('index.php?area=client&controller=cart&action=removeCoupon', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to remove discount
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});
</script>
<?php
$additionalScripts = ob_get_clean();

include __DIR__ . '/../layouts/master.php';
?>
