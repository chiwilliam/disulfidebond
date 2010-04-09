<?php
/**
 * TEST
 * public function query($vo, $orderby) return array
 */
        include '../lib/common/dao/DAO.class.php';
        include '../organization/Organization.class.php';

        $connection = mysql_connect("hci.cs.sfsu.edu","group2", "un848") or die("Could not connect");
        mysql_select_db("group2") or die("Could not select database");

        //print "\$vos = \$dao->query(\$vo, \"order by serialindex asc\")<br>";


        $dao = new DAO();
        $vo = new Organization();
        $vo->setParentid(10);
        $vo->setDescription("org description");
        //$vo->setOrgname("Group2");
        //$vo->setSerialindex(10);
        //$vo->setOrgname("Group8");

        $vos = $dao->query($vo);
        //$vos = $dao->query($vo, "order by serialindex asc");

        print ("count(\$vos) = ".count($vos)."<br>");
        for($i=0; $i<count($vos); $i++){
                print $vos[$i]."<br>";
        }

        mysql_close($connection);
?>
