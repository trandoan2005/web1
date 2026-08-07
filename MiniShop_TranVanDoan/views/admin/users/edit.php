<?php
$pageTitle = "Cập nhật Người dùng";
require_once __DIR__ . '/../../../dao/UserDAO.php';
$userDAO = new UserDAO();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];
$obj = $userDAO->findById($id);

if (!$obj) {
    header("Location: index.php");
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
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Cập nhật người dùng</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $obj->id ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($password) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($fullname) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Điện thoại <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Vai trò (admin/staff) <span class="text-danger">*</span></label>
                <input type="text" name="role" class="form-control" value="<?= htmlspecialchars($role) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="1" <?= $status == 1 ? "checked" : "" ?>>
                    <label class="form-check-label">Hiển thị (Hoạt động)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="0" <?= $status == 0 ? "checked" : "" ?>>
                    <label class="form-check-label">Ẩn (Ngừng hoạt động)</label>
                </div>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <button type="reset" class="btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>