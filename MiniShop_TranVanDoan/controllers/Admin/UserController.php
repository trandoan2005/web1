<?php
namespace Controllers\Admin;

use DAO\UserDAO;
use Middleware\CsrfMiddleware;

class UserController
{
    public function index()
    {
$pageTitle = "Quản lý Nhân viên";

\Middleware\AuthMiddleware::checkAdmin();
$userDAO = new UserDAO();

// Xử lý Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
    $id = $_POST['id'];
    if ($userDAO->delete($id)) {
        header("Location: index.php?area=admin&controller=user&action=index&msg=deleted");
        exit;
    } else {
        $error = "Xóa thất bại!";
    }
}

// Đọc tham số URL
$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = $_GET["sort"] ?? "name_asc";
$offset = ($page - 1) * $limit;

// Truy vấn
$totalRecords = $userDAO->count("users", "fullname", $keyword);
$totalPages = ceil($totalRecords / $limit);
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

$users = $userDAO->getPage($limit, $offset, $keyword, $sort);
        require_once __DIR__ . '/../../views/admin/users/index.php';
    }

    public function create()
    {
$pageTitle = "Thêm Người dùng";

$userDAO = new UserDAO();

$errors = [];
$username = "";
$password = "";
$fullname = "";
$email = "";
$phone = "";
$role = "";

$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $role = trim($_POST["role"] ?? "");

    $status = $_POST["status"] ?? 1;

    // Validation
    if ($username === "") { $errors[] = "Tên đăng nhập không được để trống."; }
    if ($password === "") { $errors[] = "Mật khẩu không được để trống."; }
    if ($fullname === "") { $errors[] = "Họ tên không được để trống."; }
    if ($email === "") { $errors[] = "Email không được để trống."; }
    if ($phone === "") { $errors[] = "Điện thoại không được để trống."; }
    if ($role === "") { $errors[] = "Vai trò (admin/staff) không được để trống."; }


    if (empty($errors)) {
        $obj = new User(0, $username, $password, $fullname, $email, $phone, $role, $status);
        if ($userDAO->insert($obj)) {
            header("Location: index.php?area=admin&controller=user&action=index");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/users/create.php';
    }

    public function edit()
    {
$pageTitle = "Cập nhật Người dùng";

$userDAO = new UserDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=user&action=index");
    exit;
}
$id = (int)$_GET['id'];
$obj = $userDAO->findById($id);

if (!$obj) {
    header("Location: index.php?area=admin&controller=user&action=index");
    exit;
}

$errors = [];
$username = $obj->username;
$password = $obj->password;
$fullname = $obj->fullname;
$email = $obj->email;
$phone = $obj->phone;
$role = $obj->role;

$status = $obj->status;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $role = trim($_POST["role"] ?? "");

    $status = $_POST["status"] ?? 1;

    // Validation
    if ($username === "") { $errors[] = "Tên đăng nhập không được để trống."; }
    if ($password === "") { $errors[] = "Mật khẩu không được để trống."; }
    if ($fullname === "") { $errors[] = "Họ tên không được để trống."; }
    if ($email === "") { $errors[] = "Email không được để trống."; }
    if ($phone === "") { $errors[] = "Điện thoại không được để trống."; }
    if ($role === "") { $errors[] = "Vai trò (admin/staff) không được để trống."; }


    if (empty($errors)) {
        $obj->username = $username;
        $obj->password = $password;
        $obj->fullname = $fullname;
        $obj->email = $email;
        $obj->phone = $phone;
        $obj->role = $role;

        $obj->status = $status;
        
        if ($userDAO->update($obj)) {
            header("Location: index.php?area=admin&controller=user&action=index");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/users/edit.php';
    }

    public function detail()
    {
$pageTitle = "Chi tiết Người dùng";

$userDAO = new UserDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=user&action=index");
    exit;
}
$id = (int)$_GET['id'];
$obj = $userDAO->findById($id);

if (!$obj) {
    header("Location: index.php?area=admin&controller=user&action=index");
    exit;
}
        require_once __DIR__ . '/../../views/admin/users/detail.php';
    }

}
