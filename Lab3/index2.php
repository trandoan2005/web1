<?php
require "includes/header.php";
require_once "classes/Student.php";

// Dashboard functions
function countStudents($students) {
    return count($students);
}

function countMaleStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student->gender == "Nam") $count++;
    }
    return $count;
}

function countFemaleStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student->gender == "Nữ") $count++;
    }
    return $count;
}

function countScholarshipStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student->getScholarship() == "Có") $count++;
    }
    return $count;
}

function countExcellentStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student->getRank() == "Xuất sắc") $count++;
    }
    return $count;
}

function getAverageScore($students) {
    $total = 0;
    foreach ($students as $student) {
        $total += $student->getAverage();
    }
    return round($total / count($students), 2);
}

function getHighestAverage($students) {
    $max = 0;
    foreach ($students as $student) {
        $avg = $student->getAverage();
        if ($avg > $max) $max = $avg;
    }
    return $max;
}

function getLowestAverage($students) {
    $min = 10;
    foreach ($students as $student) {
        $avg = $student->getAverage();
        if ($avg < $min) $min = $avg;
    }
    return $min;
}

$students = [
    new Student("SV001", "Nguyễn Văn An", "Nam", 2005, 8.5, 9.0, 7.5),
    new Student("SV002", "Trần Thị Bình", "Nữ", 2004, 9.0, 8.0, 9.5),
    new Student("SV003", "Lê Văn Cường", "Nam", 2005, 7.5, 8.0, 8.5),
    new Student("SV004", "Phạm Thị Dung", "Nữ", 2005, 6.0, 5.5, 7.0),
    new Student("SV005", "Hoàng Văn Em", "Nam", 2004, 9.5, 9.0, 9.0),
    new Student("SV006", "Ngô Thị Phượng", "Nữ", 2005, 4.5, 5.0, 3.5),
    new Student("SV007", "Đặng Văn Giang", "Nam", 2003, 8.0, 8.5, 8.0),
    new Student("SV008", "Vũ Thị Hương", "Nữ", 2005, 7.0, 6.5, 7.5),
    new Student("SV009", "Bùi Văn Khải", "Nam", 2004, 9.0, 9.5, 9.0),
    new Student("SV010", "Lý Thị Lan", "Nữ", 2005, 5.0, 6.0, 5.5),
    new Student("SV011", "Trương Văn Minh", "Nam", 2005, 8.5, 7.5, 8.0),
    new Student("SV012", "Đinh Thị Ngọc", "Nữ", 2004, 7.0, 7.5, 6.5),
    new Student("SV013", "Phan Văn Phúc", "Nam", 2005, 6.5, 6.0, 7.0),
    new Student("SV014", "Mai Thị Quỳnh", "Nữ", 2003, 9.5, 9.5, 9.0),
    new Student("SV015", "Cao Văn Sơn", "Nam", 2005, 3.5, 4.0, 5.0),
    new Student("SV016", "Hồ Thị Tâm", "Nữ", 2004, 8.0, 8.0, 8.5),
    new Student("SV017", "Dương Văn Uy", "Nam", 2005, 7.5, 7.0, 7.5),
    new Student("SV018", "Lương Thị Vân", "Nữ", 2005, 6.0, 7.0, 6.5),
    new Student("SV019", "Tạ Văn Xuân", "Nam", 2004, 9.0, 8.5, 9.5),
    new Student("SV020", "Châu Thị Yến", "Nữ", 2005, 5.5, 5.0, 4.5),
];
?>
<!-- main -->
<main class="container my-5">

    <!-- Dashboard thống kê -->
    <section class="mb-5">
        <h3 class="mb-3">Dashboard thống kê</h3>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tổng sinh viên</h5>
                        <p class="card-text fs-2"><?php echo countStudents($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sinh viên Nam</h5>
                        <p class="card-text fs-2"><?php echo countMaleStudents($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sinh viên Nữ</h5>
                        <p class="card-text fs-2"><?php echo countFemaleStudents($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h5 class="card-title">Đạt học bổng</h5>
                        <p class="card-text fs-2"><?php echo countScholarshipStudents($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title">Xuất sắc</h5>
                        <p class="card-text fs-2"><?php echo countExcellentStudents($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-dark bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title">ĐTB cả lớp</h5>
                        <p class="card-text fs-2"><?php echo getAverageScore($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h5 class="card-title">ĐTB cao nhất</h5>
                        <p class="card-text fs-2"><?php echo getHighestAverage($students); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title">ĐTB thấp nhất</h5>
                        <p class="card-text fs-2"><?php echo getLowestAverage($students); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Danh sách sinh viên -->
    <section class="mb-5">
        <h3 class="mb-3">Danh sách sinh viên</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã SV</th>
                    <th>Họ tên</th>
                    <th>Giới tính</th>
                    <th>Năm sinh</th>
                    <th>Điểm HTML</th>
                    <th>Điểm CSS</th>
                    <th>Điểm PHP</th>
                    <th>Tổng điểm</th>
                    <th>Tuổi</th>
                    <th>ĐTB</th>
                    <th>Xếp loại</th>
                    <th>Học bổng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($students as $student) {
                    $student->showInfo();
                }
                ?>
            </tbody>
        </table>
    </section>
</main>
<?php require "includes/footer.php"; ?>
