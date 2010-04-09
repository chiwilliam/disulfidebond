<?php
//        $size = count($orgs);
//        print $size;
//        for($i=0; $i<$size; $i++){
//                print $orgs[$i]."<br>";
//        }
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
	
	function _Checkall(){
		unitids = ",";
		var obj = document.getElementsByName("ids");
		var len = obj.length;
		if(document.listform.allcheck.checked){
			for (var i = 0;i<len;i++){
				unitids = unitids + obj[i].value + ",";
				obj[i].checked = true;
			}
		}else{
			for (var i = 0;i<len;i++){
				obj[i].checked = false;
			}
		}
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
					<td valign="top" height="50" style="padding:5px; ">
						<img src="../images/node/MessageInfo.gif" width="16" height="16"> This is a information message.<br>
						<img src="../images/node/MessageWarn.gif"> This is a warn message.<br>
						<img src="../images/node/MessageError.gif"> This is a error message.<br>
						
						
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
                        <td width="10%" height="22" >select<input type="checkbox" name="allcheck" onClick="_Checkall()" value="0" ></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group1</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group1</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group2</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group2</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >3</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group3</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group3</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >4</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group4</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group4</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >5</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group5</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group5</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >6</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group6</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group6</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >7</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group7</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group7</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >8</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group8</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group8</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >9</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group9</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group9</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" >10</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group10</td>
                        <td width="25%" height="22" class="data_td_border tdleft" >group10</td>
						<td width="30%" height="22" class="data_td_border tdleft" >&nbsp;</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
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
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				<form name="infoform" method="post" action="">
				  <tr>
					<td height="28" class="cle"></td>
					<td height="28" class="che title1 space1">Group Information</td>
					<td height="28" class="cre"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top">
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >serial index </td>
						<td width="50%" height="22" class="labelcol labelleft" ><input name="serialindex" type="text" class="textInput1" size="10"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >name</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="name" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >text</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="text" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >description</td>
						<td width="50%" height="22" class="labelcol labelleft" ><textarea name="description" cols="40" rows="6" class="desc"></textarea></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					</table>

					
					</td>
					<td class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
				</form>
				</table>
				<br>
				<table width="100%"  border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="right" valign="middle">
					  <table width="300" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                          <td><img src="../images/button/short/blue_add.png" width="83" height="31"></td>
                          <td><img src="../images/button/short/blue_update.png" width="83" height="31"></td>
                          <td><img src="../images/button/short/red_delete.png" width="83" height="31"></td>
                        </tr>
                      </table></td>
				  </tr>
		    </table>
			  
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