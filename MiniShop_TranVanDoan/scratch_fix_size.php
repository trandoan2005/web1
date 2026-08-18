<?php
chdir(__DIR__);
$dir = "controllers/Admin";
$files = glob($dir . '/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    $original = $content;
    
    $content = str_replace('200 * 1024', '5 * 1024 * 1024', $content);
    $content = str_replace('200 KB', '5 MB', $content);
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        echo "Fixed size limit in $file\n";
    }
}
echo "Done!\n";
