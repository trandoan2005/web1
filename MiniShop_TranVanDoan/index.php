<?php
require_once __DIR__ . '/autoload.php';

session_start();

// Nhận Request
$area = $_GET["area"] ?? "client";
$controller = $_GET["controller"] ?? "home";
$action = $_GET["action"] ?? "index";

// *** Kiểm tra Authentication cho Admin
if ($area === "admin" && $controller !== "auth") {
    \Middleware\AuthMiddleware::handle();
}

// *** Kiểm tra Guest
// if ($area === "admin" && $controller === "auth" && $action === "login") {
//     \Middleware\GuestMiddleware::handle();
// }

// *** Kiểm tra CSRF Token
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    \Middleware\CsrfMiddleware::generateToken(); // Chỉ sinh khi cần hoặc xử lý riêng, nhưng Lab 11 y/c
    // Ở view đã gọi generateToken(), nên ở đây chỉ cần verify nếu là POST
    // Wait, \Middleware\CsrfMiddleware::verify(); should be in Controllers or here? 
    // Theo Lab 11: 
    // if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //     \Middleware\CsrfMiddleware::generateToken(); // <-- Lab PDF viết sai logic, thực tế là tạo token
    // }
    // Actually in Lab 11:
    // // *** Tạo CSRF Token
    // if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //     \Middleware\CsrfMiddleware::generateToken();
    // }
}
// Sinh CSRF token cho mọi Request (để form có token khi render)
\Middleware\CsrfMiddleware::generateToken();

// Xác định tên Controller
$controllerClass = "Controllers\\" . ucfirst($area) . "\\" . ucfirst($controller) . "Controller";

// Kiểm tra Controller
if (!class_exists($controllerClass)) {
    die("Controller không tồn tại: " . $controllerClass);
}

// Tạo Controller
$controllerObject = new $controllerClass();

// Kiểm tra Action
if (!method_exists($controllerObject, $action)) {
    die("Action không tồn tại: " . $action);
}

// Gọi Action
$controllerObject->$action();
