<?php
    $file = $_FILES["zipFile"];
    echo $file['tmp_name'].'<br />';
    echo $file['name'].'<br />';
    $zip = zip_open($file["tmp_name"]);
    echo $zip.'<br />';
    echo 'Working folder: '.getcwd();
?>


