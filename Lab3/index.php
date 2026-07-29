<?php
require "includes/header.php";
require "functions/common.php";

// Danh sách Laptop
$products_C1 = [
    ["id" => "LT001", "proname" => "Dell Inspiron 15", "quantity" => 10, "price" => 16500000, "image" => "dell.jpg"],
    ["id" => "LT002", "proname" => "HP Pavilion 14", "quantity" => 8, "price" => 17200000, "image" => "hp.jpg"],
    ["id" => "LT003", "proname" => "Asus VivoBook 15", "quantity" => 12, "price" => 13500000, "image" => "asus.jpg"],
    ["id" => "LT004", "proname" => "Lenovo IdeaPad 3", "quantity" => 15, "price" => 12800000, "image" => "lenovo.jpg"],
    ["id" => "LT005", "proname" => "Acer Aspire 5", "quantity" => 7, "price" => 14200000, "image" => "acer.jpg"],
    ["id" => "LT006", "proname" => "MacBook Air M2", "quantity" => 5, "price" => 28500000, "image" => "macbook.jpg"],
    ["id" => "LT007", "proname" => "MSI Modern 14", "quantity" => 9, "price" => 15900000, "image" => "msi.jpg"],
    ["id" => "LT008", "proname" => "HP Envy x360", "quantity" => 6, "price" => 22000000, "image" => "hpenvy.jpg"],
    ["id" => "LT009", "proname" => "Dell Vostro 3510", "quantity" => 11, "price" => 15500000, "image" => "vostro.jpg"],
    ["id" => "LT010", "proname" => "Asus ZenBook 14", "quantity" => 4, "price" => 24000000, "image" => "zenbook.jpg"],
];

// Danh sách Phụ kiện
$products_C2 = [
    ["id" => "PK001", "proname" => "Chuột Logitech M331", "quantity" => 30, "price" => 320000, "image" => "m331.jpg"],
    ["id" => "PK002", "proname" => "Bàn phím DareU EK87", "quantity" => 20, "price" => 690000, "image" => "ek87.jpg"],
    ["id" => "PK003", "proname" => "Tai nghe Sony WH-1000XM5", "quantity" => 10, "price" => 7500000, "image" => "sony.jpg"],
    ["id" => "PK004", "proname" => "USB Kingston 32GB", "quantity" => 50, "price" => 120000, "image" => "usb.jpg"],
    ["id" => "PK005", "proname" => "Webcam Logitech C920", "quantity" => 15, "price" => 1800000, "image" => "c920.jpg"],
    ["id" => "PK006", "proname" => "Ổ cứng SSD Samsung 500GB", "quantity" => 25, "price" => 1500000, "image" => "ssd.jpg"],
    ["id" => "PK007", "proname" => "Ram Laptop DDR4 8GB", "quantity" => 18, "price" => 650000, "image" => "ram.jpg"],
    ["id" => "PK008", "proname" => "Sạc laptop đa năng", "quantity" => 22, "price" => 350000, "image" => "sac.jpg"],
    ["id" => "PK009", "proname" => "Túi chống sốc 15.6 inch", "quantity" => 35, "price" => 180000, "image" => "tui.jpg"],
    ["id" => "PK010", "proname" => "Hub USB-C 7 in 1", "quantity" => 12, "price" => 450000, "image" => "hub.jpg"],
];
?>
<!-- main -->
<main class="container my-5">

    <section class="mb-5">
        <?php showProductTable($products_C1, "Danh sách Loại C1"); ?>
    </section>

    <section class="mb-5">
        <?php showProductTable($products_C2, "Danh sách Loại C2"); ?>
    </section>

    <section class="mb-5">
        <h2>Lorem ipsum dolor sit amet.</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </section>
</main>

<?php
require "includes/footer.php";
?>
