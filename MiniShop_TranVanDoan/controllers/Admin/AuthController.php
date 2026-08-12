<?php
namespace Controllers\Admin;

use DAO\UserDAO;
use Middleware\CsrfMiddleware;

class AuthController
{
    public function login()
    {
        $pageTitle = "Đăng nhập";
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            CsrfMiddleware::verify();
            
            $username = trim($_POST["username"] ?? "");
            $password = $_POST["password"] ?? "";

            if ($username === "") {
                $errors[] = "Vui lòng nhập tên đăng nhập.";
            }
            if ($password === "") {
                $errors[] = "Vui lòng nhập mật khẩu.";
            }

            if (empty($errors)) {
                $userDAO = new UserDAO();
                $user = $userDAO->findByUsername($username);

                if (!$user) {
                    $errors[] = "Tài khoản không tồn tại.";
                } elseif (!password_verify($password, $user->password)) {
                    $errors[] = "Mật khẩu không chính xác.";
                } else {
                    if ($user->status == 0) {
                        $errors[] = "Tài khoản của bạn đã bị khóa.";
                    } else {
                        // Đăng nhập thành công
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['username'] = $user->username;
                        $_SESSION['role'] = $user->role;
                        
                        // Remember Me
                        if (isset($_POST['remember'])) {
                            setcookie('remember_user', $user->username, time() + (86400 * 30), "/"); // 30 ngày
                        }

                        header("Location: index.php?area=admin&controller=product&action=index");
                        exit;
                    }
                }
            }
        }

        require_once __DIR__ . '/../../views/admin/login.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }
        header("Location: index.php?area=admin&controller=auth&action=login");
        exit;
    }
}
