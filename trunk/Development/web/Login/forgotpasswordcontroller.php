<?php
    session_start();

    require_once "usermanagement.php";
    
    $user = new User();
    $user->setUsername($_POST['username']);
    $user->setEmail($_POST['email']);

    $usermgr = new UserManagement();

    if($usermgr->retrieveuser($user,'forgotpass')){
        $_SESSION['message'] = "Your credentials are:<br>User name: ".$user->getUsername().
        "<br>Password: ".$user->getPwd()."<br><br>Email sent successfully to: ".$user->getEmail().
        "<br><br><a href=\"index.php\">Login</a>";
        session_commit();
        header("Location: ../displaymessage.php");
    }
    else{
        $_SESSION['message'] = "User name and email do not exist in our database.<br>".
        "<a href=\"./Login/forgotpassword.php\">Forgot Password</a><br><a href=\"index.php\">Login</a><br>";
        session_commit();
        header("Location: ../displaymessage.php");
    }

?>
