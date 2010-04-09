<?php
    session_start();
    
    require_once ("usermanagement.php");

    $user = new User();
    
    $user->setUsertype($_POST['usertype']);
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setEmail($_POST['email']);
    $user->setUsername($_POST['username']);
    $user->setJavanetusername($_POST['username']);
    $user->setPwd($_POST['password']);

    $orgcontrol = new Orgcontrol();
    $orgcontrol->setIntyear($_POST['intyear']);
    $orgcontrol->setSemester($_POST['semester']);
    $orgcontrol->setOrganizationid($_POST['organizationid']);
    
    $usermgr = new usermanagement();

    if ($usermgr->userexists($user)){
        $_SESSION['message'] = "User ".$user->getUsername()." already exists.<br>".
        "<a href=\"./login/createuser.php\">Create User</a><br>".
        "<a href=\"index.php\">Login</a>";
        header('Location: ../displaymessage.php');
    }
    else{
        $result = $usermgr->createuser($user,$orgcontrol);
        if($result){
            $_SESSION['message'] = "User ".$user->getUsername()." created successfully.<br>".
            "<a href=\"index.php\">Login</a>";
        }
        else{
            $_SESSION['message'] = "An error occurred while creating user ".$user->getUsername().
            ".Please try again<br><a href=\"../Login/createuser.php\">Create User</a>";
        }
        header('Location: ../displaymessage.php');
    }

?>
