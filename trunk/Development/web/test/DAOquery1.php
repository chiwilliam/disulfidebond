<?php
/**
 * TEST
 * public function queryByPK($vo) return VO
 */
        include '../lib/common/dao/DAO.class.php';
        include '../lib/common/database/DBTableMeta.class.php';
        include '../lib/common/database/DBColumnMeta.class.php';
        include '../category/Category.class.php';

        print "\$vo =  \$dao->queryByPK(\$vo)<br>";

        $connection = mysql_connect("localhost:3306","root", "admin") or die("Could not connect");
        mysql_select_db("ppm") or die("Could not select database");

        $dao = new DAO();
        $vo = new Category();
        $vo->setCategoryid(1);
        $vo =  $dao->queryByPK($vo);

        if($vo==null){
                print "\$vo is null<br>";
        } else {
                print "vo is not null<br>".$vo."<br>";
        }

        mysql_close($connection);
?>
