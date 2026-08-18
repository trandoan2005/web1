<?php
namespace Controllers\Client;

use DAO\CustomerDAO;
use Models\Customer;

class AuthController
{
    public function login()
    {
        // Nếu đã đăng nhập, chuyển về trang chủ
        if (isset($_SESSION['customer'])) {
            header("Location: index.php?area=client&controller=home&action=index");
            exit;
        }

        $pageTitle = "Đăng nhập";
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $contact = trim($_POST['contact'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($contact) || empty($password)) {
                $errors[] = "Vui lòng nhập đầy đủ Số điện thoại/Email và Mật khẩu.";
            } else {
                $customerDAO = new CustomerDAO();
                $customer = $customerDAO->findByPhoneOrEmail($contact);

                if ($customer) {
                    if (empty($customer->password)) {
                        $errors[] = "Tài khoản này chưa thiết lập mật khẩu. Vui lòng đăng ký lại với số điện thoại này.";
                    } else if (password_verify($password, $customer->password)) {
                        if ($customer->status == 1) {
                            $_SESSION['customer'] = [
                                'id' => $customer->id,
                                'fullname' => $customer->fullname,
                                'phone' => $customer->phone,
                                'email' => $customer->email,
                                'address' => $customer->address
                            ];
                            header("Location: index.php?area=client&controller=home&action=index");
                            exit;
                        } else {
                            $errors[] = "Tài khoản của bạn đã bị khóa.";
                        }
                    } else {
                        $errors[] = "Mật khẩu không chính xác.";
                    }
                } else {
                    $errors[] = "Tài khoản không tồn tại.";
                }
            }
        }

        require_once __DIR__ . '/../../views/client/auth/login.php';
    }

    public function register()
    {
        // Nếu đã đăng nhập, chuyển về trang chủ
        if (isset($_SESSION['customer'])) {
            header("Location: index.php?area=client&controller=home&action=index");
            exit;
        }

        $pageTitle = "Đăng ký thành viên";
        $errors = [];
        $success = false;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fullname = trim($_POST['fullname'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $password = $_POST['password'] ?? '';
            $re_password = $_POST['re_password'] ?? '';

            if (empty($fullname) || empty($phone) || empty($password) || empty($re_password)) {
                $errors[] = "Vui lòng nhập đầy đủ các trường bắt buộc (*).";
            } else if ($password !== $re_password) {
                $errors[] = "Mật khẩu nhập lại không khớp.";
            } else if (strlen($password) < 6) {
                $errors[] = "Mật khẩu phải chứa ít nhất 6 ký tự.";
            } else {
                $customerDAO = new CustomerDAO();
                $existing = $customerDAO->findByPhoneOrEmail($phone);

                if ($existing && !empty($existing->password)) {
                    $errors[] = "Số điện thoại này đã được đăng ký tài khoản.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    if ($existing && empty($existing->password)) {
                        // Khách đã mua hàng (qua số đt ở Lab13) nhưng chưa có pass -> Cập nhật lại pass và thông tin
                        $existing->fullname = $fullname;
                        $existing->password = $hashedPassword;
                        $existing->email = $email;
                        $existing->address = $address;
                        $customerDAO->update($existing);
                        $success = true;
                    } else {
                        // Khách hoàn toàn mới
                        $newCustomer = new Customer(0, $fullname, $hashedPassword, $email, $phone, $address, 1);
                        if ($customerDAO->insert($newCustomer)) {
                            $success = true;
                        } else {
                            $errors[] = "Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.";
                        }
                    }
                }
            }
        }

        require_once __DIR__ . '/../../views/client/auth/register.php';
    }

    public function logout()
    {
        unset($_SESSION['customer']);
        header("Location: index.php?area=client&controller=home&action=index");
        exit;
    }
}
