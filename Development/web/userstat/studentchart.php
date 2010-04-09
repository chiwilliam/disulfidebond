<?php session_start(); if($_SESSION['loggedin'] == false){ header('Location: ../index.php');} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker - Charts for Student's Group</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../css/menustyle.css" >
<script type="text/javascript" src="../coolmenupro/coolmenupro.js" ></script>
<script>
	function changeClass(obj, name) {
		obj.className = name;
	}
</script>
<style>
.nameoftheclass {

}
</style>
</head>
<body>
<div id="container">
	<!-- header -->
    <div id="header">
    	    	<div align="right"><font color="white" size="2">
                        <?php if($_SESSION['loggedin'] == true){echo "Logged in: ".$_SESSION['username']." |
                        <a href='../logout.php'>Logout</a>"; } else { echo "<a href='../index.php'>Login</a>";} ?>
                        </font></div>
        <div id="logo"><a href="../index.php"><span class="orange">PRODUCTIVITY</span>
			TRACKER</a></font></div>
    </div>
    <!--end header -->

    <!-- main -->
    <div id="main">
		<!--menu begin-->
	 	<div id="menu">
			<script type="text/javascript" src="../coolmenupro/menu_student.js" ></script>
			<script type="text/javascript">CLoadNotify();</script>
		</div>
		<!--menu end-->
        <!-- content start-->
        <div id="content">
        
<?php

    $dbhost = 'hci.cs.sfsu.edu';
    $dbuser = 'group2';
    $dbpass = 'un848';

    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');

    $dbname = 'test';
    mysql_select_db($dbname,$conn) or die('Error selecting DB');


    include ('../GoogleCharts/mycharts.php');


     $flag=FALSE;
     $image = "";

     $title1="Group 2 Comparison";
     $title2="comparison";
     $title3="comparison";

     $type1="semester1";
     $query1 = mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group2' AND category = 'mailinglist';");
     //$att1="40";
     $query2=mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group2' and category = 'discussionforum';");
     //$att2=60;
     $query3=mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group2' and category = 'announcement';");
     //$att3=100;
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

$label1="M.L. (".$att1.")";
     $label2="D.F. (".$att2.")";
     $label3="A. (".$att3.")";

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

<br/>
<br/>
       <div id="form">
        <form id="chartform" action="studentchart.php" method ="post">

         Pie Chart <input type="radio" name="chart_type" value="pie"><br>
         Bar Chart <input type="radio" name="chart_type" value="bar"><br>
         Time Line <input type="radio" name="chart_type" value="time"><br>
         <input type="submit" name="submit" value="submit" onClick="setVisibility('chart', 'visible');setVisibility('form', 'hidden');"><br>

         </form>
        </div>

<br>
<br>

     <?php echo $image; if($image != ""){echo "<table><tr><td>M.L.  =>  Mailing Lists</td></tr><tr><td>D.F.  =>  Discussion Forums</td></tr><tr><td>A.    =>  Announcements</td></tr></table>";} ?>
   







        </div>
        <!--content end-->
    </div>
    <!-- end main -->

    <!-- footer -->
    <div id="footer">
		<div id="left_footer">&copy; Copyright 2008 CSC 848 Group2
		</div>
		<div id="right_footer">
			Design by <a href="../index.php" title="Website Design">Group2 Members</a>
		</div>
    </div>
    <!-- end footer -->
</div>
</body>
</html>
