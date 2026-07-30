<?php
require "includes/header.php";
?>
<main class="container my-5">
    <section class="mb-5 shadow p-3 mx-auto" style="width: 500px;">
        <h2>Thông tin</h2>
        <form action="form-get.php" method="get">
            <div class="mb-3 mt-3">
                <label for="fullname">Họ tên</label>
                <input type="text" class="form-control" id="fullname" placeholder="Họ tên" name="fullname" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="birthyear">Tuổi</label>
                <input type="number" class="form-control" id="birthyear" placeholder="Tuổi" name="birthyear" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="">Giới tính: </label>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="gender1" name="gender" value="1" checked>
                    <label class="form-check-label" for="gender1">Nam</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="gender2" name="gender" value="2">
                    <label class="form-check-label" for="gender2">Nữ</label>
                </div>
                <div class="form-check-inline">
                    <input type="radio" class="form-check-input" id="gender3" name="gender" value="3">
                    <label class="form-check-label" for="gender3">Khác</label>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="mclass">Lớp</label>
                <select name="mclass" id="mclass" class="form-control">
                    <option value="C1">Lớp C25A</option>
                    <option value="C2">Lớp C25E</option>
                    <option value="C3">Lớp C25F</option>
                </select>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-primary">Gửi</button>
                <button type="reset" class="btn btn-primary">Làm lại</button>
            </div>
        </form>
    </section>

    <?php
    if (isset($_GET['fullname'])) {
        // lấy dữ liệu từ form
        $fullname = $_GET['fullname'];
        $birthyear = $_GET['birthyear'];
        $gender = $_GET['gender'];
        $mclass = $_GET['mclass'];

        // Sử dụng toán tử ba ngôi (ternary)
        $genderText = ($gender == "1") ? "Nam" :
                    (($gender == "2") ? "Nữ" : "Khác");
    ?>
    <section class="mb-5 shadow p-3 mx-auto" style="width: 500px;">
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Thông tin đã nhập
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Họ và tên</th>
                        <td><?= htmlspecialchars($fullname) ?></td>
                    </tr>
                    <tr>
                        <th>Tuổi</th>
                        <td><?= $birthyear ?></td>
                    </tr>
                    <tr>
                        <th>Giới tính</th>
                        <td><?= $genderText ?></td>
                    </tr>
                    <tr>
                        <th>Lớp</th>
                        <td><?= $mclass ?></td>
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
