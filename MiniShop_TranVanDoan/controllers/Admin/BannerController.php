<?php
namespace Controllers\Admin;

use DAO\BannerDAO;
use Models\Banner;

class BannerController
{
    private function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?area=admin&controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        $bannerDAO = new BannerDAO();
        
        $keyword = trim($_GET["keyword"] ?? "");
        $banners = $bannerDAO->getAll($keyword);
        
        $pageTitle = "Quản lý Banners";
        require_once __DIR__ . '/../../views/admin/banners/index.php';
    }

    public function create()
    {
        $this->checkAuth();
        $pageTitle = "Thêm Banner mới";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST["title"] ?? "");
            $link = trim($_POST["link"] ?? "");
            $sort_order = (int)($_POST["sort_order"] ?? 0);
            $status = isset($_POST["status"]) ? 1 : 0;
            
            $errors = [];
            
            if ($title === "") $errors[] = "Vui lòng nhập tiêu đề.";
            
            $image = "";
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if (in_array($ext, $allowed)) {
                    $image = time() . "_" . $_FILES["image"]["name"];
                    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/banners/" . $image);
                } else {
                    $errors[] = "Chỉ chấp nhận file ảnh.";
                }
            } else {
                $errors[] = "Vui lòng chọn hình ảnh.";
            }

            if (empty($errors)) {
                $bannerDAO = new BannerDAO();
                $b = new Banner(0, $title, $image, $link, $sort_order, $status, null, null);
                if ($bannerDAO->insert($b)) {
                    $_SESSION['success'] = "Thêm banner thành công!";
                    header("Location: index.php?area=admin&controller=banner&action=index");
                    exit;
                } else {
                    $errors[] = "Lỗi khi lưu vào cơ sở dữ liệu.";
                }
            }
        }

        require_once __DIR__ . '/../../views/admin/banners/create.php';
    }

    public function edit()
    {
        $this->checkAuth();
        $id = (int)($_GET["id"] ?? 0);
        $bannerDAO = new BannerDAO();
        $banner = $bannerDAO->findById($id);

        if (!$banner) {
            $_SESSION['error'] = "Không tìm thấy banner.";
            header("Location: index.php?area=admin&controller=banner&action=index");
            exit;
        }

        $pageTitle = "Chỉnh sửa Banner";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($_POST["title"] ?? "");
            $link = trim($_POST["link"] ?? "");
            $sort_order = (int)($_POST["sort_order"] ?? 0);
            $status = isset($_POST["status"]) ? 1 : 0;

            $errors = [];
            if ($title === "") $errors[] = "Vui lòng nhập tiêu đề.";

            $image = $banner->image;
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if (in_array($ext, $allowed)) {
                    $image = time() . "_" . $_FILES["image"]["name"];
                    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/banners/" . $image);
                    
                    if (!empty($banner->image) && file_exists("uploads/banners/" . $banner->image)) {
                        unlink("uploads/banners/" . $banner->image);
                    }
                } else {
                    $errors[] = "Chỉ chấp nhận file ảnh.";
                }
            }

            if (empty($errors)) {
                $banner->title = $title;
                $banner->link = $link;
                $banner->sortOrder = $sort_order;
                $banner->status = $status;
                $banner->image = $image;

                if ($bannerDAO->update($banner)) {
                    $_SESSION['success'] = "Cập nhật banner thành công!";
                    header("Location: index.php?area=admin&controller=banner&action=index");
                    exit;
                } else {
                    $errors[] = "Lỗi khi cập nhật cơ sở dữ liệu.";
                }
            }
        }

        require_once __DIR__ . '/../../views/admin/banners/edit.php';
    }

    public function delete()
    {
        $this->checkAuth();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = (int)($_POST["id"] ?? 0);
            $bannerDAO = new BannerDAO();
            $banner = $bannerDAO->findById($id);

            if ($banner) {
                if (!empty($banner->image) && file_exists("uploads/banners/" . $banner->image)) {
                    unlink("uploads/banners/" . $banner->image);
                }
                if ($bannerDAO->delete($id)) {
                    $_SESSION['success'] = "Xóa banner thành công!";
                } else {
                    $_SESSION['error'] = "Lỗi khi xóa banner.";
                }
            }
        }
        header("Location: index.php?area=admin&controller=banner&action=index");
        exit;
    }
}
?>
