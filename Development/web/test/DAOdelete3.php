<?php
/**
 * TEST
 * public function deleteBySQL($queryStr) return int
 */
        include '../lib/common/dao/DAO.class.php';
        include '../lib/common/database/DBTableMeta.class.php';
        include '../lib/common/database/DBColumnMeta.class.php';
        include '../Org/Organization.class.php';

        print "\$num =  \$dao->deleteBySQL(\$queryStr)<br>";

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        $dao = new DAO();

        $num = $dao->deleteBySQL("delete from ORGANIZATION where parentid=-1 and serialindex=100");
        print "\$num = ".$num."<br>";

        $vo = new Organization();
        $vo->setParentid(-1);
        $vos = $dao->query($vo, "order by serialindex asc");
        print ("count(\$vos) = ".count($vos)."<br>");
        for($i=0; $i<count($vos); $i++){
                print $vos[$i]."<br>";
        }

        mysql_close($connection);
?>
