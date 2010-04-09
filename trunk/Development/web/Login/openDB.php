<?php

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';

    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');

    $dbname = 'group2';
    mysql_select_db($dbname) or die('Error selecting DB');

?>
