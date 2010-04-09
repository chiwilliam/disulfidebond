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

     $title1="Group 3 Comparison";
     $title2="comparison";
     $title3="comparison";

     $type1="semester1";
     $query1 = mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group3' AND category = 'mailinglist';");
     //$att1="40";
     $query2=mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group3' and category = 'discussionforum';");
     //$att2=60;
     $query3=mysql_query("SELECT count(*) AS Count FROM william WHERE groupname='group3' and category = 'announcement';");
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Group</title>
<script type="text/javascript" src="../tree/xtree.js"></script>
<script type="text/javascript" src="../tree/xmlextras.js"></script>
<script type="text/javascript" src="../tree/xloadtree.js"></script>
<link type="text/css" rel="stylesheet" href="../tree/xtree.css" />

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
    	<div id="logo"><a href="#"><span class="orange">PRODUCTIVITY</span> TRACKER</a></div>
        <div id="module">
        	<ul>
				<li><a href="#">PPM Project</a></li>
				<li><a href="#" class="active">Configuration</a></li>
            </ul>
        </div>
    </div>
    <!--end header -->
    <!-- main -->
    <div id="main">
		<!--menu begin-->
	 	<div id="menu">
			<script type="text/javascript" src="../coolmenupro/menu_instructor.js" ></script>
			<script type="text/javascript">CLoadNotify();</script>
		</div>
		<!--menu end-->

		<!--content begin-->
        <div id="content">

			<div id="banner1">
				<h2>Group</h2>
				For Fall 2008 semester there are several universities. One of the universities is SF State.
				Inside SF State the course number is CSC 848. There are group1 - group2 inside CSC848.
				<br />
				In each group there are sevearl students.
			</div>

			<!--nav begin-->
			<div id="leftarea">
				<table width="210" height="400" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td height="28" class="clg"></td>
					<td height="28" class="chg title1 space1">Group</td>
					<td height="28" class="crg"></td>
				  </tr>
				  <tr>
					<td height="380" class="bl"></td>
					<td height="380" valign="top" style="padding:10px;">


<script type="text/javascript">
/// XP Look
webFXTreeConfig.rootIcon		= "../tree/folder.gif";
webFXTreeConfig.openRootIcon	= "../tree/openfolder.gif";
webFXTreeConfig.folderIcon		= "../tree/folder.png";
webFXTreeConfig.openFolderIcon	= "../tree/openfolder.gif";
webFXTreeConfig.fileIcon		= "../tree/user01.png";
webFXTreeConfig.lMinusIcon		= "../tree/listExpanded.png";
webFXTreeConfig.lPlusIcon		= "../tree/listCollapsed.png";
webFXTreeConfig.tMinusIcon		= "../tree/listExpanded.png";
webFXTreeConfig.tPlusIcon		= "../tree/listCollapsed.png";
webFXTreeConfig.iIcon			= "../tree/I.png";
webFXTreeConfig.lIcon			= "../tree/L.png";
webFXTreeConfig.tIcon			= "../tree/T.png";
webFXTreeConfig.blankIcon	    = "../tree/blank.png";
webFXTreeConfig.defaultTarget	= "self";

var tree = new WebFXTree("Groups","#");
tree.add(new WebFXLoadTreeItem("Fall 2007", "./tree_fall2007.xml"));
tree.add(new WebFXLoadTreeItem("Fall 2008", "./tree_fall2008.xml"));
document.write(tree);
</script>


                    </td>
					<td height="380" class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
			  </table>

			</div>
			<!--nav end-->

			<!--text begin-->
		  <div id="rightarea">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				  <tr>
					<td height="28" class="cl"></td>
					<td height="28" class="ch title1 space1">Message</td>
					<td height="28" class="cr"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top" height="50" >
					</td>
					<td class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
				</table>
		  		<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_row_border">
				<form name="listform" method="post" action="">
				  <tr>
					<td height="28" class="cle"></td>
					<td height="28" class="che title1 space1">Groups List</td>
					<td height="28" class="cre"></td>
				  </tr>
				  <tr>
					<td height="200" class="bl"></td>
					<td height="200" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                      <tr class="rowhead">
                        <td width="10%" height="22" class="data_td_border" >index</td>
                        <td width="25%" height="22" class="data_td_border" >name</td>
                        <td width="25%" height="22" class="data_td_border" >text</td>
						<td width="30%" height="22" class="data_td_border" >description</td>
                        <td width="10%" height="22" >select</td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group1</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group1</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group2</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group2</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >3</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group3</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group3</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >4</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group4</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group4</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >5</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group5</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group5</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >6</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group6</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group6</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >7</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group7</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group7</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >8</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group8</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group8</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >9</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group9</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group9</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >10</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group10</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group10</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="checkbox" value="checkbox"></td>
                      </tr>
                    </table></td>
					<td height="200" class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
			  </form>
			  </table>
			  <br />




       <div id="form">
        <form id="chartform" action="ViewStatData.php" method ="post">

         Pie Chart <input type="radio" name="chart_type" value="pie">
         Bar Chart <input type="radio" name="chart_type" value="bar">
         Time Line <input type="radio" name="chart_type" value="time"><br>
         <input type="submit" name="submit" value="submit" onClick="setVisibility('chart', 'visible');setVisibility('form', 'hidden');"><br>

         </form>
        </div>

<br>
<br>

     <?php echo $image; if($image != ""){echo "<table><tr><td>M.L.  =>  Mailing Lists</td></tr><tr><td>D.F.  =>  Discussion Forums</td></tr><tr><td>A.    =>  Announcements</td></tr></table>";} ?>



		  </div>
	   		<!--text end-->


       </div>
	   <!--content end-->
    </div>
    <!-- end main -->



    <!-- footer -->
    <div id="footer">
		<div id="left_footer">&copy; Copyright 2008 CSC 848 Group2
		</div>
		<div id="right_footer">
			Design by <a href="http://www.realitysoftware.ca" title="Website Design">Group2 Members</a>
		</div>
    </div>
    <!-- end footer -->
</div>
</body>
</html>
