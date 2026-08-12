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
            header("Location: index.php?area=admin&controller=dashboard&action=index");
            exit;
        }
    }
}
?>
