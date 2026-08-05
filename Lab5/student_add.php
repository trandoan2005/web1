<?php
require_once 'dao/StudentDAO.php';

$errors = [];
$studentcode = '';
$fullname = '';
$phone = '';
$gender = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentcode = isset($_POST['studentcode']) ? trim($_POST['studentcode']) : '';
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Validate
    if (empty($studentcode)) {
        $errors[] = "Mã sinh viên không được để trống.";
    }
    if (empty($fullname)) {
        $errors[] = "Họ và tên không được để trống.";
    }
    if (!empty($phone) && !preg_match('/^[0-9]{10,11}$/', $phone)) {
        $errors[] = "Số điện thoại không đúng định dạng (10-11 chữ số).";
    }
    if (empty($gender)) {
        $errors[] = "Vui lòng chọn giới tính.";
    }

    if (count($errors) == 0) {
        $student = new Student();
        $student->studentcode = $studentcode;
        $student->fullname = $fullname;
        $student->phone = $phone;
        $student->gender = $gender;

        $studentDAO = new StudentDAO();
        if ($studentDAO->insert($student)) {
            header("Location: student_index.php?msg=add");
            exit;
        } else {
            $errors[] = "Thêm sinh viên thất bại. Mã sinh viên có thể đã tồn tại.";
        }
    }
}

include 'includes/header.php';
?>

<h2 class="mb-4">Thêm Sinh viên mới</h2>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow" style="max-width: 600px;">
    <div class="card-body">
        <form action="student_add.php" method="POST">
            <div class="mb-3">
                <label for="studentcode" class="form-label">Mã sinh viên</label>
                <input type="text" class="form-control" id="studentcode" name="studentcode" value="<?= htmlspecialchars($studentcode) ?>" placeholder="VD: SV006">
            </div>
            <div class="mb-3">
                <label for="fullname" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($fullname) ?>" placeholder="Nhập họ và tên">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" placeholder="VD: 0901234567">
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderNam" value="Nam" <?= $gender == 'Nam' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="genderNam">Nam</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderNu" value="Nữ" <?= $gender == 'Nữ' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="genderNu">Nữ</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Thêm</button>
                <a href="student_index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
