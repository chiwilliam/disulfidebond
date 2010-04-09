<?php
    require_once("User.class.php");
    require_once("UserManager.class.php");
    
    session_start();

    $user = new User();
    $usermgr = new UserManager();

if ($_REQUEST['username'] != $_SESSION['username'] && strlen($_REQUEST['username']) > 0){
        $user->setUsername($_REQUEST['username']);

        $sql = "SELECT USERID FROM USER WHERE USERNAME = '".$_REQUEST['username']."'";
        if(count($usermgr->getUsersBySQL($user, $sql)) > 0){
            $usernameexists = true;
        }
        else{
            $usernameexists = false;
        }

        if ($usernameexists){
            unset($user);
            $user = new User();
            $_SESSION['message'] = "Username already exists and could not be changed.";
        }
        else{
            $_SESSION['message'] = "Username changed to: ".$_REQUEST['username'].".";
            //$user->setUsername($_REQUEST['username']);
        }
    }

    $user->setUserid($_SESSION['userid']);
    $user->setFirstname($_REQUEST['firstname']);
    $user->setLastname($_REQUEST['lastname']);
    if (strlen($_REQUEST['password']) > 0){
        $user->setPwd($_REQUEST['password']);
    }
    $user->setEmail($_REQUEST['email']);
    $user->setPhone($_REQUEST['phone']);
    $user->setAddress($_REQUEST['address']);
    $user->setJavanetrealname($_REQUEST['javanetrealname']);
    $user->setJavanetusername($_REQUEST['javanetusername']);
    $user->setJavanetschool($_REQUEST['javanetschool']);
    $user->setJavanetstudentid($_REQUEST['javanetstudentid']);
    $user->setDescription($_REQUEST['description']);

    $usermgr->updateUser($user);
    
    $_SESSION['message'] = $_SESSION['message']."<br>Information updated successfully!";

    include "StudentProfileController.php"


?>
