<?php

    require_once("User.class.php");
    require_once("UserManager.class.php");

    //start session
    session_start();
    $_SESSION['message'] = "";

    $mode = $_REQUEST['mode'];

    $user = new User();
    $usermgr = new UserManager();

    $user = $usermgr->getUserByID($_SESSION['userid']);

    include "studentprofile.php"

?>
