<?php
/**
 * public function insert($vo) return VO
 */
        include '../lib/common/dao/DAO.class.php';
        include '../lib/common/database/DBTableMeta.class.php';
        include '../lib/common/database/DBColumnMeta.class.php';
        include '../Org/Organization.class.php';

        print "\$vo =  \$dao->insert(\$vo)<br>";

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        $dao = new DAO();
        $vo = new Organization();
        $vo->setParentid(-1);
        $vo->setSerialindex(78);
        $vo->setOrgname("YangYang Name");
        $vo->setOrgtext("YangYang Text");
        $vo->setDescription("yangyang description");

        $vo = $dao->insert($vo);
        print "vo = ".$vo."<br>";

        $vo = new Organization();
        $vo->setParentid(-1);
        $vos = $dao->query($vo, "order by serialindex asc");
        print ("count(\$vos) = ".count($vos)."<br>");
        for($i=0; $i<count($vos); $i++){
                print $vos[$i]."<br>";
        }

        mysql_close($connection);
?>
