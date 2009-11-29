<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<!-- Begin Container -->
<div id="container">
	<!-- Begin Masthead -->
	<div id="masthead">
		<img alt="Your Company Logo Here" height="66" src="images/logo.gif" width="150" />
		<div id="mastheadright">
			<img alt="SFSU Logo" height="39" src="images/SFSU_logo.jpg" width="150" />
		</div>
	</div>
	<!-- End Masthead -->
	<!-- Begin Navigation -->
	<div id="navigation">
		<ul>
			<li><a href="index.php">Home</a></li>
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
                                <table align="center">
                                    <tr>
                                        <td>
                                            <label>Upload ZIP with DTA files:</label>
                                        </td>
                                        <td>
                                            <input type="file" id="zipFile" name="zipFile" size="50"></input>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Enter FASTA protein sequence:</label>
                                        </td>
                                        <td>
                                            <textarea id="fastaProtein" name="fastaProtein" rows="5" cols="50"><?php if(isset($fastaProtein)){echo $fastaProtein;}?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Choose protease used in digestion:</label>
                                        </td>
                                        <td>
                                            <select id="protease" name="protease">
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "T"){echo "selected";} ?> value="T">Trypsin</option>
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "C"){echo "selected";} ?> value="C">Chymotrypsin</option>
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "TC"){echo "selected";} ?> value="TC">Trypsin + Chymotrypsin</option>
                                                <option <?php if(!isset($protease)){$protease = "T";} if($protease == "G"){echo "selected";} ?> value="G">Glu-C</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Missing cleavages:</label>
                                        </td>
                                        <td>
                                            <select id="missingcleavages" name="missingcleavages">
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "-1"){echo "selected";} ?> value="-1">Optional</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "0"){echo "selected";} ?> value="0">0</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "1"){echo "selected";} ?> value="1">1</option>
                                                <option <?php if(!isset($missingcleavages)){$missingcleavages = "-1";} if($missingcleavages == "2"){echo "selected";} ?> value="2">2</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="3">
                                            <input type="submit" id="submit" size="200" name="submit" value="Search Disulfide Bonds"></input>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <br/>
                                        </td>
                                    </tr>
                                    <?php
                                        if(strtoupper(substr($message, 0, 5)) == "ERROR"){
                                            echo '<tr><td align="left" colspan="3"><font color="red">';
                                        }
                                        else{
                                            echo '<tr><td align="center" colspan="3"><font color="blue">';
                                        }

                                        if(isset($message)){
                                            echo $message;
                                        }
                                        echo '</font></td></tr>';
                                    ?>
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
