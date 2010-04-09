<?php
    include '../lib/common/Manager.class.php';
    include './Organization.class.php';

/**
 * PHP Template.
 */
    class OrgManager extends Manager{
        // Hold an instance of the class
        private static $manager;

        // A private constructor; prevents direct creation of object
        private function __construct(){
            //echo 'I am constructed<br>';
        }

        // The singleton method
        public static function getInstance(){
            if (!isset(self::$manager)) {
                $c = __CLASS__;
                self::$manager = new $c;
            }
            return self::$manager;
        }
        // Prevent users to clone the instance
        public function __clone(){
            trigger_error('Clone is not allowed.', E_USER_ERROR);
        }

        // Example method
        public function bark(){
            parent::openDB();
            echo 'Woof!';
            parent::closeDB();
        }

        /**
         * get the root groups
         * @return <type>
         */
        public function getRootOrgs(){
            parent::getConnection();

            $query = "select * from ORGANIZATION where parentid=-1";
            $resultset = mysql_query($query) or die("Query failed");

            $orgs = array();
            while ($row = mysql_fetch_array($resultset, MYSQL_ASSOC)) {
                //create a new ogject
                $org = new Organization();
                //get the column value and set the value into attribute of the object using set() method.
                $org->setOrganizationid($row["ORGANIZATIONID"]);
                $org->setParentid($row["PARENTID"]);
                $org->setSerialindex($row["SERIALINDEX"]);
                $org->setOrgname($row["ORGNAME"]);
                $org->setOrgtext($row["ORGTEXT"]);
                $org->setDescription($row["DESCRIPTION"]);
                //add the object into a list
                $orgs[] = $org;
            }
            mysql_free_result ($resultset);
            parent::closeConnection();
            return $orgs;
        }

        /**
         * get the children groups of a parent group
         * @param <type> $parentid primary key of the parent group
         * @return <type>
         */
        public function getOrgs($parentid){
            parent::getConnection();

            $query = "select * from ORGANIZATION where parentid=".$parentid;
            $resultset = mysql_query($query) or die("Query failed");

            $orgs = array();
            while ($row = mysql_fetch_array($resultset, MYSQL_ASSOC)) {
                //create a new ogject
                $org = new Organization();
                //get the column value and set the value into attribute of the object using set() method.
                $org->setOrganizationid($row["ORGANIZATIONID"]);
                $org->setParentid($row["PARENTID"]);
                $org->setSerialindex($row["SERIALINDEX"]);
                $org->setOrgname($row["ORGNAME"]);
                $org->setOrgtext($row["ORGTEXT"]);
                $org->setDescription($row["DESCRIPTION"]);
                //add the object into a list
                $orgs[] = $org;
            }
            mysql_free_result ($resultset);
            parent::closeConnection();
            return $orgs;
        }

    }
?>
