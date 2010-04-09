<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Productivity Tracker - Create User</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../css/menustyle.css" >
<script type="text/javascript" src="../tree/xtree.js"></script>
<script type="text/javascript" src="../tree/xmlextras.js"></script>
<script type="text/javascript" src="../tree/xloadtree.js"></script>
<link type="text/css" rel="stylesheet" href="../tree/xtree.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../css/menustyle.css" >
<script type="text/javascript" src="../coolmenupro/coolmenupro.js" ></script>
<script language="javascript">

function SelectGroup(){
	window.open('./abc.html', 'haha');
}

function SetGroup(organizationid, orgname){
	document.loginform.organizationid.value = organizationid;
	document.loginform.orgname.value = orgname;
	//alert("document.infoform.organizationid.value = " + document.infoform.organizationid.value);
	//alert("document.infoform.orgname.value = " + document.infoform.orgname.value);
}

function validate_required(field,alerttxt){
    with (field)
    {
        if (value==null||value==""||value=="-1"){
            alert(alerttxt);
            return false;
        }
        else{
            return true
        }
    }
}

function validate_form(thisform)
{
    with (thisform){
        if (validate_required(usertype,"User Type must be selected!")==false){
            usertype.focus();
            return false;
        }
        if (validate_required(firstname,"First Name must be filled out!")==false){
            firstname.focus();
            return false;
        }
        if (validate_required(lastname,"Last Name must be filled out!")==false){
            lastname.focus();
            return false;
        }if (validate_required(email,"Email must be filled out!")==false){
            email.focus();
            return false;
        }
        if (validate_required(username,"User Name must be filled out!")==false){
            username.focus();
            return false;
        }
        if (validate_required(password,"Password must be filled out!")==false){
            password.focus();
            return false;
        }
        if (validate_required(intyear,"Year must be selected!")==false){
            intyear.focus();
            return false;
        }
        if (validate_required(semester,"Semester must be selected!")==false){
            semester.focus();
            return false;
        }
        if (usertype.value == "Student"){
            if (validate_required(organizationid,"Group must be selected!")==false){
                organizationid.focus();
                return false;
            }
        }
    }
}


</script>
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
          <script language="javascript">

                function testuser()
                {
                    if (document.loginform.usertype.selectedIndex == 2){
                        document.loginform.intyear.disabled = false;
                        document.loginform.semester.disabled = false;
                        document.loginform.orgname.disabled = false;                        document.loginform.group.disabled = false;
                    }
                    else{
                        document.loginform.intyear.disabled = true;
                        document.loginform.semester.disabled = true;
                        document.loginform.orgname.disabled = true;
                    }
                }
         </script>
                <form id="loginform" name="loginform" method="post" action="createusercontroller.php"
                onsubmit="return validate_form(this)">
                  <table align="center" id="logintable" width="350">
                    <tr>
                        <td align="left" width="150"><label>User Type:</label></td>
                        <td align="left" width="50"><select name="usertype" onchange="testuser()">
                            <option value="">-Please Select One-</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Student">Student</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" width="150"><label>First Name:</label></td>
                        <td align="left" width="50"><input type="text" name="firstname" id="firstname" /></td>
                    </tr>
                    <tr>
                        <td align="left" width="150"><label>Last Name:</label></td>
                        <td align="left" width="50"><input type="text" name="lastname" id="lastname" /></td>
                    </tr>
                    <tr>
                        <td align="left" width="150"><label>Java.net Email:</label></td>
                        <td align="left" width="50"><input type="text" name="email" id="email" /></td>
                    </tr>
                    <tr>
                        <td align="left" width="150"><label>Java.net User Name:</label></td>
                        <td align="left" width="50"><input type="text" name="username" id="username" /></td>
                    </tr>
                    <tr>
                        <td align="left" width="150"><label>Password:</label></td>
                        <td align="left" width="50"><input type="password" name="password" id="password" /></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2"><b>For Students only:</b></td>
                    </tr>
                    <tr>
						<td align="left" width="150">Year:</td>
						<td align="left" width="50">
						<select name="intyear" size="1" class="textInput1" style=" width:133px; ">
						<?php
							$currentYear = (int)date('Y');
							// "<option value=".$currentYear.">".$currentYear."</option>";

							for($n = $currentYear-2; $n<$currentYear+3; $n++){
								if($currentYear==$n){
									print "<option value=".$n." selected >".$n."</option>";
								} else  {
									print "<option value=".$n.">".$n."</option>";
								}

							}

						?>
						</select>
						</td>
						<td align="left" width="150">&nbsp;</td>
					  </tr>
					  <tr>
						<td align="left" width="150">Semester:</td>
						<td align="left" width="50">
						  <select name="semester" size="1" class="textInput1" style=" width:133px; ">
						    <option value="Spring">Spring</option>
						    <option value="Summer">Summer</option>
						    <option value="Fall">Fall</option>
						    <option value="Winter">Winter</option>
				           </select>
						</td>
						<td align="left" width="50">&nbsp;</td>
					  </tr>
					  <tr>
						<td align="left" width="150">Group:</td>
						<td align="left" width="50">
                        <input type="text" name="orgname" class="textInput1" size="20">
					        <script type="text/javascript">
                            /// XP Look
                            webFXTreeConfig.rootIcon		= "../tree/folder.gif";
                            webFXTreeConfig.openRootIcon	= "../tree/openfolder.gif";
                            webFXTreeConfig.folderIcon		= "../tree/folder.png";
                            webFXTreeConfig.openFolderIcon	= "../tree/openfolder.gif";
                            webFXTreeConfig.fileIcon		= "../tree/folder.png";
                            webFXTreeConfig.lMinusIcon		= "../tree/listExpanded.png";
                            webFXTreeConfig.lPlusIcon		= "../tree/listCollapsed.png";
                            webFXTreeConfig.tMinusIcon		= "../tree/listExpanded.png";
                            webFXTreeConfig.tPlusIcon		= "../tree/listCollapsed.png";
                            webFXTreeConfig.iIcon			= "../tree/I.png";
                            webFXTreeConfig.lIcon			= "../tree/L.png";
                            webFXTreeConfig.tIcon			= "../tree/T.png";
                            webFXTreeConfig.blankIcon	    = "../tree/blank.png";
                            webFXTreeConfig.defaultTarget	= "";
                            </script>
                            <?php
                                require_once("../organization/OrganizationManager.class.php");
                                require_once("../organization/Organization.class.php");
                                $manager = OrganizationManager::getInstance();

                                //get all root organizations
                                $org = new Organization();
                                $org->setParentid(-1);
                                $orgs = $manager->getOrganizations($org,"");

                                $size = count($orgs);
                                print "<script type=\"text/javascript\">";
                                print "var tree = new WebFXTree(\"Groups\",\"#\");";
                                for($t=0; $t<$size; $t++){
                                    $org = $orgs[$t];
                                    print "tree.add(new WebFXLoadTreeItem(\"".$org->getOrgtext()."\", \"./SelectGroupTree.php?parentid=".$org->getOrganizationid()."\", \"javascript:SetGroup('".$org->getOrganizationid()."', '".$org->getOrgtext()."')\"));";
                                }
                                print "document.write(tree);";
                                print "</script>";
                            ?>
						<input type="hidden" name="organizationid" value="-1" >
						</td>
						<td align="left" width="50">&nbsp;</td>
					  </tr>
                    <tr>
                        <td colspan="2" align="right"><input name="Submit" type="submit" value="" class="saveButton"/></td>
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
