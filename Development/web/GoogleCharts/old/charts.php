<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php

    $dbhost = 'hci.cs.sfsu.edu';
    $dbuser = 'group2';
    $dbpass = 'un848';

    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');

    $dbname = 'test';
    mysql_select_db($dbname,$conn) or die('Error selecting DB');


    include ('mycharts.php');


     $flag=FALSE;
     $image = "";

     $title1="comparison";
     $title2="comparison";
     $title3="comparison";

     $type1="semester1";
     $query1 = mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group2';");
     //$att1="40";
     $label1="group2";
     $query2=mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group3';");
     //$att2=60;
     $label2="group3";
     $query3=mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group4';");
     //$att3=100;
     $label3="group4";
     $type2="semester2";
     $att4=45;
     $att5=20;
     $att6=70;
     $type3="semester3";
     $att7=20;
     $att8=40;
     $att9=200;

    while($row = mysql_fetch_array($query1))
     {
       $att1=$row['Count'];
     }
     while($row = mysql_fetch_array($query2))
     {
       $att2=$row['Count'];
     }
     while($row = mysql_fetch_array($query3))
     {
       $att3=$row['Count'];
     }
     
    
   /*
   echo $att1;
   echo "<br />";
   echo $att2;
   echo "<br />";
   echo $att3;
   echo "<br />";
   */
    switch($_POST[chart_type])
    {
        case pie:$image=piechart($title1,$att1,$label1,$att2,$label2,$att3,$label3);break;
        case bar:$image=barchart($title2,$type1,$att1,$label1,$att2,$label2,$att3,$label3,$type2,$att4,$att5,$att6);break;
        case time:$image=timeline($title3,$type1,$att1,$label1,$att2,$label2,$att3,$label3,$type2,$att4,$att5,$att6,$type3,$att7,$att8,$att9);break;
        default:$flag=TRUE;break;
    }
 ?>

<script language="JavaScript">
function setVisibility(id, visibility) {
document.all[id].style.display = visibility;
}
</script>

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title></title>
    </head>
    <body>
       <div id="form">
        <form id="chartform" action="charts.php" method ="post">

         Pie Chart <input type="radio" name="chart_type" value="pie"><br>
         Bar Chart <input type="radio" name="chart_type" value="bar"><br>
         Time Line <input type="radio" name="chart_type" value="time"><br>
         <input type="submit" name="submit" value="submit" onClick="setVisibility('chart', 'visible');setVisibility('form', 'hidden');"><br>

         </form>
        </div>

<br>
<br>

     <?php echo $image; ?>
         </body>
</html>





