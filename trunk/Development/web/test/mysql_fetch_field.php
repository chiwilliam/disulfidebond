<?php
	$host="localhost:3306";
	$user="root";
	$password="admin";
	mysql_connect ($host, $user, $password) or die ("Could not connect");
	$result = mysql_db_query ("ppm", "select * from user") or die ("Query failed"); 
	# get column metadata 
	$i = 0;
	while ($i < mysql_num_fields ($result)) {
		echo "Information for column $i:<BR>\n"; 
		$meta = mysql_fetch_field ($result); 
		if (!$meta) {
			echo "No information available<BR>\n"; 
		}
		echo "<PRE> 
		blob:                  $meta->blob 
		max_length:      $meta->max_length 
		multiple_key:    $meta->multiple_key 
		name:                $meta->name 
		not_null:           $meta->not_null 
		numeric:           $meta->numeric 
		primary_key:    $meta->primary_key 
		table:                $meta->table 
		type:                 $meta->type 
		unique_key:     $meta->unique_key 
		unsigned:         $meta->unsigned 
		zerofill:            $meta->zerofill 
		</PRE>"; 
		$i++; 
	} 
	mysql_free_result ($result);
?>

