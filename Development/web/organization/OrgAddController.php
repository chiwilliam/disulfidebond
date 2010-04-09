<?php
        require_once("OrganizationManager.class.php");
        require_once("Organization.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/MessageUtil.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/Message.class.php");
        require_once (dirname(__FILE__)."/../lib/common/log/Log.class.php");

        $parentid = $_REQUEST["parentid"];
        $serialindex = $_REQUEST["serialindex"];
        $orgname = $_REQUEST["orgname"];
        $orgtext = $_REQUEST["orgtext"];
        $description = $_REQUEST["description"];
        //$description = str_replace("\r\n", "<BR>", $description);

        Log::println("OrgAddController.php \$parentid = $parentid");
        Log::println("OrgAddController.php \$serialindex = $serialindex");
        Log::println("OrgAddController.php \$orgname = $orgname");
        Log::println("OrgAddController.php \$orgtext = $orgtext");
        Log::println("OrgAddController.php \$description = $description");

        $org = new Organization();
        $org->setParentid($parentid);
        $org->setSerialindex($serialindex);
        $org->setOrgname($orgname);
        $org->setOrgtext($orgtext);
        $org->setDescription($description);

        $manager = OrganizationManager::getInstance();
        $rownum = $manager->addOrganization($org);
        MessageUtil::addMessage("organization", new Message(Message::INFO, "$rownum record has been added."));

        header ("Location: ./OrgListController.php?parentid=".$parentid);
?>
