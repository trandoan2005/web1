<?php
// --- Câu 3.1 ---
$str = "   Hello World!   ";
echo "Chuỗi gốc: '" . $str . "'<br>";
echo "Dùng trim(): '" . trim($str) . "'<br>";

// --- Câu 3.2 ---
echo "Dùng ltrim(): '" . ltrim($str) . "'<br>";
echo "Dùng rtrim(): '" . rtrim($str) . "'<br>";
echo "<hr>";

// --- Câu 3.3 ---
$chuoi_dai = "Lap trinh web 1 la mon hoc rat thu vi va huu ich cho sinh vien";
echo "Chuỗi gốc: $chuoi_dai<br>";
echo "Lấy 10 ký tự đầu tiên: " . substr($chuoi_dai, 0, 10) . "<br>";
echo "Lấy từ ký tự thứ 5 đến hết: " . substr($chuoi_dai, 5) . "<br>";
echo "<hr>";

// --- Câu 3.4 ---
echo "Chuỗi gốc: $chuoi_dai<br>";
$chuoi_thay_the = str_replace("rat thu vi", "cuc ky thu vi", $chuoi_dai);
echo "Chuỗi sau khi thay thế: $chuoi_thay_the<br>";
?>
