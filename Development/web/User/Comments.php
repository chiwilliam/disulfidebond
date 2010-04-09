<?php session_start(); if($_SESSION['loggedin'] == false){ header('Location: ../index.php');} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker - Comments Information</title>
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
            <div id="filters">
                <!-- table with filters -->
                <form name="filtersform" method="post" action="./CommentsController.php">
                <table align="center" width="300" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="5" align="center"><font color="red"><?php echo $_SESSION['message']?></font></td>
                    </tr>
                    <tr>
                        <td align="right" width="100">Project:</td>
                        <td align="left" width="150">
                            <select name="project" onchange="this.form.submit();">
                            <option value="">-Please Select One-</option>
                            <?php
                                for ($i=0; $i<count($projects); $i++){
                                    if($projects[$i]->getProjectid() == $_SESSION['projectid']){
                                        echo '<option selected value="'.$projects[$i]->getProjectid().
                                             '">'.$projects[$i]->getProjectname().'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$projects[$i]->getProjectid().
                                             '">'.$projects[$i]->getProjectname().'</option>';
                                    }
                                }
                            ?>
                            </select></td>
                        <td align="right" width="100">Group:</td>
                        <td align="left" width="150">
                            <select name="organization" onchange="this.form.submit();">
                            <option value="">-Please Select One-</option>
                            <?php
                                if ($projectselected == true)
                                {
                                    for ($i=0; $i<count($groups); $i++){
                                        if($groups[$i]->getOrganizationid() == $_SESSION['organizationid']){
                                            echo '<option selected value="'.$groups[$i]->getOrganizationid().
                                                 '">'.$groups[$i]->getOrgname().'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$groups[$i]->getOrganizationid().
                                                 '">'.$groups[$i]->getOrgname().'</option>';
                                        }
                                    }
                                }
                            ?>
                            </select></td>
                        <td align="right" width="100">
                            <input name="btnsubmit" type="submit" align="right" value="" class="displayButton" /></td>
                    </tr>
                </table>
                </form>
            </div>
            <form id="dataform" name="dataform">
            <table width="500" align="center">
                <tr>
                    <td><b>Comments regarding Group-2:</b></td>
                </tr>
                <tr>
                    <td><textarea name="comments" rows="15" cols="80" readonly="readonly" style="font-size:small">
<?php
    for($i=0; $i<count($comments);$i++){
        $user = $usermgr->getUserByID($comments[$i]->getUserid());
        echo "Date: ".$comments[$i]->getPubdate()."\n";
        echo "Author: ".$user->getFirstname()." ".$user->getLastname()."\n";
        echo "Title: ".$comments[$i]->getTitle()."\n";
        echo "Comment: ".$comments[$i]->getContent()."\n\n";
    }
?>
                    </textarea></td>
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
</div>
</body>
</html>
