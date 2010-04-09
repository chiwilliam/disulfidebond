<?php
        /**
         * @author Yang Yang
         * @version 1.0
         * 11/30/2008
         */
        function getPageNumUrl($_url, $_num){
                $return_url = "";
                if(strpos($_url,"?")>0){
                        $return_url = $_url."&page_num=$_num";
                } else {
                        $return_url = $_url."?page_num=$_num";
                }
                return $return_url;
        }

        function getPageSizeUrl($_url, $_size){
                $return_url = "";
                if(strpos($_url,"?")>0){
                        $return_url = $_url."&page_size=$_size";
                } else {
                        $return_url = $_url."?page_size=$_size";
                }
                return $return_url;
        }

        $_page_url = $_SESSION["page_url"];
        $_page_size = $_SESSION["page_size"];
        $_page_num = $_SESSION["page_num"];
        $_page_total = $_SESSION["page_total"];

        $_page_num_first = 1;
        $_page_num_prev = (int)$_page_num-1;
        $_page_num_next = (int)$_page_num+1;
        $_page_num_last = $_page_total;

        /*
        print "\$_page_url = $_page_url<br>";
        print "\$_page_tables = $_page_tables<br>";
        print "\$_page_size =$_page_size<br>";
        print "\$_page_num = $_page_num<br>";
        print "\$_page_total = $_page_total<br>";
        */

        $hrefLabel = "";
        if($page_num>1){
                //url link for first page
                $hrefLabel = "$hrefLabel <a href=\"".getPageNumUrl($_page_url, $_page_num_first)."\">First</a> ";
                //url link for previous page
                $hrefLabel = "$hrefLabel <a href=\"".getPageNumUrl($_page_url, $_page_num_prev)."\">Previous</a> ";
        }

        //url link for pages before current page
        $beginPageNum = (int)$page_num-4;
        for($p1 = $beginPageNum; $p1<$page_num; $p1++){
                if($p1>0){
                        $hrefLabel = "$hrefLabel <a href=\"".getPageNumUrl($_page_url, $p1)."\">$p1</a> ";
                }
        }

        //current page number has no url link
        $hrefLabel = $hrefLabel." <strong>$page_num</strong> ";

        //url link for pages after current page
        $endNum = (int)$page_num+4;
        for($p2 = $page_num+1; $p2<=$endNum; $p2++){
                //print $p2."   ";
                if($p2>$_page_num_last){
                        continue;
                }
                $hrefLabel = "$hrefLabel <a href=\"".getPageNumUrl($_page_url, $p2)."\">$p2</a> ";
        }

        if($page_num<$_page_num_last){
                //url link for first page
                $hrefLabel = "$hrefLabel <a href=\"".getPageNumUrl($_page_url, $_page_num_next)."\">Next</a> ";
                //url link for previous page
                $hrefLabel = "$hrefLabel <a href=\"".getPageNumUrl($_page_url, $_page_num_last)."\">Last</a> ";
        }

        if($_page_num_last==null||$_page_num_last==""){
                $_page_num_last = 1;
        }

        $leftLabel = "Page <strong>$page_num</strong> of <strong>$_page_num_last</strong>";
        $rightLabel = "Items per page:";
        if($_page_size==10){
                $rightLabel = $rightLabel." <strong>10</strong>";
        } else {
                $rightLabel = $rightLabel." <a href=\"".getPageSizeUrl($_page_url, 10)."\">10</a>";
        }

        if($_page_size==20){
                $rightLabel = $rightLabel." | <strong>20</strong>";
        } else {
                $rightLabel = $rightLabel." | <a href=\"".getPageSizeUrl($_page_url, 20)."\">20</a>";
        }

        if($_page_size==50){
                $rightLabel = $rightLabel." | <strong>50</strong>";
        } else {
                $rightLabel = $rightLabel." | <a href=\"".getPageSizeUrl($_page_url, 50)."\">50</a>";
        }

        if($_page_size==100){
                $rightLabel = $rightLabel." | <strong>100</strong>";
        } else {
                $rightLabel = $rightLabel." | <a href=\"".getPageSizeUrl($_page_url, 100)."\">100</a>";
        }

        print "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        print "<tr>";
        print "<td width=\"25%\" height=\"22\" align=\"left\">$leftLabel</td>";
        print "<td width=\"50%\" height=\"22\" align=\"center\">$hrefLabel</td>";
        print "<td width=\"25%\" height=\"22\" align=\"right\">$rightLabel</td>";
        print "</tr>";
        print "</table>";

        //unset($_SESSION["page_size"]);
        unset($_SESSION["page_url"]);
        unset($_SESSION["page_num"]);
        unset($_SESSION["page_total"]);
?>
