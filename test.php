<?php
    echo $_FILES["zipFile"];
    $file = $_FILES["zipFile"];
    echo $file['tmp_name'];
    $zip = zip_open($file["tmp_name"]);
    //echo 'test...';
?>


