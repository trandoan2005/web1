<?php ob_start(); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white border-0 text-center pt-5 pb-3">
                    <h3 class="fw-bold" style="color: var(--primary);">Đăng Nhập</h3>
                    <p class="text-muted">Chào mừng bạn quay lại ShoeShop</p>
                </div>
                <div class="card-body p-4 p-md-5 pt-0">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" style="border-radius: 12px;">
                            <ul class="mb-0 ps-3">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?area=client&controller=auth&action=login">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Số điện thoại hoặc Email" required style="border-radius: 12px;">
                            <label for="contact">Số điện thoại / Email</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required style="border-radius: 12px;">
                            <label for="password">Mật khẩu</label>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label text-muted" for="remember">
                                    Ghi nhớ
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none" style="color: var(--accent);">Quên mật khẩu?</a>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-accent btn-lg" style="border-radius: 12px;">Đăng nhập</button>
                        </div>
                    </form>

                    <div class="text-center mt-4 text-muted">
                        Chưa có tài khoản? <a href="index.php?area=client&controller=auth&action=register" class="fw-bold text-decoration-none" style="color: var(--primary);">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
