<?php
    $connection = mysql_connect ("localhost:3306", "root", "admin"); 
    $result = mysql_list_tables ("ppm"); 
    $i = 0;
    while ($i < mysql_num_rows ($result)) { 
		$tb_names[$i] = mysql_tablename ($result, $i); 
		echo $tb_names[$i] . "<BR>"; 
		
		$col_result = mysql_list_fields ("ppm", $tb_names[$i]);		
		
		$num = mysql_num_rows($col_result);	
		echo "num = ".$num."<br>";

		//for($j=1; $j<=$num; $j++){
		//	$col_names[$j] = mysql_field_name($col_result, $j);
		//	echo "\t".$col_name[$j]."<br>";
		//}

		$i++;
   }
   mysql_close($connection);
?>

