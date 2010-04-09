<?php
    //required libraries
    require_once("DataMap.php");
    require_once("User.class.php");
    require_once("UserManager.class.php");
    require_once("../Category/Category.class.php");
    require_once("../Category/CategoryManager.class.php");
    require_once("../GoogleCharts/mycharts.php");
    require_once("../organization/Organization.class.php");
    require_once("../organization/OrganizationManager.class.php");
    require_once("../project/Project.class.php");
    require_once("../project/ProjectManager.class.php");
    require_once("../projectorg/Projectorg.class.php");
    require_once("../projectorg/ProjectorgManager.class.php");
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
    $user = $usermgr->getUser($user);

    //mount project drop down menu
    $config = new Configuration;
    $configmgr = new ConfigurationManager();
    $sql = "SELECT CONFIGURATIONID, CONFIGURATIONNAME FROM CONFIGURATION WHERE CONFIGURATIONID IN
    (SELECT CONFIGURATIONID FROM CONFIGINSTRUCTOR WHERE USERID = ".$_SESSION['userid'].")".
    " ORDER BY CONFIGURATIONNAME";
    $configs = $configmgr->getConfigurationsBySQL($config, $sql);

    $configid = $_POST['configuration'];
    if (strlen($configid) > 0){
        $configurationselected = true;
        $_SESSION['configid'] = $configid;
    }
    else{
        if (strlen($_SESSION['configid']) > 0){
            $configid = $_SESSION['configid'];
            $configurationselected = true;
            $_SESSION['configid'] = $configid;
        }
        else{
            $configurationselected = false;
        }
    }

    //mount project drop down menu
    $project = new Project();
    $projectmgr = new ProjectManager();
    if (strlen($configid) == 0){
        $cfgid = "0";
    }
    else{
        $cfgid = $configid;
    }
    $sql = "SELECT PROJECTID, PROJECTNAME FROM PROJECT WHERE PROJECTID IN
    (SELECT PROJECTID FROM CONFIGPROJECT WHERE CONFIGURATIONID = ".$cfgid.")".
    " ORDER BY PROJECTNAME";
    $projects = $projectmgr->getProjectsBySQL($project, $sql);

    $projectid = $_POST['project'];
    if (strlen($projectid) > 0){
        $projectselected = true;
        $_SESSION['projectid'] = $projectid;
    }
    else{
        if (strlen($_SESSION['projectid']) > 0){
            $projectid = $_SESSION['projectid'];
            $projectselected = true;
            $_SESSION['projectid'] = $projectid;
        }
        else{
            $projectselected = false;
        }
    }

    //mount organization/group drop down menu
    $org = new Organization();
    $orgmgr = new OrganizationManager();
    if (strlen($projectid) == 0){
        $pid = "0";
    }
    else{
        $pid = $projectid;
    }
    $sql = "SELECT ORGANIZATIONID, ORGNAME FROM ORGANIZATION WHERE ORGANIZATIONID IN
    (SELECT ORGANIZATIONID FROM PROJECTORG WHERE PROJECTID = ".$pid." AND CONFIGURATIONID = ".$cfgid.
    ") ORDER BY ORGNAME";
    $orgs = $orgmgr->getOrganizationsBySQL($org, $sql);
    
    $organizationid = $_POST['organization'];

    $message = "";

    if(count($_REQUEST['selected']) == 0 && count($_REQUEST['type']) == 0){
        $selected = "group";
        $type = "total";
        $chartdescription = "Total posts for group by category";
    }
    else{
        $selected = $_REQUEST['selected'];
        $type = $_REQUEST['type'];
        if ($type == "student" || ($type == "total" && $selected == "group")){
            $chartdescription = "Total posts for ".$selected." by category";
        }
        else{
            if ($type == "total" && $selected == "category"){
                $chartdescription = "Total posts for group by students";
            }
            else{
                $chartdescription = "Total posts for ".$selected." by students";
            }
        }
    }
    
    if ((strlen($type) == 0 || $type == "total") && strlen($configid) == 0 
        && strlen($_SESSION['configid']) == 0){
        $message = "Please select a configuration";
        $visible = "hidden";
        $_SESSION['configid'] = "";
    }
    else{
        if (strlen($configid) != 0){
            $_SESSION['configid'] = $configid;
        }
        else{
            $configid = $_SESSION['configid'];
        }
    }

    if ((strlen($type) == 0 || $type == "total") && strlen($projectid) == 0
        && strlen($_SESSION['projectid']) == 0){
        if (strlen($configid) == 0){
            $message = $message." first and then a project";
        }
        else{
            $message = "Please select a project";
        }
        $visible = "hidden";
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

    if ((strlen($type) == 0 || $type == "total") && strlen($organizationid) == 0
        && strlen($_SESSION['organizationid']) == 0){
        if (strlen($projectid) == 0){
            $message = $message." and finally a group";
        }
        else{
            $message = "Please select a group";
        }
        $visible = "hidden";
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

        //create organization-project object
        $projectorg = new Projectorg();
        //create organization-projects manager object
        $projectorgmgr = new ProjectorgManager();

        $projectorg->setProjectid($projectid);
        $projectorg->setOrganizationid($organizationid);
        $projectorg->setConfigurationid($configid);

        $projectorgs = $projectorgmgr->getProjectorgs($projectorg, "PROJECTID DESC");

        if (count($projectorgs) == 0){
            //$message = "No groups were found. Please make a valid selection.";
            $visible = "hidden";
            $_SESSION['message'] = $message;
        }
        else{

            //get users from the same group
            $sql = "SELECT USER.* FROM USER, ORGCONTROL WHERE USER.USERID = ORGCONTROL.USERID
                        AND ORGCONTROL.ORGANIZATIONID = ".$organizationid.
                        " ORDER BY USER.FIRSTNAME ASC, USER.LASTNAME ASC";
            $users = $usermgr->getUsersBySQL($user, $sql);

            //create category object
            $category = new Category();
            //create category manager object
            $categorymgr = new CategoryManager();

            //get categories from a project
            $category->setProjectid($projectorg->getProjectid());
            $categories = $categorymgr->getCategorys($category, "");

            //mount DataMap with info
            $datamap = DataMap($users, $categories,$selected, $type);

            if (count($datamap[0]) == 0){
                $visible = "hidden";
            }

            $report = $datamap;
            unset($report[count($report)-1]);
            $_SESSION['report'] = $report;

        }

    }
    else{
        $_SESSION['message'] = $message;
    }

    include "./UserMain.php";

?>
