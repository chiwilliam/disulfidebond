<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>User Information</title>
<script type="text/javascript" src="../tree/xtree.js"></script>
<script type="text/javascript" src="../tree/xmlextras.js"></script>
<script type="text/javascript" src="../tree/xloadtree.js"></script>
<link type="text/css" rel="stylesheet" href="../tree/xtree.css" />

<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../css/menustyle.css" >
<script type="text/javascript" src="../coolmenupro/coolmenupro.js" ></script>
<script>
	function changeClass(obj, name) { 
		obj.className = name; 
	}
	
	function _Checkall(){
		unitids = ",";
		var obj = document.getElementsByName("ids");
		var len = obj.length;
		if(document.listform.allcheck.checked){
			for (var i = 0;i<len;i++){
				unitids = unitids + obj[i].value + ",";
				obj[i].checked = true;
			}
		}else{
			for (var i = 0;i<len;i++){
				obj[i].checked = false;
			}
		}
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
    	<div id="logo"><a href="#"><span class="orange">PRODUCTIVITY</span> TRACKER</a></div>
        <div id="module">
        	<ul>
				<li><a href="#">PPM Project</a></li>
				<li><a href="#" class="active">Configuration</a></li>
            </ul>
        </div>
    </div>
    <!--end header -->
    <!-- main -->
    <div id="main">
		<!--menu begin-->
	 	<div id="menu">			
			<script type="text/javascript" src="../coolmenupro/menu_instructor.js" ></script>
			<script type="text/javascript">CLoadNotify();</script>			
		</div>
		<!--menu end-->
		
		<!--content begin-->
        <div id="content">

			<div id="banner1">
				<h2>User Information</h2>
				This is the information of one user. The user should use the java.net username and java.net real name in this system.
				<br />
			</div>

			<!--text begin-->
		  <div id="fillarea">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				  <tr>
					<td height="28" class="cl"></td>
					<td height="28" class="ch title1 space1">Message</td>
					<td height="28" class="cr"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top" height="50" style="padding:5px; ">
						<img src="../images/node/MessageInfo.gif" width="16" height="16"> This is a information message.<br>
						<img src="../images/node/MessageWarn.gif"> This is a warn message.<br>
						<img src="../images/node/MessageError.gif"> This is a error message.<br>
						
						
					</td>
					<td class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
				</table>		  		
			  <br />
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				<form name="infoform" method="post" action="">
				  <tr>
					<td height="28" class="clg"></td>
					<td height="28" class="chg title1 space1">User Information</td>
					<td height="28" class="crg"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top">
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >serial index </td>
						<td width="50%" height="22" class="labelcol labelleft" ><input name="serialindex" type="text" class="textInput1" size="10"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >username</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="username" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >password</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="password" name="pwd" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >confirm password</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="password" name="pwd2" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>		
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >first name</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="firstname" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>	
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >last name</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="lastname" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>	
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >email</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="email" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>		
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >phone</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="phone" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>	
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >address</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="address" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>						  					  					  			  
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >description</td>
						<td width="50%" height="22" class="labelcol labelleft" ><textarea name="description" cols="40" rows="6" class="desc"></textarea></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					</table>

					
					</td>
					<td class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
				</form>
				</table>
				<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				<form name="infoform2" method="post" action="">
				  <tr>
					<td height="28" class="clg"></td>
					<td height="28" class="chg title1 space1">Java.net Profile</td>
					<td height="28" class="crg"></td>
				  </tr>
				  <tr>
					<td class="bl"></td>
					<td valign="top">
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >username</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input name="serialindex" type="text" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >realname</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="text" name="username" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >studentid</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="password" name="pwd" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="20%" height="22" class="labelright labelcol labelbg" >school</td>
						<td width="50%" height="22" class="labelcol labelleft" ><input type="password" name="pwd2" class="textInput1" size="50"></td>
						<td width="30%" height="22">&nbsp;</td>
					  </tr>
					</table>

					
					</td>
					<td class="br"></td>
				  </tr>
				  <tr>
					<td class="cfl"></td>
					<td class="cf"></td>
					<td class="cfr"></td>
				  </tr>
				</form>
				</table>
				<br>				
				<table width="100%"  border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="right" valign="middle">
					  <table width="200" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                          <td><img src="../images/button/short/blue_save.png" width="83" height="31"></td>
                          <td><img src="../images/button/short/gray_return.png" width="83" height="31" onClick="window.location.href='./UserList.php'"></td>
                        </tr>
                      </table></td>
				  </tr>
		    </table>
			  
		  </div>
	   		<!--text end-->


       </div>
	   <!--content end-->
    </div>
    <!-- end main -->
	
	
	
    <!-- footer -->
    <div id="footer">	
		<div id="left_footer">&copy; Copyright 2008 CSC 848 Group2
		</div>	
		<div id="right_footer">
			Design by <a href="http://www.realitysoftware.ca" title="Website Design">Group2 Members</a>
		</div>
    </div>
    <!-- end footer -->
</div>
</body>
</html>
