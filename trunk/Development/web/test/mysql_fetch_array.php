<?php
    /* connect to database connection */
    $link = mysql_connect("localhost", "root", "admin")
    or die("Could not connect");

    print "Connected successfully";
    mysql_select_db("ppm") or die("Could not select database");

    /* execute SQL query */
    $query = "SELECT * FROM user";
    $result = mysql_query($query) or die("Query failed");

	
	print_r($result);

    /* display query result in HTML */
    print "<table>\n";
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {

		echo "<BR>************************************************************************************";
		print_r($line);
		echo "<BR>************************************************************************************";
        
		print "\t<tr>\n";
        foreach ($line as $col_value) {
            print "\t\t<td>$col_value</td>\n";
        }
        print "\t</tr>\n";
    }
    print "</table>\n";

    /* release resources */
    mysql_free_result($result);

    /* disconnect database connection */
    mysql_close($link);
?>
