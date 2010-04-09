<?php
        require_once (dirname(__FILE__)."/./OrganizationManager.class.php");
        require_once (dirname(__FILE__)."/./Organization.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/MessageUtil.class.php");
        require_once (dirname(__FILE__)."/../lib/common/message/Message.class.php");
        require_once (dirname(__FILE__)."/../lib/common/log/Log.class.php");
        require_once (dirname(__FILE__)."/../orgcontrol/Orgcontrol.class.php");
        require_once (dirname(__FILE__)."/../orgcontrol/OrgcontrolManager.class.php");
        require_once (dirname(__FILE__)."/../userorgaccesscontrol/Userorgaccesscontrol.class.php");
        require_once (dirname(__FILE__)."/../userorgaccesscontrol/UserorgaccesscontrolManager.class.php");
        require_once (dirname(__FILE__)."/../orgcomment/Orgcomment.class.php");
        require_once (dirname(__FILE__)."/../orgcomment/OrgcommentManager.class.php");
        require_once (dirname(__FILE__)."/../projectorg/Projectorg.class.php");
        require_once (dirname(__FILE__)."/../projectorg/ProjectorgManager.class.php");
        require_once (dirname(__FILE__)."/../configorg/Configorg.class.php");
        require_once (dirname(__FILE__)."/../configorg/ConfigorgManager.class.php");

        /**
         * delete an organization
         * @param <type> $organizationid
         * @return <type> 0 or 1
         */
        function recursionDeleteGroup($organizationid){

                //Step1: delete all the sub organizations of current organization
                $org1 = new Organization();
                $org1->setParentid($organizationid);
                $orgManager = OrganizationManager::getInstance();
                $orgManager->disableScrollPage();
                $subOrgs = $orgManager->getOrganizations($org1, null);

                for($i=0;$i<count($subOrgs);$i++){
                        $subOrg = $subOrgs[$i];
                        if(!recursionDeleteGroup($subOrg->getOrganizationid())){
                                //if error happens when delete one of the sub organizations of  current organization
                                //then stop delete current organizatioin an return false;
                                return 0;
                        }
                }

                //Step2: delete data related to current organization
                //ORGCONTROL
                OrgcontrolManager::getInstance()->deleteOrgcontrolsBySQL("delete from ORGCONTROL where ORGANIZATIONID=$organizationid");
                //USERORGACCESSCONTROL
                UserorgaccesscontrolManager::getInstance()->deleteUserorgaccesscontrolsBySQL("delete from USERORGACCESSCONTROL where ORGANIZATIONID=$organizationid");
                //ORGCOMMENT
                OrgcommentManager::getInstance()->deleteOrgcommentsBySQL("delete from ORGCOMMENT where ORGANIZATIONID=$organizationid");
                //PROJECTORG
                ProjectorgManager::getInstance()->deleteProjectorgsBySQL("delete from PROJECTORG where ORGANIZATIONID=$organizationid");
                //CONFIGORG
                ConfigorgManager::getInstance()->deleteConfigorgsBySQL("delete from CONFIGORG where ORGANIZATIONID=$organizationid");

                //Step3: delete current organization
                $deleteOrg = new Organization();
                $deleteOrg->setOrganizationid($organizationid);
                //deleteOrganization() method returns 0 or 1 (record number deleted by operation)
                $orgManager = new OrganizationManager();
                return $orgManager->deleteOrganization($deleteOrg);
        }

        $parentid = $_REQUEST["parentid"];
        $organizatioinids = $_REQUEST["organizationids"];        

        Log::println("OrgDeleteController.php \$parentid = $parentid");

        for($i=0;$i<count($organizatioinids);$i++){
                //print $organizatioinids[$i]."<br>";
                Log::println("OrgDeleteController.php \$organizatioinids[$i] = $organizatioinids[$i]");

                if(recursionDeleteGroup($organizatioinids[$i])){
                        MessageUtil::addMessage("organization", new Message(Message::INFO, "Organization record (organizatioinid=$organizatioinids[$i]) has been deleted successfully."));
                } else {
                        MessageUtil::addMessage("organization", new Message(Message::ERROR, "Failed to delete Organization record (organizatioinid=$organizatioinids[$i])."));
                }
        }

        header ("Location: ./OrgListController.php?parentid=".$parentid);
?>
