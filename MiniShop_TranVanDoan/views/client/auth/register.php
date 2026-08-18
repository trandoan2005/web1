<?php ob_start(); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white border-0 text-center pt-5 pb-3">
                    <h3 class="fw-bold" style="color: var(--primary);">Đăng Ký Tài Khoản</h3>
                    <p class="text-muted">Trở thành thành viên của ShoeShop để nhận nhiều ưu đãi</p>
                </div>
                <div class="card-body p-4 p-md-5 pt-0">
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success text-center py-4" style="border-radius: 12px;">
                            <i class="bi bi-check-circle-fill fs-2 d-block mb-2"></i>
                            <h5 class="mb-2">Đăng ký thành công!</h5>
                            <p class="mb-0">Tài khoản của bạn đã được tạo.</p>
                            <a href="index.php?area=client&controller=auth&action=login" class="btn btn-primary mt-3" style="border-radius: 12px;">Đến trang Đăng nhập</a>
                        </div>
                    <?php else: ?>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" style="border-radius: 12px;">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($errors as $err): ?>
                                        <li><?= htmlspecialchars($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?area=client&controller=auth&action=register">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên" required style="border-radius: 12px;" value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
                                        <label for="fullname">Họ và tên <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" required style="border-radius: 12px;" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                                        <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="border-radius: 12px;" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                        <label for="email">Email (Tùy chọn)</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="address" name="address" placeholder="Địa chỉ" style="border-radius: 12px; height: 100px;"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                                        <label for="address">Địa chỉ (Tùy chọn)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required style="border-radius: 12px;">
                                        <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Nhập lại Mật khẩu" required style="border-radius: 12px;">
                                        <label for="re_password">Nhập lại Mật khẩu <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-accent btn-lg" style="border-radius: 12px;">Đăng ký</button>
                            </div>
                        </form>

                        <div class="text-center mt-4 text-muted">
                            Đã có tài khoản? <a href="index.php?area=client&controller=auth&action=login" class="fw-bold text-decoration-none" style="color: var(--primary);">Đăng nhập</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
