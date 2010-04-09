<?php
        require_once(dirname(__FILE__)."/OrganizationManager.class.php");
        require_once(dirname(__FILE__)."/Organization.class.php");

        $parentid = $_GET["parentid"];
        //$manager = OrganizationManager::getInstance();
        $manager = new OrganizationManager();
        $manager->disableScrollPage();

        if($parentid==null){
                //get all root organizations
                $org = new Organization();
                $org->setParentid(-1);
                $orgs = $manager->getOrganizations($org);
        } else {
                //get children organizations of the parent organization
                $org = new Organization();
                $org->setParentid($parentid);
                $orgs = $manager->getOrganizations($org);
        }

        $treeXML = "<?xml version=\"1.0\"?>";
        $treeXML = $treeXML."<tree>";
        $size = count($orgs);

        for($t=0; $t<$size; $t++){
                $org = $orgs[$t];
                $treeXML .= "\t<tree text=\"".$org->getOrgtext()."\" src=\"./OrgTree.php?parentid=".$org->getOrganizationid()."\" action=\"./OrgListController.php?parentid=".$org->getOrganizationid()."\" />\r";
        }

        $treeXML = $treeXML."</tree>";
        header("Content-type: text/xml");
        print $treeXML;

?>
