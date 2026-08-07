<?php
$entities = [
    'Brand' => [
        'dao' => 'BrandDAO',
        'var' => 'brand',
        'table' => 'brands',
        'title' => 'Thương hiệu',
        'folder' => 'brands',
        'fields' => [
            'name' => ['label' => 'Tên thương hiệu', 'db' => 'name', 'type' => 'text'],
            'logo' => ['label' => 'Logo (Tên file)', 'db' => 'logo', 'type' => 'text'],
        ]
    ],
    'Customer' => [
        'dao' => 'CustomerDAO',
        'var' => 'customer',
        'table' => 'customers',
        'title' => 'Khách hàng',
        'folder' => 'customers',
        'fields' => [
            'fullname' => ['label' => 'Họ tên', 'db' => 'fullname', 'type' => 'text'],
            'email' => ['label' => 'Email', 'db' => 'email', 'type' => 'text'],
            'phone' => ['label' => 'Điện thoại', 'db' => 'phone', 'type' => 'text'],
            'address' => ['label' => 'Địa chỉ', 'db' => 'address', 'type' => 'text'],
        ]
    ],
    'User' => [
        'dao' => 'UserDAO',
        'var' => 'user',
        'table' => 'users',
        'title' => 'Người dùng',
        'folder' => 'users',
        'fields' => [
            'username' => ['label' => 'Tên đăng nhập', 'db' => 'username', 'type' => 'text'],
            'password' => ['label' => 'Mật khẩu', 'db' => 'password', 'type' => 'text'],
            'fullname' => ['label' => 'Họ tên', 'db' => 'fullname', 'type' => 'text'],
            'email' => ['label' => 'Email', 'db' => 'email', 'type' => 'text'],
            'phone' => ['label' => 'Điện thoại', 'db' => 'phone', 'type' => 'text'],
            'role' => ['label' => 'Vai trò (admin/staff)', 'db' => 'role', 'type' => 'text'],
        ]
    ]
];

$baseDir = __DIR__ . "/views/admin/";
$daoDir = __DIR__ . "/dao/";

foreach ($entities as $className => $data) {
    // --- 1. UPDATE DAO ---
    $daoFile = $daoDir . $data['dao'] . ".php";
    $daoContent = file_get_contents($daoFile);
    
    // Replace getAll() to support keyword
    $searchField = array_keys($data['fields'])[0]; // Search by first field
    if ($className == 'Customer') $searchField = 'fullname';
    if ($className == 'User') $searchField = 'username';
    
    // We will just do a simple replacement for getAll()
    $oldGetAll = '    public function getAll()
    {
        try {
            $sql = "SELECT * FROM ' . $data['table'] . ' ORDER BY id ASC";
            $result = $this->executeQuery($sql);';
            
    $newGetAll = '    public function getAll($keyword = "")
    {
        try {
            $sql = "SELECT * FROM ' . $data['table'] . '";
            $keyword = trim($keyword);
            
            if (!empty($keyword)) {
                $sql .= " WHERE ' . $searchField . ' LIKE ?";
            }
            $sql .= " ORDER BY id ASC";
            
            if (!empty($keyword)) {
                $searchParam = "%" . $keyword . "%";
                $stmt = $this->executePrepared($sql, "s", $searchParam);
                $result = $stmt->get_result();
            } else {
                $result = $this->executeQuery($sql);
            }';
            
    $daoContent = str_replace($oldGetAll, $newGetAll, $daoContent);
    file_put_contents($daoFile, $daoContent);

    // --- 2. INDEX.PHP ---
    $indexFile = $baseDir . $data['folder'] . "/index.php";
    
    $thHtml = "";
    $tdHtml = "";
    foreach ($data['fields'] as $k => $f) {
        $thHtml .= "                <th>{$f['label']}</th>\n";
        $tdHtml .= "                    <td><?= htmlspecialchars(\${$data['var']}->{$k}) ?></td>\n";
    }

    $indexContent = '<?php
$pageTitle = "Quản lý ' . $data['title'] . '";
require_once __DIR__ . \'/../../../dao/' . $data['dao'] . '.php\';
$' . lcfirst($data['dao']) . ' = new ' . $data['dao'] . '();

// Xử lý Xóa
if ($_SERVER[\'REQUEST_METHOD\'] == \'POST\' && isset($_POST[\'btnDelete\'])) {
    $id = $_POST[\'id\'];
    if ($' . lcfirst($data['dao']) . '->delete($id)) {
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
$' . lcfirst($data['table']) . ' = $' . lcfirst($data['dao']) . '->getAll($keyword);

ob_start();
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<?php if (isset($_GET[\'msg\']) && $_GET[\'msg\'] == \'deleted\'): ?>
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

<?php if (empty($' . lcfirst($data['table']) . ')): ?>
    <div class="alert alert-warning">Không tìm thấy dữ liệu.</div>
<?php else: ?>
    <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
' . $thHtml . '
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($' . lcfirst($data['table']) . ' as $index => $' . $data['var'] . '): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
' . $tdHtml . '
                    <td>
                        <span class="badge <?= $' . $data['var'] . '->status ? \'bg-success\' : \'bg-secondary\' ?>">
                            <?= $' . $data['var'] . '->status ? \'Hoạt động\' : \'Khóa\' ?>
                        </span>
                    </td>
                    <td>
                        <a href="detail.php?id=<?= $' . $data['var'] . '->id ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                        <a href="edit.php?id=<?= $' . $data['var'] . '->id ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" onsubmit="return confirm(\'Bạn có chắc muốn xóa?\');" class="d-inline">
                            <input type="hidden" name="id" value="<?= $' . $data['var'] . '->id ?>">
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
include \'../layouts/master.php\';
?>';
    file_put_contents($indexFile, $indexContent);

    // --- 3. CREATE.PHP ---
    $createFile = $baseDir . $data['folder'] . "/create.php";
    
    $initVars = "";
    $postVars = "";
    $validation = "";
    $formHtml = "";
    $constructorArgs = "0";
    
    foreach ($data['fields'] as $k => $f) {
        $initVars .= "$" . $k . " = \"\";\n";
        $postVars .= "    $" . $k . " = trim(\$_POST[\"" . $k . "\"] ?? \"\");\n";
        $validation .= '    if ($' . $k . ' === "") { $errors[] = "' . $f['label'] . ' không được để trống."; }' . "\n";
        $constructorArgs .= ", $" . $k;
        
        $formHtml .= '            <div class="mb-3">
                <label class="form-label fw-bold">' . $f['label'] . ' <span class="text-danger">*</span></label>
                <input type="' . $f['type'] . '" name="' . $k . '" class="form-control" value="<?= htmlspecialchars($' . $k . ') ?>">
            </div>
';
    }
    
    if ($className == 'User') {
        $constructorArgs .= ", \$status";
    } else {
        $constructorArgs .= ", \$status"; 
    }
    // Note: Brand(0, name, logo, status)
    // Customer(0, fullname, email, phone, address, status)
    // User(0, username, password, fullname, email, phone, role, status)

    $createContent = '<?php
$pageTitle = "Thêm ' . $data['title'] . '";
require_once __DIR__ . \'/../../../dao/' . $data['dao'] . '.php\';
$' . lcfirst($data['dao']) . ' = new ' . $data['dao'] . '();

$errors = [];
' . $initVars . '
$status = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
' . $postVars . '
    $status = $_POST["status"] ?? 1;

    // Validation
' . $validation . '

    if (empty($errors)) {
        $obj = new ' . $className . '(' . $constructorArgs . ');
        if ($' . lcfirst($data['dao']) . '->insert($obj)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Thêm thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Thêm mới ' . strtolower($data['title']) . '</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
' . $formHtml . '
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="1" <?= $status == 1 ? \'checked\' : \'\' ?>>
                    <label class="form-check-label">Hiển thị (Hoạt động)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="0" <?= $status == 0 ? \'checked\' : \'\' ?>>
                    <label class="form-check-label">Ẩn (Ngừng hoạt động)</label>
                </div>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            <button type="reset" class="btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include \'../layouts/master.php\';
?>';
    file_put_contents($createFile, $createContent);

    // --- 4. EDIT.PHP ---
    $editFile = $baseDir . $data['folder'] . "/edit.php";
    
    $fetchVars = "";
    $assignVars = "";
    foreach ($data['fields'] as $k => $f) {
        $fetchVars .= "$" . $k . " = \$obj->" . $k . ";\n";
        $assignVars .= "        \$obj->" . $k . " = $" . $k . ";\n";
    }
    
    $editContent = '<?php
$pageTitle = "Cập nhật ' . $data['title'] . '";
require_once __DIR__ . \'/../../../dao/' . $data['dao'] . '.php\';
$' . lcfirst($data['dao']) . ' = new ' . $data['dao'] . '();

if (!isset($_GET[\'id\'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET[\'id\'];
$obj = $' . lcfirst($data['dao']) . '->findById($id);

if (!$obj) {
    header("Location: index.php");
    exit;
}

$errors = [];
' . $fetchVars . '
$status = $obj->status;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
' . $postVars . '
    $status = $_POST["status"] ?? 1;

    // Validation
' . $validation . '

    if (empty($errors)) {
' . $assignVars . '
        $obj->status = $status;
        
        if ($' . lcfirst($data['dao']) . '->update($obj)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Cập nhật ' . strtolower($data['title']) . '</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $obj->id ?>">
' . $formHtml . '
            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="1" <?= $status == 1 ? "checked" : "" ?>>
                    <label class="form-check-label">Hiển thị (Hoạt động)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" value="0" <?= $status == 0 ? "checked" : "" ?>>
                    <label class="form-check-label">Ẩn (Ngừng hoạt động)</label>
                </div>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <button type="reset" class="btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i> Làm mới</button>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include \'../layouts/master.php\';
?>';
    file_put_contents($editFile, $editContent);
    
    // --- 5. DETAIL.PHP ---
    $detailFile = $baseDir . $data['folder'] . "/detail.php";
    
    $detailRows = "";
    foreach ($data['fields'] as $k => $f) {
        $detailRows .= '
                <tr>
                    <th class="table-light">' . $f['label'] . '</th>
                    <td class="fw-bold text-primary"><?= htmlspecialchars($obj->' . $k . ') ?></td>
                </tr>';
    }
    
    $detailContent = '<?php
$pageTitle = "Chi tiết ' . $data['title'] . '";
require_once __DIR__ . \'/../../../dao/' . $data['dao'] . '.php\';
$' . lcfirst($data['dao']) . ' = new ' . $data['dao'] . '();

if (!isset($_GET[\'id\'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET[\'id\'];
$obj = $' . lcfirst($data['dao']) . '->findById($id);

if (!$obj) {
    header("Location: index.php");
    exit;
}

ob_start();
?>
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Chi tiết ' . strtolower($data['title']) . '</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 200px;" class="table-light">ID</th>
                    <td><?= $obj->id ?></td>
                </tr>' . $detailRows . '
                <tr>
                    <th class="table-light">Trạng thái</th>
                    <td>
                        <span class="badge <?= $obj->status ? \'bg-success\' : \'bg-secondary\' ?>">
                            <?= $obj->status ? \'Hoạt động\' : \'Ngừng hoạt động\' ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th class="table-light">Ngày tạo</th>
                    <td><?= $obj->createdAt ?></td>
                </tr>
                <tr>
                    <th class="table-light">Cập nhật lần cuối</th>
                    <td><?= $obj->updatedAt ?></td>
                </tr>
            </tbody>
        </table>
        
        <div class="mt-3">
            <a href="edit.php?id=<?= $obj->id ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include \'../layouts/master.php\';
?>';
    file_put_contents($detailFile, $detailContent);
}
echo "CRUD generated successfully.\n";
