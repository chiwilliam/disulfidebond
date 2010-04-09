<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>UserProfile</title>
<script type="text/javascript" src="../tree/xtree.js"></script>
<script type="text/javascript" src="../tree/xmlextras.js"></script>
<script type="text/javascript" src="../tree/xloadtree.js"></script>
<link type="text/css" rel="stylesheet" href="../tree/xtree.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../css/menustyle.css" >
<script type="text/javascript" src="../coolmenupro/coolmenupro.js" ></script>
<script language="javascript">

function SelectGroup(){
	window.open('./abc.html', 'haha');
}

function SetGroup(organizationid, orgname){
	document.infoform.organizationid.value = organizationid;
	document.infoform.orgname.value = orgname;
	//alert("document.infoform.organizationid.value = " + document.infoform.organizationid.value);
	//alert("document.infoform.orgname.value = " + document.infoform.orgname.value);
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
		<br><br>
		<!--content begin-->
        <div id="content">

			<div id="rightarea">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				<form name="infoform" method="post" action="">

				  <tr>
					<td height="28" class="cle"></td>
					<td height="28" class="che title1 space1">User Information</td>
					<td height="28" class="cre"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top">

					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >YEAR</td>
						<td width="50%" height="22" class="labelcol labelleft" >
						<select name="intyear" size="1" class="textInput1" style=" width:133px; ">
						<?php
							$currentYear = (int)date('Y');
							// "<option value=".$currentYear.">".$currentYear."</option>";

							for($n = $currentYear-2; $n<$currentYear+3; $n++){
								if($currentYear==$n){
									print "<option value=".$n." selected >".$n."</option>";
								} else  {
									print "<option value=".$n.">".$n."</option>";
								}

							}

						?>
						</select>
						</td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >SEMESTER</td>
						<td width="50%" height="22" class="labelcol labelleft" >
						  <select name="semester" size="1" class="textInput1" style=" width:133px; ">
						    <option value="Spring">Spring</option>
						    <option value="Summer">Summer</option>
						    <option value="Fall">Fall</option>
						    <option value="Winter">Winter</option>
				           </select>
						</td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >Group</td>
						<td width="50%" height="22" class="labelcol labelleft" >
<script type="text/javascript">
/// XP Look
webFXTreeConfig.rootIcon		= "../tree/folder.gif";
webFXTreeConfig.openRootIcon	= "../tree/openfolder.gif";
webFXTreeConfig.folderIcon		= "../tree/folder.png";
webFXTreeConfig.openFolderIcon	= "../tree/openfolder.gif";
webFXTreeConfig.fileIcon		= "../tree/folder.png";
webFXTreeConfig.lMinusIcon		= "../tree/listExpanded.png";
webFXTreeConfig.lPlusIcon		= "../tree/listCollapsed.png";
webFXTreeConfig.tMinusIcon		= "../tree/listExpanded.png";
webFXTreeConfig.tPlusIcon		= "../tree/listCollapsed.png";
webFXTreeConfig.iIcon			= "../tree/I.png";
webFXTreeConfig.lIcon			= "../tree/L.png";
webFXTreeConfig.tIcon			= "../tree/T.png";
webFXTreeConfig.blankIcon	    = "../tree/blank.png";
webFXTreeConfig.defaultTarget	= "";

</script>
<?php
	require_once("OrganizationManager.class.php");
	require_once("Organization.class.php");
	$manager = OrganizationManager::getInstance();

	//get all root organizations
	$org = new Organization();
	$org->setParentid(-1);
	$orgs = $manager->getOrganizations($org, "order by serialindex asc");

	$size = count($orgs);
	print "<script type=\"text/javascript\">";
	print "var tree = new WebFXTree(\"Groups\",\"#\");";
	for($t=0; $t<$size; $t++){
		$org = $orgs[$t];
		print "tree.add(new WebFXLoadTreeItem(\"".$org->getOrgtext()."\", \"./SelectGroupTree.php?parentid=".$org->getOrganizationid()."\", \"\"));";
	}
	print "document.write(tree);";
	print "</script>";
?>
						<input type="hidden" name="organizationid" value="-1" >
						<input type="text" name="orgname" class="textInput1" size="40">
					    </td>
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
			</div>

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