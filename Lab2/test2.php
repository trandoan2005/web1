<?php
$menus = ["Trang chủ", "Sản phẩm", "Khuyến mãi", "Liên hệ"];
$products = [
    [
        "name" => "Sản phẩm A",
        "price" => 1500000
    ],
    [
        "name" => "Sản phẩm B",
        "price" => 2000000
    ],
    [
        "name" => "Sản phẩm C",
        "price" => 3500000
    ],
    [
        "name" => "Sản phẩm D",
        "price" => 500000
    ]
];
$brands = ["Thương hiệu 1", "Thương hiệu 2", "Thương hiệu 3", "Thương hiệu 4"];
$categories = ["Điện thoại", "Máy tính bảng", "Laptop", "Phụ kiện"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lab 2 - Test 2 - Sản phẩm</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .banner {
        background: url('https://via.placeholder.com/1200x400/0d6efd/ffffff?text=Banner+C%E1%BB%ADa+H%C3%A0ng') center/cover;
        color: white;
        padding: 100px 0;
        text-align: center;
    }
    .product-card img {
        height: 200px;
        object-fit: cover;
    }
</style>
</head>
<body>

<!-- 1. Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">LOGO CỬA HÀNG</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php foreach ($menus as $menu) { ?>
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
    <div class="container">
        <h1 class="display-4 fw-bold">CHÀO MỪNG ĐẾN VỚI CỬA HÀNG</h1>
        <p class="lead">Cung cấp các sản phẩm chất lượng với giá tốt nhất thị trường.</p>
    </div>
</div>

<div class="container my-5">
    <!-- 3. Danh sách sản phẩm -->
    <h2 class="text-center mb-4 text-primary">DANH SÁCH SẢN PHẨM</h2>
    <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="col-md-3 mb-4">
            <div class="card product-card">
                <img src="images/default-product.jpg" class="card-img-top" alt="<?= $product['name'] ?>" onerror="this.src='https://via.placeholder.com/300x200?text=S%E1%BA%A3n+ph%E1%BA%A9m'">
                <div class="card-body text-center">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                    <a href="#" class="btn btn-primary btn-sm">Mua ngay</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- 4. Thương hiệu nổi bật -->
    <h2 class="text-center my-4 text-primary">THƯƠNG HIỆU NỔI BẬT</h2>
    <div class="row text-center mb-5">
        <?php foreach ($brands as $brand) { ?>
        <div class="col-md-3">
            <div class="p-3 bg-light border rounded">
                <strong><?= $brand ?></strong>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- 5. Form đăng ký nhận báo giá -->
    <h2 class="text-center mb-4 text-primary">ĐĂNG KÝ NHẬN BÁO GIÁ</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Danh mục sản phẩm quan tâm</label>
                        <select class="form-select" name="category">
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat) { ?>
                            <option><?= $cat ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Hình thức nhận báo giá</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contact_method" id="rEmail" value="Email">
                            <label class="form-check-label" for="rEmail">Email</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contact_method" id="rPhone" value="Điện thoại">
                            <label class="form-check-label" for="rPhone">Điện thoại</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thời gian liên hệ</label>
                        <select class="form-select" name="contact_time">
                            <option>Buổi sáng (8h-11h)</option>
                            <option>Buổi chiều (13h-17h)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung yêu cầu</label>
                        <textarea class="form-control" name="message" rows="3"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Gửi yêu cầu</button>
                        <button type="reset" class="btn btn-secondary px-4">Làm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 6. Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; 2026 Cửa hàng của chúng tôi. Bản quyền đã được bảo lưu.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
