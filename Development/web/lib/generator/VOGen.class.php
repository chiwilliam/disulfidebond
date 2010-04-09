<?php
        include '../common/database/DBTableMeta.class.php';
        include '../common/database/DBColumnMeta.class.php';

        /**
         * value object generator
         */
        class VOGen {

                private $path;
                private $database;

                public function VOGen($path, $database){
                        $this->path = $path;
                        $this->database = $database;
                        $this->createFolder($path);
                }

                public function createFolder($path){
                        //print "createFolder() \$path=\"".$path."\"<br>";
                        if (!file_exists($path)){
                                $this->createFolder(dirname($path));
                                mkdir($path, 0777);
                        }
                }

                public function execute(){
                        //get all table names of the database
                        $result = mysql_list_tables ($this->database);
                        $rowNumber = mysql_num_rows ($result);

                        //primary key names
                        $pkColumnNames = array();
                        //primary key => table name map
                        $pkColumnTableNameMap = array();

                        $tableNames = array();
                        for ($i = 0; $i < $rowNumber; $i++) {
                                //get current database table name
                                $tableName = mysql_tablename ($result, $i);
                                $tableNames[] = $tableName;
                                $resultset = mysql_query("select * from ".$tableName." where 1=0") or die("Invalid query");
                                $tableMeta = new DBTableMeta($resultset);
                                $pkColumnName = $tableMeta->getPKColumnName();
                                if($pkColumnName!=null){
                                        //$pkColumnMeta = $tableMeta->getColumnMeta($pkColumnName);
                                        //print $pkColumnMeta."<br>";
                                        $pkColumnNames[] = $pkColumnName;
                                        $pkColumnTableNameMap[$pkColumnName] = $tableName;
                                }
                                //close resultset
                                mysql_free_result ($resultset);
                        }

                        /*
                        for ($m = 0; $m < count($pkColumnNames); $m++) {
                                print $pkColumnNames[$m]."<br>";
                        }
                        */
                        /*
                        while(list($key , $val) = each($pkColumnTableNameMap)) {
                                echo "$key => $val<br>";
                        }
                        */

                        for ($i = 0; $i < $rowNumber; $i++) {
                                //get current database table name
                                //$tableNames[$i] = mysql_tablename ($result, $i);
                                print  "\$tableNames[$i] = ".$tableNames[$i]."<br>";
                                //step1 -  create forder
                                $this->createFolder($this->path."\\".strtolower($tableNames[$i]));

                                //step2 - create tableName.class.php
                                $fileName = $this->path."\\".$tableNames[$i]."\\".ucwords(strtolower($tableNames[$i])).".class.php";
                                //print "fileName = $fileName<br>";

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
                                        fwrite ($file,"<?php\r");
                                        fwrite($file,"\trequire_once (\"\\\../\\lib\\\\common\\\\dao\\\\VO.class.php\");\r\r");
                                        fwrite ($file,"\tclass ".ucwords(strtolower($tableNames[$i]))." extends VO {\r\r");


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate foreign key value object reference
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        $hasFK = 0;
                                        for ($j = 0; $j < $columnNumber; $j++) {
                                                //get column name
                                                $columnName = $columnNames[$j];
                                               
                                                if(!($tableMeta->isPrimaryKey($columnName))){
                                                        //current column is not the primary key of current table
                                                        if (in_array($columnName, $pkColumnNames)) {
                                                                //print $columnName." is foreign key<br>";
                                                                $fkTableName = $pkColumnTableNameMap[$columnName];
                                                                //print "\$fkTableName = $fkTableName<br>";
                                                                fwrite ($file,"\t\tprivate $".strtolower($fkTableName)."VO;\r");
                                                                $hasFK = 1;
                                                        }
                                                }
                                        }
                                        if($hasFK){
                                                 fwrite ($file, "\r");
                                        }

                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate properties
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        for ($j = 0; $j < $columnNumber; $j++) {
                                                //get column name
                                                $columnName = $columnNames[$j];
                                                //generate attribute of the value object
                                                fwrite ($file,"\t\tprivate $".strtolower($columnName).";\r");
                                        }



                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate set & get functions(or methods) for foreign key value object
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        fwrite ($file,"\r");
                                        for ($j = 0; $j < $columnNumber; $j++) {
                                                //get column name
                                                $columnName = $columnNames[$j];

                                                if(!($tableMeta->isPrimaryKey($columnName))){
                                                        //current column is not the primary key of current table
                                                        if (in_array($columnName, $pkColumnNames)) {
                                                                //print $columnName." is foreign key<br>";
                                                                $fkTableName = $pkColumnTableNameMap[$columnName];
                                                                //print "\$fkTableName = $fkTableName<br>";

                                                                //generate set function of the value object
                                                                fwrite ($file,"\t\tpublic function set".ucwords(strtolower($fkTableName))."($".strtolower($fkTableName)."VO){\r");
                                                                fwrite ($file,"\t\t\t\$this->".strtolower($fkTableName)."VO=$".strtolower($fkTableName)."VO;\r");
                                                                fwrite ($file,"\t\t}\r");

                                                                //generate get function of the attribute
                                                                fwrite ($file,"\t\tpublic function get".ucwords(strtolower($fkTableName))."(){\r");
                                                                fwrite ($file,"\t\t\treturn \$this->".strtolower($fkTableName)."VO;\r");
                                                                fwrite ($file,"\t\t}\r");

                                                                fwrite ($file,"\r");
                                                        }
                                                }
                                        } //end for

                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate set & get functions(or methods) for all properties
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        //fwrite ($file,"\r");
                                        for ($j = 0; $j < $columnNumber; $j++) {
                                                //get column name
                                                $columnName = $columnNames[$j];

                                                //generate set function of the attribute
                                                fwrite ($file,"\t\tpublic function set".ucwords(strtolower($columnName))."($".strtolower($columnName)."){\r");
                                                fwrite ($file,"\t\t\t\$this->".strtolower($columnName)."=$".strtolower($columnName).";\r");
                                                fwrite ($file,"\t\t}\r");

                                                //generate get function of the attribute
                                                fwrite ($file,"\t\tpublic function get".ucwords(strtolower($columnName))."(){\r");
                                                fwrite ($file,"\t\t\treturn \$this->".strtolower($columnName).";\r");
                                                fwrite ($file,"\t\t}\r");

                                                fwrite ($file,"\r");
                                        } //end for




                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate the __toString() function
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        fwrite ($file,"\t\tpublic function __toString(){\r");
                                        $toStringStr = "";
                                        for ($j = 0; $j < $columnNumber; $j++) {
                                                //get column name
                                                $columnName = $columnNames[$j];
                                                $toStringStr = $toStringStr.".\", ".strtolower($columnName)."=\".\$this->".strtolower($columnName);

                                                //generate _toString() for foreign key value object reference
                                                if(!($tableMeta->isPrimaryKey($columnName))){
                                                        if (in_array($columnName, $pkColumnNames)) {
                                                                $fkTableName = $pkColumnTableNameMap[$columnName];
                                                                $toStringStr = $toStringStr.".\"(\".\$this->".strtolower($fkTableName)."VO.\")\"";
                                                        }
                                                }

                                        } //end for

                                        $toStringStr = substr($toStringStr, 4);
                                        fwrite ($file,"\t\t\treturn \"".$toStringStr.";\r");
                                        fwrite ($file,"\t\t}\r");


                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        // generate class end information
                                        //--------------------------------------------------------------------------------------------------------------------------------
                                        fwrite ($file,"\t}\r");
                                        fwrite ($file,"?>\r");

                                        //close resultset
                                        mysql_free_result ($resultset);

                                } // end if
                                fclose($file);
                                print $fileName." created.<br>";

                        } // end for
                        mysql_free_result ($result);
                }



        }

?>
