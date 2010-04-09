<?php
        include '../common/database/DBTableMeta.class.php';
        include '../common/database/DBColumnMeta.class.php';

        class ManagerGen {
                private $path;
                private $database;

                public function ManagerGen($path, $database){
                        $this->path = $path;
                        $this->database = $database;
                        $this->createFolder($path);
                        print ("<br>");
                }

                public function createFolder($path){
                        //print "createFolder() \$path=\"".$path."\"<br>";
                        if (!file_exists($path)){
                                $this->createFolder(dirname($path));
                                mkdir($path, 0777);
                        }
                }

                public function execute(){
                        $result = mysql_list_tables ($this->database);
                        for ($i = 0; $i < mysql_num_rows ($result); $i++) {
                                //get current database table name
                                $tableNames[$i] = mysql_tablename ($result, $i);

                                //step1 -  create forder
                                $this->createFolder($this->path."\\".strtolower($tableNames[$i]));

                                //step2 - create tableName.class.php
                                $fileName = $this->path."\\".strtolower($tableNames[$i])."\\".ucwords(strtolower($tableNames[$i]))."Manager.class.php";
                                print "fileName = $fileName<br>";

                                $file = fopen($fileName, 'w');
                                if (is_writable($fileName)) {
                                        //step3 - get columns information of the table and generate the content to write into the php class

                                        //get resultset of the metadata
                                        $resultset = mysql_query("select * from ".$tableNames[$i]." where 1=0") or die("Invalid query");
                                        $tableMeta = new DBTableMeta($resultset);
                                        $columnNames =  $tableMeta->getColumnNames();
                                        $columnNumber = count($columnNames);


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate class begin information
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        fwrite($file,"<?php\r"); //file begin
                                        fwrite($file,"\trequire_once (\"\\\../\\lib\\\\common\\\\dao\\\\DAO.class.php\");\r");
                                        fwrite($file,"\trequire_once (\"\\\../\\lib\\\\common\\\\Manager.class.php\");\r");
                                        fwrite($file,"\trequire_once (\"\\\\.\\\\".ucwords(strtolower($tableNames[$i])).".class.php\");\r\r");

                                        fwrite($file,"\t/*\r");
                                        fwrite($file,"\t * Manager class of ".strtoupper($tableNames[$i])." table\r");
                                        fwrite($file,"\t */\r");
                                        fwrite($file,"\tclass ".ucwords(strtolower($tableNames[$i]))."Manager extends Manager {\r\r"); //class begin


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate static functions
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        if(1){
                                                //private static $manager;
                                                fwrite($file,"\t\t//hold a single instance of the manager class\r");
                                                fwrite($file,"\t\tprotected static \$manager;\r\r");
                                                fwrite($file,"\t\t/**\r");

                                                //public static function getInstance()
                                                fwrite($file,"\t\t * singleton pattern method\r");
                                                fwrite($file,"\t\t * get the single instance of the manager class\r");
                                                fwrite($file,"\t\t * @return <OrganizationManager>\r");
                                                fwrite($file,"\t\t */\r");
                                                fwrite($file,"\t\tpublic static function getInstance(){\r"); //getInstance begin
                                                fwrite($file,"\t\t\tif (!isset(self::\$manager)) {\r"); //if begin
                                                fwrite($file,"\t\t\t\t\$c = __CLASS__;\r");
                                                fwrite($file,"\t\t\t\tself::\$manager = new \$c;\r");
                                                fwrite($file,"\t\t\t}\r");// if end
                                                fwrite($file,"\t\t\treturn self::\$manager;\r");
                                                fwrite($file,"\t\t}\r\r");// getInstance end
                                        }


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate query functions
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        $pkColumnName = $tableMeta->getPKColumnName();
                                        if($pkColumnName!=null){
                                                $pkColumnMeta = $tableMeta->getColumnMeta($pkColumnName);

                                                //public function getVOByID($vo)
                                                fwrite($file,"\t\t/**\r");
                                                fwrite($file,"\t\t * get a ".ucwords(strtolower($tableNames[$i]))." instance by primary key\r");
                                                fwrite($file,"\t\t * @param <".$pkColumnMeta->getType()."> \$".strtolower($pkColumnName)."\r");
                                                fwrite($file,"\t\t * @return <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                                fwrite($file,"\t\t */\r");
                                                fwrite($file, "\t\tpublic function get".ucwords(strtolower($tableNames[$i]))."ByID(\$".strtolower($pkColumnName)."){\r");
                                                fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                                fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                                fwrite($file, "\t\t\t\$vo = new ".ucwords(strtolower($tableNames[$i]))."();\r");
                                                fwrite($file, "\t\t\t\$vo->set".ucwords(strtolower($pkColumnName))."(\$".strtolower($pkColumnName).");\r");
                                                fwrite($file, "\t\t\t\$vo = \$dao->queryByPK(\$vo);\r");
                                                fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                                fwrite($file, "\t\t\treturn \$vo;\r");
                                                fwrite($file, "\t\t}\r\r");

                                                //public function getVO($vo)
                                                fwrite($file,"\t\t/**\r");
                                                fwrite($file,"\t\t * get a ".ucwords(strtolower($tableNames[$i]))." instance by primary key\r");
                                                fwrite($file,"\t\t * primary key value in \$vo (value object) must not be null\r");
                                                fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                                fwrite($file,"\t\t * @return <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                                fwrite($file,"\t\t */\r");
                                                fwrite($file, "\t\tpublic function get".ucwords(strtolower($tableNames[$i]))."(\$vo){\r");
                                                fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                                fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                                fwrite($file, "\t\t\t\$vo = \$dao->queryByPK(\$vo);\r");
                                                fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                                fwrite($file, "\t\t\treturn \$vo;\r");
                                                fwrite($file, "\t\t}\r\r");

                                                //public function getVOMap($vo)
                                                fwrite($file,"\t\t/**\r");
                                                fwrite($file,"\t\t * get an array of ".strtolower($pkColumnName)."=>".ucwords(strtolower($tableNames[$i]))." map\r");
                                                fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                                fwrite($file,"\t\t * @return Array<key<".$pkColumnMeta->getType().">=>value<".ucwords(strtolower($tableNames[$i])).">> \$voMap\r");
                                                fwrite($file,"\t\t */\r");
                                                fwrite($file, "\t\tpublic function get".ucwords(strtolower($tableNames[$i]))."Map(\$vo){\r");
                                                fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                                fwrite($file, "\t\t\t\$voMap = array();\r");
                                                fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                                fwrite($file, "\t\t\t\$vos = \$dao->query(\$vo);\r");
                                                fwrite($file, "\t\t\tfor(\$i=0; \$i<count(\$vos); \$i++){\r");
                                                fwrite($file, "\t\t\t\t\$curr_vo = \$vos[\$i];\r");
                                                fwrite($file, "\t\t\t\t\$voMap[\$curr_vo->get".ucwords(strtolower($pkColumnName))."()] = \$curr_vo;\r");
                                                fwrite($file, "\t\t\t}\r");
                                                fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                                fwrite($file, "\t\t\treturn \$voMap;\r");
                                                fwrite($file, "\t\t}\r\r");
                                        }

                                        //public function getVOs($vo, $orderby)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * get an array of ".ucwords(strtolower($tableNames[$i]))." instances\r");
                                        fwrite($file,"\t\t * query condition is stored in value object\r");
                                        fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                        fwrite($file,"\t\t * @param <string> \$orderby\r");
                                        fwrite($file,"\t\t * @return Array<".ucwords(strtolower($tableNames[$i])).">\r");
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function get".ucwords(strtolower($tableNames[$i]))."s(\$vo, \$orderby){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$vos = \$dao->query(\$vo, \$orderby);\r");
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$vos;\r");
                                        fwrite($file, "\t\t}\r\r");

                                        //public function getVOsByWhere($vo, $where, $orderby)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * get an array of ".ucwords(strtolower($tableNames[$i]))." instances by where clause\r");
                                        fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                        fwrite($file,"\t\t * @param <string> \$orderby\r");
                                        fwrite($file,"\t\t * @param <string> \$where\r");
                                        fwrite($file,"\t\t * @return Array<".ucwords(strtolower($tableNames[$i])).">\r");
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function get".ucwords(strtolower($tableNames[$i]))."sByWhere(\$vo, \$where, \$orderby){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$vos = \$dao->queryByWhere(\$vo, \$where, \$orderby);\r");
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$vos;\r");
                                        fwrite($file, "\t\t}\r\r");

                                        //public function getVOsBySQL($sql)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * get an array of ".ucwords(strtolower($tableNames[$i]))." instances by SQL\r");
                                        fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                        fwrite($file,"\t\t * @param <string> \$sql\r");
                                        fwrite($file,"\t\t * @return Array<".ucwords(strtolower($tableNames[$i])).">\r");
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function get".ucwords(strtolower($tableNames[$i]))."sBySQL(\$vo, \$sql){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$vos = \$dao->queryBySQL(\$vo, \$sql);\r");
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$vos;\r");
                                        fwrite($file, "\t\t}\r\r");


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate add functions
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        //public function addVO($vo)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * add a ".ucwords(strtolower($tableNames[$i]))." record to database\r");
                                        fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                        if($pkColumnName!=null){
                                                fwrite($file,"\t\t * @return <".ucwords(strtolower($tableNames[$i]))."> \$vo - a ".ucwords(strtolower($tableNames[$i]))." instance with primary key value\r");
                                        } else {
                                                fwrite($file,"\t\t * @return <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                        }
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function add".ucwords(strtolower($tableNames[$i]))."(\$vo){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$vo = \$dao->insert(\$vo);\r");                                        
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$vo;\r");
                                        fwrite($file, "\t\t}\r\r");


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate update functions
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        if($pkColumnName!=null){
                                                //public function updateVO($vo)
                                                fwrite($file,"\t\t/**\r");
                                                fwrite($file,"\t\t * update a ".ucwords(strtolower($tableNames[$i]))." record in database\r");
                                                fwrite($file,"\t\t * primary key value in \$vo (value object) must not be null\r");
                                                fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                                fwrite($file,"\t\t * @return <int> affected row number (0 or 1)\r");
                                                fwrite($file,"\t\t */\r");
                                                fwrite($file, "\t\tpublic function update".ucwords(strtolower($tableNames[$i]))."(\$vo){\r");
                                                fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                                fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                                fwrite($file, "\t\t\t\$num = \$dao->update(\$vo);\r");
                                                fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                                fwrite($file, "\t\t\treturn \$num;\r");
                                                fwrite($file, "\t\t}\r\r");
                                        }

                                        //public function updateVOBySQL($sql)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * update a batch of ".ucwords(strtolower($tableNames[$i]))." records in database\r");
                                        fwrite($file,"\t\t * @param <string> \$sql\r");
                                        fwrite($file,"\t\t * @return <int> affected row number\r");
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function update".ucwords(strtolower($tableNames[$i]))."BySQL(\$sql){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$num = \$dao->updateBySQL(\$sql);\r");
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$num;\r");
                                        fwrite($file, "\t\t}\r\r");


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate delete functions
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        if($pkColumnName!=null){
                                                //public function deleteVO($vo)
                                                fwrite($file,"\t\t/**\r");
                                                fwrite($file,"\t\t * delete a ".ucwords(strtolower($tableNames[$i]))." record in database\r");
                                                fwrite($file,"\t\t * primary key value in \$vo (value object) must not be null\r");
                                                fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                                fwrite($file,"\t\t * @return <int> affected row number (0 or 1)\r");
                                                fwrite($file,"\t\t */\r");
                                                fwrite($file, "\t\tpublic function delete".ucwords(strtolower($tableNames[$i]))."(\$vo){\r");
                                                fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                                fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                                fwrite($file, "\t\t\t\$num = \$dao->delete(\$vo);\r");
                                                fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                                fwrite($file, "\t\t\treturn \$num;\r");
                                                fwrite($file, "\t\t}\r\r");
                                        }

                                        //public function deleteVOs($vo)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * delete a batch of ".ucwords(strtolower($tableNames[$i]))." records in database\r");
                                        fwrite($file,"\t\t * @param <".ucwords(strtolower($tableNames[$i]))."> \$vo\r");
                                        fwrite($file,"\t\t * @return <int> affected row number\r");
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function delete".ucwords(strtolower($tableNames[$i]))."s(\$vo){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$num = \$dao->batchDelete(\$vo);\r");
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$num;\r");
                                        fwrite($file, "\t\t}\r\r");

                                        //public function deleteVOsBySQL($vo)
                                        fwrite($file,"\t\t/**\r");
                                        fwrite($file,"\t\t * delete a batch of ".ucwords(strtolower($tableNames[$i]))." records in database\r");
                                        fwrite($file,"\t\t * @param <string> \$sql\r");
                                        fwrite($file,"\t\t * @return <int> affected row number\r");
                                        fwrite($file,"\t\t */\r");
                                        fwrite($file, "\t\tpublic function delete".ucwords(strtolower($tableNames[$i]))."sBySQL(\$sql){\r");
                                        fwrite($file, "\t\t\t\$conn = \$this->getConnection();\r");
                                        fwrite($file, "\t\t\t\$dao = new DAO();\r");
                                        fwrite($file, "\t\t\t\$num = \$dao->deleteBySQL(\$sql);\r");
                                        fwrite($file, "\t\t\t\$this->closeConnection(\$conn);\r");
                                        fwrite($file, "\t\t\treturn \$num;\r");
                                        fwrite($file, "\t\t}\r\r");


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate class end information
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        fwrite ($file,"\t}\r"); //class end
                                        fwrite ($file,"?>\r"); //file end

                                } //end if
                                fclose($file);
                                print $fileName." created.<br>";

                        } //end for
                        mysql_free_result ($result);
                }

        }
?>
