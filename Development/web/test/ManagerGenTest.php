<?php
        include "../lib/generator/ManagerGen.class.php";

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        //param1: path to save the php file
        //param2: database name
        $managerGen = new ManagerGen("D:\Temp2\PHP\ppm", "ppm");
        $managerGen->execute();

        mysql_close($connection);
?>