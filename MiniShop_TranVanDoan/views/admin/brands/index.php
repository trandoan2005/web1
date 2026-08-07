<?php
$pageTitle = "Quản lý Thương hiệu";
require_once __DIR__ . '/../../../dao/BrandDAO.php';
$brandDAO = new BrandDAO();

// Xử lý Xóa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDelete'])) {
    $id = $_POST['id'];
    if ($brandDAO->delete($id)) {
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
$brands = $brandDAO->getAll($keyword);

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
            <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..." value="<?= htmlspecialchars($keyword) ?>">
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

<?php if (empty($brands)): ?>
    <div class="alert alert-warning">Không tìm thấy dữ liệu.</div>
<?php else: ?>
    <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Tên thương hiệu</th>
                <th>Logo (Tên file)</th>

                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brands as $index => $brand): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($brand->name) ?></td>
                    <td><?= htmlspecialchars($brand->logo) ?></td>

                    <td>
                        <span class="badge <?= $brand->status ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $brand->status ? 'Hoạt động' : 'Khóa' ?>
                        </span>
                    </td>
                    <td>
                        <a href="detail.php?id=<?= $brand->id ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                        <a href="edit.php?id=<?= $brand->id ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');" class="d-inline">
                            <input type="hidden" name="id" value="<?= $brand->id ?>">
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