<?php
	$host = "hci.cs.sfsu.edu";
	$user = "group2";
	$password = "un848";

	mysql_connect ($host, $user, $password) or die ("Could not connect");

    $result = mysql_db_query ("ppm", "select * from ORGANIZATION") or die ("Query failed"); 

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" style='font-size:14px;' bgcolor=\"#333333\">\r";
	echo "\t<tr style='font-weight:bold; text-transform:uppercase;' bgcolor=\"#FFFFFF\" height=\"22\" align=\"center\" >\r";
	echo "\t\t<td>column</td>\r";
	echo "\t\t<td>blob</td>\r";
	echo "\t\t<td>max_length</td>\r";
	echo "\t\t<td>multiple_key</td>\r";
	echo "\t\t<td>name</td>\r";
	echo "\t\t<td>not_null</td>\r";
	echo "\t\t<td>numeric</td>\r";
	echo "\t\t<td>primary_key</td>\r";
	echo "\t\t<td>table</td>\r";
	echo "\t\t<td>type</td>\r";
	echo "\t\t<td>unique_key</td>\r";
	echo "\t\t<td>unsigned</td>\r";
	echo "\t\t<td>zerofill</td>\r";
	echo "\t</tr>\r";

	$i = 0;
	while ($i < mysql_num_fields ($result)) { 		
        $meta = mysql_fetch_field ($result); 
		echo "\t<tr bgcolor=\"#FFFFFF\" height=\"22\" align=\"center\" >\r";
		echo "\t\t<td>column $i</td>\r";
		echo "\t\t<td>$meta->blob</td>\r";
		echo "\t\t<td>$meta->max_length</td>\r";
		echo "\t\t<td>$meta->multiple_key</td>\r";
		echo "\t\t<td>$meta->name</td>\r";
		echo "\t\t<td>$meta->not_null</td>\r";
		echo "\t\t<td>$meta->numeric</td>\r";
		echo "\t\t<td>$meta->primary_key</td>\r";
		echo "\t\t<td>$meta->table</td>\r";
		echo "\t\t<td>$meta->type</td>\r";
		echo "\t\t<td>$meta->unique_key</td>\r";
		echo "\t\t<td>$meta->unsigned</td>\r";
		echo "\t\t<td>$meta->zerofill</td>\r";
		echo "\t</tr>\r";
		$i++;
	}
	echo "</table>";

	mysql_free_result ($result);
?>
