<?php
// ===== 1. Mảng Menu =====
$menus = ["Trang chủ", "Sản phẩm", "Khuyến mãi", "Liên hệ"];

// ===== 3. Mảng nhiều chiều Sản phẩm =====
$products = [
    [
        "name" => "Điện thoại iPhone 15",
        "price" => 25000000,
        "image" => "images/default-product.jpg"
    ],
    [
        "name" => "Samsung Galaxy S24",
        "price" => 23000000,
        "image" => "images/default-product.jpg"
    ],
    [
        "name" => "Laptop Dell XPS",
        "price" => 35000000,
        "image" => "images/default-product.jpg"
    ],
    [
        "name" => "MacBook Pro M3",
        "price" => 40000000,
        "image" => "images/default-product.jpg"
    ]
];

// ===== 4. Mảng Thương hiệu nổi bật =====
$brands = ["Apple", "Samsung", "Dell", "Asus"];

// ===== 5. Mảng Danh mục sản phẩm quan tâm (cho select trong form) =====
$categories = ["Điện thoại", "Máy tính bảng", "Laptop", "Phụ kiện"];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng của Đoàn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .banner {
            background-color: #f8f9fa;
            padding: 50px 0;
            text-align: center;
        }
        .brand-item {
            text-align: center;
            padding: 20px;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: bold;
            transition: .3s;
        }
        .brand-item:hover {
            background: #e7f1ff;
            transform: translateY(-3px);
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

<!-- ===== 1. Navbar ===== -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="images/logo.png" alt="Logo" width="30" height="24">
        Cửa hàng Đoàn
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <?php foreach ($menus as $menu) { ?>
        <li class="nav-item">
          <a class="nav-link" href="#"><?= $menu ?></a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<!-- ===== 2. Banner (không dùng mảng) ===== -->
<div class="banner">
    <h1>Cửa hàng Điện máy Đoàn</h1>
    <p>Chuyên cung cấp các sản phẩm công nghệ chính hãng.</p>
</div>

<div class="container mt-4">

    <!-- ===== 3. Danh sách sản phẩm ===== -->
    <h2>Danh sách sản phẩm</h2>
    <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="<?= $product['image'] ?>" class="card-img-top" alt="Hình ảnh sản phẩm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= number_format($product['price']) ?> đ</p>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-info">Xem chi tiết</a>
                        <a href="#" class="btn btn-primary">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- ===== 4. Thương hiệu nổi bật (dùng mảng + foreach) ===== -->
    <h2 class="mt-5">Thương hiệu nổi bật</h2>
    <div class="row">
        <?php foreach ($brands as $brand) { ?>
        <div class="col-md-3">
            <div class="brand-item"><?= $brand ?></div>
        </div>
        <?php } ?>
    </div>

    <!-- ===== 5. Form đăng ký nhận báo giá ===== -->
    <h2 class="mt-5">Form đăng ký nhận báo giá</h2>
    <form action="#" method="post">
        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" class="form-control" name="fullname">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone">
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="address">
        </div>
        <div class="mb-3">
            <label class="form-label">Danh mục sản phẩm quan tâm</label>
            <select class="form-select" name="category">
                <?php foreach ($categories as $category) { ?>
                <option value="<?= $category ?>"><?= $category ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hình thức nhận báo giá</label><br>
            <input type="radio" name="contact_method" value="Email"> Email
            <input type="radio" name="contact_method" value="Điện thoại"> Điện thoại
        </div>
        <div class="mb-3">
            <label class="form-label">Thời gian liên hệ</label>
            <select class="form-select" name="contact_time">
                <option value="Buổi sáng (8h-11h)">Buổi sáng (8h-11h)</option>
                <option value="Buổi chiều (13h-17h)">Buổi chiều (13h-17h)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung yêu cầu</label>
            <textarea class="form-control" name="request_content"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Gửi yêu cầu</button>
        <button type="reset" class="btn btn-secondary">Làm mới</button>
    </form>
</div>

<!-- ===== 6. Footer (không dùng mảng) ===== -->
<div class="footer">
    <p>Bản quyền thuộc về cửa hàng của Đoàn.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>