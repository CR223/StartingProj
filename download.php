<?php
$file_path = 'backup/backup.txt';
 
if (file_exists($file_path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
} else {
    echo "File not found.";
}
?>