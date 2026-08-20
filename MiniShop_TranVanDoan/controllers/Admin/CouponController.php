<?php
namespace Controllers\Admin;

use DAO\CouponDAO;
use Models\Coupon;

class CouponController
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
        $couponDAO = new CouponDAO();
        
        $keyword = trim($_GET["keyword"] ?? "");
        $coupons = $couponDAO->getAll($keyword);
        
        $pageTitle = "Quản lý Mã Giảm Giá";
        require_once __DIR__ . '/../../views/admin/coupons/index.php';
    }

    public function create()
    {
        $this->checkAuth();
        $pageTitle = "Thêm Mã Giảm Giá mới";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $code = strtoupper(trim($_POST["code"] ?? ""));
            $discount_percent = (int)($_POST["discount_percent"] ?? 0);
            $max_usage = (int)($_POST["max_usage"] ?? 0);
            $valid_until = trim($_POST["valid_until"] ?? "");
            $status = isset($_POST["status"]) ? 1 : 0;
            
            $errors = [];
            
            if ($code === "") $errors[] = "Vui lòng nhập mã giảm giá.";
            if ($discount_percent <= 0 || $discount_percent > 100) $errors[] = "Phần trăm giảm giá phải từ 1 đến 100.";
            if ($valid_until === "") {
                $valid_until = null;
            }

            $couponDAO = new CouponDAO();
            if ($couponDAO->findByCode($code)) {
                $errors[] = "Mã giảm giá này đã tồn tại.";
            }

            if (empty($errors)) {
                $c = new Coupon(0, $code, $discount_percent, $max_usage, 0, $valid_until, $status, null);
                if ($couponDAO->insert($c)) {
                    $_SESSION['success'] = "Thêm mã giảm giá thành công!";
                    header("Location: index.php?area=admin&controller=coupon&action=index");
                    exit;
                } else {
                    $errors[] = "Lỗi khi lưu vào cơ sở dữ liệu.";
                }
            }
        }

        require_once __DIR__ . '/../../views/admin/coupons/create.php';
    }

    public function edit()
    {
        $this->checkAuth();
        $id = (int)($_GET["id"] ?? 0);
        $couponDAO = new CouponDAO();
        $coupon = $couponDAO->findById($id);

        if (!$coupon) {
            $_SESSION['error'] = "Không tìm thấy mã giảm giá.";
            header("Location: index.php?area=admin&controller=coupon&action=index");
            exit;
        }

        $pageTitle = "Chỉnh sửa Mã Giảm Giá";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $code = strtoupper(trim($_POST["code"] ?? ""));
            $discount_percent = (int)($_POST["discount_percent"] ?? 0);
            $max_usage = (int)($_POST["max_usage"] ?? 0);
            $valid_until = trim($_POST["valid_until"] ?? "");
            $status = isset($_POST["status"]) ? 1 : 0;

            $errors = [];
            if ($code === "") $errors[] = "Vui lòng nhập mã giảm giá.";
            if ($discount_percent <= 0 || $discount_percent > 100) $errors[] = "Phần trăm giảm giá phải từ 1 đến 100.";
            if ($valid_until === "") {
                $valid_until = null;
            }

            $existing = $couponDAO->findByCode($code);
            if ($existing && $existing->id != $id) {
                $errors[] = "Mã giảm giá này đã tồn tại ở một mục khác.";
            }

            if (empty($errors)) {
                $coupon->code = $code;
                $coupon->discountPercent = $discount_percent;
                $coupon->maxUsage = $max_usage;
                $coupon->validUntil = $valid_until;
                $coupon->status = $status;

                if ($couponDAO->update($coupon)) {
                    $_SESSION['success'] = "Cập nhật mã giảm giá thành công!";
                    header("Location: index.php?area=admin&controller=coupon&action=index");
                    exit;
                } else {
                    $errors[] = "Lỗi khi cập nhật cơ sở dữ liệu.";
                }
            }
        }

        require_once __DIR__ . '/../../views/admin/coupons/edit.php';
    }

    public function delete()
    {
        $this->checkAuth();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = (int)($_POST["id"] ?? 0);
            $couponDAO = new CouponDAO();
            
            if ($couponDAO->delete($id)) {
                $_SESSION['success'] = "Xóa mã giảm giá thành công!";
            } else {
                $_SESSION['error'] = "Lỗi khi xóa mã giảm giá.";
            }
        }
        header("Location: index.php?area=admin&controller=coupon&action=index");
        exit;
    }
}
?>
