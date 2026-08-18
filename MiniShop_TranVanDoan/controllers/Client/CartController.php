<?php
namespace Controllers\Client;

use DAO\ProductDAO;
use DAO\CategoryDAO;
use DAO\BrandDAO;
use DAO\CustomerDAO;
use DAO\OrderDAO;
use DAO\OrderDetailDAO;

class CartController
{
    private $cartKey = "cart";

    public function index()
    {
        $pageTitle = "Giỏ hàng";
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();
        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        // Lấy giỏ hàng từ Session
        $cart = $_SESSION[$this->cartKey] ?? [];

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item["price"] * $item["quantity"];
        }

        require_once __DIR__ . '/../../views/client/cart/index.php';
    }

    // Thêm sản phẩm vào giỏ hàng (AJAX)
    public function add()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["success" => false, "message" => "Method not allowed"]);
            exit;
        }

        $productId = (int)($_POST['productId'] ?? 0);
        if ($productId <= 0) {
            echo json_encode(["success" => false, "message" => "ID sản phẩm không hợp lệ"]);
            exit;
        }

        $productDAO = new ProductDAO();
        $product = $productDAO->findById($productId);

        if (!$product) {
            echo json_encode(["success" => false, "message" => "Không tìm thấy sản phẩm"]);
            exit;
        }

        // Lấy giá bán
        $price = ($product->oldPrice > $product->salePrice && $product->salePrice > 0)
            ? $product->salePrice
            : $product->salePrice;

        // Kiểm tra sản phẩm đã có trong giỏ
        if (isset($_SESSION[$this->cartKey][$productId])) {
            $_SESSION[$this->cartKey][$productId]["quantity"]++;
        } else {
            $_SESSION[$this->cartKey][$productId] = [
                "productId"   => $product->id,
                "productName" => $product->name,
                "image"       => $product->image,
                "price"       => $price,
                "quantity"    => 1
            ];
        }

        // Tính tổng số lượng trong Cart
        $cartCount = 0;
        foreach ($_SESSION[$this->cartKey] as $item) {
            $cartCount += $item["quantity"];
        }

        echo json_encode([
            "success"   => true,
            "message"   => "Đã thêm sản phẩm vào giỏ hàng",
            "cartCount" => $cartCount
        ]);
        exit;
    }

    // Cập nhật số lượng (AJAX)
    public function update()
    {
        header('Content-Type: application/json; charset=utf-8');

        $productId = (int)($_POST['productId'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);

        if (!isset($_SESSION[$this->cartKey][$productId])) {
            echo json_encode(["success" => false, "message" => "Sản phẩm không có trong giỏ"]);
            exit;
        }

        if ($quantity <= 0) {
            // Xóa sản phẩm nếu quantity <= 0
            unset($_SESSION[$this->cartKey][$productId]);
        } else {
            $_SESSION[$this->cartKey][$productId]["quantity"] = $quantity;
        }

        // Tính lại
        $cartCount = 0;
        $cartTotal = 0;
        $itemTotal = 0;
        foreach ($_SESSION[$this->cartKey] as $item) {
            $cartCount += $item["quantity"];
            $cartTotal += $item["price"] * $item["quantity"];
        }
        if (isset($_SESSION[$this->cartKey][$productId])) {
            $itemTotal = $_SESSION[$this->cartKey][$productId]["price"] * $_SESSION[$this->cartKey][$productId]["quantity"];
        }

        echo json_encode([
            "success"   => true,
            "message"   => "Đã cập nhật giỏ hàng",
            "cartCount" => $cartCount,
            "cartTotal" => number_format($cartTotal, 0, ',', '.'),
            "itemTotal" => number_format($itemTotal, 0, ',', '.'),
            "quantity"  => $quantity
        ]);
        exit;
    }

    // Xóa sản phẩm khỏi giỏ (AJAX)
    public function remove()
    {
        header('Content-Type: application/json; charset=utf-8');

        $productId = (int)($_POST['productId'] ?? 0);

        if (!isset($_SESSION[$this->cartKey][$productId])) {
            echo json_encode(["success" => false, "message" => "Sản phẩm không có trong giỏ"]);
            exit;
        }

        unset($_SESSION[$this->cartKey][$productId]);

        // Tính lại
        $cartCount = 0;
        $cartTotal = 0;
        foreach ($_SESSION[$this->cartKey] as $item) {
            $cartCount += $item["quantity"];
            $cartTotal += $item["price"] * $item["quantity"];
        }

        echo json_encode([
            "success"   => true,
            "message"   => "Đã xóa sản phẩm khỏi giỏ hàng",
            "cartCount" => $cartCount,
            "cartTotal" => number_format($cartTotal, 0, ',', '.')
        ]);
        exit;
    }

    // Trang đặt hàng (Checkout)
    public function checkout()
    {
        $categoryDAO = new CategoryDAO();
        $brandDAO = new BrandDAO();
        $categories = $categoryDAO->getAll();
        $brands = $brandDAO->getAll();

        $cart = $_SESSION[$this->cartKey] ?? [];

        if (empty($cart)) {
            header("Location: index.php?area=client&controller=cart&action=index");
            exit;
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item["price"] * $item["quantity"];
        }

        $pageTitle = "Đặt hàng";
        $errors = [];
        $success = false;

        // Xử lý form POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fullname = trim($_POST["fullname"] ?? "");
            $phone    = trim($_POST["phone"] ?? "");
            $address  = trim($_POST["address"] ?? "");
            $note     = trim($_POST["note"] ?? "");

            // Validate
            if ($fullname === "") $errors[] = "Vui lòng nhập họ tên.";
            if ($phone === "")    $errors[] = "Vui lòng nhập số điện thoại.";
            if ($address === "")  $errors[] = "Vui lòng nhập địa chỉ nhận hàng.";

            if (empty($errors)) {
                $customerDAO = new CustomerDAO();
                $orderDAO = new OrderDAO();
                $orderDetailDAO = new OrderDetailDAO();

                try {
                    $orderDAO->beginTransaction();

                    // Tìm customer theo phone hoặc tạo mới
                    if (isset($_SESSION['customer'])) {
                        $customerId = $_SESSION['customer']['id'];
                        // Cập nhật thông tin nếu có thay đổi
                        $customer = clone $customerDAO->findById($customerId);
                        if ($customer) {
                            $customer->fullname = $fullname;
                            $customer->phone = $phone;
                            $customer->address = $address;
                            $customerDAO->update($customer);
                        }
                    } else {
                        $customer = $customerDAO->findByPhone($phone);
                        if ($customer) {
                            $customerId = $customer->id;
                        } else {
                            $customerId = $customerDAO->insertAndGetId($fullname, $phone, $address);
                        }
                    }

                    // Tạo đơn hàng
                    $orderId = $orderDAO->insertAndGetId($customerId, $total, "Chờ xử lý", $note);

                    // Tạo chi tiết đơn hàng
                    foreach ($cart as $item) {
                        $orderDetailDAO->insertDetail($orderId, $item["productId"], $item["quantity"], $item["price"]);
                    }

                    $orderDAO->commitTransaction();

                    // Xóa giỏ hàng
                    unset($_SESSION[$this->cartKey]);
                    $success = true;

                } catch (\Exception $e) {
                    $orderDAO->rollbackTransaction();
                    $errors[] = "Đặt hàng thất bại: " . $e->getMessage();
                }
            }
        }

        require_once __DIR__ . '/../../views/client/cart/checkout.php';
    }
}
