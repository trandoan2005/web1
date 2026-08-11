<?php
class AuthMiddleware
{
    public static function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Remember Me Logic (nếu session chưa có nhưng cookie có)
        if (!isset($_SESSION["user"]) && isset($_COOKIE['remember_token'])) {
            $token = base64_decode($_COOKIE['remember_token']);
            if (strpos($token, ':') !== false) {
                list($username, $hash) = explode(':', $token);
                require_once __DIR__ . '/../dao/UserDAO.php';
                $userDAO = new UserDAO();
                $user = $userDAO->findByUsername($username);
                if ($user && $user->status == 1) {
                    $expectedHash = md5($user->password . 'secret');
                    if ($hash === $expectedHash) {
                        $_SESSION["user"] = $user;
                    }
                }
            }
        }

        if (!isset($_SESSION["user"])) {
            header("Location: login.php");
            exit;
        }
    }

    public static function checkAdmin()
    {
        self::handle();
        $user = $_SESSION["user"];
        if ($user->role !== 'admin') {
            header("Location: 403.php");
            exit;
        }
    }
}
?>
