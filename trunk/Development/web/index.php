<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker</title>
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<link rel="stylesheet" type="text/css" href="./css/menustyle.css" >
<script type="text/javascript" src="./coolmenupro/coolmenupro.js" ></script>
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
                        <a href='./logout.php'>Logout</a>"; } else { echo "<a href='./index.php'>Login</a>";} ?>
                        </font></div>
        <div id="logo"><a href="index.php"><span class="orange">PRODUCTIVITY</span>
        TRACKER</a></div>
    </div>
    <!--end header -->

    <!-- main -->
    <div id="main">

        <!-- content start-->
        <div align="center" id="content">
            <!-- WILLIAM'S CODE - BEGIN-->
            <table width="969" border="0">
              <tr>
                <td width="336"><img src="images/UN.jpg" width="320" height="240" /></td>
                <td width="400"><font color="black" size="3" style="font-weight:bold">
                    <table>
                        <tr>
                            <td align="center">CSC848 - SOFTWARE ENGINEERING</td>
                        </tr>
                        <tr>
                            <td align="center">PRODUCTIVITY TRACKER</td>
                        </tr>
                        <tr>
                            <td align="center">SFSU - SAN FRANCISCO STATE UNIVERSITY</td>
                        </tr>
                    </table></font>
                <td>
                    <form id="form1" name="form1" method="post" action="./Login/logincontroller.php">
                    <div align="right">
                      <table>
                        <tr>
                            <td align="right"><label><font size="2" style="font-weight:bold">Instructors and Students</font></label></td>
                        </tr>
                        <tr>
                            <td align="right"><label><font size="2" style="font-weight:bold">Login here to get started</font></label></td>
                        </tr>
                        <tr>
                            <?php
                                echo '<td><font size="2" color="red">';
                                if ($_SESSION['message'] != "Please select a project and a group"
                                || $_SESSION['message'] != "Please select a project"
                                || $_SESSION['message'] != "Please select a group"){
                                    $_SESSION['message'] = "";
                                }
                                echo $_SESSION['message'];
                                $_SESSION['message'] = "";
                                echo '</font></td>';
                            ?>
                        </tr>
                        <tr>
                            <td><label>Username:</label><input type="text" name="username" id="username" /></td>
                        </tr>
                        <tr>
                            <td><label>Password:</label><input name="password" type="password" id="password" /></td>
                        </tr>
                        <tr>
                            <td align="right"><input name="submit" type="submit" value="" class="loginButton" /></td>
                        </tr>
                      </table>
                    </div>
                  </form>
                  <p align="right"><a href="./Login/forgotpassword.php">Forgot Password?</a></p>
                  <p align="right"><a href="./Login/createuser.php">Create New User</a></p>
                </td>
              </tr>
            </table>
            <table width="967" border="0">
              <tr>
                <th width="957" scope="row"><div align="left">
                  <p align="justify">It has become apparent throughout the
				  software industry that to become successful, programmers need
				  to become proficient in teamwork, communication, organization,
				  and other such soft skills. While there are now courses in
				  computer science that endeavor to teach these skills, there
				  are unfortunately very few tools available that actively
				  measure how well a software-team actually applies such skills.</p>
                  <p align="justify"><br />
                    <strong>Productivity Tracker</strong> is a web-based tool
				  designed to aid in measuring these nebulous concepts. With
				  this tool, instructors shall be able to set up a project
				  participation metrics reporting suite at the beginning of an
				  academic term. Once the service has been setup, the suite
				  shall then automatically log and register activity on mailing
				  lists and discussion forums in real time throughout the
				  academic term via RSS feeds.<br />
                    At any time during the academic term, the instructor shall
				  also be able to generate reports of a given group mailing
				  list and discussion board activity either in a tabular format
				  or a graphical format. The instructor should then be able to
				  compare this data with similar data from other groups during
				  that particular academic term. <strong>Productivity Tracker</strong>
				  shall also be able to generate alerts for the instructors if
				  there is a long period of inactivity from a given group of
				  students.</p>
                  <p align="justify"><br />
                    With <strong>Productivity Tracker</strong>, our development
				  group shall allow both instructors and students to have a
				  qualitative measurement of soft skills. There are very few
				  products out in the market that can do these things, and our
				  development team believes that Productivity Tracker shall
				  greatly aid computer courses that aim to teach more than just
				  the hard facts of computer programming.</p>
                </div></th>
              </tr>
              </table>
          <!-- WILLIAM'S CODE - END-->
        </div>
        <!--content end-->
    </div>
    <!-- end main -->

    <!-- footer -->
    <div id="footer">
		<div id="left_footer">&copy; Copyright 2008 CSC 640/848 Group2
		</div>
		<div id="right_footer">
			Design by <a href="index.php" title="Website Design">Group2 Members</a>
		</div>
    </div>
    <!-- end footer -->
</div>
</body>
</html>
