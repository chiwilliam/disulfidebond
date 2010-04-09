<?php
    mysql_connect ("localhost:3306", "root", "admin");
    mysql_select_db ("ppm"); 
    $result = mysql_query ("SELECT * FROM domain"); 
    $fields = mysql_num_fields ($result); 
    $rows = mysql_num_rows ($result); 
    $i = 0;
    $table = mysql_field_table ($result, $i); 
    echo "Your '".$table."' table has ".$fields." fields and ".$rows." records <BR>"; 
    echo "The table has the following fields <BR>"; 
    while ($i < $fields) { 
		$type = mysql_field_type ($result, $i); 
		$name = mysql_field_name ($result, $i); 
		$len = mysql_field_len ($result, $i); 
		$flags = mysql_field_flags ($result, $i); 
		echo $type." ".$name." ".$len." ".$flags."<BR>"; 
		$i++; 
    }
    mysql_close();
?>