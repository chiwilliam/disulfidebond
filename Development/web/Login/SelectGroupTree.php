<?php
	require_once("../organization/OrganizationManager.class.php");
	require_once("../organization/Organization.class.php");

	$parentid = $_GET["parentid"];
	$manager = OrganizationManager::getInstance();

	if($parentid==null){
		//get all root organizations
		$orgNode = new Organization();
		$orgNode->setParentid(-1);
		$orgNodes = $manager->getOrganizations($orgNode, "");
	} else {
		//get children organizations of the parent organization
		$orgNode = new Organization();
		$orgNode->setParentid($parentid);
		$orgNodes = $manager->getOrganizations($orgNode, "");
	}

	$treeXML = "<?xml version=\"1.0\"?>";
	$treeXML = $treeXML."<tree>";
	$size = count($orgNodes);
	for($t=0; $t<$size; $t++){
		$curr_org = $orgNodes[$t];
		$treeXML .= "\t<tree text=\"".$curr_org->getOrgtext()."\" src=\"./SelectGroupTree.php?parentid=".$curr_org->getOrganizationid()."\" action=\"javascript:SetGroup('".$curr_org->getOrganizationid()."', '".$curr_org->getOrgtext()."')\" />\r";
	}

	$treeXML = $treeXML."</tree>";
       
	header("Content-type: text/xml");
	echo $treeXML;
?>




	
	
