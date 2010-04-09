<?php
    //required libraries
    require_once("User.class.php");
    require_once("UserManager.class.php");
    require_once("../project/Project.class.php");
    require_once("../project/ProjectManager.class.php");
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
    $project = new Project();
    //create projectmanagerobject
    $projectmgr = new ProjectManager();

    //create configuration and configurationmanager objects
    $config = new Configuration();
    $configmgr = new ConfigurationManager();

    $sql = "SELECT PROJECT.*
            FROM USER, ORGCONTROL, PROJECTORG, PROJECT
            WHERE
             USER.USERID = ORGCONTROL.USERID
             AND ORGCONTROL.ORGANIZATIONID = PROJECTORG.ORGANIZATIONID
             AND PROJECTORG.PROJECTID = PROJECT.PROJECTID
             AND USER.USERID = ".$user->getUserid();
    $projects = $projectmgr->getProjectsBySQL($project, $sql);

    if(strlen($_POST['project']) > 0){
        $project->setProjectid($_POST['project']);
    }
    else{
        if(strlen($_SESSION['projectid']) > 0){
            $project->setProjectid($_SESSION['projectid']);
        }
        else{
            //get specific project
            $project->setProjectid("0");
            $_SESSION['message'] = "Please select a Project!";
            $visible = "hidden";
        }
    }

    if ($project->getProjectid() != "0"){

        $project = $projectmgr->getProjectByID($project->getProjectid());

        $where = "parentid = ".$project->getProjectid();
        $subprojects = $projectmgr->getProjectsByWhere($project, $where, "");

        $_SESSION['projectid'] = $project->getProjectid();

        $sql = "SELECT CONFIGURATION.* FROM CONFIGURATION, CONFIGPROJECT
        WHERE CONFIGURATION.CONFIGURATIONID = CONFIGPROJECT.CONFIGURATIONID
        AND CONFIGPROJECT.PROJECTID = ".$project->getProjectid();

        $config = $configmgr->getConfigurationsBySQL($config, $sql);
        $config = $config[0];
    }
    
    include "./Project.php";

?>
