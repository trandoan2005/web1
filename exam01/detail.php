<?php
require_once "dao/RoomDao.php";
$roomDao = new RoomDao();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$room = $roomDao->findById($id);

require "includes/header.php";
?>
<div class="container my-5">
    <?php if ($room): ?>
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Chi tiết phòng: <?= $room->roomNumber ?></h3>
                <a href="index.php" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="<?= $room->image ?>" alt="<?= htmlspecialchars($room->roomName) ?>" class="room-img-detail img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-primary mb-3"><?= htmlspecialchars($room->roomName) ?></h2>
                        <h4 class="text-danger fw-bold mb-4">Giá: <?= $room->getFormattedPrice() ?> / Đêm</h4>
                        
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Loại phòng:</strong>
                                <span><span class="badge bg-secondary fs-6"><?= $room->roomType ?></span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Tầng:</strong>
                                <span>Tầng <?= $room->floor ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Sức chứa:</strong>
                                <span><?= $room->capacity ?> Người lớn</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Trạng thái:</strong>
                                <span class="<?= $room->getStatusClass() ?> fs-6"><?= $room->status ?></span>
                            </li>
                        </ul>
                        
                        <div class="mt-4">
                            <h5>Mô tả:</h5>
                            <p class="text-muted" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($room->description)) ?>
                            </p>
                        </div>

                        <?php if ($room->status == 'Còn trống'): ?>
                            <button class="btn btn-success btn-lg w-100 mt-3"><i class="bi bi-check-circle"></i> Đặt phòng ngay</button>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg w-100 mt-3" disabled><i class="bi bi-x-circle"></i> Không thể đặt</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center shadow-sm">
            <h4 class="alert-heading">Lỗi!</h4>
            <p>Không tìm thấy thông tin phòng. Phòng có thể không tồn tại hoặc ID không hợp lệ.</p>
            <hr>
            <a href="index.php" class="btn btn-primary"><i class="bi bi-house-door"></i> Quay lại trang chủ</a>
        </div>
    <?php endif; ?>
</div>
<?php require "includes/footer.php"; ?>
