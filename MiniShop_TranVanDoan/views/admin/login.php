<?php
require_once __DIR__ . '/../../dao/UserDAO.php';
require_once __DIR__ . '/../../middleware/GuestMiddleware.php';
require_once __DIR__ . '/../../middleware/CsrfMiddleware.php';

session_start();
GuestMiddleware::handle();
CsrfMiddleware::generateToken();

$errors = [];
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    CsrfMiddleware::verify();

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validate
    if ($username === "") {
        $errors["username"] = "Vui lòng nhập tên đăng nhập.";
    }
    if ($password === "") {
        $errors["password"] = "Vui lòng nhập mật khẩu.";
    }

    // Nếu không có lỗi thì tìm user
    if (empty($errors)) {
        $userDAO = new UserDAO();
        $user = $userDAO->findByUsername($username);

        if (!$user) {
            $errors["username"] = "Tên đăng nhập không tồn tại.";
        } elseif (!password_verify($password, $user->password)) {
            $errors["password"] = "Mật khẩu không chính xác.";
        } else {
            // Kiểm tra trạng thái hoạt động của User
            if ($user->status == 0) {
                $errors["username"] = "Tài khoản của bạn đã bị khóa.";
            } else {
                $_SESSION["user"] = $user;

                // Xử lý Remember Me (Ghi nhớ đăng nhập)
                if (isset($_POST['remember'])) {
                    // Tạo mã token đơn giản (Trong thực tế nên lưu token vào DB)
                    $token = base64_encode($user->username . ':' . md5($user->password . 'secret'));
                    setcookie('remember_token', $token, time() + (86400 * 30), "/"); // 30 ngày
                }

                header("Location: dashboard.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 text-primary fw-bold">Đăng nhập</h3>
                        
                        <form action="login.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên đăng nhập</label>
                                <input type="text" name="username" 
                                    class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                    placeholder="Nhập tên đăng nhập" 
                                    value="<?= htmlspecialchars($username) ?>">
                                <?php if (isset($errors["username"])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors["username"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mật khẩu</label>
                                <input type="password" name="password" 
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                    placeholder="Nhập mật khẩu">
                                <?php if (isset($errors["password"])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors["password"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember"> Ghi nhớ đăng nhập</label>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary py-2 fw-bold">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
