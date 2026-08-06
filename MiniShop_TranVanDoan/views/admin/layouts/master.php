<?php
// Master layout: nhận $pageTitle và $content từ các trang con
include 'header.php';
?>
<div class="d-flex">
    <?php include 'sidebar.php'; ?>
    <div class="flex-grow-1">
        <div class="p-4">
            <h2 class="mb-4"><?= $pageTitle ?></h2>
            <?= $content ?>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</div>
