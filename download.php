<?php

$file = $_GET['file'];

if (file_exists("image/" . $file)) {
    $file = "image/" . $file;

    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));


    readfile($file);
    exit;
} else {
    echo "File not found.";
}
?>
