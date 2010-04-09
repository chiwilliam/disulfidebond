<?php

        /**
         * Supper class for all manager class
         */
        class Manager {
                protected $host = "localhost";
                protected $user = "root";
                protected $password = "";
                protected $database = "group2";

                protected $isScrollPageEnabled = 1;

                public function getConnection(){
                        //open a database connection
                        $connection = mysql_connect($this->host, $this->user, $this->password) or die("Could not connect");
                        //select a database
                        mysql_select_db($this->database) or die("Could not select database");
                        return $connection;
                }

                public function closeConnection($connection){
                        //close database connection
                        mysql_close($connection);
                }

                public function enableScrollPage(){
                        $this->isScrollPageEnabled = 1;
                }
                public function disableScrollPage(){
                        $this->isScrollPageEnabled = 0;
                }
                public function isScrollPageEnabled(){
                        return $this->isScrollPageEnabled;
                }

        }

                /*
                protected $host = "hci.cs.sfsu.edu";
                protected $user = "group2";
                protected $password = "un848";
                protected $database = "group2";

                protected $host = "localhost:3306";
                protected $user = "root";
                protected $password = "admin";
                protected $database = "ppm";
                */
//		//hold a single instance of the manager class
//		protected static $manager;
//		/**
//		 * singleton pattern method
//		 * get the single instance of the manager class
//		 * @return <OrganizationManager>
//		 */
//		public static function getInstance(){
//			if (!isset(self::$manager)) {
//                                //print get_class($this);
//                                //$c = get_class($this);
//                                print __CLASS__;
//                                $c = __CLASS__;
//				self::$manager = new $c;
//			}
//			return self::$manager;
//		}
?>
