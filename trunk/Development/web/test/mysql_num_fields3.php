<?php
	$host = "hci.cs.sfsu.edu";
	$user = "group2";
	$password = "un848";

	mysql_connect ($host, $user, $password) or die ("Could not connect");
	
	$tabls_result = mysql_list_tables ("group2");
    $m = 0;
    while ($m < mysql_num_rows ($tabls_result)) { 
		$tb_names[$m] = mysql_tablename ($tabls_result, $m);

		$result = mysql_db_query ("group2", "select * from $tb_names[$m]") or die ("Query failed");

		echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" style='font-size:12px;font-family:Arial, Helvetica, sans-serif;' bgcolor=\"#333333\">\r";

		echo "\t<tr style='font-weight:bold; text-transform:uppercase;' bgcolor=\"#FFFFFF\" height=\"22\" align=\"center\" >\r";
		echo "\t\t<td colspan=\"13\" >$tb_names[$m]</td>\r";
		echo "\t</tr>\r";

		echo "\t<tr style='font-weight:bold; text-transform:uppercase;' bgcolor=\"#FFFFFF\" height=\"22\" align=\"center\" >\r";
		echo "\t\t<td width=\"8%\" >column</td>\r";
		echo "\t\t<td width=\"8%\" >blob</td>\r";
		echo "\t\t<td width=\"8%\" >max_length</td>\r";
		echo "\t\t<td width=\"8%\" >multiple_key</td>\r";
		echo "\t\t<td width=\"8%\" >name</td>\r";
		echo "\t\t<td width=\"8%\" >not_null</td>\r";
		echo "\t\t<td width=\"8%\" >numeric</td>\r";
		echo "\t\t<td width=\"8%\" >primary_key</td>\r";
		echo "\t\t<td width=\"15%\" >table</td>\r";
		echo "\t\t<td width=\"8%\" >type</td>\r";
		echo "\t\t<td width=\"8%\" >unique_key</td>\r";
		echo "\t\t<td width=\"8%\" >unsigned</td>\r";
		echo "\t\t<td width=\"8%\" >zerofill</td>\r";
		echo "\t</tr>\r";

		$i = 0;
		while ($i < mysql_num_fields ($result)) { 		
			$meta = mysql_fetch_field ($result); 
			echo "\t<tr bgcolor=\"#FFFFFF\" height=\"22\" align=\"center\" >\r";
			echo "\t\t<td width=\"8%\" >column $i</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->blob</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->max_length</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->multiple_key</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->name</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->not_null</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->numeric</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->primary_key</td>\r";
			echo "\t\t<td width=\"15%\" >$meta->table</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->type</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->unique_key</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->unsigned</td>\r";
			echo "\t\t<td width=\"8%\" >$meta->zerofill</td>\r";
			echo "\t</tr>\r";
			$i++;
		}
		echo "</table><br>";

		$m++;
   }

	mysql_free_result ($result);
?>
