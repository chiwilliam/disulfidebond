<?php
        require_once("OrganizationManager.class.php");
        require_once("Organization.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/MessageUtil.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/Message.class.php");
        require_once (dirname(__FILE__)."/../lib/common/log/Log.class.php");
        include_once(dirname(__FILE__)."/../lib/common/scrollpage/ScrollPageHead.php");

        $parentid = $_GET["parentid"];
        //print "\$parentid = $parentid<br>";

        Log::println("OrgListController.php \$parentid = $parentid");

        //$manager = OrganizationManager::getInstance();
        $manager = new OrganizationManager();
        $manager->enableScrollPage();

        if($parentid==null){
                //get all root organizations
                $org = new Organization();
                $org->setParentid(-1);
                $orgs = $manager->getOrganizations($org,"order by serialindex asc");
        } else {
                //get children organizations of the parent organization
                $org = new Organization();
                $org->setParentid($parentid);
                $orgs = $manager->getOrganizations($org, "order by serialindex asc");
        }

        include "./OrgList.php";
?>
