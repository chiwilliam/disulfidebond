<?php
        include "../lib/generator/VOGen.class.php";

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        //param1: path to save the php file
        //param2: database name
        $voGen = new VOGen("D:\Temp2\PHP\ppm", "ppm");
        $voGen->execute();

        mysql_close($connection);
?>