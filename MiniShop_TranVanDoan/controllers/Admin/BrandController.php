<?php
namespace Controllers\Admin;

use DAO\BrandDAO;
use Middleware\CsrfMiddleware;

class BrandController
{
    public function index()
    {
$pageTitle = "Quản lý Thương hiệu";

$brandDAO = new BrandDAO();

// Xử lý Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
    $id = $_POST['id'];
    if ($brandDAO->delete($id)) {
        header("Location: index.php?area=admin&controller=brand&action=index&msg=deleted");
        exit;
    } else {
        $error = "Xóa thất bại (có thể thương hiệu đang chứa sản phẩm)!";
    }
}

// Đọc tham số URL
$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = $_GET["sort"] ?? "name_asc";
$offset = ($page - 1) * $limit;

// Truy vấn
$totalRecords = $brandDAO->count("brands", "name", $keyword);
$totalPages = ceil($totalRecords / $limit);
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

$brands = $brandDAO->getPage($limit, $offset, $keyword, $sort);
        require_once __DIR__ . '/../../views/admin/brands/index.php';
    }

    public function create()
    {
$pageTitle = "Thêm Thương hiệu";

$brandDAO = new BrandDAO();

$errors = [];
$name = "";
$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = "";

    if ($name === "") {
        $errors[] = "Tên thương hiệu không được để trống.";
    }

    $tmpName = "";
    if ($fileName != "") {
        $fileSize = $_FILES["image"]["size"] ?? 0;
        $error = $_FILES["image"]["error"] ?? 0;
        $tmpName = $_FILES["image"]["tmp_name"] ?? "";

        if ($error != UPLOAD_ERR_OK) {
            $errors[] = "Upload hình ảnh không thành công.";
        }
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) {
            $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        }
        $maxSize = 5 * 1024 * 1024;
        if ($fileSize > $maxSize) {
            $errors[] = "Kích thước hình ảnh <= 5 MB.";
        }
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $image = time() . "_" . rand(1000, 9999) . "." . $extension;
            $uploadPath = __DIR__ . "/../../uploads/brands/" . $image;
            move_uploaded_file($tmpName, $uploadPath);
        }

        $b = new Brand(0, $name, $image, $status);
        if ($brandDAO->insert($b)) {
            header("Location: index.php?area=admin&controller=brand&action=index");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/brands/create.php';
    }

    public function edit()
    {
$pageTitle = "Cập nhật Thương hiệu";

$brandDAO = new BrandDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=brand&action=index");
    exit;
}
$id = (int)$_GET['id'];
$brandOld = $brandDAO->findById($id);

if (!$brandOld) {
    header("Location: index.php?area=admin&controller=brand&action=index");
    exit;
}

$errors = [];
$name = $brandOld->name;
$status = $brandOld->status;
$image = $brandOld->logo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = $brandOld->logo; // Giữ nguyên hình cũ

    if ($name === "") {
        $errors[] = "Tên thương hiệu không được để trống.";
    }

    $tmpName = "";
    if ($fileName != "") {
        $fileSize = $_FILES["image"]["size"] ?? 0;
        $error = $_FILES["image"]["error"] ?? 0;
        $tmpName = $_FILES["image"]["tmp_name"] ?? "";

        if ($error != UPLOAD_ERR_OK) {
            $errors[] = "Upload hình ảnh không thành công.";
        }
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) {
            $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        }
        $maxSize = 5 * 1024 * 1024;
        if ($fileSize > $maxSize) {
            $errors[] = "Kích thước hình ảnh <= 5 MB.";
        }
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $image = time() . "_" . rand(1000, 9999) . "." . $extension;
            $uploadPath = __DIR__ . "/../../uploads/brands/" . $image;

            // Xóa hình cũ
            if (!empty($brandOld->logo)) {
                $oldImage = __DIR__ . "/../../uploads/brands/" . $brandOld->logo;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            move_uploaded_file($tmpName, $uploadPath);
        }

        $brandOld->name = $name;
        $brandOld->status = $status;
        $brandOld->logo = $image;

        if ($brandDAO->update($brandOld)) {
            header("Location: index.php?area=admin&controller=brand&action=index");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/brands/edit.php';
    }

    public function detail()
    {
$pageTitle = "Chi tiết Thương hiệu";

$brandDAO = new BrandDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=brand&action=index");
    exit;
}
$id = (int)$_GET['id'];
$obj = $brandDAO->findById($id);

if (!$obj) {
    header("Location: index.php?area=admin&controller=brand&action=index");
    exit;
}
        require_once __DIR__ . '/../../views/admin/brands/detail.php';
    }

}
