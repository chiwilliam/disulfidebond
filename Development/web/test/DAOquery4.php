<?php
/**
 * TEST
 * public function query($vo, $orderby) return array
 */
        include '../lib/common/dao/DAO.class.php';
        include '../organization/Organization.class.php';

        print "\$vos = \$dao->queryBySQL(\$vo, \"select * from organization where parentid=10 and (serialindex=1 or serialindex=2 or serialindex=3) and description like '%org%' order by serialindex desc\")<br>";

        $connection = mysql_connect("hci.cs.sfsu.edu","group2", "un848") or die("Could not connect");
        mysql_select_db("group2") or die("Could not select database");

        $dao = new DAO();
        $vo = new Organization();

        $vos = $dao->queryBySQL($vo, "select * from organization where parentid=10 order by serialindex asc");
        //$vos = $dao->queryBySQL($vo, "select * from organization where parentid=10 and description like '%org%' order by serialindex asc");
        //$vos = $dao->queryBySQL($vo, "select * from organization where parentid=10 and (serialindex=1 or serialindex=2 or serialindex=3) and description like '%org%' order by serialindex desc");

        print ("count(\$vos) = ".count($vos)."<br>");
        for($i=0; $i<count($vos); $i++){
                print $vos[$i]."<br>";
        }

        mysql_close($connection);
?>
