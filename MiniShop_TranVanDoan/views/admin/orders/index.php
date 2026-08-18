<?php ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Form tìm kiếm và sắp xếp -->
    <form class="row gx-2 align-items-center" method="GET">
        <input type="hidden" name="area" value="admin">
        <input type="hidden" name="controller" value="order">
        <input type="hidden" name="action" value="index">

        <div class="col-auto">
            <input type="text" name="keyword" class="form-control" placeholder="Tên khách hàng..." value="<?= htmlspecialchars($keyword) ?>">
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="newest" <?= $sort == "newest" ? 'selected' : '' ?>>Mới nhất</option>
                <option value="oldest" <?= $sort == "oldest" ? 'selected' : '' ?>>Cũ nhất</option>
                <option value="amount_asc" <?= $sort == "amount_asc" ? 'selected' : '' ?>>Tổng tiền tăng dần</option>
                <option value="amount_desc" <?= $sort == "amount_desc" ? 'selected' : '' ?>>Tổng tiền giảm dần</option>
            </select>
        </div>
        <input type="hidden" name="limit" value="<?= $limit ?>">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
        </div>
        <?php if (!empty($keyword) || $sort != 'newest'): ?>
            <div class="col-auto">
                <a href="index.php?area=admin&controller=order&action=index" class="btn btn-secondary">Hủy</a>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php if (empty($orders)): ?>
    <div class="alert alert-warning">
        Không tìm thấy đơn hàng nào <?= !empty($keyword) ? 'phù hợp với từ khóa "' . htmlspecialchars($keyword) . '"' : '' ?>.
    </div>
<?php else: ?>
    <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Mã ĐH</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $item): ?>
                <tr>
                    <td class="fw-bold">#<?= $item->id ?></td>
                    <td class="text-start"><?= htmlspecialchars($item->customerName) ?></td>
                    <td class="text-danger fw-bold text-end"><?= number_format($item->totalAmount, 0, ',', '.') ?> đ</td>
                    <td>
                        <?php
                        $statusText = "Chờ xử lý";
                        $statusClass = "bg-warning text-dark";
                        if ($item->status == 1) {
                            $statusText = "Đang giao";
                            $statusClass = "bg-info text-dark";
                        } elseif ($item->status == 2) {
                            $statusText = "Đã giao";
                            $statusClass = "bg-success";
                        } elseif ($item->status == 3) {
                            $statusText = "Đã hủy";
                            $statusClass = "bg-danger";
                        }
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($item->createdAt)) ?></td>
                    <td>
                        <a href="index.php?area=admin&controller=order&action=detail&id=<?= $item->id ?>" class="btn btn-sm btn-info text-white" title="Chi tiết"><i class="bi bi-eye"></i></a>
                        <a href="update_status.php?id=<?= $item->id ?>" class="btn btn-sm btn-warning" title="Cập nhật trạng thái"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <!-- Chỉnh số lượng hiển thị -->
        <div class="d-flex align-items-center">
            <label class="me-2">Hiển thị:</label>
            <form method="GET">
        <input type="hidden" name="area" value="admin">
        <input type="hidden" name="controller" value="order">
        <input type="hidden" name="action" value="index">

                <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                <select name="limit" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                </select>
            </form>
        </div>
        
        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination mb-0">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=order&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=1">Đầu</a>
                </li>
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=order&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $page - 1 ?>">Trước</a>
                </li>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?area=admin&controller=order&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=order&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $page + 1 ?>">Sau</a>
                </li>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=order&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $totalPages ?>">Cuối</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
