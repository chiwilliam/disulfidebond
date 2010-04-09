<?php
        require_once("OrganizationManager.class.php");
        require_once("Organization.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/MessageUtil.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/Message.class.php");
        require_once (dirname(__FILE__)."/../lib/common/log/Log.class.php");
        
        $organizationid = $_REQUEST["organizationid"];
        $parentid = $_REQUEST["parentid"];

        $serialindex = $_REQUEST["serialindex"];
        $serialindex = $serialindex==null || $serialindex==0?"1":$serialindex;

        $orgname = $_REQUEST["orgname"];
        $orgname = $orgname==null?"":$orgname;

        $orgtext = $_REQUEST["orgtext"];
        $orgtext = $orgtext==null?"":$orgtext;

        $description = $_REQUEST["description"];
        $description = $description==null?"":$description;
        //$description = str_replace("\r\n", "<BR>", $description);

        Log::println("OrgUpdateController.php \$parentid = $parentid");
        Log::println("OrgUpdateController.php \$serialindex = $serialindex");
        Log::println("OrgUpdateController.php \$orgname = $orgname");
        Log::println("OrgUpdateController.php \$orgtext = $orgtext");
        Log::println("OrgUpdateController.php \$description = $description");

        $org = new Organization();
        $org->setOrganizationid($organizationid);
        $org->setParentid($parentid);
        $org->setSerialindex($serialindex);
        $org->setOrgname($orgname);
        $org->setOrgtext($orgtext);
        $org->setDescription($description);

        $manager = OrganizationManager::getInstance();
        $rownum = $manager->updateOrganization($org);
        MessageUtil::addMessage("organization", new Message(Message::INFO, "$rownum record has been updated."));

        header ("Location: ./OrgListController.php?parentid=".$parentid);
?>
