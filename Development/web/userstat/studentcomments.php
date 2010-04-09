<?php session_start(); if($_SESSION['loggedin'] == false){ header('Location: ../index.php');} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker - Comments for Student's group</title>
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
            <table width="500">
                <tr>
                    <td><b>Comments regarding Group-2:</b></td>
                </tr>
                <tr>
                <td><textarea name="comments" rows="15" cols="80" readonly="readonly">
Author: Dr. Petkovic
Date: 2008-11-17 19:21PM
Comment: If you guys do not deliver your software by the end of Thanksgiving week, you're in deep doo doo.

Author: Gary Thompson
Date: 2008-11-17 19:05PM
Comment: This group must focus on Milestones deliveries, not on building a complex application.

Author: Dr. Petkovic
Date: 2008-11-17 19:21PM
Comment: If you guys do not deliver your software by the end of Thanksgiving week, you're in deep doo doo.

Author: Gary Thompson
Date: 2008-11-17 19:05PM
Comment: This group must focus on Milestones deliveries, not on building a complex application.

Author: Dr. Petkovic
Date: 2008-11-17 19:21PM
Comment: If you guys do not deliver your software by the end of Thanksgiving week, you're in deep doo doo.

Author: Gary Thompson
Date: 2008-11-17 19:05PM
Comment: This group must focus on Milestones deliveries, not on building a complex application.
</textarea></td>
                </tr>
            </table>
        </div>
        <!--content end-->
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
