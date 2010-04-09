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

<script type="text/javascript" src="../include/formverify/extendString.js" ></script>
<script type="text/javascript" src="../include/formverify/formVerify.js" ></script>
<script type="text/javascript" src="../include/formverify/runFormVerify.js" ></script>

<script>
	function changeClass(obj, name) {
		obj.className = name;
	}

	function _Checkall(){
		unitids = ",";
		var obj = document.getElementsByName("organizationids[]");
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

	function showOrgInfo(organizationid, parentid, serialindex, orgname, orgtext, description){
		document.infoform.organizationid.value = organizationid;
		document.infoform.parentid.value = parentid;
		document.infoform.serialindex.value = serialindex;
		document.infoform.orgname.value = orgname;
		document.infoform.orgtext.value = orgtext;
		while(description.indexOf("<BR>")>=0){
			description = description.replace("<BR>","\r\n");
		}		
		document.infoform.description.value = description;
	}

	function _add(){
		if(checkInput()){
			document.infoform.action="./OrgAddController.php";
			document.infoform.submit();
		}
	}

	function _update(){
		if(checkInput()){
			document.infoform.action="./OrgUpdateController.php";
			document.infoform.submit();
		}
	}

	function _delete(){
		var formObject = document.getElementsByName("organizationids[]");
		var length = formObject.length;
		var selected = false;
		for(var i = 0;i<length;i++){
			if(formObject[i].checked==true){
				selected = true;
				break;
			}
		}
		
		if(selected==false){
			outputMsgs("To delete an organization please click checkbox on right side of the Organization list table.");
			return;		
		}
		
		var ok=confirm("Are you sure you want to delete selected organization records?");
		if(ok){
			document.listform.action="./OrgDeleteController.php";
			document.listform.submit();
		}
	}
	
	function checkInput(){
		var isValid = true;
		
		//serialindex can't be null
		var verify = nullVerify(document.infoform.serialindex);
		if(verify!="SUCCESS"){
			outputMsgs(verify, "warn");
			isValid = false;
		}
		
		//serialindex should be integer
		var verify = numberVerify(document.infoform.serialindex);
		if(verify!="SUCCESS"){
			//info/debug/warn/error/fatal
			outputMsgs(verify, "warn");
			isValid = false;
		}
		
		//orgname can't be null
		var verify = nullVerify(document.infoform.orgname);
		if(verify!="SUCCESS"){
			outputMsgs(verify, "warn");
			isValid = false;
		}		

		//orgtext can't be null
		var verify = nullVerify(document.infoform.orgtext);
		if(verify!="SUCCESS"){
			outputMsgs(verify, "warn");
			isValid = false;
		}		
		return isValid;
	}
</script>

</head>
<body>
<div id="container">
	<!-- header -->
    <div id="header">
    	<div id="logo"><a href="#"><span class="orange">PRODUCTIVITY</span> TRACKER</a></div>
		<!--
        <div id="module">
        	<ul>
				<li><a href="#">PPM Project</a></li>
				<li><a href="#" class="active">Configuration</a></li>
            </ul>
        </div>
		-->
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
					<td height="28" class="cle"></td>
					<td height="28" class="che title1 space1">Group</td>
					<td height="28" class="cre"></td>
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
	//require_once("OrganizationManager.class.php");
	//require_once("Organization.class.php");

	//$manager = OrganizationManager::getInstance();
	$manager = new OrganizationManager();
	$manager->disableScrollPage();

	//get all root organizations
	$org = new Organization();
	$org->setParentid(-1);
	$orgNodes = $manager->getOrganizations($org,null);

	$size = count($orgNodes);
	print "<script type=\"text/javascript\">";
	print "var tree = new WebFXTree(\"Groups\",\"./OrgListController.php\");";
	for($t=0; $t<$size; $t++){
		$orgNode = $orgNodes[$t];
		print "tree.add(new WebFXLoadTreeItem(\"".$orgNode->getOrgtext()."\", \"./OrgTree.php?parentid=".$orgNode->getOrganizationid()."\", \"./OrgListController.php?parentid=".$orgNode->getOrganizationid()."\"));";
	}
	print "document.write(tree);";
	print "tree.expandAll();";
	print "</script>";
?>
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

	<?php
		require_once (dirname(__FILE__)."/../lib/common/message/MessageUtil.class.php");
		require_once (dirname(__FILE__)."/../lib/common/message/Message.class.php");
		$_msgs = MessageUtil::popMessages("organization");
	?>
	<div id="msgWindow" <?php if(count($_msgs)<=0){ ?>style="display:none" <?php } ?> >
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
		  <tr>
			<td height="28" class="cl"></td>
			<td height="28" class="ch title1 space1">Message</td>
			<td height="28" class="cr"></td>
		  </tr>
		  <tr>
			<td class="bl"></td>
			<td id="outputMsg" valign="top" style="padding:5px; ">
			<?php
				for($m=0; $m<count($_msgs); $m++){
					$_msg = $_msgs[$m];
					//print "class = ".get_class($_msg)."<br>";
					$_img = $_msg->getImage();
					$_content = $_msg->getContent();
					$_color = $_msg->getColor();
					print "<img src=\"../images/node/$_img\"><font color=\"$_color\" >$_content</font><br>";
				}
			?>
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
	</div>


				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_row_border">
				<form name="listform" method="post" action="">
				  <input type="hidden" name="parentid" value="<?php print $parentid ?>">
				  <tr>
					<td height="28" class="cle"></td>
					<td height="28" class="che title1 space1">Groups List</td>
					<td height="28" class="cre"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                      <tr class="rowhead">
                        <td width="10%" height="22" class="data_td_border" >index</td>
                        <td width="20%" height="22" class="data_td_border" >name</td>
                        <td width="20%" height="22" class="data_td_border" >text</td>
						<td width="30%" height="22" class="data_td_border" >description</td>
						<td width="10%" height="22" class="data_td_border" >edit</td>
                        <td width="10%" height="22" >select<input type="checkbox" name="allcheck" onClick="_Checkall()" value="0" ></td>
                      </tr>
<?php
	$size = count($orgs);
	//print $size;
	for($i=0; $i<$size; $i++){
		$org = $orgs[$i];
		if($i % 2==0){
			$rowStyle = "rowdd";
		}else{
			$rowStyle = "roweven";
		}
?>
                      <tr class="<?php echo $rowStyle;?>" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, '<?php echo $rowStyle;?>')" >
                        <td width="10%" height="22" class="data_td_border tdcenter" ><?php echo $org->getSerialindex()==null?"":$org->getSerialindex();?></td>
                        <td width="20%" height="22" class="data_td_border tdleft" ><?php echo $org->getOrgname()==null?"":$org->getOrgname();?></td>
                        <td width="20%" height="22" class="data_td_border tdleft" ><?php echo $org->getOrgtext()==null?"":$org->getOrgtext();?></td>
						<td width="30%" height="22" class="data_td_border tdleft" ><?php echo $org->getDescription()==null?"": str_replace("\r\n", "<BR>", $org->getDescription());?></td>
						<td width="10%" height="22" class="data_td_border tdcenter" >
						<img src="../images/button/small/editButton.png" style="cursor:hand; "
						onClick="showOrgInfo('<?php echo $org->getOrganizationid();?>', '<?php echo $org->getParentid();?>', '<?php echo $org->getSerialindex();?>', '<?php echo $org->getOrgname();?>', '<?php echo $org->getOrgtext();?>', '<?php echo str_replace("\r\n", "<BR>", $org->getDescription());?>');">
						</td>
                        <td width="10%" height="22" class="tdcenter" ><input type="checkbox" name="organizationids[]" value="<?php echo $org->getOrganizationid();?>"></td>
                      </tr>
<?php
	}
?>
                      <tr class="roweven">
                        <td height="22" colspan="6" class="tdcenter" >
							<?php include_once(dirname(__FILE__)."/../lib/common/scrollpage/ScrollPageBar.php");?>
						</td>
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
			  <br />
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				<form name="infoform" method="post" action="">
				  <input type="hidden" name="organizationid" value="-1" >
				  <input type="hidden" name="parentid" value="<?php echo $parentid; ?>" >
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
						<td width="50%" height="22" class="labelcol labelleft" ><input name="orgname" type="text" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >text</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input name="orgtext" type="text" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >description</td>
						<td width="50%" height="22" class="labelcol labelleft" ><textarea name="description" cols="52" rows="6" class="desc"></textarea></td>
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
                          <td><input name="Submit" type="button" class="blue_addButton" value="" onClick="_add();"></td>
                          <td><input name="Submit" type="button" class="blue_updateButton" value="" onClick="_update();"></td>
                          <td><input name="Submit" type="button" class="red_deleteButton" value="" onClick="_delete();"></td>
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