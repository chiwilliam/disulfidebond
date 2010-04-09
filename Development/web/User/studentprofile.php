<?php session_start(); if($_SESSION['loggedin'] == false){ header('Location: ../index.php');} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker - Student Profile</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../css/menustyle.css" >
<script type="text/javascript" src="../coolmenupro/coolmenupro.js" ></script>
<script>
	function changeClass(obj, name) {
		obj.className = name;
	}
</script>
<style>
.nameoftheclass {

}
</style>
</head>
<body>
<div id="container">
	<!-- header -->
    <div id="header">
        <div align="right"><font color="white" size="2">
                        <?php if($_SESSION['loggedin'] == true){echo "Logged in: ".$_SESSION['username']." |
                        <a href='../logout.php'>Logout</a>"; } else { echo "<a href='../index.php'>Login</a>";} ?>
                        </font></div>
        <div id="logo"><a href="../index.php"><span class="orange">PRODUCTIVITY</span>
			TRACKER</a></div>
    </div>
    <!--end header -->

    <!-- main -->
    <div id="main">
		<!--menu begin-->
	 	<div id="menu">
			<?php if($mode == "student"){
                echo '<script type="text/javascript" src="../coolmenupro/menu_student.js" ></script>';
            }
            else{
                echo '<script type="text/javascript" src="../coolmenupro/menu_student.js" ></script>';
            }
            ?>
            
			<script type="text/javascript">CLoadNotify();</script>
		</div>
		<!--menu end-->
        <!-- content start-->

        <div id="content">
            <div id="banner1">
				<h2><?php echo $mode; ?> Profile Page</h2>
				This page displays your profile. Please make sure you have the most up-to-date information in the system.
			</div>
            <div align="center">
                <font size="2" color="red"><?php echo $_SESSION['message']; $_SESSION['message'] = "";?></font>
            </div>
            <form id="dataform" name="dataform" action="UpdateProfileController.php">
            <table align="center" border="5px" id="studentinfo" width="400">
                <tr>
                    <td width="150"><LABEL>First Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" id="firstname" name="firstname" value="<?php echo $user->getFirstname();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Last Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="lastname" value="<?php echo $user->getLastname();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>User Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="username" value="<?php echo $user->getUsername();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Password:</LABEL></td>
                    <td width="200"><input size="30" type="password" name="password" value="<?php echo $user->getPwd();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Email:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="email" value="<?php echo $user->getEmail();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Phone:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="phone" value="<?php echo $user->getPhone();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Address:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="address" value="<?php echo $user->getAddress();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Java.net Real Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="javanetrealname" value="<?php echo $user->getJavanetrealname();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Java.net User Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="javanetusername" value="<?php echo $user->getJavanetusername();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Java.net School:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="javanetschool" value="<?php echo $user->getJavanetschool();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Java.net StudentID:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="javanetstudentid" value="<?php echo $user->getJavanetstudentid();?>" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Extra Details:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="description" value="<?php echo $user->getDescription();?>" /></td>
                </tr>
            </table>
            <table align="center">
                <tr>
                    <td width="50"></td>
                    <td width="150"></td>
                    <td width="150" align="right"><input name="submit" type="submit" value="" class="saveButton" /></td>
                </tr>
            </table>
            </form>
        </div>
        <!--content end-->
            <script language="javascript">

                function save(){
                    alert("Item saved Successfully.");
                }
            </script>
    </div>
    <!-- end main -->

    <!-- footer -->
    <div id="footer">
		<div id="left_footer">&copy; Copyright 2008 CSC 848 Group2
		</div>
		<div id="right_footer">
			Design by <a href="../index.php" title="Website Design">Group2 Members</a>
		</div>
    </div>
    <!-- end footer -->
</div>
</body>
</html>
