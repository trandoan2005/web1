<?php

namespace Controllers\Admin;

use DAO\ProductDAO;
use DAO\CategoryDAO;
use DAO\BrandDAO;
use Middleware\CsrfMiddleware;

class ProductController
{
    public function index()
    {

        $pageTitle = "Quản lý Sản phẩm";

        $productDAO = new ProductDAO();

        // Xử lý Xóa
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
            $id = $_POST['id'];
            if ($productDAO->delete($id)) {
                header("Location: index.php?area=admin&controller=product&action=index&msg=deleted");
                exit;
            } else {
                $error = "Xóa thất bại! Dữ liệu đang được sử dụng ở nơi khác (ví dụ: đã có trong đơn hàng).";
            }
        }

        // Đọc tham số URL
        $keyword = trim($_GET["keyword"] ?? "");
        $limit = (int)($_GET["limit"] ?? 10);
        $page = (int)($_GET["page"] ?? 1);
        $sort = $_GET["sort"] ?? "name_asc";
        $offset = ($page - 1) * $limit;

        // Truy vấn
        $totalRecords = $productDAO->count("products", "name", $keyword);
        $totalPages = ceil($totalRecords / $limit);
        // Đảm bảo page hợp lệ
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }

        $products = $productDAO->getPage($limit, $offset, $keyword, $sort);
        require_once __DIR__ . '/../../views/admin/products/index.php';
    }

    public function create()
    {
        $pageTitle = "Thêm Sản phẩm";




        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        $errors = [];
        $name = $slug = $description = "";
        $categoryId = $brandId = 0;
        $oldPrice = $salePrice = $quantity = 0;
        $status = 1;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST["name"] ?? "");
            $slug = trim($_POST["slug"] ?? "");
            $categoryId = (int)($_POST["categoryId"] ?? 0);
            $brandId = (int)($_POST["brandId"] ?? 0);
            $oldPrice = (float)($_POST["oldPrice"] ?? 0);
            $salePrice = (float)($_POST["salePrice"] ?? 0);
            $quantity = (int)($_POST["quantity"] ?? 0);
            $description = trim($_POST["description"] ?? "");
            $status = (int)($_POST["status"] ?? 1);

            $fileName = $_FILES["image"]["name"] ?? "";
            $image = ""; // gán giá trị tạm thời

            // Validation
            if ($name === "") $errors[] = "Tên sản phẩm không được để trống.";
            if ($categoryId <= 0) $errors[] = "Vui lòng chọn danh mục.";
            if ($brandId <= 0) $errors[] = "Vui lòng chọn thương hiệu.";
            if ($salePrice <= 0) $errors[] = "Giá bán phải lớn hơn 0.";
            if ($quantity < 0) $errors[] = "Số lượng không hợp lệ.";

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

            // Nếu không có lỗi
            if (empty($errors)) {
                if ($fileName != "") {
                    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $image = time() . "_" . $slug . "." . $extension;
                    $uploadPath = __DIR__ . "/../../uploads/products/" . $image;
                    move_uploaded_file($tmpName, $uploadPath);
                }

                $p = new Product(0, $categoryId, $brandId, $name, $slug, $oldPrice, $salePrice, $quantity, $description, $image, $status);
                if ($productDAO->insert($p)) {
                    header("Location: index.php?area=admin&controller=product&action=index");
                    exit;
                } else {
                    $errors[] = "Thêm thất bại. Vui lòng thử lại.";
                }
            }
        }
        require_once __DIR__ . '/../../views/admin/products/create.php';
    }

    public function edit()
    {
        $pageTitle = "Cập nhật Sản phẩm";




        $productDAO = new ProductDAO();
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();

        if (!isset($_GET['id'])) {
            header("Location: index.php?area=admin&controller=product&action=index");
            exit;
        }
        $id = (int)$_GET['id'];
        $productOld = $productDAO->findById($id);

        if (!$productOld) {
            header("Location: index.php?area=admin&controller=product&action=index");
            exit;
        }

        // Code xử lý XÓA hình ảnh trong Gallery (nếu có)
        if (isset($_GET['delete_image_id'])) {
            $imgId = (int)$_GET['delete_image_id'];
            $imgName = $_GET['image_name'];

            if ($productDAO->deleteImage($imgId)) {
                // Xóa file vật lý
                $filePath = __DIR__ . "/../../uploads/products/" . $imgName;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                header("Location: index.php?area=admin&controller=product&action=edit&id=$id&msg=img_deleted");
                exit;
            }
        }

        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();
        $galleryImages = $productDAO->getImagesByProductId($id);

        $errors = [];
        $name = $productOld->name;
        $slug = $productOld->slug;
        $categoryId = $productOld->categoryId;
        $brandId = $productOld->brandId;
        $oldPrice = $productOld->oldPrice;
        $salePrice = $productOld->salePrice;
        $quantity = $productOld->quantity;
        $description = $productOld->description;
        $status = $productOld->status;
        $image = $productOld->image;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST["name"] ?? "");
            $slug = trim($_POST["slug"] ?? "");
            $categoryId = (int)($_POST["categoryId"] ?? 0);
            $brandId = (int)($_POST["brandId"] ?? 0);
            $oldPrice = (float)($_POST["oldPrice"] ?? 0);
            $salePrice = (float)($_POST["salePrice"] ?? 0);
            $quantity = (int)($_POST["quantity"] ?? 0);
            $description = trim($_POST["description"] ?? "");
            $status = (int)($_POST["status"] ?? 1);

            $fileName = $_FILES["image"]["name"] ?? "";
            $image = $productOld->image; // Giữ nguyên hình cũ

            // Validation
            if ($name === "") $errors[] = "Tên sản phẩm không được để trống.";
            if ($categoryId <= 0) $errors[] = "Vui lòng chọn danh mục.";
            if ($brandId <= 0) $errors[] = "Vui lòng chọn thương hiệu.";
            if ($salePrice <= 0) $errors[] = "Giá bán phải lớn hơn 0.";
            if ($quantity < 0) $errors[] = "Số lượng không hợp lệ.";

            $tmpName = "";
            if ($fileName != "") {
                $fileSize = $_FILES["image"]["size"] ?? 0;
                $error = $_FILES["image"]["error"] ?? 0;
                $tmpName = $_FILES["image"]["tmp_name"] ?? "";

                if ($error != UPLOAD_ERR_OK) {
                    $errors[] = "Upload hình ảnh đại diện không thành công.";
                }
                $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (!in_array($extension, $allowExtensions)) {
                    $errors[] = "Ảnh đại diện: Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
                }
                $maxSize = 5 * 1024 * 1024;
                if ($fileSize > $maxSize) {
                    $errors[] = "Ảnh đại diện: Kích thước <= 5 MB.";
                }
            }

            if (empty($errors)) {
                // Có chọn hình ảnh mới
                if ($fileName != "") {
                    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $image = time() . "_" . $slug . "." . $extension;
                    $uploadPath = __DIR__ . "/../../uploads/products/" . $image;

                    // Xóa hình ảnh cũ (nếu có)
                    if (!empty($productOld->image)) {
                        $oldImage = __DIR__ . "/../../uploads/products/" . $productOld->image;
                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                    }
                    // Upload hình ảnh mới
                    move_uploaded_file($tmpName, $uploadPath);
                }

                // Upload nhiều hình ảnh (Gallery)
                $images = $_FILES["images"] ?? null;
                if ($images && is_array($images['name'])) {
                    for ($i = 0; $i < count($images['name']); $i++) {
                        $galFileName = $images['name'][$i];
                        if ($galFileName != "") {
                            $galTmpName = $images['tmp_name'][$i];
                            $ext = strtolower(pathinfo($galFileName, PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $newImageName = time() . "_" . rand(100, 999) . "." . $ext;
                                $galUploadPath = __DIR__ . "/../../uploads/products/" . $newImageName;
                                if (move_uploaded_file($galTmpName, $galUploadPath)) {
                                    $productDAO->insertImage($id, $newImageName);
                                }
                            }
                        }
                    }
                }

                $productOld->name = $name;
                $productOld->slug = $slug;
                $productOld->categoryId = $categoryId;
                $productOld->brandId = $brandId;
                $productOld->oldPrice = $oldPrice;
                $productOld->salePrice = $salePrice;
                $productOld->quantity = $quantity;
                $productOld->description = $description;
                $productOld->image = $image;
                $productOld->status = $status;

                if ($productDAO->update($productOld)) {
                    header("Location: index.php?area=admin&controller=product&action=index");
                    exit;
                } else {
                    $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
                }
            }
        }
        require_once __DIR__ . '/../../views/admin/products/edit.php';
    }

    public function detail()
    {
        $pageTitle = "Chi tiết Sản phẩm";

        $productDAO = new ProductDAO();

        if (!isset($_GET['id'])) {
            header("Location: index.php?area=admin&controller=product&action=index");
            exit;
        }
        $id = (int)$_GET['id'];
        $product = $productDAO->findById($id);

        if (!$product) {
            header("Location: index.php?area=admin&controller=product&action=index");
            exit;
        }
        require_once __DIR__ . '/../../views/admin/products/detail.php';
    }
}
