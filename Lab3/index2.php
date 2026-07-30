<?php
require "includes/header.php";
require_once "classes/Student.php";

$students = [
    new Student("SV001", "Nguyễn Văn A", "Nam", 2005, 8.5, 9.0, 7.5),
    new Student("SV002", "Trần Thị B", "Nữ", 2004, 9.0, 8.0, 9.5),
    new Student("SV003", "Lê Văn C", "Nam", 2005, 7.5, 8.0, 8.5),
    new Student("SV004", "Phạm Thị D", "Nữ", 2005, 6.0, 5.5, 7.0),
    new Student("SV005", "Hoàng Văn E", "Nam", 2004, 9.5, 9.0, 9.0),
    new Student("SV006", "Ngô Thị F", "Nữ", 2005, 4.5, 5.0, 3.5),
    new Student("SV007", "Đặng Văn G", "Nam", 2003, 8.0, 8.5, 8.0),
    new Student("SV008", "Vũ Thị H", "Nữ", 2005, 7.0, 6.5, 7.5),
    new Student("SV009", "Bùi Văn I", "Nam", 2004, 9.0, 9.5, 9.0),
    new Student("SV010", "Lý Thị J", "Nữ", 2005, 5.0, 6.0, 5.5),
    new Student("SV011", "Trương Văn K", "Nam", 2005, 8.5, 7.5, 8.0),
    new Student("SV012", "Đinh Thị L", "Nữ", 2004, 7.0, 7.5, 6.5),
    new Student("SV013", "Phan Văn M", "Nam", 2005, 6.5, 6.0, 7.0),
    new Student("SV014", "Mai Thị N", "Nữ", 2003, 9.5, 9.5, 9.0),
    new Student("SV015", "Cao Văn O", "Nam", 2005, 3.5, 4.0, 5.0),
    new Student("SV016", "Hồ Thị P", "Nữ", 2004, 8.0, 8.0, 8.5),
    new Student("SV017", "Dương Văn Q", "Nam", 2005, 7.5, 7.0, 7.5),
    new Student("SV018", "Lương Thị R", "Nữ", 2005, 6.0, 7.0, 6.5),
    new Student("SV019", "Trần Văn Đoàn", "Nam", 2005, 10.0, 10.0, 9.5),
    new Student("SV020", "Diễm Trần", "Nữ", 1990, 5.5, 5.0, 4.5),
];
?>
<!-- main -->
<main class="container my-5">
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