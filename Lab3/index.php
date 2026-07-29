<?php
require "includes/header.php";
require "functions/common.php";

// Danh sách Laptop
$products_C1 = [
    ["id" => "LT001", "proname" => "Dell Inspiron 15", "quantity" => 10, "price" => 16500000],
    ["id" => "LT002", "proname" => "HP Pavilion 14", "quantity" => 8, "price" => 17200000],
    ["id" => "LT003", "proname" => "Asus VivoBook 15", "quantity" => 12, "price" => 13500000],
    ["id" => "LT004", "proname" => "Lenovo IdeaPad 3", "quantity" => 15, "price" => 12800000],
    ["id" => "LT005", "proname" => "Acer Aspire 5", "quantity" => 7, "price" => 14200000],
    ["id" => "LT006", "proname" => "MacBook Air M2", "quantity" => 5, "price" => 28500000],
    ["id" => "LT007", "proname" => "MSI Modern 14", "quantity" => 9, "price" => 15900000],
    ["id" => "LT008", "proname" => "HP Envy x360", "quantity" => 6, "price" => 22000000],
    ["id" => "LT009", "proname" => "Dell Vostro 3510", "quantity" => 11, "price" => 15500000],
    ["id" => "LT010", "proname" => "Asus ZenBook 14", "quantity" => 4, "price" => 24000000],
];

// Danh sách Phụ kiện
$products_C2 = [
    ["id" => "PK001", "proname" => "Chuột Logitech M331", "quantity" => 30, "price" => 320000],
    ["id" => "PK002", "proname" => "Bàn phím DareU EK87", "quantity" => 20, "price" => 690000],
    ["id" => "PK003", "proname" => "Tai nghe Sony WH-1000XM5", "quantity" => 10, "price" => 7500000],
    ["id" => "PK004", "proname" => "USB Kingston 32GB", "quantity" => 50, "price" => 120000],
    ["id" => "PK005", "proname" => "Webcam Logitech C920", "quantity" => 15, "price" => 1800000],
    ["id" => "PK006", "proname" => "Ổ cứng SSD Samsung 500GB", "quantity" => 25, "price" => 1500000],
    ["id" => "PK007", "proname" => "Ram Laptop DDR4 8GB", "quantity" => 18, "price" => 650000],
    ["id" => "PK008", "proname" => "Sạc laptop đa năng", "quantity" => 22, "price" => 350000],
    ["id" => "PK009", "proname" => "Túi chống sốc 15.6 inch", "quantity" => 35, "price" => 180000],
    ["id" => "PK010", "proname" => "Hub USB-C 7 in 1", "quantity" => 12, "price" => 450000],
];
?>
<!-- main -->
<main class="container my-5">

    <section class="mb-5">
        <?php showProductTable($products_C1, "Danh sách Laptop"); ?>
    </section>

    <section class="mb-5">
        <?php showProductTable($products_C2, "Danh sách Phụ kiện", "VNĐ", 2); ?>
    </section>

</main>

<?php
require "includes/footer.php";
?>
