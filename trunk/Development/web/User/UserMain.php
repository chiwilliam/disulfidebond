<?php session_start(); if($_SESSION['loggedin'] == false){ header('Location: ../index.php');} ?>
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

    function changechart(chart) {
        
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
			<div id="banner1">
				<h2>Student Main Page</h2>
				This page lists all data from your group, according to your profile.
                The data is listed by members and it is divided by categories.
			</div>
            <div id="filters">
                <!-- table with filters -->
                <form id="filtersform" name="filtersform" method="post" action="./UserMainController.php?mode=filters">
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" colspan="5">
                            <font color="red"><b><?php echo $_SESSION['message']; ?></b></font></td>
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
            <div style="visibility:<?php echo $visible; ?>" id="leftareauser">
				<form name="listform" method="post" action="">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_row_border">
                      <tr>
                        <td height="28" class="cle"></td>
                        <td height="28" class="che title1 space1">Group Data</td>
                        <td height="28" class="cre"></td>
                      </tr>
                      <tr>
                        <td height="200" class="bl"></td>
                        <td height="200" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                          <tr class="rowhead">
                            <td height="22" class="data_td_border" >Member</td>
                            <?php
                                $header = $datamap[0];
                                $size = count($header);
                                for($i=0; $i<$size; $i++){
                                    echo '<td height="22" class="data_td_border" >'.
                                    $header[$i]."</td>";
                                }
                            ?>
                          </tr>
                                <?php
                                    $size = count($datamap)-1;
                                    //print $size;
                                    for($i=1; $i<$size; $i++){
                                        $row = $datamap[$i];
                                        if($i % 2==0){
                                            $rowStyle = "rowdd";
                                        }else{
                                            $rowStyle = "roweven";
                                        }
                                ?>
                          <tr class="<?php echo $rowStyle;?>" onMouseOver="changeClass(this, 'rowhightlight')" onMouseOut="changeClass(this, '<?php echo $rowStyle;?>')" >
                               <?php
                                    for($j=0; $j<count($row); $j++){
                               ?>
                            <td height="22" class="data_td_border tdleft" ><?php echo $row[$j]; if($j>0){echo " posts";}?></td>
                                <?php
                                        }
                                ?>
                          </tr>
                                <?php
                                    }
                                ?>
                        </table>
                        </td>
                        <td height="200" class="br"></td>
                      </tr>
                      <tr>
                        <td colspan="3" align="center"><font size="3" color="blue">
                            <a target="_blank" href="../report/pdfgenerator.php"><b>EXPORT TO PDF</b></a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a target="_blank" href="../report/xlsgenerator.php"><b>EXPORT TO EXCEL</b></a>
                        </font></td>
                      </tr>
                      <tr>
                        <td class="cfl"></td>
                        <td class="cf"></td>
                        <td class="cfr"></td>
                      </tr>
                  </table>
			  </form>
		     </div>
             <div style="visibility:<?php echo $visible; ?>" id="rightareauser">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="info_row_border">
				  <tr>
					<td height="28" class="cl"></td>
					<td height="28" class="ch title1 space1">Chart</td>
					<td height="28" class="cr"></td>
				  </tr>
                  <tr>
                    <td align="center" colspan="3"><font size="2" color="red"><?php echo $chartdescription ; ?></font></td>
                  </tr>
                  <tr>
                    <td colspan="3">
                    <?php

                        if ($visible != "hidden"){

                            $chart = $datamap[count($datamap)-1];
                            $title = array("","");

                            if ($type == "category" || ($type == "total" && $selected == "category")){
                                for ($i=0; $i<($size-2); $i++){
                                    $header[$i] = $users[$i]->getFirstname()." ".$users[$i]->getLastname();
                                }
                            }
                            else{
                                for ($i=0; $i<count($header); $i++){
                                    $initialpos = stripos($header[$i],'>')+1;
                                    $finalpos = stripos($header[$i],'</a>');
                                    $header[$i] = substr($header[$i],$initialpos,($finalpos-$initialpos));
                                }
                                for ($i=0; $i<(count($chart)-1); $i++){
                                    $newchart[$i] = $chart[$i+1];
                                }
                                $chart = $newchart;
                            }
                            //$chart = array(10,20,30,40);
                            $pieimage = piechart($chart,$header,$title);
                            $barimage = barchart($chart,$header,$title);
                            //$image2 = timeline($chart,$header,$title);

                            if ($_REQUEST['chart'] == "barchart"){
                                $image = $barimage;
                            }
                            else{
                                $image = $pieimage;
                            }

                            $_SESSION['piechartimage'] = $pieimage;
                            $_SESSION['barchartimage'] = $barimage;
                        }
                    ?>
                    </td>
				  </tr>
                  <tr>
                    <td colspan="3">
                        <?php echo $image; ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" colspan="3">
                        <a href="../User/UserMainController.php?type=<?php echo $type; ?>&selected=<?php echo $selected; ?>&chart=piechart">PIECHART</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="../User/UserMainController.php?type=<?php echo $type; ?>&selected=<?php echo $selected; ?>&chart=barchart">BARCHART</a>
                    </td>
                  </tr>
				</table>
		  	  </div>
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
