<?php
        require_once ("DBColumnMeta.class.php");
        /**
         * @author Yang Yang
         * @version 1.0
         * 11/20/2008
         */
        class DBTableMeta {
                protected $tableName;
                protected $columns;
                protected $pkColumnName;

                public function DBTableMeta($resultset){
                        $this->columns = array();
                        $columnNumber = mysql_num_fields ($resultset);
                        //print "columnNumber = ".$columnNumber."<br>";

                        for ($i=0; $i < $columnNumber; $i++) {
                                $meta = mysql_fetch_field ($resultset);
                                $this->tableName = $meta->table;

                                $columnMeta = new DBColumnMeta();
                                $columnMeta->setName($meta->name);
                                $columnMeta->setPrimaryKey($meta->primary_key);
                                $columnMeta->setNumeric($meta->numeric);
                                $columnMeta->setType($meta->type);
                                $columnMeta->setBlob($meta->blob);
                                $this->columns[$columnMeta->getName()] = $columnMeta;
                                //print "column meta = ".$columnMeta."<br>";

                                if($columnMeta->isPrimaryKey()){
                                        $this->pkColumnName = $columnMeta->getName();
                                }
                        }
                }

                /**
                 * get the table name
                 * @return <type>
                 */
                public function getTableName(){
                        return $this->tableName;
                }

                /**
                 * get the primary key's column name of the table
                 * if there is no primary key, then return null
                 * @return <string>
                 */
                public function getPKColumnName(){
                        return $this->pkColumnName;
                }

                /**
                 * if the $columnName is primary key column
                 * @param <type> $columnName
                 * @return <int> 0 - $columnName is primary key column
                 *                         1 - $columnName is not primary key column
                 */
                public function isPrimaryKey($columnName){
                        if($this->pkColumnName==null){
                                return 0;
                        } else {
                                if(strcasecmp ($this->pkColumnName, $columnName)==0){
                                        //$var1 is equal to $var2 in a case-insensitive string comparison
                                        return 1;
                                } else {
                                        return 0;
                                }
                        }
                }

                /**
                 * get the column names of a table
                 * @return an array of column names
                 */
                public function getColumnNames(){
                        return array_keys($this->columns);
                }

                /**
                 * get the meta data of a column
                 * @param string $columnName
                 * @return DBColumnMeta
                 */
                public function getColumnMeta($columnName){
                        return $this->columns[$columnName];
                }

        }

?>
