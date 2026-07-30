<?php
require "includes/header.php";

// Dữ liệu sinh viên (tối thiểu 20 sinh viên)
$students = [
    ["fullname" => "Nguyễn Văn A", "age" => 20, "gender" => "Nam", "mclass" => "C1", "email" => "nva@gmail.com"],
    ["fullname" => "Trần Thị B", "age" => 19, "gender" => "Nữ", "mclass" => "C2", "email" => "ttb@gmail.com"],
    ["fullname" => "Lê Văn C", "age" => 21, "gender" => "Nam", "mclass" => "C3", "email" => "lvc@gmail.com"],
    ["fullname" => "Phạm Thị D", "age" => 20, "gender" => "Nữ", "mclass" => "C1", "email" => "ptd@gmail.com"],
    ["fullname" => "Hoàng Văn E", "age" => 19, "gender" => "Nam", "mclass" => "C2", "email" => "hve@gmail.com"],
    ["fullname" => "Ngô Thị F", "age" => 22, "gender" => "Nữ", "mclass" => "C3", "email" => "ntf@gmail.com"],
    ["fullname" => "Đặng Văn G", "age" => 20, "gender" => "Nam", "mclass" => "C1", "email" => "dvg@gmail.com"],
    ["fullname" => "Vũ Thị H", "age" => 19, "gender" => "Nữ", "mclass" => "C2", "email" => "vth@gmail.com"],
    ["fullname" => "Bùi Văn I", "age" => 21, "gender" => "Nam", "mclass" => "C3", "email" => "bvi@gmail.com"],
    ["fullname" => "Lý Thị J", "age" => 20, "gender" => "Nữ", "mclass" => "C1", "email" => "ltj@gmail.com"],
    ["fullname" => "Trương Văn K", "age" => 19, "gender" => "Nam", "mclass" => "C2", "email" => "tvk@gmail.com"],
    ["fullname" => "Đinh Thị L", "age" => 21, "gender" => "Nữ", "mclass" => "C3", "email" => "dtl@gmail.com"],
    ["fullname" => "Phan Văn M", "age" => 20, "gender" => "Nam", "mclass" => "C1", "email" => "pvm@gmail.com"],
    ["fullname" => "Mai Thị N", "age" => 19, "gender" => "Nữ", "mclass" => "C2", "email" => "mtn@gmail.com"],
    ["fullname" => "Cao Văn O", "age" => 22, "gender" => "Nam", "mclass" => "C3", "email" => "cvo@gmail.com"],
    ["fullname" => "Hồ Thị P", "age" => 20, "gender" => "Nữ", "mclass" => "C1", "email" => "htp@gmail.com"],
    ["fullname" => "Dương Văn Q", "age" => 19, "gender" => "Nam", "mclass" => "C2", "email" => "dvq@gmail.com"],
    ["fullname" => "Lương Thị R", "age" => 21, "gender" => "Nữ", "mclass" => "C3", "email" => "ltr@gmail.com"],
    ["fullname" => "Tạ Văn S", "age" => 20, "gender" => "Nam", "mclass" => "C1", "email" => "tvs@gmail.com"],
    ["fullname" => "Châu Thị T", "age" => 19, "gender" => "Nữ", "mclass" => "C2", "email" => "ctt@gmail.com"]
];

// Lấy điều kiện tìm kiếm
$search_name = isset($_GET['fullname']) ? trim($_GET['fullname']) : '';
$search_gender = isset($_GET['gender']) ? $_GET['gender'] : '';
$search_mclass = isset($_GET['mclass']) ? $_GET['mclass'] : '';

$results = [];
$is_searched = isset($_GET['fullname']); // Kiểm tra xem đã submit form chưa

if ($is_searched) {
    foreach ($students as $student) {
        $match = true;

        // Lọc theo tên (chứa từ khóa, không phân biệt hoa thường)
        if ($search_name != '' && mb_stripos($student['fullname'], $search_name) === false) {
            $match = false;
        }

        // Lọc theo giới tính
        if ($search_gender != '' && $student['gender'] != $search_gender) {
            $match = false;
        }

        // Lọc theo lớp
        if ($search_mclass != '' && $student['mclass'] != $search_mclass) {
            $match = false;
        }

        if ($match) {
            $results[] = $student;
        }
    }
} else {
    // Nếu chưa search thì hiển thị tất cả
    $results = $students;
}
?>
<main class="container my-5">
    <section class="mb-5 shadow p-4 mx-auto" style="max-width: 800px;">
        <h2 class="mb-4 text-center">Tìm kiếm Sinh viên</h2>
        <form action="student-search.php" method="GET">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fullname">Họ tên</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập tên..." value="<?= htmlspecialchars($search_name) ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Giới tính</label><br>
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="gender" id="genderAll" value="" <?= $search_gender == '' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="genderAll">Tất cả</label>
                    </div>
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Nam" <?= $search_gender == 'Nam' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="genderMale">Nam</label>
                    </div>
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Nữ" <?= $search_gender == 'Nữ' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="genderFemale">Nữ</label>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="mclass">Lớp</label>
                    <select class="form-select form-control" id="mclass" name="mclass">
                        <option value="">-- Tất cả các lớp --</option>
                        <option value="C1" <?= $search_mclass == 'C1' ? 'selected' : '' ?>>Lớp C25A (C1)</option>
                        <option value="C2" <?= $search_mclass == 'C2' ? 'selected' : '' ?>>Lớp C25E (C2)</option>
                        <option value="C3" <?= $search_mclass == 'C3' ? 'selected' : '' ?>>Lớp C25F (C3)</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3 mt-3">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-search"></i> Tìm kiếm</button>
                <a href="student-search.php" class="btn btn-secondary px-4">Làm lại</a>
            </div>
        </form>
    </section>

    <section class="mb-5 shadow p-4 mx-auto" style="max-width: 800px;">
        <h3 class="mb-3">Kết quả tìm kiếm (<?= count($results) ?> sinh viên)</h3>
        
        <?php if (count($results) > 0): ?>
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Họ và tên</th>
                        <th>Tuổi</th>
                        <th>Giới tính</th>
                        <th>Lớp</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $index => $student): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($student['fullname']) ?></td>
                            <td><?= htmlspecialchars($student['age']) ?></td>
                            <td><?= htmlspecialchars($student['gender']) ?></td>
                            <td><?= htmlspecialchars($student['mclass']) ?></td>
                            <td><?= htmlspecialchars($student['email']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Không tìm thấy sinh viên phù hợp
            </div>
        <?php endif; ?>
    </section>
</main>
<?php
require "includes/footer.php";
?>
