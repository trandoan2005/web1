<?php
$menus = ["Trang chủ", "Sản phẩm", "Khuyến mãi", "Liên hệ"];

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

$categories = ["Điện thoại", "Máy tính bảng", "Laptop", "Phụ kiện"];
?>
<!DOCTYPE html>
<html lang="en">
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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="images/logo.png" alt="Logo" width="30" height="24">
        Cửa hàng Đoàn
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <?php foreach($menus as $menu) { ?>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo $menu; ?></a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<div class="banner">
    <h1>Cửa hàng Điện máy Đoàn</h1>
    <p>Chuyên cung cấp các sản phẩm công nghệ chính hãng.</p>
</div>

<div class="container mt-4">
    <h2>Danh sách sản phẩm</h2>
    <div class="row">
        <?php foreach($products as $product) { ?>
        <div class="col-md-3">
            <div class="card">
                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Hình ảnh sản phẩm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text">Giá: <?php echo number_format($product['price']); ?> VNĐ</p>
                    <a href="#" class="btn btn-info">Xem chi tiết</a>
                    <a href="#" class="btn btn-primary">Mua ngay</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <h2 class="mt-5">Thương hiệu nổi bật</h2>
    <div class="row">
        <div class="col-md-3">Apple</div>
        <div class="col-md-3">Samsung</div>
        <div class="col-md-3">Dell</div>
        <div class="col-md-3">Asus</div>
    </div>

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
                <?php foreach($categories as $category) { ?>
                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
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

<div class="footer">
    <p>Bản quyền thuộc về cửa hàng của Đoàn.</p>
</div>

</body>
</html>
