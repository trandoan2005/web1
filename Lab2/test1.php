<?php
// Khởi tạo mảng menu
$menus = [
    "Trang chủ",
    "Tin tức",
    "Liên hệ",
    "Giới thiệu"
];

// Khởi tạo biến lưu mảng chứa danh sách môn học
$subjects = ["HTML", "CSS", "JavaScript", "PHP", "MySQL"];

// Khởi tạo mảng chứa danh sách sinh viên (mảng nhiều chiều)
$students = [
    [
        "id" => "SV001",
        "name" => "Nguyễn Văn An",
        "gender" => "Nam",
        "class" => "CNTT1"
    ],
    [
        "id" => "SV002",
        "name" => "Trần Thị Bình",
        "gender" => "Nữ",
        "class" => "CNTT2"
    ],
    [
        "id" => "SV003",
        "name" => "Lê Văn Cường",
        "gender" => "Nam",
        "class" => "CNTT1"
    ],
    [
        "id" => "SV004",
        "name" => "Phạm Thị Dung",
        "gender" => "Nữ",
        "class" => "CNTT3"
    ]
];

// Khởi tạo các mảng lưu danh sách Khoa, Lớp học, Giới tính, Sở thích
$faculties = ["Công nghệ thông tin", "Quản trị kinh doanh", "Kế toán", "Ngôn ngữ Anh"];
$classes = ["A1" => "CNTT1", "A2" => "CNTT2", "A3" => "CNTT3", "A4" => "CNTT4"];
$genders = ["Nam", "Nữ", "Khác"];
$hobbies = ["LT" => "Lập trình", "DS" => "Đọc sách", "AN" => "Âm nhạc", "DL" => "Du lịch", "TT" => "Thể thao"];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test 1</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        /* ===== Menu ===== */
        nav {
            background: rgb(4, 40, 94);
        }
        nav ul {
            list-style: none;
            display: flex;
        }
        nav li {
            flex: 1;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            display: block;
            padding: 15px;
            text-align: center;
        }
        nav ul li:hover {
            background: #084298;
        }

        /* ===== Danh sách môn học ===== */
        .s1 {
            width: 500px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        .s1 h3 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .s1 ul {
            list-style: none;
        }
        .s1 li {
            padding: 12px;
            margin-bottom: 10px;
            background: #e7f1ff;
            border-left: 5px solid #0d6efd;
            border-radius: 5px;
            transition: .3s;
        }
        .s1 li:hover {
            background: #cfe2ff;
            transform: translateX(5px);
        }

        /* ===== Danh sách sinh viên ===== */
        .s2 {
            width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        .s2 h3 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .s2 table {
            width: 100%;
            border-collapse: collapse;
        }
        .s2 th {
            background: #0d6efd;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .s2 td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        .s2 tr:nth-child(even) {
            background: #e7f1ff;
        }

        /* ===== Form đăng ký ===== */
        .s3 {
            width: 500px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        .s3 h3 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .s3 div {
            margin-bottom: 15px;
        }
        .s3 label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .s3 input[type="text"],
        .s3 select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .s3 button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .s3 button[type="submit"] {
            background: #0d6efd;
            color: white;
        }
        .s3 button[type="reset"] {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>

    <!-- =====Menu====== -->
    <nav>
        <ul>
            <?php foreach ($menus as $menu) { ?>
            <li>
                <a href="#"><?php echo $menu; ?></a>
            </li>
            <?php } ?>
        </ul>
    </nav>

    <!-- ===== Danh sách môn học ===== -->
    <section class="s1">
        <h3>Danh sách ngôn ngữ sử dụng trong môn học</h3>
        <ul>
            <?php
            foreach ($subjects as $subject) {
                echo "<li>$subject</li>";
            }
            ?>
        </ul>
    </section>

    <!-- ===== Danh sách sinh viên ===== -->
    <section class="s2">
        <h3>Danh sách sinh viên</h3>
        <table>
            <tr>
                <th>STT</th>
                <th>Mã sinh viên</th>
                <th>Họ và tên</th>
                <th>Giới tính</th>
                <th>Lớp</th>
            </tr>
            <?php foreach ($students as $index => $student) { ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $student["id"]; ?></td>
                <td><?php echo $student["name"]; ?></td>
                <td><?php echo $student["gender"]; ?></td>
                <td><?php echo $student["class"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    </section>

    <!-- ===== Form đăng ký thông tin sinh viên ===== -->
    <section class="s3">
        <h3>ĐĂNG KÝ THÔNG TIN SINH VIÊN</h3>
        <form action="#" method="post">
            <div>
                <label>Họ và tên</label>
                <input type="text" name="fullname">
            </div>
            <div>
                <label>Khoa</label>
                <select name="faculty">
                    <?php foreach ($faculties as $faculty) { ?>
                    <option><?php echo $faculty; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Lớp</label>
                <select name="class">
                    <?php foreach ($classes as $key => $class) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $class; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Giới tính</label>
                <?php foreach ($genders as $gender) { ?>
                <input type="radio" name="gender" value="<?php echo $gender; ?>"> <?php echo $gender; ?>
                <?php } ?>
            </div>
            <div>
                <label>Sở thích</label>
                <?php foreach ($hobbies as $key => $hobby) { ?>
                <input type="checkbox" name="hobbies[]" value="<?php echo $key; ?>"> <?php echo $hobby; ?>
                <?php } ?>
            </div>
            <div>
                <button type="submit">Đăng ký</button>
                <button type="reset">Làm mới</button>
            </div>
        </form>
    </section>

</body>
</html>