<?php
    
    function select($query){
        include "openDB.php";
        $list = array();
        $i = 0;
        $result = mysql_query($query) or die("Error while selecting data from DB.");
        while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
            $list[$i] = $row;
            $i += 1;
        }
        include "closeDB.php";
        return $list;
    }

    function insert($query){
        include "openDB.php";
        $result = mysql_query($query) or die("Error while inserting data into DB.");
        include "closeDB.php";
    }

    function update($query){
        include "openDB.php";
        $result = mysql_query($query) or die("Error while trying to update data on DB.");
        include "closeDB.php";
    }

    function delete($query){
        include "openDB.php";
        $result = mysql_query($query) or die("Error while trying to delete data from DB.");
        include "closeDB.php";
    }

?>
