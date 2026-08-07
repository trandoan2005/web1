<?php
$pageTitle = "Quản lý Sản phẩm";
require_once __DIR__ . '/../../../dao/ProductDAO.php';
$productDAO = new ProductDAO();

// Xử lý Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
    $id = $_POST['id'];
    if ($productDAO->delete($id)) {
        header("Location: index.php?msg=deleted");
        exit;
    } else {
        $error = "Xóa thất bại!";
    }
}

// Xử lý Tìm kiếm
$keyword = "";
if (isset($_GET["keyword"])) {
    $keyword = trim($_GET["keyword"]);
}
$products = $productDAO->getAll($keyword);

ob_start();
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-success">Đã xóa thành công!</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <form class="row gx-2 align-items-center" method="GET">
        <div class="col-auto">
            <input type="text" name="keyword" class="form-control" placeholder="Tên SP, Hãng, Danh mục..." value="<?= htmlspecialchars($keyword) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
        </div>
        <?php if (!empty($keyword)): ?>
            <div class="col-auto">
                <a href="index.php" class="btn btn-secondary">Hủy</a>
            </div>
        <?php endif; ?>
    </form>
    
    <a href="create.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Thêm mới</a>
</div>

<?php if (empty($products)): ?>
    <div class="alert alert-warning">Không tìm thấy dữ liệu.</div>
<?php else: ?>
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Giá bán</th>
                <th>Tồn kho</th>
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $index => $p): ?>
                <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($p->name) ?></td>
                    <td><?= htmlspecialchars($p->cateName) ?></td>
                    <td><?= htmlspecialchars($p->brandName) ?></td>
                    <td class="text-danger fw-bold text-end"><?= number_format($p->salePrice, 0, ',', '.') ?> đ</td>
                    <td class="text-center"><?= $p->quantity ?></td>
                    <td class="text-center">
                        <span class="badge <?= $p->status ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $p->status ? 'Hiện' : 'Ẩn' ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="detail.php?id=<?= $p->id ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                        <a href="edit.php?id=<?= $p->id ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');" class="d-inline">
                            <input type="hidden" name="id" value="<?= $p->id ?>">
                            <button type="submit" name="btnDelete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
$content = ob_get_clean();
include '../layouts/master.php';
?>
