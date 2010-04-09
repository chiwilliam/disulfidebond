<?php

    require_once ("./usermanagement.php");

    $user = new User();

    $user->setUsername($_POST['username']);
    $user->setPwd($_POST['password']);

    $usermgr = new usermanagement();

    if($usermgr->retrieveuser($user,'login')){
        $usermgr->setsessionwithuserinfo($user);
        if($user->getUsertype() == 'Student'){
            header('Location: ../User/UserMainController.php');
        }
        else{
            header('Location: ../Instructor/UserMainController.php');
        }
    }
    else{
        session_start();
        session_destroy();
        session_start();
        $_SESSION['loggedin'] = false;
        $_SESSION['message'] = "Username and/or password invalid!";
        session_commit();
        header('Location: ../index.php');
    }

?>
