<?php
namespace Controllers\Admin;

use DAO\CustomerDAO;
use Middleware\CsrfMiddleware;

class CustomerController
{
    public function index()
    {
$pageTitle = "Quản lý Khách hàng";

$customerDAO = new CustomerDAO();

// Xử lý Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
    $id = $_POST['id'];
    if ($customerDAO->delete($id)) {
        header("Location: index.php?area=admin&controller=customer&action=index&msg=deleted");
        exit;
    } else {
        $error = "Xóa thất bại (có thể khách hàng này đang có đơn hàng)!";
    }
}

// Đọc tham số URL
$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = $_GET["sort"] ?? "name_asc";
$offset = ($page - 1) * $limit;

// Truy vấn
$totalRecords = $customerDAO->count("customers", "fullname", $keyword);
$totalPages = ceil($totalRecords / $limit);
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

$customers = $customerDAO->getPage($limit, $offset, $keyword, $sort);
        require_once __DIR__ . '/../../views/admin/customers/index.php';
    }

    public function create()
    {
$pageTitle = "Thêm Khách hàng";

$customerDAO = new CustomerDAO();

$errors = [];
$fullname = "";
$email = "";
$phone = "";
$address = "";

$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");

    $status = $_POST["status"] ?? 1;

    // Validation
    if ($fullname === "") { $errors[] = "Họ tên không được để trống."; }
    if ($email === "") { $errors[] = "Email không được để trống."; }
    if ($phone === "") { $errors[] = "Điện thoại không được để trống."; }
    if ($address === "") { $errors[] = "Địa chỉ không được để trống."; }


    if (empty($errors)) {
        $obj = new Customer(0, $fullname, $email, $phone, $address, $status);
        if ($customerDAO->insert($obj)) {
            header("Location: index.php?area=admin&controller=customer&action=index");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/customers/create.php';
    }

    public function edit()
    {
$pageTitle = "Cập nhật Khách hàng";

$customerDAO = new CustomerDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=customer&action=index");
    exit;
}
$id = (int)$_GET['id'];
$obj = $customerDAO->findById($id);

if (!$obj) {
    header("Location: index.php?area=admin&controller=customer&action=index");
    exit;
}

$errors = [];
$fullname = $obj->fullname;
$email = $obj->email;
$phone = $obj->phone;
$address = $obj->address;

$status = $obj->status;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");

    $status = $_POST["status"] ?? 1;

    // Validation
    if ($fullname === "") { $errors[] = "Họ tên không được để trống."; }
    if ($email === "") { $errors[] = "Email không được để trống."; }
    if ($phone === "") { $errors[] = "Điện thoại không được để trống."; }
    if ($address === "") { $errors[] = "Địa chỉ không được để trống."; }


    if (empty($errors)) {
        $obj->fullname = $fullname;
        $obj->email = $email;
        $obj->phone = $phone;
        $obj->address = $address;

        $obj->status = $status;
        
        if ($customerDAO->update($obj)) {
            header("Location: index.php?area=admin&controller=customer&action=index");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/customers/edit.php';
    }

    public function detail()
    {
$pageTitle = "Chi tiết Khách hàng";

$customerDAO = new CustomerDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=customer&action=index");
    exit;
}
$id = (int)$_GET['id'];
$obj = $customerDAO->findById($id);

if (!$obj) {
    header("Location: index.php?area=admin&controller=customer&action=index");
    exit;
}
        require_once __DIR__ . '/../../views/admin/customers/detail.php';
    }

}
