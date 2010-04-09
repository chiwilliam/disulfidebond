<?php session_start(); if($_SESSION['loggedin'] == false){ header('Location: ../index.php');} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker - Student Group Information</title>
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
			<script type="text/javascript" src="../coolmenupro/menu_student.js" ></script>
			<script type="text/javascript">CLoadNotify();</script>
		</div>
		<!--menu end-->
        <!-- content start-->
        <div id="content">
            <form id="dataform" name="dataform">
            <table border="5px" id="studentinfo" width="400">
                <tr>
                    <td width="150"><LABEL>Semester:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="phone" value="Fall 2008" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>University:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="email" value="SFSU" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Course Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="username" value="CSC 848" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Project Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="lastname" value="PPM" /></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Group Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" id="firstname" name="firstname" value="Group 2" /></td>
                </tr>
            </table>
            </form>
            <table>
                <tr>
                    <td width="50"></td>
                    <td width="150"></td>
                    <td width="150"><img src="../images/button/short/blue_save.png" onclick="save()"></td>
                </tr>
            </table>
        </div>
        <!--content end-->
            <script language="javascript">

                function save(){
                    alert("Item saved Successfully.");
                }
            </script>
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
