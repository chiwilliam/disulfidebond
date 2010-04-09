<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker</title>
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

        <!-- content start-->
        <div id="content">
            <form id="forgotpassform" name="forgotpassform" method="post" action="forgotpasswordcontroller.php">
              <table id="forgotpasstable" width="400">
                <tr>
                    <td colspan="2"><font color="red"><?php echo $_SESSION['message']; $_SESSION['message'] = ""; ?></font></td>
                </tr>
                <tr>
                    <td width="100" align="right"><label>User Name:</label></td>
                    <td width="50" align="right"><input type="text" name="username" id="username" /></td>
                </tr>
                <tr>
                    <td width="100" align="right"><label>Email:</label></td>
                    <td width="50" align="right"><input type="text" name="email" id="email" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input name="submit" type="submit" value="" class="sendButton" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><a href="../index.php">Home</a></td>
                </tr>
              </table>
            </form>
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
