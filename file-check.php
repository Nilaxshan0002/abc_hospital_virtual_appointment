<?php
echo "<h2>File Check</h2>";
echo "<h3>Current Directory: " . __DIR__ . "</h3>";

$files = scandir(__DIR__);
echo "<h3>Files in root:</h3>";
echo "<ul>";
foreach($files as $file) {
    if($file != "." && $file != "..") {
        echo "<li>" . $file . "</li>";
    }
}
echo "</ul>";

if(is_dir('pages')) {
    echo "<h3>Files in pages folder:</h3>";
    $pages_files = scandir(__DIR__ . '/pages');
    echo "<ul>";
    foreach($pages_files as $file) {
        if($file != "." && $file != "..") {
            echo "<li>" . $file . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>pages folder not found!</p>";
}
?>