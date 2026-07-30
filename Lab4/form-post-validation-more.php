<?php
require "includes/header.php";

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $birthyear = isset($_POST['birthyear']) ? trim($_POST['birthyear']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $mclass = isset($_POST['mclass']) ? $_POST['mclass'] : '';
    $hobbies = isset($_POST['hobbies']) ? $_POST['hobbies'] : [];
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;

    // Validate Họ tên
    if (empty($fullname)) {
        $errors[] = "Họ và tên không được để trống.";
    } else if (mb_strlen($fullname) < 5) {
        $errors[] = "Họ và tên phải có ít nhất 5 ký tự.";
    }

    // Validate Tuổi
    if (empty($birthyear)) {
        $errors[] = "Tuổi không được để trống.";
    } else if (!is_numeric($birthyear)) {
        $errors[] = "Tuổi phải là số.";
    } else if ($birthyear < 18 || $birthyear > 60) {
        $errors[] = "Tuổi phải nằm trong khoảng từ 18 đến 60.";
    }

    // Validate Email
    if (empty($email)) {
        $errors[] = "Email không được để trống.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không đúng định dạng.";
    }

    // Validate Giới tính
    if (empty($gender)) {
        $errors[] = "Giới tính bắt buộc chọn.";
    }

    // Validate Lớp
    if (empty($mclass)) {
        $errors[] = "Lớp bắt buộc chọn.";
    }

    // Validate Sở thích
    if (empty($hobbies) || count($hobbies) == 0) {
        $errors[] = "Bạn phải chọn ít nhất một sở thích.";
    }

    // Validate Địa chỉ
    if (empty($address)) {
        $errors[] = "Địa chỉ không được để trống.";
    }

    // Validate Ngày sinh
    if (empty($dob)) {
        $errors[] = "Ngày sinh không được để trống.";
    }

    // Validate Ảnh đại diện
    if (empty($avatar['name'])) {
        $errors[] = "Ảnh đại diện bắt buộc chọn.";
    } else {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExtension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Chỉ chấp nhận các định dạng ảnh: jpg, jpeg, png, gif, webp.";
        }
        
        if ($avatar['size'] > 200 * 1024) { // 200KB
            $errors[] = "Kích thước ảnh không được vượt quá 200KB.";
        }
    }

    if (count($errors) == 0) {
        $success = true;
    }
}
?>
<main class="container my-5">
    <section class="mb-5 shadow p-3 mx-auto" style="max-width: 600px;">
        <h2>Thông tin đăng ký</h2>

        <?php
        if (count($errors) > 0) {
        ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                    ?>
                </ul>
            </div>
        <?php
        }
        ?>

        <form action="form-post-validation-more.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="fullname">Họ tên</label>
                <input type="text" class="form-control" id="fullname" placeholder="Họ tên" name="fullname" value="<?= isset($fullname) ? htmlspecialchars($fullname) : '' ?>">
            </div>
            
            <div class="mb-3 mt-3">
                <label for="birthyear">Tuổi</label>
                <input type="number" class="form-control" id="birthyear" placeholder="Tuổi" name="birthyear" value="<?= isset($birthyear) ? htmlspecialchars($birthyear) : '' ?>">
            </div>

            <div class="mb-3 mt-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
            </div>
            
            <div class="mb-3 mt-3">
                <label>Giới tính: </label><br>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="gender1" name="gender" value="1" <?= (isset($gender) && $gender == '1') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="gender1">Nam</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="gender2" name="gender" value="2" <?= (isset($gender) && $gender == '2') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="gender2">Nữ</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="gender3" name="gender" value="3" <?= (isset($gender) && $gender == '3') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="gender3">Khác</label>
                </div>
            </div>
            
            <div class="mb-3 mt-3">
                <label for="mclass">Lớp</label>
                <select name="mclass" id="mclass" class="form-control">
                    <option value="">-- Chọn lớp --</option>
                    <option value="C1" <?= (isset($mclass) && $mclass == 'C1') ? 'selected' : '' ?>>Lớp C25A</option>
                    <option value="C2" <?= (isset($mclass) && $mclass == 'C2') ? 'selected' : '' ?>>Lớp C25E</option>
                    <option value="C3" <?= (isset($mclass) && $mclass == 'C3') ? 'selected' : '' ?>>Lớp C25F</option>
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label>Sở thích: </label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobby1" name="hobbies[]" value="Đọc sách" <?= (isset($hobbies) && in_array("Đọc sách", $hobbies)) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="hobby1">Đọc sách</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobby2" name="hobbies[]" value="Chơi thể thao" <?= (isset($hobbies) && in_array("Chơi thể thao", $hobbies)) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="hobby2">Chơi thể thao</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobby3" name="hobbies[]" value="Nghe nhạc" <?= (isset($hobbies) && in_array("Nghe nhạc", $hobbies)) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="hobby3">Nghe nhạc</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hobby4" name="hobbies[]" value="Du lịch" <?= (isset($hobbies) && in_array("Du lịch", $hobbies)) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="hobby4">Du lịch</label>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label for="address">Địa chỉ</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?= isset($address) ? htmlspecialchars($address) : '' ?></textarea>
            </div>

            <div class="mb-3 mt-3">
                <label for="dob">Ngày sinh</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= isset($dob) ? htmlspecialchars($dob) : '' ?>">
            </div>

            <div class="mb-3 mt-3">
                <label for="avatar">Ảnh đại diện</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
            
            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-primary">Gửi</button>
                <button type="reset" class="btn btn-primary">Làm lại</button>
            </div>
        </form>
    </section>

    <?php
    if ($success) {
        $genderText = ($gender == "1") ? "Nam" : (($gender == "2") ? "Nữ" : "Khác");
        $mclassText = ($mclass == "C1") ? "Lớp C25A" : (($mclass == "C2") ? "Lớp C25E" : "Lớp C25F");
        $hobbiesText = implode(", ", $hobbies);
    ?>
    <section class="mb-5 shadow p-3 mx-auto" style="max-width: 600px;">
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Thông tin đã nhập
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Họ và tên</th>
                        <td><?= htmlspecialchars($fullname) ?></td>
                    </tr>
                    <tr>
                        <th>Tuổi</th>
                        <td><?= htmlspecialchars($birthyear) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($email) ?></td>
                    </tr>
                    <tr>
                        <th>Giới tính</th>
                        <td><?= $genderText ?></td>
                    </tr>
                    <tr>
                        <th>Lớp</th>
                        <td><?= $mclassText ?></td>
                    </tr>
                    <tr>
                        <th>Sở thích</th>
                        <td><?= htmlspecialchars($hobbiesText) ?></td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td><?= nl2br(htmlspecialchars($address)) ?></td>
                    </tr>
                    <tr>
                        <th>Ngày sinh</th>
                        <td><?= htmlspecialchars($dob) ?></td>
                    </tr>
                    <tr>
                        <th>Ảnh đại diện</th>
                        <td><?= htmlspecialchars($avatar['name']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    <?php
    }
    ?>
</main>
<?php
require "includes/footer.php";
?>
