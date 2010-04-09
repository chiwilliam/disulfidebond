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
			<script type="text/javascript" src="../coolmenupro/menu_instructor_william.js" ></script>
			<script type="text/javascript">CLoadNotify();</script>
		</div>
		<!--menu end-->
        <!-- content start-->
        <div id="content">
            <div id="filters">
                <!-- table with filters -->
                <form id="filtersform" name="filtersform" method="post" action="./CommentsController.php?mode=filters">
                <table align="center" width="800" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" colspan="7">
                            <font color="red"><b><?php echo $_SESSION['message']; ?></b></font></td>
                    </tr>
                    <tr>
                        <td align="right" width="100">Configuration:</td>
                        <td align="left" width="150">
                            <select name="configuration" onchange="this.form.submit();">
                            <option value="">-Please Select One-</option>
                            <?php
                                for ($i=0; $i<count($configs); $i++){
                                    if($configs[$i]->getConfigurationid() == $_SESSION['configid']){
                                        echo '<option selected value="'.$configs[$i]->getConfigurationid().
                                             '">'.$configs[$i]->getConfigurationname().'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$configs[$i]->getConfigurationid().
                                             '">'.$configs[$i]->getConfigurationname().'</option>';
                                    }
                                }
                            ?>
                            </select></td>
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
                                    for ($i=0; $i<count($orgs); $i++){
                                        if($orgs[$i]->getOrganizationid() == $_SESSION['organizationid']){
                                            echo '<option selected value="'.$orgs[$i]->getOrganizationid().
                                                 '">'.$orgs[$i]->getOrgname().'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$orgs[$i]->getOrganizationid().
                                                 '">'.$orgs[$i]->getOrgname().'</option>';
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
            <form id="savecomments" name="savecomments" method="post" action="CommentsController.php?mode=save">
                <table width="500" align="center">
                    <tr>
                        <td colspan="2" align="left"><b>Add a comment:</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="title" id="title" size="93" type="text"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea name="comment" id="comment" rows="5" cols="80" style="font-size:small"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <a href="" onclick="window.close();"><u><b>CLOSE</b></u></a></td>
                        <td align="right">
                            <input align="right" type="submit" name="savebtn" value="" class="saveButton"/></td>
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
