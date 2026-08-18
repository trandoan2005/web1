<?php
// Script to fix CRUD links in views
chdir(__DIR__);
$viewsDir = "views/admin";

function fixLinksInFile($filePath, $controller) {
    $content = file_get_contents($filePath);
    $original = $content;

    // Fix create link
    $content = preg_replace('/href="create\.php"/', 'href="index.php?area=admin&controller=' . $controller . '&action=create"', $content);
    
    // Fix edit link
    $content = preg_replace('/href="edit\.php\?id=([^"]+)"/', 'href="index.php?area=admin&controller=' . $controller . '&action=edit&id=$1"', $content);
    
    // Fix detail link
    $content = preg_replace('/href="detail\.php\?id=([^"]+)"/', 'href="index.php?area=admin&controller=' . $controller . '&action=detail&id=$1"', $content);
    
    // Fix back to index link (href="index.php")
    $content = preg_replace('/href="index\.php"/', 'href="index.php?area=admin&controller=' . $controller . '&action=index"', $content);
    
    // Fix pagination links
    // href="?keyword=...&sort=...&limit=...&page=..." => href="index.php?area=admin&controller=...&action=index&keyword=...
    $content = preg_replace('/href="\?keyword=/', 'href="index.php?area=admin&controller=' . $controller . '&action=index&keyword=', $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        echo "Fixed links in: $filePath\n";
    }
}

$dirs = ['categories' => 'category', 'brands' => 'brand', 'products' => 'product', 'customers' => 'customer', 'orders' => 'order', 'users' => 'user'];

foreach ($dirs as $folder => $controller) {
    $dirPath = $viewsDir . '/' . $folder;
    if (is_dir($dirPath)) {
        $files = glob($dirPath . '/*.php');
        foreach ($files as $file) {
            fixLinksInFile($file, $controller);
        }
    }
}

echo "Done fixing links!\n";
