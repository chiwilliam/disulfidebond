﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">

<!-- #BeginTemplate "master.dwt" -->

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<!-- #BeginEditable "doctitle" -->
<title>Home</title>
<!-- #EndEditable -->
<link href="styles/style1.css" media="screen" rel="stylesheet" title="CSS" type="text/css" />
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/wz_jsgraphics.js"></script>
</head>

<body>
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<!-- Begin Container -->
<div id="container">
	<!-- Begin Masthead -->
	<div id="masthead">
		<img alt="MS2DBp logo" height="66" src="images/logo.gif" width="150" onmouseover="Tip('MS2DBp Project')" onmouseout="UnTip()"/>
		<div id="mastheadright">
			<img alt="SFSU Logo" height="39" src="images/SFSU_logo.jpg" width="150" onmouseover="Tip('SFSU http://www.sfsu.edu')" onmouseout="UnTip()"/>
		</div>
	</div>
	<!-- End Masthead -->
	<!-- Begin Navigation -->
	<div id="navigation" class="horizontalmenu">
		<ul>
			<li><a href="index.php" onmouseover="Tip('MS2DBp Home Page')" onmouseout="UnTip()">Home</a></li>
                        <li><a href="index.php" onmouseover="Tip('MS2DBp for Beginner users')" onmouseout="UnTip()">Standard User</a></li>
                        <li><a href="Analysis.php?mode=advanced" onmouseover="Tip('MS2DBp for Advanced users')" onmouseout="UnTip()">Advanced User</a></li>
		</ul>
	</div>
	<!-- End Navigation -->
	<!-- Begin Page Content -->
	<div id="page_content">
		<!-- Begin Left Column -->
		<div id="column_l">
			<!-- #BeginEditable "content" -->
                        <form action="Analysis.php" name="submitForm" enctype="multipart/form-data" method="post">
                            <div>
                                <table class="input">
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Upload ZIP with DTA files:</label>
                                        </td>
                                        <td class="inputright">
                                            <input type="file" id="zipFile" name="zipFile" size="50"
                                                   onmouseover="Tip('Select a ZIP file containing DTA files from a MS/MS experiment')"
                                                   onmouseout="UnTip()"></input>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Enter FASTA protein sequence:</label>
                                        </td>
                                        <td class="inputright">
                                            <textarea id="fastaProtein" name="fastaProtein" rows="5" cols="50"
                                                      onmouseover="Tip('Enter a protein sequence in FASTA format (a.k.a Pearson format)')"
                                                      onmouseout="UnTip()"
                                                      ><?php if(isset($fastaProtein)){echo $fastaProtein;}?></textarea>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Choose protease used in digestion:</label>
                                        </td>
                                        <td class="inputright">
                                            <select id="protease" name="protease"
                                                    onmouseover="Tip('Choose a protease using to digest the protein sequence entered above')"
                                                    onmouseout="UnTip()">
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "T"){echo "selected";} ?> value="T">Trypsin</option>
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "C"){echo "selected";} ?> value="C">Chymotrypsin</option>
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "TC"){echo "selected";} ?> value="TC">Trypsin + Chymotrypsin</option>
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "G"){echo "selected";} ?> value="G">Glu-C</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Missing cleavages:</label>
                                        </td>
                                        <td class="inputright">
                                            <select id="missingcleavages" name="missingcleavages"
                                                    onmouseover="Tip('Choose the number of missing cleavages. The default is 2')"
                                                    onmouseout="UnTip()">
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "-1"){echo "selected";} ?> value="-1">Optional</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "0"){echo "selected";} ?> value="0">0</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "1"){echo "selected";} ?> value="1">1</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "2"){echo "selected";} ?> value="2">2</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "3"){echo "selected";} ?> value="3">3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td colspan="2">
                                            <p></p>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td colspan="2">
                                            <?php
                                                if(isset($advancedusers)){
                                                    echo '<div id="advanceddiv" class="advancedusers">';
                                                    echo $advancedusers;
                                                }
                                                else{
                                                    echo '<div id="advanceddiv" class="standardusers">';
                                                }
                                                echo '</div>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label style="visibility:hidden">Click Search Disulfide Bonds to process your request</label>
                                        </td>
                                        <td class="inputright">
                                            <input type="submit" id="submit" size="200" name="submit" value="Search Disulfide Bonds"
                                                   onmouseover="Tip('Click Search Disulfide Bonds button to process your request')"
                                                   onmouseout="UnTip()">
                                            </input>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td colspan="2">
                                            <br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="inputleft">
                                            <label style="visibility:hidden">Disulfide Bonds</label>
                                        </td>
                                        <td class="inputright">
                                            <?php
                                                if(strtoupper(substr($message, 0, 5)) == "ERROR"){
                                                    echo '<font color="red">';
                                                }
                                                else{
                                                    echo '<font color="blue">';
                                                }

                                                if(isset($message)){
                                                    echo $message;
                                                }
                                                echo '</font>';
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <div id="graphdiv" class="graph">
                            <script type="text/javascript" src="js/graph.js"></script>
                            <?php echo $SSgraph; ?>
                            <?php echo $SSgraphJS; ?>
                        </div>
                        <div id="listofbondsdiv" class="listofbonds">
                            <table align="center" id="bonds" width="800">
                                <tr><td></td></tr>
                                <?php
                                    if(isset($bonds)){
                                        if(count($bonds) == -1){
                                            $rows = (((int)(strlen($fastaProtein)/60)+1)*2);
                                            $cols = 6;
                                            for($i=0;$i<$rows;$i++){
                                                echo '<tr width="720px">';
                                                for($j=0;$j<$cols;$j++){
                                                    if($i%2 == 0){
                                                        echo '<td align="right" width="120px">';
                                                        echo ((($i/2)*60)+(($j+1)*10))/10;
                                                        echo "<u>0</u>";
                                                    }
                                                    else{
                                                        if($i == $rows-1 && $j == $cols-1)
                                                            echo '<td align="center" width="120px">';
                                                        else
                                                            echo '<td align="right" width="120px">';
                                                        $output = substr($fastaProtein,((($i-1)/2)*60)+($j*10),10);
                                                        for($k=0;$k<count($bonds);$k++){
                                                            $c1 = substr($bonds[$k],0,strpos($bonds[$k],"-"));
                                                            $c2 = substr($bonds[$k],strpos($bonds[$k],"-")+1);
                                                            if($c1 >= ((($i-1)/2)*60)+($j*10) && $c1 <= (((($i-1)/2)*60)+($j*10)+10)){
                                                                $start = (((($i-1)/2)*60)+($j*10))+1;
                                                                $output = substr($output,0,($c1-$start)).'<font color="red"><u><b>'.
                                                                          substr($output,($c1-$start),1).'</b></u></font>'.
                                                                          substr($output,($c1-$start+1));
                                                            }
                                                            if($c2 >= ((($i-1)/2)*60)+($j*10) && $c2 <= (((($i-1)/2)*60)+($j*10)+10)){
                                                                $start = (((($i-1)/2)*60)+($j*10))+1;
                                                                $output = substr($output,0,($c2-$start)).'<font color="red"><u><b>'.
                                                                          substr($output,($c2-$start),1).'</b></u></font>'.
                                                                          substr($output,($c2-$start+1));
                                                            }
                                                        }
                                                        echo $output;
                                                    }
                                                    echo '</td>';
                                                }
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                ?>
                            </table>
                            <?php
                                if(isset($debug)){echo $debug;}
                            ?>
                      </div>
                </div>
		<!-- End Left Column -->
	<!-- End Page Content -->
	<!-- Begin Footer -->
	<div id="footer">
		<p>&nbsp;</p>
		<p>Copyright © 2009 William Murad. All Rights Reserved.</p>
	</div>
	<!-- End Footer --></div>
</div><!-- End Container -->

</body>

<!-- #EndTemplate -->

</html>
