<?php
namespace Middleware;
use DAO\UserDAO;

class GuestMiddleware
{
    public static function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["user"])) {
            header("Location: /TranVanDoan_LTW1/MiniShop_TranVanDoan/views/admin/dashboard.php");
            exit;
        }
    }
}
?>
