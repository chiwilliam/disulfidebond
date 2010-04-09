<?php
    //required libraries
    require_once("User.class.php");
    require_once("UserManager.class.php");
    require_once("../organization/Organization.class.php");
    require_once("../organization/OrganizationManager.class.php");
    require_once("../configuration/Configuration.class.php");
    require_once("../configuration/ConfigurationManager.class.php");

    //start session
    session_start();
    $_SESSION['message'] = "";

    //create object user
    $user = new User();
    //create usermanagerobject
    $usermgr = new UserManager();

    //retrieve user information
    $user->setUserid($_SESSION['userid']);

    //create object Project
    $group = new Organization();
    //create projectmanagerobject
    $groupmgr = new OrganizationManager();

    //create configuration and configurationmanager objects
    $config = new Configuration();
    $configmgr = new ConfigurationManager();

    $sql = "SELECT ORGANIZATION.*
            FROM USER, ORGCONTROL, ORGANIZATION
            WHERE
            USER.USERID = ORGCONTROL.USERID
            AND ORGCONTROL.ORGANIZATIONID = ORGANIZATION.ORGANIZATIONID
            AND USER.USERID = ".$user->getUserid();

    $groups = $groupmgr->getOrganizationsBySQL($group, $sql);

    if(strlen($_POST['organization']) > 0){
        $group->setOrganizationid($_POST['organization']);
    }
    else{
        if(strlen($_SESSION['organizationid']) > 0){
            $group->setOrganizationid($_SESSION['organizationid']);
        }
        else{
            $group->setOrganizationid("0");
            //get specific project
            $_SESSION['message'] = "Please select a Group!";
            $visible = "hidden";
        }
    }

    if ($group->getOrganizationid() != "0"){

        $group = $groupmgr->getOrganizationByID($group->getOrganizationid());

        $_SESSION['organizationid'] = $group->getOrganizationid();

        $sql = "SELECT CONFIGURATION.* FROM CONFIGURATION, CONFIGORG
        WHERE CONFIGURATION.CONFIGURATIONID = CONFIGORG.CONFIGURATIONID
        AND CONFIGORG.ORGANIZATIONID = ".$group->getOrganizationid();

        $config = $configmgr->getConfigurationsBySQL($config, $sql);
        $config = $config[0];
    }
    
    include "./Group.php";

?>
