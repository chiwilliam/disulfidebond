<?php

            include 'openDB.php';
            $sql = 'SELECT CATEGORY.categoryid,rssurl FROM CATEGORY,CONFIGPROJECT,CONFIGURATION WHERE (CONFIGURATION.enabled=\'yes\' AND CATEGORY.projectid=CONFIGPROJECT.projectid AND CONFIGPROJECT.configurationid=CONFIGURATION.configurationid)';
            $result = mysql_query($sql) or die(mysql_error());

            while($row = mysql_fetch_assoc($result))
            {
                   $rsslink=$row['rssurl'];
                   $catid=$row['categoryid'];
                   $result2 = new SimpleXMLElement($rsslink,LIBXML_NOCDATA,true);
                   if(isset($result2->channel))
                   {
                      parseRSS($result2,$rsslink,$catid);
                   }
                    else
                   {
                      echo "File was not recognized...";
                    }
                                           }
           function parseRSS($xml,$url,$catid)
           {
               echo $xml->channel->title."\n";
               $cnt = count($xml->channel->item);
               for($i=0; $i<$cnt; $i++)
               {
		   $guid=$xml->channel->item[$i]->guid;
                   $sql3 = 'SELECT count(guid) as rep FROM ITEM where guid="'.$guid.'"';
                   $result4 = mysql_query($sql3) or die(mysql_error());
                   while($row = mysql_fetch_assoc($result4))
                      {
                        $rep=$row['rep'];
                       }
                   if ($rep==0){
                   $query2 = 'INSERT INTO ITEM
                               (categoryid,guid,username,createdate)
                            VALUES
                               ("'.$catid.'","'.$guid.'","'.$xml->channel->item[$i]->author.'","'.$xml->channel->item[$i]->pubDate.'")';
                      if (!mysql_query($query2))
                          {
                             die('Error: ' . mysql_error());
                             }
                   $sql2 = 'SELECT itemid FROM ITEM WHERE itemid=(SELECT MAX(itemid) FROM ITEM)';                    
                   $result3 = mysql_query($sql2) or die(mysql_error());
                   $itemid=$row['itemid'];
                   while($row = mysql_fetch_assoc($result3))
                      {
                        $itemid=$row['itemid'];
                       }
                   $query = 'SELECT TAG.categoryid,tagname,tagid FROM CATEGORY,TAG WHERE (rssurl="'.$url.'" and TAG.categoryid=CATEGORY.categoryid)';
                   $result2 = mysql_query($query) or die(mysql_error());
                   $num_rows = mysql_num_rows($result2); 
                   while($row = mysql_fetch_assoc($result2))
                   {
                          $tagname = $row['tagname'];
                          $tagid = $row['tagid'];
                          $value =  $xml->channel->item[$i]->$tagname;
                          if (strlen($value)>390)
                            {
                               $value=ShortenText($value);
                              }
                          $query3 = 'INSERT INTO CELL VALUES ("'.$itemid.'","'.$tagid.'","'.$value.'")';
                          if (!mysql_query($query3))
                            {
                              die('Error: ' . mysql_error());
                               }
                             
                    } 
                 }
               }
             }
function ShortenText($text) {
        // Change to the number of characters you want to display
        $chars = 390;
        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }
include 'closeDB.php';
?>
