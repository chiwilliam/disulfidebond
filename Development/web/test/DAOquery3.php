<?php
/**
 * TEST
 * public function queryByWhereClause($vo, $whereClause, $orderby) return array
 */
        include '../lib/common/dao/DAO.class.php';
        include '../lib/common/database/DBTableMeta.class.php';
        include '../lib/common/database/DBColumnMeta.class.php';
        include '../Org/Organization.class.php';

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        print "\$vos = \$dao->queryByWhereClause(\$vo, \"where parentid=10 and description like '%org%'\", \"order by serialindex asc\")<br>";

        $dao = new DAO();
        $vo = new Organization();

        //$vos = $dao->queryByWhere($vo, "parentid=10 and description like '%org%'");
        //$vos = $dao->queryByWhere($vo, "parentid=10 and (orgname='Group2' or orgname='Group3') and description like '%org%'");
        //$vos = $dao->queryByWhere($vo, "where parentid=10", "order by serialindex asc");
        $vos = $dao->queryByWhere($vo, "where parentid=10 and description like '%org%'", "order by serialindex asc");

        print ("count(\$vos) = ".count($vos)."<br>");
        for($i=0; $i<count($vos); $i++){
                print $vos[$i]."<br>";
        }

        mysql_close($connection);
?>
