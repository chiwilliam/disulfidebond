<?php
    $file = $_FILES["zipFile"];
    echo $file['tmp_name'].'<br />';
    echo $file['name'].'<br />';
    echo 'Working folder: '.getcwd().'<br />';
    $zipDir = getcwd().DIRECTORY_SEPARATOR;
    $zip = zip_open($zipDir.$file["tmp_name"]);
    echo $zip.'<br />';
    
?>


