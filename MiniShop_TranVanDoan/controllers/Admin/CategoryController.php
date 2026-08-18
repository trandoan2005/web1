<?php
namespace Controllers\Admin;

use DAO\CategoryDAO;
use Middleware\CsrfMiddleware;

class CategoryController
{
    public function index()
    {
$pageTitle = "Quản lý Danh mục";


$categoryDAO = new CategoryDAO();

// Xử lý Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
    CsrfMiddleware::verify();
    $id = $_POST['id'];
    if ($categoryDAO->delete($id)) {
        header("Location: index.php?area=admin&controller=category&action=index&msg=deleted");
        exit;
    } else {
        $error = "Xóa thất bại (có thể danh mục này đang chứa sản phẩm)!";
    }
}

// Đọc tham số URL
$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = $_GET["sort"] ?? "name_asc";
$offset = ($page - 1) * $limit;

// Truy vấn
$totalRecords = $categoryDAO->count("categories", "name", $keyword);
$totalPages = ceil($totalRecords / $limit);
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

$categories = $categoryDAO->getPage($limit, $offset, $keyword, $sort);
        require_once __DIR__ . '/../../views/admin/categories/index.php';
    }

    public function create()
    {
$pageTitle = "Thêm Danh mục";


$categoryDAO = new CategoryDAO();

$errors = [];
$name = $description = "";
$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = "";

    if ($name === "") {
        $errors[] = "Tên danh mục không được để trống.";
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
            $uploadPath = __DIR__ . "/../../uploads/categories/" . $image;
            move_uploaded_file($tmpName, $uploadPath);
        }

        $c = new Category(0, $name, $description, $image, $status);
        if ($categoryDAO->insert($c)) {
            header("Location: index.php?area=admin&controller=category&action=index");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/categories/create.php';
    }

    public function edit()
    {
$pageTitle = "Cập nhật Danh mục";


$categoryDAO = new CategoryDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=category&action=index");
    exit;
}
$id = (int)$_GET['id'];
$catOld = $categoryDAO->findById($id);

if (!$catOld) {
    header("Location: index.php?area=admin&controller=category&action=index");
    exit;
}

$errors = [];
$name = $catOld->name;
$description = $catOld->description;
$status = $catOld->status;
$image = $catOld->image;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = (int)($_POST["status"] ?? 1);

    $fileName = $_FILES["image"]["name"] ?? "";
    $image = $catOld->image; // Giữ nguyên hình cũ

    if ($name === "") {
        $errors[] = "Tên danh mục không được để trống.";
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
            $uploadPath = __DIR__ . "/../../uploads/categories/" . $image;

            // Xóa hình cũ
            if (!empty($catOld->image)) {
                $oldImage = __DIR__ . "/../../uploads/categories/" . $catOld->image;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            move_uploaded_file($tmpName, $uploadPath);
        }

        $catOld->name = $name;
        $catOld->description = $description;
        $catOld->image = $image;
        $catOld->status = $status;

        if ($categoryDAO->update($catOld)) {
            header("Location: index.php?area=admin&controller=category&action=index");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/categories/edit.php';
    }

    public function detail()
    {
$pageTitle = "Chi tiết Danh mục";

$categoryDAO = new CategoryDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=category&action=index");
    exit;
}
$id = (int)$_GET['id'];
$category = $categoryDAO->findById($id);

if (!$category) {
    header("Location: index.php?area=admin&controller=category&action=index");
    exit;
}
        require_once __DIR__ . '/../../views/admin/categories/detail.php';
    }

}
