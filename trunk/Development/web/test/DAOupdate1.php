<?php
/**
 * TEST
 * public function update($vo) return int
 */
        include '../lib/common/dao/DAO.class.php';
        include '../lib/common/database/DBTableMeta.class.php';
        include '../lib/common/database/DBColumnMeta.class.php';
        include '../Org/Organization.class.php';

        print "\$num = \$dao->update(\$vo)<br>";

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        $dao = new DAO();
        $vo = new Organization();

        $vo->setOrganizationid(3);
        $vo->setParentid(1);
        $vo->setDescription("my new description aaa bbb ccc");
        $num = $dao->update($vo);
        print "\$num = ".$num."<br>";

        $vo = new Organization();
        $vo->setParentid(1);
        $vos = $dao->query($vo);
        print ("count(\$vos) = ".count($vos)."<br>");
        for($i=0; $i<count($vos); $i++){
                print $vos[$i]."<br>";
        }

        mysql_close($connection);
?>
