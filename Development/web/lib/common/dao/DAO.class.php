<?php
       require_once (dirname(__FILE__)."/../database/DBTableMeta.class.php");
       require_once (dirname(__FILE__)."/../database/DBColumnMeta.class.php");
       require_once (dirname(__FILE__)."/../log/Log.class.php");

       /**
        * query functions:
        * public function queryByPK($vo) return VO
        * public function query($vo, $orderby) return array                                  //$orderby is optional
        * public function queryByWhere($vo, $where, $orderby) return array      //$orderby is optional
        * public function queryBySQL($vo, $queryStr) return array
        *
        * insert function:
        * public function insert($vo) return VO
        *
        * update functions:
        * public function update($vo) return int
        * public function updateBySQL($queryStr) return int
        *
        * delete functions:
        * public function delete($vo) return int
        * public function batchDelete($vo) return int
        * public function deleteBySQL($queryStr) return int
        *
        * Data Access Object
        *
        * @author YANG YANG & William
        * @version 1.0
        */
        class DAO{
                protected $isScrollPageEnabled = 0;

                /**
                 * get the value object from it's primary key value which is stored in the $vo
                 * @param <VO> $vo
                 * @return <VO>
                 */
                public function queryByPK($vo){
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //get column meta data
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $tableName = $this->getTableName($vo);
                        $resultset = mysql_query("select * from ".$tableName." where 1=0") or die("Invalid query");
                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);

                        //the table corresponding to the value object must has primary key column
                        //because we are going to use the primary key's value as the search condition
                        $pkColumnName = $tableMeta->getPKColumnName();
                        if($pkColumnName==null){
                                return null;
                        }

                        //the value object's field of primary key must has value
                        $pkValue = $vo->__call($this->getGetFuncName($pkColumnName), array());
                        if($pkValue==null){
                                return null;
                        }

                        $pkColumnMeta = $tableMeta->getColumnMeta($pkColumnName);
                        $whereStr;
                        if($pkColumnMeta->getType()=="int"){
                                //column's data type is int
                                $whereStr = $pkColumnName."=".$pkValue;
                        } else if ($pkColumnMeta->getType()=="string"){
                                //column's data type is string
                                $whereStr = $pkColumnName."='".$pkValue."'";
                        } else {
                                $whereStr = $pkColumnName."='".$pkValue."'";
                        }

                        $queryStr = "select * from ".$this->getTableName($vo)." where ".$whereStr ;

                        mysql_free_result ($resultset);
                        $vos = $this->executeQuery($vo, $queryStr);

                        if(count($vos)<=0){
                                return null;

                        } else {
                                /*
                                $pkTableNameMap = $this->getPKTableNameMap();

                                for ($i = 0; $i < $columnNumber; $i++) {
                                        $columnName = $columnNames[$i];
                                        if(!($tableMeta->isPrimaryKey($columnName))){
                                                $pkColumnNames = array_keys($pkTableNameMap);
                                                if (in_array($columnName, $pkColumnNames)) {
                                                        $fkTableName = $pkTableNameMap[$columnName];
                                                        print ("\$fkTableName = $fkTableName<br>");
                                                }
                                        }
                                }
                                 */
                                return $vos[0];
                        }
                }

                /**
                 * query function
                 * @param <VO> $vo
                 * @param <string> $orderby (optional)
                 * @return <array>
                 */
                public function query($vo, $orderby){
                        $queryStr = "select * from ".$this->getTableName($vo);

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //where clause
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $metaQuery = "$queryStr where 1=0";
                        Log::println("DAO->query() \$metaQuery = $metaQuery");
                        $resultset = mysql_query($metaQuery) or die("Invalid query: \$metaQuery=$metaQuery");

                        //$resultset = mysql_query($queryStr." where 1=0") or die("Invalid query");
                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);

                        $hasValueInVO = 0;
                        $_whereClause = "";
                        for ($i = 0; $i < $columnNumber; $i++) {
                                //get column name
                                $columnName = $columnNames[$i];
                                //get the field value from vo to see if the value of the field is null.
                                $fieldValue = $vo->__call($this->getGetFuncName($columnName), array());

                                //if the value is not null, then use the value as search conditon in where clause
                                if($fieldValue!=null){
                                        $hasValueInVO = 1;
                                        //get column's meta data
                                        $columnMeta = $tableMeta->getColumnMeta($columnName);
                                        if($columnMeta->getType()=="int"){
                                                //column's data type is int
                                                $_whereClause = $_whereClause." and ".$columnName."=".$fieldValue;
                                        } else if ($columnMeta->getType()=="string"){
                                                //column's data type is string
                                                $_whereClause = $_whereClause." and ".$columnName."='".$fieldValue."'";
                                        }
                                }
                        }
                        if($hasValueInVO){
                                $_whereClause = substr($_whereClause, 5);
                                $queryStr = $queryStr." where ".$_whereClause;
                                //print "query() queryStr with where clause = ".$queryStr."<br>";
                        }
                        mysql_free_result ($resultset);


                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //order by clause
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        if($orderby!=null && $orderby!=""){
                                $_orderby = trim($orderby);
                                //if the order by clause is not started with "order by", then add "order by " in front of the order by clause.
                                if(substr(strtolower($_orderby), 0, 9)!="order by "){
                                        $_orderby = "order by ".$_orderby;
                                }
                                $queryStr = $queryStr." ".$_orderby;
                                //print "query() queryStr with order by clause = ".$queryStr."<br>";
                        }

                        return $this->executeQuery($vo, $queryStr);
                }

                /**
                 *
                 * @param <VO> $vo
                 * @param <string> $where
                 * @param <string> $orderby (optional)
                 * @return <array>
                 */
                public function queryByWhere($vo, $where, $orderby){
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //where clause
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $_whereClause = trim($where);
                        //if the where clause is not started with "where", then add "where " in front of the where clause.
                        if(substr(strtolower($_whereClause), 0, 6)!="where "){
                                $_whereClause = "where ".$_whereClause;
                        }
                        $queryStr = "select * from ".$this->getTableName($vo)." ".$_whereClause;
                        //print "queryByWhereClause() queryStr with where clause = ".$queryStr."<br>";

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //order by clause
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        if($orderby!=null){
                                $_orderby = trim($orderby);
                                //if the order by clause is not started with "order by", then add "order by " in front of the order by clause.
                                if(substr(strtolower($_orderby), 0, 9)!="order by "){
                                        $_orderby = "order by ".$_orderby;
                                }
                                $queryStr = $queryStr." ".$_orderby;
                                //print "queryByWhereClause() queryStr with order by clause = ".$queryStr."<br>";
                        }

                        return $this->executeQuery($vo, $queryStr);
                }

                /**
                 *
                 * @param <type> $vo
                 * @param <type> $queryStr
                 * @return <type>
                 */
                public function queryBySQL($vo, $queryStr){
                        return $this->executeQuery($vo, $queryStr);
                }


                protected function executeQuery($vo, $queryStr){
                        //print ("executeQuery() \$queryStr = ".$queryStr."<br>");

                        $_page_tables = $_SESSION["page_tables"];
                        if ($_page_tables == null){
                            $_page_tables = array();
                        }
                        $_page_num = $_SESSION["page_num"];
                        if($_page_num==null || $_page_num==0){
                                $_page_num = 1;
                        }
                        $_page_size = $_SESSION["page_size"];
                        if($_page_size==null || $_page_size==0){
                                $_page_size = 10;
                        }
                        //print "DAO \$_page_num = $_page_num<br>";
                        //print "DAO \$_page_size =$_page_size<br>";

                        Log::println("DAO->executeQuery() \$queryStr = $queryStr");
                        $resultset = mysql_query($queryStr) or die("Invalid query: $queryStr");

                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);
                        $tableName = $tableMeta->getTableName();
                        //print "\$tableName = $tableName<br>";
                        //get total page number
                        $rowSize = mysql_num_rows($resultset);

                        if($this->isScrollPageEnabled){
                                //if(in_array($tableName, $_page_tables)){
                                        //print "need page scroll<br>";

                                        //print "\$rowSize=$rowSize<br>";
                                        if((int)$rowSize % (int)$_page_size==0){
                                                $_page_total = (int)$rowSize/(int)$_page_size;
                                        } else {
                                                $_page_total = ceil((int)$rowSize/(int)$_page_size);
                                        }

                                        //print "\$_page_total = $_page_total<br>";
                                        $_SESSION["page_total"] = $_page_total;
                                        //$_SESSION["page_total"] = 100;

                                        //get the sql for scroll page
                                        if($_page_num==1){
                                                $_row_begin = 0;
                                        } else {
                                                $_row_begin = ((int)$_page_num-1)*(int)$_page_size;
                                        }
                                        $queryStr = $queryStr." limit ".$_row_begin.", ".$_page_size;
                                        //print "DAO \$queryStr =$queryStr<br>";

                                        mysql_free_result ($resultset);
                                        
                                        Log::println("DAO->executeQuery() Page Scroll \$queryStr = $queryStr");

                                        $resultset = mysql_query($queryStr) or die("Invalid query: $queryStr");

                                //} else {
                                        //print "don't need page scroll<br>";
                                //}
                        } else {
                                //print "scroll page is disabled.<br>";
                        }

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        // get result
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $objects = array();
                        while ($row = mysql_fetch_array($resultset, MYSQL_ASSOC)) {
                                //create a new object for each record
                                eval("\$obj = new ".get_class( $vo)."();");
                                //print "vo class name = ".get_class($obj)."<br>";

                                for ($i = 0; $i < $columnNumber; $i++) {
                                        $columnMeta = $tableMeta->getColumnMeta($columnNames[$i]);
                                        //print "column name = ".$columnMeta->getName();
                                        //print ", column value = ".$row[$columnMeta->getName()];
                                        //print ", function name = ".$this->getSetFuncName($columnMeta->getName())."<br>";
                                        $obj->__call($this->getSetFuncName($columnMeta->getName()), array($row[$columnMeta->getName()]));
                                }
                                //print "object value = ".$obj."<br>";
                                //add the object into a list
                                $objects[] = $obj;
                        }
                        mysql_free_result ($resultset);
                        return $objects;
                }




                /**
                 *
                 * @param <type> $vo
                 * @return <type>
                 */
                public function insert($vo){

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //get column meta data
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $tableName = $this->getTableName($vo);
                        $resultset = mysql_query("select * from ".$tableName." where 1=0") or die("Invalid query");
                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //generate insert query SQL
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $hasValueInVO = 0;
                        //the insert query will be: insert into $tableName ($columnStr) values ($valuesStr)
                        $columnStr = "";
                        $valueStr = "";
                        for ($i = 0; $i < $columnNumber; $i++) {
                                //get column name
                                $columnName = $columnNames[$i];
                                //get the field value from vo to see if the value of the field is null.
                                $fieldValue = $vo->__call($this->getGetFuncName($columnName), array());

                                //if the value is not null, then use the value in insert clause
                                if($fieldValue!=null){
                                        $hasValueInVO = 1;
                                        //get column's meta data
                                        $columnMeta = $tableMeta->getColumnMeta($columnName);

                                        $columnStr = $columnStr.",".$columnName;
                                        if($columnMeta->getType()=="int"){
                                                //column's data type is int
                                                $valueStr = $valueStr.",".$fieldValue;
                                        } else if ($columnMeta->getType()=="string"){
                                                //column's data type is string
                                                $valueStr = $valueStr.",'".$fieldValue."'";
                                        }
                                }
                        }

                        mysql_free_result ($resultset);

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //execute insert
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        if($hasValueInVO){
                                $columnStr = substr($columnStr, 1);
                                $valueStr = substr($valueStr, 1);
                                //insert query
                                $queryStr = "insert into ".$tableName." (".$columnStr.") values (".$valueStr.")";

                                //print "insert() \$queryStr = ".$queryStr."<br>";

                                //execute insert query
                                Log::println("DAO->insert() \$queryStr = $queryStr");
                                mysql_query($queryStr) or die("Invalid query");

                                $pkColumnName = $tableMeta->getPKColumnName();
                                if($pkColumnName!=null){
                                        //get the AUTO_INCREMENTED id value of the primary key of the table
                                        $id = mysql_insert_id ();
                                        //print "insert() \$id = ".$id."<br>";
                                        //print "\$this->setGetFuncName(\$pkColumnName) = ".$this->getSetFuncName($pkColumnName)."<br>";
                                        $vo->__call($this->getSetFuncName($pkColumnName), array($id));
                                }
                        }
                        return $vo;
                }

                /**
                 * single update function to update one record in the database
                 *
                 * update function is not used in batch update, because some of the fileds in vo will be new values to be updated, and some of the fields in vo will be where condition.
                 * one vo parameter can not tell the update function which fields are for "set" and which are for "where". There would be an extra parameters to indicate that.
                 * So if we create another function update($updateQuery) the parameter is the whole update SQL.
                 * That would be easier and clearer than write a funcion like update($vo, $whereClause).
                 *
                 * @param <type> $vo
                 * @return <type>
                 */
                public function update($vo){

                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //get column meta data
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $tableName = $this->getTableName($vo);
                        $resultset = mysql_query("select * from ".$tableName." where 1=0") or die("Invalid query");
                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);

                        //the table corresponding to vo must has primary key
                        $pkColumnName = $tableMeta->getPKColumnName();
                        if($pkColumnName==null){
                                return 0;
                        }
                        //the value object's field of primary key must has value
                        $pkValue = $vo->__call($this->getGetFuncName($pkColumnName), array());
                        if($pkValue==null){
                                return 0;
                        }

                        $pkColumnMeta = $tableMeta->getColumnMeta($pkColumnName);
                        $whereStr;
                        if($pkColumnMeta->getType()=="int"){
                                //column's data type is int
                                $whereStr = $pkColumnName."=".$pkValue;
                        } else if ($pkColumnMeta->getType()=="string"){
                                //column's data type is string
                                $whereStr = $pkColumnName."='".$pkValue."'";
                        } else {
                                $whereStr = $pkColumnName."='".$pkValue."'";
                        }

                        $hasValueInVO = 0;
                        $setStr = "";
                        for ($i = 0; $i < $columnNumber; $i++) {
                                //get column name
                                $columnName = $columnNames[$i];
                                //get the field value from vo to see if the value of the field is null.
                                $fieldValue = $vo->__call($this->getGetFuncName($columnName), array());

                                //if the value is not null, then use the value in insert clause
                                if($fieldValue!=null){
                                        $hasValueInVO = 1;
                                        //get column's meta data
                                        $columnMeta = $tableMeta->getColumnMeta($columnName);

                                        if(!$columnMeta->isPrimaryKey()){
                                                if($columnMeta->getType()=="int"){
                                                        //column's data type is int
                                                        $setStr = $setStr.",".$columnName."=".$fieldValue;

                                                } else if ($columnMeta->getType()=="string"){
                                                        //column's data type is string
                                                        $setStr = $setStr.",".$columnName."='".$fieldValue."'";
                                                }
                                        }//end if(!$columnMeta->isPrimaryKey())

                                } // end if($fieldValue!=null)

                        } // end for

                        $setStr = substr($setStr, 1);
                        $queryStr = "update ".$tableName." set ".$setStr." where ".$whereStr;

                        //print "update() \$queryStr = ".$queryStr."<br>";

                        //execute update query
                        Log::println("DAO->update() \$queryStr = $queryStr");
                        mysql_query($queryStr) or die("Invalid query: $queryStr");
                        return mysql_affected_rows();
                }

                /**
                 * update a batch of records in the database
                 * @param <string> $queryStr
                 */
                public function updateBySQL($queryStr){
                        //print "updateBySQL() \$queryStr = ".$queryStr."<br>";
                        //execute update query
                        Log::println("DAO->updateBySQL() \$queryStr = $queryStr");
                        mysql_query($queryStr) or die("Invalid query: $queryStr");
                        return mysql_affected_rows();
                }

                /**
                 * delete one record in the database
                 *
                 * $vo must has a field which is primary key in the table, and the field must has a value as delete where condition
                 * @param <VO> $vo
                 * @return <int> affected rows e.g. 0(failed/no record deleted) or 1(succeeded)
                 */
                public function delete($vo){
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //get column meta data
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $tableName = $this->getTableName($vo);
                        $metaQuery = "select * from $tableName where 1=0";
                        Log::println("DAO->delete() \$metaQuery = $metaQuery");
                        $resultset = mysql_query($metaQuery) or die("Invalid query: \$metaQuery=$metaQuery");

                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);

                        //the table corresponding to vo must has primary key
                        $pkColumnName = $tableMeta->getPKColumnName();
                        if($pkColumnName==null){
                                return 0;
                        }

                        //the value object's field of primary key must has value
                        $pkValue = $vo->__call($this->getGetFuncName($pkColumnName), array());
                        if($pkValue==null){
                                return 0;
                        }

                        $pkColumnMeta = $tableMeta->getColumnMeta($pkColumnName);
                        $whereStr;
                        if($pkColumnMeta->getType()=="int"){
                                //column's data type is int
                                $whereStr = $pkColumnName."=".$pkValue;
                        } else if ($pkColumnMeta->getType()=="string"){
                                //column's data type is string
                                $whereStr = $pkColumnName."='".$pkValue."'";
                        } else {
                                $whereStr = $pkColumnName."='".$pkValue."'";
                        }

                        $queryStr = "delete from ".$tableName." where ".$whereStr;
                        //print "delete() \$queryStr = ".$queryStr."<br>";

                        //execute delete query
                        Log::println("DAO->delete() \$queryStr = $queryStr");
                        mysql_query($queryStr) or die("Invalid query: $queryStr");
                        return mysql_affected_rows();
                }

                /**
                 * delete a batch of records in database
                 *
                 * All the fields in the $vo which have value will be the delete condition.
                 * Client program should be careful to use this function by making sure that the fields in the $vo are set properly.
                 * @param <type> $vo
                 */
                public function batchDelete($vo){
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        //get column meta data
                        //----------------------------------------------------------------------------------------------------------------------------------------
                        $tableName = $this->getTableName($vo);
                        $resultset = mysql_query("select * from ".$tableName." where 1=0") or die("Invalid query");
                        $tableMeta = new DBTableMeta($resultset);
                        $columnNames =  $tableMeta->getColumnNames();
                        $columnNumber = count($columnNames);

                        $hasValueInVO = 0;
                        $_whereClause = "";
                        for ($i = 0; $i < $columnNumber; $i++) {
                                //get column name
                                $columnName = $columnNames[$i];
                                //get the field value from vo to see if the value of the field is null.
                                $fieldValue = $vo->__call($this->getGetFuncName($columnName), array());

                                //if the value is not null, then use the value as search conditon in where clause
                                if($fieldValue!=null){
                                        $hasValueInVO = 1;
                                        //get column's meta data
                                        $columnMeta = $tableMeta->getColumnMeta($columnName);
                                        if($columnMeta->getType()=="int"){
                                                //column's data type is int
                                                $_whereClause = $_whereClause." and ".$columnName."=".$fieldValue;
                                        } else if ($columnMeta->getType()=="string"){
                                                //column's data type is string
                                                $_whereClause = $_whereClause." and ".$columnName."='".$fieldValue."'";
                                        }
                                }
                        }

                        mysql_free_result ($resultset);
                        if($hasValueInVO){
                                $_whereClause = substr($_whereClause, 5);
                                $queryStr = "delete from ".$tableName." where ".$_whereClause;
                                //print "delete() \$queryStr = ".$queryStr."<br>";
                                //execute delete query
                                Log::println("DAO->batchDelete() \$queryStr = $queryStr");
                                mysql_query($queryStr) or die("Invalid query: $queryStr");
                                return mysql_affected_rows();
                        } else {
                                return 0;
                        }
                }

                public function deleteBySQL($queryStr){
                        //print "deleteBySQL() \$queryStr = ".$queryStr."<br>";
                        //execute delete query
                        Log::println("DAO->deleteBySQL() \$queryStr = $queryStr");
                        mysql_query($queryStr) or die("Invalid query: $queryStr");
                        return mysql_affected_rows();
                }


                /**
                 * get  the table name according to the value object's class name
                 * e.g.
                 * $vo = new User()
                 * getTableName($vo) will return "USER"
                 *
                 * $vo = new Organization
                 * getTableName($vo) will return "ORGANIZATION"
                 *
                 * @param string $vo
                 * @return string table name
                 */
                protected  function getTableName($vo){
                        //echo __CLASS__."<br>";
                        //get the class name of the value object
                        $className = get_class( $vo);
                        //table name is upper case in our design
                        $tableName = strtoupper($className);
                        return $tableName;
                }

                /**
                 * get the setXXX() function of a column.
                 * e.g.
                 * columnName = "NAME"
                 * getSetFuncName($columnName) will return "setName"
                 *
                 * columnName = "parentid"
                 * getSetFuncName($columnName) will return "setParentid"
                 *
                 * @param string $columnName
                 * @return string set function name
                 */
                protected function getSetFuncName($columnName){
                        return "set".ucwords(strtolower($columnName));
                }

                /**
                 * get the getXXX() function of a column.
                 * e.g.
                 * columnName = "NAME"
                 * getGetFuncName($columnName) will return "getName"
                 *
                 * columnName = "parentid"
                 * getGetFuncName($columnName) will return "getParentid"
                 *
                 * @param string $columnName
                 * @return string get function name
                 */
                protected function getGetFuncName($columnName){
                        return "get".ucwords(strtolower($columnName));
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

                //resolve foreign key reference by default
                //private $resolveForeignKeyReference = 1;
                /**
                 * get an array of key=>value
                 * key : primary key column name
                 * value : table name
                 * @return Array<string(primary key column name)=>string(table name)>
                private function getPKTableNameMap(){
                        $pkTableNameMap = array();
                        $resultset = mysql_query("SHOW TABLES") or die("Invalid query");
                        while ( $row = mysql_fetch_array ( $resultset , MYSQL_ASSOC) ) {
                                $_array = array_values($row);
                                $tableName = $_array[0];
                                $resultset1 = mysql_query("select * from ".$tableName." where 1=0") or die("Invalid query");
                                $tableMeta = new DBTableMeta($resultset1);
                                $pkColumnName = $tableMeta->getPKColumnName();
                                if($pkColumnName!=null){
                                        //$pkColumnMeta = $tableMeta->getColumnMeta($pkColumnName);
                                        //print $pkColumnMeta."<br>";
                                        $pkTableNameMap[$pkColumnName] = $tableName;
                                }
                                //close resultset
                                mysql_free_result ($resultset1);
                        }
                        mysql_free_result ($resultset);
                        return $pkTableNameMap;
                }
                public function setResolveForeignKey($resolveForeignKeyReference){
                        $this->resolveForeignKeyReference = $resolveForeignKeyReference;
                }
                public function isResolveForeignKey(){
                        return $this->resolveForeignKeyReference;
                }
                 */
        }
?>
