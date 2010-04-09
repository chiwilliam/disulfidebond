<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>User</title>
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
				<h2>User</h2>
				The users need to provide their java.net username and/or java.net real name in their profile.
				So that the information created by the user can be calculated.
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
		  		<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_row_border">
				<form name="listform" method="post" action="">
				  <tr>
					<td height="28" class="clb"></td>
					<td height="28" class="chb title1 space1">Users List</td>
					<td height="28" class="crb"></td>
				  </tr>
				  <tr>
					<td height="200" class="bl"></td>
					<td height="200" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                      <tr class="rowhead">
                        <td width="5%" height="22" class="data_td_border" >index</td>
                        <td width="9%" height="22" class="data_td_border" >username</td>
                        <td width="8%" height="22" class="data_td_border" >first name</td>
						<td width="8%" height="22" class="data_td_border" >lastname</td>
                        <td width="11%" height="22" class="data_td_border" >phone</td>
                        <td width="17%" height="22" class="data_td_border" >email</td>
						<td width="31%" height="22" class="data_td_border" >address</td>						
                        <td width="11%" height="22" >select<input type="checkbox" name="allcheck" onClick="_Checkall()" value="0" ></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php" target="_self">username1</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst1</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast1</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1001</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username1@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 1 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username2</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst2</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast2</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1002</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username2@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 2</td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
					  
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username3</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst3</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast3</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1003</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username3@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 3 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username4</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst4</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast4</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1004</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username4@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 4 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username5</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst5</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast5</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1005</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username5@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 5 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username6</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst6</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast6</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1006</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username6@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 6 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username7</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst7</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast7</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1007</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username7@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 7 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username8</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst8</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast8</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1008</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username8@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 8 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username9</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst9</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast9</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1009</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username9@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 9 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username10</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst10</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast10</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1010</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username10@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 10 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username11</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst11</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast11</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1011</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username11@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 11 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username12</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst12</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast12</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1012</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username12@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 12</td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username13</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst13</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast13</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1013</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username13@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 13 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username14</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst14</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast14</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1014</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username14@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 14 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username15</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst15</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast15</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1015</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username15@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 15 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username16</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst16</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast16</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1016</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username16@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 16 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username17</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst17</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast17</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1017</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username17@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 17 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username18</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst18</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast18</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1018</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username18@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 18 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="rowodd" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'rowodd')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >1</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username19</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst19</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast19</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1019</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username19@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 19 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>
                      <tr class="roweven" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, 'roweven')" >
                        <td width="5%" height="22" class="data_td_border tdcenter" >2</td>
                        <td width="9%" height="22" class="data_td_border tdleft" ><a href="./UserInfo.php">username20</a></td>
                        <td width="8%" height="22" class="data_td_border tdleft" >MyFirst20</td>
						<td width="8%" height="22" class="data_td_border tdleft" >MyLast20</td>
                        <td width="11%" height="22" class="data_td_border tdleft" >(415)-600-1020</td>
                        <td width="17%" height="22" class="data_td_border tdleft" >username20@gmail.com</td>
						<td width="31%" height="22" class="data_td_border tdleft" >My Address 20 </td>						
                        <td width="11%" height="22" class="tdcenter" ><input type="checkbox" name="ids" value="checkbox"></td>
                      </tr>					  					  					  					  					  					  					  					  					  
					  
					  
                      <tr class="">
                        <td height="22" colspan="8" class="" ><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%" height="22">&nbsp;</td>
                            <td width="50%" height="22" align="right">Items per page:&nbsp;<strong>25</strong> | <a href="#">50</a> | <a href="#">100</a> | <a href="#">200</a> </td>
                          </tr>
                        </table></td>
                      </tr>	
                      <tr class="">
                        <td height="22" colspan="8" class="data_td_border tdcenter" >
							<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FAFAFA">
							  <tr>
								<td width="25%" height="22" align="left">Page 1 of 20</td>
								<td width="50%" align="center">Previous 1 2 3 4 <strong>5</strong> 6 7 8 9 Next </td>
								<td width="25%" height="22" align="right">Go to page&nbsp;&nbsp;<input type="text" size="2" maxlength="2">&nbsp;&nbsp;<input name="GO" type="button" value="GO"></td>
							  </tr>
							</table>						
						</td>
                      </tr>								  					  
                    </table>					
					</td>
					<td height="200" class="br"></td>
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
					  <table width="300" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                          <td><img src="../images/button/short/green_add.png" width="83" height="31"></td>
                          <td><img src="../images/button/short/green_update.png" width="83" height="31"></td>
                          <td><img src="../images/button/short/red_delete.png" width="83" height="31"></td>
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
