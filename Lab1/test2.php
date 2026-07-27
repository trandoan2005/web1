<?php
// --- Câu 2.1 ---
$a = 10;
$b = 3;
echo "a = $a, b = $b<br>";
echo "Cộng: " . ($a + $b) . "<br>";
echo "Trừ: " . ($a - $b) . "<br>";
echo "Nhân: " . ($a * $b) . "<br>";
echo "Chia: " . ($a / $b) . "<br>";
echo "Chia lấy dư: " . ($a % $b) . "<br>";
echo "<hr>";

// --- Câu 2.2 ---
$intVar = 5;
$strVar = "5";

echo "So sánh == (Chỉ so sánh giá trị): ";
var_dump($intVar == $strVar); 
echo "<br>So sánh === (So sánh cả giá trị và kiểu dữ liệu): ";
var_dump($intVar === $strVar);
echo "<br>So sánh != (Khác giá trị): ";
var_dump($intVar != $strVar);
echo "<br>So sánh <> (Tương tự !=): ";
var_dump($intVar <> $strVar);
echo "<br>So sánh !== (Khác giá trị hoặc khác kiểu): ";
var_dump($intVar !== $strVar);
// Giải thích: == ép kiểu tự động để so sánh, còn === yêu cầu cùng kiểu.
echo "<hr>";

// --- Câu 2.3 ---
$x1 = 5;
echo "Giá trị ban đầu x1 = $x1<br>";
echo "Giá trị trả về của ++x1: " . (++$x1) . "<br>"; // Tăng trước, trả về giá trị mới
echo "Giá trị sau cùng x1 = $x1<br>";

$x2 = 5;
echo "<br>Giá trị ban đầu x2 = $x2<br>";
echo "Giá trị trả về của x2++: " . ($x2++) . "<br>"; // Trả về giá trị cũ, sau đó mới tăng
echo "Giá trị sau cùng x2 = $x2<br>";
// Sự khác nhau: ++$x tăng ngay rồi lấy giá trị; $x++ lấy giá trị rồi mới tăng
echo "<hr>";

// --- Câu 2.4 ---
$s1 = "Hello";
$s2 = " World";
echo "Dùng . : " . ($s1 . $s2) . "<br>"; // Nối chuỗi nhưng không thay đổi biến gốc

$s1 .= $s2;
echo "Dùng .= : " . $s1 . "<br>"; // Nối và gán lại vào $s1
// Sự khác nhau: . chỉ tạo ra chuỗi mới, .= thay đổi trực tiếp biến bên trái.
echo "<hr>";

// --- Câu 2.5 ---
$str_ko_dau = "Lap trinh web 1";
$str_co_dau = "Lập trình web 1";
echo "Chuỗi không dấu: '$str_ko_dau' có độ dài (strlen) là " . strlen($str_ko_dau) . "<br>";
echo "Chuỗi có dấu: '$str_co_dau' có độ dài (mb_strlen) là " . mb_strlen($str_co_dau, 'UTF-8') . "<br>";
// Giải thích: strlen đếm số byte, mb_strlen đếm số ký tự (hỗ trợ unicode). Chữ "Lập" có ký tự unicode chiếm nhiều byte.
echo "<hr>";

// --- Câu 2.6 ---
$chuoi = "Xin chao buoi sang";
echo "In hoa: " . strtoupper($chuoi) . "<br>";
echo "In thường: " . strtolower($chuoi) . "<br>";
// Giải thích: strtoupper/strtolower chỉ dùng cho chuỗi ascii tiếng Anh, không xử lý tốt ký tự có dấu.
// mb_strtoupper/mb_strtolower hỗ trợ chuyển đổi chuỗi unicode có dấu (tiếng Việt).
echo "<hr>";

// --- Câu 2.7 ---
$str1 = "123 abc";
$str2 = "abc 123";
echo "Ép kiểu '123 abc' sang int: ";
var_dump((int)$str1); // Kết quả 123
echo "<br>Ép kiểu 'abc 123' sang int: ";
var_dump((int)$str2); // Kết quả 0
echo "<hr>";

// --- Câu 2.8 ---
$var_int = 100;
$var_float = 9.99;
$var_string = "Hello PHP";
$var_bool = true;

var_dump($var_int); echo "<br>";
var_dump($var_float); echo "<br>";
var_dump($var_string); echo "<br>";
var_dump($var_bool); echo "<br>";
?>
