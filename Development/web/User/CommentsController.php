<?php
    //required libraries
    require_once("User.class.php");
    require_once("UserManager.class.php");
    require_once("../organization/Organization.class.php");
    require_once("../organization/OrganizationManager.class.php");
    require_once("../project/Project.class.php");
    require_once("../project/ProjectManager.class.php");
    require_once("../orgcomment/Orgcomment.class.php");
    require_once("../orgcomment/OrgcommentManager.class.php");

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

    $sql = "SELECT PROJECT.*
            FROM USER, ORGCONTROL, PROJECTORG, PROJECT
            WHERE
             USER.USERID = ORGCONTROL.USERID
             AND ORGCONTROL.ORGANIZATIONID = PROJECTORG.ORGANIZATIONID
             AND PROJECTORG.PROJECTID = PROJECT.PROJECTID
             AND USER.USERID = ".$user->getUserid();
    $projects = $projectmgr->getProjectsBySQL($project, $sql);

    $projectid = $_POST['project'];
    if (strlen($projectid) > 0){
        $projectselected = true;
    }
    else{
        if (strlen($_SESSION['projectid']) > 0){
            $projectid = $_SESSION['projectid'];
            $projectselected = true;
        }
        else{
            $projectselected = false;
        }
    }

    //mount organization/group drop down menu
    $group = new Organization();
    $groupmgr = new OrganizationManager();
    if (strlen($projectid) == 0){
        $pid = "0";
    }
    else{
        $pid = $projectid;
    }
    $sql = "SELECT ORGANIZATIONID, ORGNAME FROM ORGANIZATION WHERE ORGANIZATIONID IN
    (SELECT ORGANIZATIONID FROM PROJECTORG WHERE PROJECTID = ".$pid." AND ORGANIZATIONID IN
    (SELECT ORGANIZATIONID FROM ORGCONTROL WHERE USERID = ".$_SESSION['userid'].
    ")) ORDER BY ORGNAME";
    $groups = $groupmgr->getOrganizationsBySQL($group, $sql);

    $organizationid = $_POST['organization'];
    $message = "";

   if (strlen($projectid) == 0 && strlen($_SESSION['projectid']) == 0){
        $message = "Please select a project";
        $_SESSION['projectid'] = "";
    }
    else{
        if (strlen($projectid) != 0){
            $_SESSION['projectid'] = $projectid;
        }
        else{
            $projectid = $_SESSION['projectid'];
        }
    }

    if (strlen($organizationid) == 0 && strlen($_SESSION['organizationid']) == 0){
        if (strlen($projectid) == 0){
            $message = $message." and a group";
        }
        else{
            $message = "Please select a group";
        }
        $_SESSION['organizationid'] = "";
    }
    else{
        if (strlen($organizationid) != 0){
            $_SESSION['organizationid'] = $organizationid;
        }
        else{
            $organizationid = $_SESSION['organizationid'];
        }
    }

    if (strlen($message) == 0){

        //create orgcomments and orgcommentsmanager objects
        $comment = new Orgcomment();
        $commentmgr = new OrgcommentManager();

        $project = $projectmgr->getProjectByID($project->getProjectid());

        $sql = "SELECT * FROM ORGCOMMENT WHERE ORGANIZATIONID = ".$organizationid.
            " AND PROJECTID = ".$projectid." ORDER BY PUBDATE DESC";

        $comments = $commentmgr->getOrgcommentsBySQL($comment, $sql);
    }
    else{
        $_SESSION['message'] = $message;
        $comments = array();
    }
    include "./Comments.php";

?>
