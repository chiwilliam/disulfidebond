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
            <div id="filters">
                <!-- table with filters -->
                <form name="filtersform" method="post" action="./GroupController.php">
                <table align="center" width="300" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="2" align="center"><font color="red"><?php echo $_SESSION['message']?></font></td>
                    </tr>
                    <tr>
                        <td align="right" width="100">Group:</td>
                        <td align="left" width="150">
                            <select name="organization" onchange="this.form.submit();">
                            <option value="">-Please Select One-</option>
                            <?php
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
                            ?>
                            </select></td>
                        <td align="right" width="100">
                            <input name="btnsubmit" type="submit" align="right" value="" class="displayButton" /></td>
                    </tr>
                </table>
                </form>
            </div>
            <form id="dataform" name="dataform">
            <table style="visibility:<?php echo $visible; ?>" align="center" border="5px" id="projectinfo" width="400">
                <tr>
                    <td width="150"><LABEL>Group Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="projectname" value="<?php echo $group->getOrgname();?>"/></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Year:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="intyear" value="<?php echo $config->getIntyear();?>"/></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Semester:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="semester" value="<?php echo $config->getSemester();?>"/></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Course Code:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="coursecode" value="<?php echo $config->getCoursecode();?>"/></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Course Name:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="coursename" value="<?php echo $config->getCoursename();?>"/></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Instructor:</LABEL></td>
                    <td width="200"><input size="30" type="text" name="teachername" value="<?php echo $config->getTeachername();?>"/></td>
                </tr>
                <tr>
                    <td width="150"><LABEL>Description:</LABEL></td>
                    <td width="200"><textarea name="description" rows="5" cols="28" style="font-size:small"><?php echo $group->getDescription();?></textarea></td>
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
