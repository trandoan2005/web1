<?php
namespace Middleware;
use DAO\UserDAO;

class AuthMiddleware
{
    public static function handle()
    {

        
        
        // Remember Me Logic (nếu session chưa có nhưng cookie có)
        if (!isset($_SESSION["user"]) && isset($_COOKIE['remember_token'])) {
            $token = base64_decode($_COOKIE['remember_token']);
            if (strpos($token, ':') !== false) {
                list($username, $hash) = explode(':', $token);
                
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
            header("Location: index.php?area=admin&controller=auth&action=login");
            exit;
        }
    }

    public static function checkAdmin()
    {
        self::handle();
        $user = $_SESSION["user"];
        if ($user->role !== 'admin') {
            header("Location: index.php?area=admin&controller=dashboard&action=error403");
            exit;
        }
    }
}
?>
