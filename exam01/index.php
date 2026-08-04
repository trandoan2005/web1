<?php
require_once "dao/RoomDao.php";
$roomDao = new RoomDao();

// Thống kê
$stats = $roomDao->getStats();

// Xử lý tìm kiếm và lọc
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : '';
$maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : '';

// Xử lý sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// 1. Lấy dữ liệu + Lọc
$data = $roomDao->search($keyword, $type, $status, $minPrice, $maxPrice);

// 2. Sắp xếp
if ($sort == 'asc') {
    $data = $roomDao->sortPriceASC($data);
} else if ($sort == 'desc') {
    $data = $roomDao->sortPriceDESC($data);
}

// 3. Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$pageSize = 5;
$totalItems = count($data);
$totalPages = ceil($totalItems / $pageSize);

// Cắt dữ liệu cho trang hiện tại
$pagedData = $roomDao->paging($data, $page, $pageSize);

// Hàm tạo URL giữ nguyên param (để phân trang không mất filter/sort)
function buildUrl($paramsToUpdate) {
    $queryParams = $_GET;
    foreach ($paramsToUpdate as $key => $value) {
        $queryParams[$key] = $value;
    }
    return '?' . http_build_query($queryParams);
}

require "includes/header.php";
?>
<div class="container my-5">
    
    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center p-3">
                <h4><?= $stats['total'] ?></h4>
                <p class="mb-0">Tổng số phòng</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white text-center p-3">
                <h4><?= $stats['available'] ?></h4>
                <p class="mb-0">Còn trống</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white text-center p-3">
                <h4><?= $stats['booked'] ?></h4>
                <p class="mb-0">Đã đặt</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark text-center p-3">
                <h4><?= $stats['maintenance'] ?></h4>
                <p class="mb-0">Bảo trì</p>
            </div>
        </div>
    </div>

    <!-- Bộ lọc -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="index.php" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tên phòng..." value="<?= htmlspecialchars($keyword) ?>">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">-- Loại phòng --</option>
                        <option value="Standard" <?= $type == 'Standard' ? 'selected' : '' ?>>Standard</option>
                        <option value="Superior" <?= $type == 'Superior' ? 'selected' : '' ?>>Superior</option>
                        <option value="VIP" <?= $type == 'VIP' ? 'selected' : '' ?>>VIP</option>
                        <option value="President" <?= $type == 'President' ? 'selected' : '' ?>>President</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">-- Trạng thái --</option>
                        <option value="Còn trống" <?= $status == 'Còn trống' ? 'selected' : '' ?>>Còn trống</option>
                        <option value="Đã đặt" <?= $status == 'Đã đặt' ? 'selected' : '' ?>>Đã đặt</option>
                        <option value="Bảo trì" <?= $status == 'Bảo trì' ? 'selected' : '' ?>>Bảo trì</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="minPrice" class="form-control" placeholder="Giá từ..." value="<?= htmlspecialchars($minPrice) ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="maxPrice" class="form-control" placeholder="Đến giá..." value="<?= htmlspecialchars($maxPrice) ?>">
                </div>
                <!-- Giữ lại thông tin sort nếu có -->
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Nút sắp xếp -->
    <div class="mb-3 d-flex gap-2">
        <a href="<?= buildUrl(['sort' => 'asc', 'page' => 1]) ?>" class="btn <?= $sort == 'asc' ? 'btn-success' : 'btn-outline-secondary' ?>">
            <i class="bi bi-sort-numeric-up"></i> Giá tăng dần
        </a>
        <a href="<?= buildUrl(['sort' => 'desc', 'page' => 1]) ?>" class="btn <?= $sort == 'desc' ? 'btn-success' : 'btn-outline-secondary' ?>">
            <i class="bi bi-sort-numeric-down-alt"></i> Giá giảm dần
        </a>
        <a href="index.php" class="btn btn-outline-danger ms-auto">
            <i class="bi bi-arrow-counterclockwise"></i> Đặt lại
        </a>
    </div>

    <!-- Bảng danh sách -->
    <div class="table-responsive bg-white shadow-sm p-3 rounded">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Số phòng</th>
                    <th>Tên phòng</th>
                    <th>Loại</th>
                    <th>Giá/Đêm</th>
                    <th>Số người</th>
                    <th>Tầng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pagedData) > 0): ?>
                    <?php foreach ($pagedData as $index => $room): ?>
                        <tr>
                            <td><?= ($page - 1) * $pageSize + $index + 1 ?></td>
                            <td><img src="<?= $room->image ?>" alt="<?= $room->roomName ?>" class="room-img-thumbnail"></td>
                            <td><strong><?= $room->roomNumber ?></strong></td>
                            <td><?= htmlspecialchars($room->roomName) ?></td>
                            <td><span class="badge bg-secondary"><?= $room->roomType ?></span></td>
                            <td class="text-danger fw-bold"><?= $room->getFormattedPrice() ?></td>
                            <td><i class="bi bi-people-fill"></i> <?= $room->capacity ?></td>
                            <td>Tầng <?= $room->floor ?></td>
                            <td class="<?= $room->getStatusClass() ?>"><?= $room->status ?></td>
                            <td>
                                <a href="detail.php?id=<?= $room->id ?>" class="btn btn-sm btn-info text-white">Chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center py-4">Không tìm thấy phòng nào phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= buildUrl(['page' => $page - 1]) ?>">Trước</a>
            </li>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= buildUrl(['page' => $i]) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= buildUrl(['page' => $page + 1]) ?>">Sau</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

</div>

<?php require "includes/footer.php"; ?>
