<?php
session_start();
session_unset();
session_destroy();
// Xóa cookie Remember Me
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}
header("Location: login.php");
exit;
?>
