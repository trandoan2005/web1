<?php
// 1. Menu
$menus = ["Trang chủ", "Sản phẩm", "Khuyến mãi", "Liên hệ"];

// 3. Danh sách sản phẩm (mảng nhiều chiều)
$products = [
    [
        "name" => "Sản phẩm 1",
        "price" => 1500000,
        "image" => "images/default-product.jpg"
    ],
    [
        "name" => "Sản phẩm 2",
        "price" => 2500000,
        "image" => "images/default-product.jpg"
    ],
    [
        "name" => "Sản phẩm 3",
        "price" => 3000000,
        "image" => "images/default-product.jpg"
    ],
    [
        "name" => "Sản phẩm 4",
        "price" => 4000000,
        "image" => "images/default-product.jpg"
    ]
];

// 5. Danh mục sản phẩm quan tâm (mảng)
$categories = ["Điện thoại", "Máy tính bảng", "Laptop"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 2 - Test 2</title>
    <!-- Sử dụng CSS framework Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- kết hợp CSS thuần để thiết kế giao diện -->
    <style>
        .banner {
            background-color: #f8f9fa;
            padding: 50px 0;
            text-align: center;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- 1. Thanh Menu (Navbar) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <!-- Hiển thị Logo cửa hàng -->
    <a class="navbar-brand" href="#">
        <img src="images/logo.png" alt="Logo" width="30" height="24">
        Logo Cửa Hàng
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <!-- Hiển thị menu bằng vòng lặp foreach -->
        <?php foreach($menus as $menu) { ?>
        <li class="nav-item">
          <a class="nav-link" href="#"><?= $menu ?></a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<!-- 2. Banner -->
<div class="banner">
    <!-- Có tiêu đề, Có mô tả ngắn -->
    <h1>Tiêu đề Banner Cửa Hàng</h1>
    <p>Đây là mô tả ngắn giới thiệu về cửa hàng của chúng tôi.</p>
</div>

<div class="container mt-4">
    <!-- 3. Danh sách sản phẩm -->
    <h2>Danh sách sản phẩm</h2>
    <!-- Hiển thị bằng Bootstrap Grid -->
    <div class="row">
        <?php foreach($products as $product) { ?>
        <div class="col-md-3">
            <!-- Hiển thị bằng Bootstrap Card -->
            <div class="card">
                <!-- Hình ảnh (sử dụng cùng một ảnh mặc định cho tất cả sản phẩm) -->
                <img src="<?= $product['image'] ?>" class="card-img-top" alt="Hình ảnh sản phẩm">
                <div class="card-body">
                    <!-- Tên sản phẩm -->
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <!-- Giá bán (sử dụng hàm number_format() để định dạng có dấu phân cách hàng nghìn) -->
                    <p class="card-text">Giá: <?= number_format($product['price']) ?> VNĐ</p>
                    <!-- Nút Xem chi tiết, Nút Mua ngay -->
                    <a href="#" class="btn btn-info">Xem chi tiết</a>
                    <a href="#" class="btn btn-primary">Mua ngay</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- 4. Thương hiệu nổi bật -->
    <h2 class="mt-5">Thương hiệu nổi bật</h2>
    <!-- Hiển thị danh sách thương hiệu bằng Bootstrap Grid -->
    <div class="row">
        <div class="col-md-3">Thương hiệu A</div>
        <div class="col-md-3">Thương hiệu B</div>
        <div class="col-md-3">Thương hiệu C</div>
        <div class="col-md-3">Thương hiệu D</div>
    </div>

    <!-- 5. Form đăng ký nhận báo giá -->
    <h2 class="mt-5">Form đăng ký nhận báo giá</h2>
    <form action="#" method="post">
        <!-- Họ và tên -->
        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" class="form-control" name="fullname">
        </div>
        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <!-- Số điện thoại -->
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone">
        </div>
        <!-- Địa chỉ -->
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="address">
        </div>
        <!-- Danh mục sản phẩm quan tâm (<select>) - Được hiển thị từ mảng bằng vòng lặp foreach -->
        <div class="mb-3">
            <label class="form-label">Danh mục sản phẩm quan tâm</label>
            <select class="form-select" name="category">
                <?php foreach($categories as $category) { ?>
                <option value="<?= $category ?>"><?= $category ?></option>
                <?php } ?>
            </select>
        </div>
        <!-- Hình thức nhận báo giá (Radio Button) -->
        <div class="mb-3">
            <label class="form-label">Hình thức nhận báo giá</label><br>
            <input type="radio" name="contact_method" value="Email"> Email
            <input type="radio" name="contact_method" value="Điện thoại"> Điện thoại
        </div>
        <!-- Thời gian liên hệ (<select>) -->
        <div class="mb-3">
            <label class="form-label">Thời gian liên hệ</label>
            <select class="form-select" name="contact_time">
                <option value="Buổi sáng (8h-11h)">Buổi sáng (8h-11h)</option>
                <option value="Buổi chiều (13h-17h)">Buổi chiều (13h-17h)</option>
            </select>
        </div>
        <!-- Nội dung yêu cầu (<textarea>) -->
        <div class="mb-3">
            <label class="form-label">Nội dung yêu cầu</label>
            <textarea class="form-control" name="request_content"></textarea>
        </div>
        <!-- Thêm hai nút: Gửi yêu cầu (Submit), Làm mới (Reset) -->
        <button type="submit" class="btn btn-success">Gửi yêu cầu</button>
        <button type="reset" class="btn btn-secondary">Làm mới</button>
    </form>
</div>

<!-- 6. Footer -->
<div class="footer">
    <p>Bản quyền thuộc về cửa hàng.</p>
</div>

</body>
</html>
