<?php
namespace Controllers\Admin;

use DAO\OrderDAO;
use DAO\OrderDetailDAO;
use Middleware\CsrfMiddleware;

class OrderController
{
    public function index()
    {
$pageTitle = "Quản lý Đơn hàng";

$orderDAO = new OrderDAO();

// Đọc tham số URL
$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = $_GET["sort"] ?? "newest";
$offset = ($page - 1) * $limit;

// Truy vấn
$totalRecords = $orderDAO->count("orders o LEFT JOIN customers c ON o.customer_id = c.id", "c.fullname", $keyword);
$totalPages = ceil($totalRecords / $limit);
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

$orders = $orderDAO->getPage($limit, $offset, $keyword, $sort);
        require_once __DIR__ . '/../../views/admin/orders/index.php';
    }

    public function detail()
    {
$pageTitle = "Chi tiết Đơn hàng";



$orderDAO = new OrderDAO();
$orderDetailDAO = new OrderDetailDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=order&action=index");
    exit;
}
$id = (int)$_GET['id'];
$order = $orderDAO->findById($id);

if (!$order) {
    header("Location: index.php?area=admin&controller=order&action=index");
    exit;
}

$orderDetails = $orderDetailDAO->getByOrderId($id);

function getStatusText($status) {
    switch ($status) {
        case 0: return 'Chờ xác nhận';
        case 1: return 'Đã xác nhận';
        case 2: return 'Đang giao';
        case 3: return 'Hoàn thành';
        case 4: return 'Đã hủy';
        default: return 'Không xác định';
    }
}
function getStatusClass($status) {
    switch ($status) {
        case 0: return 'bg-secondary';
        case 1: return 'bg-info text-dark';
        case 2: return 'bg-warning text-dark';
        case 3: return 'bg-success';
        case 4: return 'bg-danger';
        default: return 'bg-dark';
    }
}
        require_once __DIR__ . '/../../views/admin/orders/detail.php';
    }

    public function update_status()
    {
$pageTitle = "Cập nhật trạng thái Đơn hàng";

$orderDAO = new OrderDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php?area=admin&controller=order&action=index");
    exit;
}
$id = (int)$_GET['id'];
$order = $orderDAO->findById($id);

if (!$order) {
    header("Location: index.php?area=admin&controller=order&action=index");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newStatus = (int)$_POST['status'];
    $currentStatus = (int)$order->status;
    
    // Logic validate quá trình chuyển đổi trạng thái
    $isValid = false;
    if ($currentStatus == 0 && in_array($newStatus, [0, 1, 4])) $isValid = true;
    elseif ($currentStatus == 1 && in_array($newStatus, [1, 2, 4])) $isValid = true;
    elseif ($currentStatus == 2 && in_array($newStatus, [2, 3])) $isValid = true;
    elseif ($currentStatus == 3 && $newStatus == 3) $isValid = true;
    elseif ($currentStatus == 4 && $newStatus == 4) $isValid = true;
    
    if (!$isValid) {
        $error = "Chuyển đổi trạng thái không hợp lệ!";
    } else {
        if ($orderDAO->updateStatus($id, $newStatus)) {
            header("Location: index.php?area=admin&controller=order&action=index&msg=updated");
            exit;
        } else {
            $error = "Cập nhật trạng thái thất bại!";
        }
    }
}
        require_once __DIR__ . '/../../views/admin/orders/update_status.php';
    }

}
