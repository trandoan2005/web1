<?php ob_start(); ?>

<div class="breadcrumb-shop">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php?area=client&controller=home&action=index">Trang chủ</a></li>
                <li class="breadcrumb-item active">Giỏ hàng của bạn</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <h2 class="section-title mb-4">Giỏ hàng của bạn</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
            <h4>Giỏ hàng trống</h4>
            <p>Bạn chưa chọn sản phẩm nào để mua.</p>
            <a href="index.php?area=client&controller=product&action=index" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col" class="text-center">Đơn giá</th>
                                <th scope="col" class="text-center" style="width: 150px;">Số lượng</th>
                                <th scope="col" class="text-end">Thành tiền</th>
                                <th scope="col" class="text-center">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $item): ?>
                            <tr id="cart-item-<?= $item['productId'] ?>">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php $imgSrc = !empty($item['image']) ? 'uploads/products/'.$item['image'] : 'https://placehold.co/100'; ?>
                                        <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($item['productName']) ?>" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        <a href="index.php?area=client&controller=product&action=detail&id=<?= $item['productId'] ?>" class="text-dark text-decoration-none fw-semibold">
                                            <?= htmlspecialchars($item['productName']) ?>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center fw-medium"><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-secondary" type="button" onclick="updateCart(<?= $item['productId'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                                        <input type="text" class="form-control text-center px-1" id="qty-<?= $item['productId'] ?>" value="<?= $item['quantity'] ?>" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="updateCart(<?= $item['productId'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-danger" id="item-total-<?= $item['productId'] ?>">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeCart(<?= $item['productId'] ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <a href="index.php?area=client&controller=product&action=index" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card bg-light border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4">Tóm tắt đơn hàng</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tổng tạm tính:</span>
                            <strong id="cart-subtotal"><?= number_format($total, 0, ',', '.') ?>₫</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <strong>Miễn phí</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5">Tổng cộng:</span>
                            <strong class="fs-4 text-danger" id="cart-total"><?= number_format($total, 0, ',', '.') ?>₫</strong>
                        </div>
                        <a href="index.php?area=client&controller=cart&action=checkout" class="btn btn-primary w-100 btn-lg">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
