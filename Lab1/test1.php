<?php
// --- Câu 1.1 ---
// In ra thông tin cơ bản
echo "Họ tên: Trần Văn Đoàn<br>";
echo "Ngày sinh: 01/01/2005<br>";
echo "Mã số sinh viên: 123456789<br>";
echo "<hr>";

// --- Câu 1.2 ---
/*
  Khai báo biến và in ra giá trị
*/
$hoTen = "Trần Văn Đoàn";
$mssv = "123456789";
$sdt = "0901234567";
$ngaySinh = "01/01/2005";

echo "Họ tên từ biến: " . $hoTen . "<br>";
echo "MSSV từ biến: " . $mssv . "<br>";
echo "SĐT từ biến: " . $sdt . "<br>";
echo "Ngày sinh từ biến: " . $ngaySinh . "<br>";
echo "<hr>";

// --- Câu 1.3 ---
// Khai báo hằng số
define("HOST", "localhost");
define("DATABASE", "qlsv");
define("USERNAME", "root");
define("PASSWORD", "123456");

echo "HOST: " . HOST . "<br>";
echo "DATABASE: " . DATABASE . "<br>";
echo "USERNAME: " . USERNAME . "<br>";
echo "PASSWORD: " . PASSWORD . "<br>";
echo "<hr>";

// --- Câu 1.4 ---
// Sự khác nhau giữa nháy kép và nháy đơn
$name = "Đoàn";
// Nháy kép có phân tích biến (parse variables) bên trong chuỗi
echo "Xin chào $name (Dùng nháy kép)<br>";
// Nháy đơn không phân tích biến, in ra nguyên văn
echo 'Xin chào $name (Dùng nháy đơn)<br>';

// --- Câu 1.5 ---
// Đây là comment 1 dòng (single-line)
/*
 Đây là comment nhiều dòng
 (multi-line)
*/
?>
