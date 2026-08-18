<?php ob_start();
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-success">Đã xóa thành công!</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Form tìm kiếm và sắp xếp -->
    <form class="row gx-2 align-items-center" method="GET">
        <input type="hidden" name="area" value="admin">
        <input type="hidden" name="controller" value="brand">
        <input type="hidden" name="action" value="index">

        <div class="col-auto">
            <input type="text" name="keyword" class="form-control" placeholder="Tên thương hiệu..." value="<?= htmlspecialchars($keyword) ?>">
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="name_asc" <?= $sort == "name_asc" ? 'selected' : '' ?>>Tên A-Z</option>
                <option value="name_desc" <?= $sort == "name_desc" ? 'selected' : '' ?>>Tên Z-A</option>
                <option value="newest" <?= $sort == "newest" ? 'selected' : '' ?>>Mới nhất</option>
            </select>
        </div>
        <input type="hidden" name="limit" value="<?= $limit ?>">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
        </div>
        <?php if (!empty($keyword) || $sort != 'name_asc'): ?>
            <div class="col-auto">
                <a href="index.php?area=admin&controller=brand&action=index" class="btn btn-secondary">Hủy</a>
            </div>
        <?php endif; ?>
    </form>
    
    <a href="index.php?area=admin&controller=brand&action=create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Thêm mới</a>
</div>

<?php if (empty($brands)): ?>
    <div class="alert alert-warning">
        Không tìm thấy thương hiệu nào <?= !empty($keyword) ? 'phù hợp với từ khóa "' . htmlspecialchars($keyword) . '"' : '' ?>.
    </div>
<?php else: ?>
    <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Logo</th>
                <th>Tên thương hiệu</th>
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stt = $offset + 1;
            foreach ($brands as $item): 
            ?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td>
                        <?php if ($item->logo != "") { ?>
                            <img src="uploads/brands/<?= htmlspecialchars($item->logo) ?>" alt="<?= htmlspecialchars($item->name) ?>" class="img-thumbnail" width="80">
                        <?php } else { ?>
                            <span class="text-muted">No Image</span>
                        <?php } ?>
                    </td>
                    <td class="text-start fw-bold"><?= htmlspecialchars($item->name) ?></td>
                    <td>
                        <span class="badge <?= $item->status ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $item->status ? 'Hoạt động' : 'Khóa' ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?area=admin&controller=brand&action=detail&id=<?= $item->id ?>" class="btn btn-sm btn-info text-white" title="Chi tiết"><i class="bi bi-eye"></i></a>
                        <a href="index.php?area=admin&controller=brand&action=edit&id=<?= $item->id ?>" class="btn btn-sm btn-warning" title="Sửa"><i class="bi bi-pencil"></i></a>
                        <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');" class="d-inline">
                            <input type="hidden" name="id" value="<?= $item->id ?>">
                            <button type="submit" name="btnDelete" class="btn btn-sm btn-danger" title="Xóa"><i class="bi bi-trash"></i></button>
                        </form>
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
        <input type="hidden" name="controller" value="brand">
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
                    <a class="page-link" href="index.php?area=admin&controller=brand&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=1">Đầu</a>
                </li>
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=brand&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $page - 1 ?>">Trước</a>
                </li>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?area=admin&controller=brand&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=brand&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $page + 1 ?>">Sau</a>
                </li>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?area=admin&controller=brand&action=index&keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&limit=<?= $limit ?>&page=<?= $totalPages ?>">Cuối</a>
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
