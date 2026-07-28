<?php
// Khởi tạo mảng menu
$menus = [
"Trang chủ",
"Tin tức",
"Liên hệ",
"Giới thiệu"
];

// Khởi tạo biến lưu mảng chứa danh sách môn học
$subjects = [ "HTML", "CSS", "JavaScript", "PHP", "MySQL" ];

// Khởi tạo mảng chứa danh sách sinh viên
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

$faculties = [ "Công nghệ thông tin", "Quản trị kinh doanh", "Kế toán", "Ngôn ngữ Anh" ];
$classes = [ "A1"=> "CNTT1", "A2"=> "CNTT2", "A3"=> "CNTT3", "A4"=> "CNTT4" ];
$genders = [ "Nam", "Nữ", "Khác" ];
$hobbies = [ "LT" => "Lập trình", "DS" => "Đọc sách", "AN" => "Âm nhạc", "DL" => "Du lịch", "TT" => "Thể thao" ];
?>
<style>
*{
 margin: 0;
 padding: 0;
 box-sizing: border-box;
}
body{
 padding: 20px;
}
nav {
 background:rgb(4, 40, 94);
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

.s1{
 width: 500px;
 margin: auto;
 background: #fff;
 padding: 20px;
 border-radius: 8px;
 box-shadow: 0 0 10px rgba(0,0,0,0.15);
}
.s1 h3{
 text-align: center;
 color: #0d6efd;
 margin-bottom: 20px;
}
.s1 ul{
 list-style: none;
}
.s1 li{
 padding: 12px;
 margin-bottom: 10px;
 background: #e7f1ff;
 border-left: 5px solid #0d6efd;
 border-radius: 5px;
 transition: .3s;
}
.s1 li:hover{
 background: #cfe2ff;
 transform: translateX(5px);
}
</style>

<!-- =====Menu====== -->
<nav>
<ul>
<?php foreach ($menus as $menu) { ?>
<li>
<a href="#"><?= $menu ?></a>
</li>
<?php } ?>
</ul>
</nav>

<section class="s1">
 <h3>Danh sách ngôn ngữ sử dụng trong môn học</h3>
 <ul>
 <!-- Hiển thị dữ liệu -->
 <?php
 foreach($subjects as $subject){
 echo "<li>$subject</li>";
 }
 ?>
 </ul>
</section>

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

<section class="s3">
 <h3>ĐĂNG KÝ THÔNG TIN SINH VIÊN</h3>
 <form action="#" method="post">
 <div>
 <label>Họ và tên</label>
 <input type="text" name="fullname">
 </div>
 <div>
 <label>Khoa</label>
 <select>
 <option>...</option>
 <?php foreach ($faculties as $faculty) { ?>
 <option><?= $faculty ?></option>
 <?php } ?>
 </select>
 </div>
 <div>
 <label>Lớp</label>
 <select>
 <option value="....">...</option>
 <?php foreach ($classes as $key => $class) { ?>
 <option value="<?= $key ?>"><?= $class ?></option>
 <?php } ?>
 </select>
 </div>
 <div>
 <label>Giới tính</label>
 <?php foreach ($genders as $gender) { ?>
 <input type="radio" name="gender" value="<?= $gender ?>"> <?= $gender ?>
 <?php } ?>
 </div>
 <div>
 <label>Sở thích</label>
 <?php foreach ($hobbies as $key => $hobby) { ?>
 <input type="checkbox" name="hobbies[]" value="<?= $key ?>"> <?= $hobby ?>
 <?php } ?>
 </div>
 <div>
 <input type="submit" value="Submit">
 <input type="reset" value="Reset">
 </div>
 </form>
</section>
