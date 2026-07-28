<?php
// 1. Menu
$menus = ["Trang chủ", "Tin tức", "Liên hệ", "Giới thiệu"];

// 2. Subjects
$subjects = ["HTML", "CSS", "JavaScript", "PHP", "MySQL"];

// 3. Students
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

// 4. Form options
$faculties = ["Công nghệ thông tin", "Quản trị kinh doanh", "Kế toán", "Ngôn ngữ Anh"];
$classes = ["A1"=> "CNTT1", "A2"=> "CNTT2", "A3"=> "CNTT3", "A4"=> "CNTT4"];
$genders = ["Nam", "Nữ", "Khác"];
$hobbies = ["LT" => "Lập trình", "DS" => "Đọc sách", "AN" => "Âm nhạc", "DL" => "Du lịch", "TT" => "Thể thao"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lab 2 - Test 1</title>
<style>
/* CSS Menu */
* { margin: 0; padding: 0; box-sizing: border-box; }
body { padding: 20px; font-family: sans-serif; }
nav { background: rgb(4, 40, 94); margin-bottom: 30px; }
nav ul { list-style: none; display: flex; }
nav li { flex: 1; }
nav a { color: white; text-decoration: none; font-weight: bold; display: block; padding: 15px; text-align: center; }
nav ul li:hover { background: #084298; }

/* CSS s1 */
.s1 { width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.15); margin-bottom: 30px; }
.s1 h3 { text-align: center; color: #0d6efd; margin-bottom: 20px; }
.s1 ul { list-style: none; }
.s1 li { padding: 12px; margin-bottom: 10px; background: #e7f1ff; border-left: 5px solid #0d6efd; border-radius: 5px; transition: .3s; }
.s1 li:hover { background: #cfe2ff; transform: translateX(5px); }

/* CSS s2 */
.s2 { width: 800px; margin: auto; margin-bottom: 30px; }
.s2 h3 { text-align: center; color: #0d6efd; margin-bottom: 20px; }
table { width: 100%; border-collapse: collapse; }
th { background: #0d6efd; color: white; padding: 10px; }
td { padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
tr:nth-child(even) { background-color: #f2f2f2; }
tr:hover { background-color: #ddd; }

/* CSS s3 */
.s3 { width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.15); }
.s3 h3 { text-align: center; color: #0d6efd; margin-bottom: 20px; text-transform: uppercase; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input[type="text"], .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
.form-inline label { display: inline-block; margin-right: 15px; font-weight: normal; }
button { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; color: white; font-weight: bold; }
button[type="submit"] { background: #0d6efd; }
button[type="reset"] { background: #6c757d; }
</style>
</head>
<body>

<!-- 1. Menu -->
<nav>
    <ul>
        <?php foreach ($menus as $menu) { ?>
        <li><a href="#"><?= $menu ?></a></li>
        <?php } ?>
    </ul>
</nav>

<!-- 2. Subjects -->
<section class="s1">
    <h3>Danh sách ngôn ngữ sử dụng trong môn học</h3>
    <ul>
        <?php foreach($subjects as $subject){
            echo "<li>$subject</li>";
        } ?>
    </ul>
</section>

<!-- 3. Students -->
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
            <td><?= $index + 1 ?></td>
            <td><?= $student["id"] ?></td>
            <td><?= $student["name"] ?></td>
            <td><?= $student["gender"] ?></td>
            <td><?= $student["class"] ?></td>
        </tr>
        <?php } ?>
    </table>
</section>

<!-- 4. Form -->
<section class="s3">
    <h3>ĐĂNG KÝ THÔNG TIN SINH VIÊN</h3>
    <form action="#" method="post">
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="fullname" placeholder="Nhập họ và tên">
        </div>
        
        <div class="form-group">
            <label>Khoa</label>
            <select name="faculty">
                <option value="">-- Chọn khoa --</option>
                <?php foreach ($faculties as $faculty) { ?>
                <option><?= $faculty ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Lớp học</label>
            <select name="class">
                <option value="">-- Chọn lớp --</option>
                <?php foreach ($classes as $key => $class) { ?>
                <option value="<?= $key ?>"><?= $class ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group form-inline">
            <label style="font-weight: bold; display: block;">Giới tính</label>
            <?php foreach ($genders as $gender) { ?>
            <label><input type="radio" name="gender" value="<?= $gender ?>"> <?= $gender ?></label>
            <?php } ?>
        </div>
        
        <div class="form-group form-inline">
            <label style="font-weight: bold; display: block;">Sở thích</label>
            <?php foreach ($hobbies as $key => $hobby) { ?>
            <label><input type="checkbox" name="hobbies[]" value="<?= $key ?>"> <?= $hobby ?></label>
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
