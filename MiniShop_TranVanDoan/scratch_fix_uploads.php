<?php
chdir(__DIR__);
$dir = "controllers/Admin";
$files = glob($dir . '/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, '/../../../uploads/') !== false) {
        $newContent = str_replace('/../../../uploads/', '/../../uploads/', $content);
        file_put_contents($file, $newContent);
        echo "Fixed paths in $file\n";
    }
}
echo "Done!\n";
