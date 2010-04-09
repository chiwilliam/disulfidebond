<?php
        /**
         * @author Yang Yang
         * @version 1.0
         * 11/30/2008
         */
        session_start();
        //------------------------------------------------------------------------------------------------------
        // scroll page parameter1: "table"
        //------------------------------------------------------------------------------------------------------
        $page_table = $_REQUEST["table"];
        if($page_table==null){
                $page_table = $_SESSION["page_table"];
                if($page_table==null){
                        $page_tables = array();
                }
                $page_tables = explode ("|", $page_table);
        } else {
                $_SESSION["page_table"] = $page_table;
                $page_tables = explode ("|", $page_table);
                /*
                while(list($key, $table) = each($page_tables)) {
                         echo "\$table=$table<br>";
                }
                 */
        }
        //print "size of \$page_table is ".count($page_tables)."<br>";
        $_SESSION["page_tables"]=$page_tables;


        //------------------------------------------------------------------------------------------------------
        // scroll page parameter2: "page_size"
        //------------------------------------------------------------------------------------------------------
        $page_size = $_REQUEST["page_size"];
        if($page_size==null){
                $page_size = $_SESSION["page_size"];
                if($page_size==null){
                        $page_size = 10;
                }
        }
        //DAO will use this value from _SESSION
        $_SESSION["page_size"]=$page_size;


        //------------------------------------------------------------------------------------------------------
        // scroll page parameter3: "page_num"
        //------------------------------------------------------------------------------------------------------
        $page_num = $_REQUEST["page_num"];
        if($page_num==null){
                $page_num = 1;
        }
        //DAO will use this value from _SESSION
        $_SESSION["page_num"]=$page_num;


        //------------------------------------------------------------------------------------------------------
        // create url for the scroll page bar
        //------------------------------------------------------------------------------------------------------
        $page_url = $_SERVER[PHP_SELF];
        //print "step1 url = ".$page_url."<br>";

        $urlParamSize = count($_REQUEST);
        //print "\$paramSize = ".$paramSize."<br>";
        $urlParameters = "";
        //$_REQUEST | $HTTP_POST_VARS
        while(list($key , $val) = each($_REQUEST)) {
                //echo "$key => $val<br>";
                //ignore the table name, because the table names cann't be passed as parameters to DAO.
                //The table names will be stored in SESSION. DAO will get the table names from SESSION, when the DAO is executing the query functiions.
                //So it is unnecessary to put the page_table in the URL
                if($key=="table"){
                        continue;
                }
                //ignore the page size
                if($key=="page_size"){
                        continue;
                }
                //ignore the page number, because the new page number will be added to the end of the url when the user click the next page link.
                if($key=="page_num"){
                        continue;
                }
                $urlParameters = $urlParameters."&".$key."=".$val;
        }

        if($urlParamSize!=0){
                $urlParameters = substr($urlParameters, 1);
                $page_url = $page_url."?".$urlParameters;
        }
        //print "step2 url = ".$page_url."<br>";

        //get the last index of "/"
        $pos = strrpos($page_url, "/");
        if($pos>=0){
                $page_url = ".".substr($page_url, $pos);
        }
        //print "step3 url = ".$page_url."<br>";
        $_SESSION["page_url"]=$page_url;

?>
