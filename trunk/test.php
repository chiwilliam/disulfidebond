<?php
    $file = $_FILES["zipFile"];
    echo $file['tmp_name'].'<br />';
    echo $file['name'].'<br />';
    echo 'Working folder: '.getcwd().'<br />';
    $zip = zip_open($file["tmp_name"]);
    echo $zip.'<br />';
    
?>


