﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Methods Selection</title>
        <link href="styles/style1.css" media="screen" rel="stylesheet" title="CSS" type="text/css" />
        <link href="styles/style.css" rel="stylesheet" type="text/css" />        
    </head>
    <body>
        <?php include_once("analyticstracking.php") ?>
        <script type="text/javascript" src="js/wz_jsgraphics.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>        
        <script type="text/javascript" src="js/wz_tooltip.js"></script>
        <script type="text/javascript" src="js/graph.js"></script>
        <!-- Begin Container -->
        <div id="container">
            <?php include 'header.php';?>
            <!-- Begin Navigation -->
            <?php include 'menu.php';?>
            <!-- End Navigation -->
            <!-- Begin Page Content -->
            <div id="page_content">
                <!-- Begin Left Column -->
                <div class="readme" id="readme">
                    "Point the mouse over each input field or output result to read its description.
                    For more details, please visit our <a class="alwaysblue" target="_blank" href="help.php"><b>HELP</b></a> section."
                </div>
                <div id="column_l">
                    <!-- #BeginEditable "content" -->
                    <form action="kernel.php?mode=stantard" name="submitForm" id="submitForm" enctype="multipart/form-data" method="post">
                        <div>
                            <div id="fixeddetails">
                                <table class="input">
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label><b>Click to select/deselect</b> the S-S connectivity determination methods to be used:</label>
                                        </td>
                                        <td class="inputright" style="margin-top:10px;">
                                            <input type="hidden" value="<?php echo $MSMS; ?>" name="inputmsms" id="inputmsms"/>
                                            <input type="hidden" value="<?php echo $SVM; ?>" name="inputsvm" id="inputsvm"/>
                                            <input type="hidden" value="<?php echo $CSP; ?>" name="inputcsp" id="inputcsp"/>
                                            <input type="hidden" value="<?php echo $CUSTOM; ?>" name="inputcustom" id="inputcustom"/>
                                            <input type="hidden" value="<?php echo $CUSTOM2; ?>" name="inputcustom2" id="inputcustom2"/>
                                            <a href="#"><img alt="MS/MS" src="images/msms<?php if($MSMS != "")echo '_on'; ?>.png" id="imgmsms" onmouseover="Tip('Tandem Mass Spectrometry method')"
                                                             onmouseout="UnTip()" onclick="changeSkin('imgmsms','msms');"></img></a>
                                            <a href="#"><img alt="SVM" src="images/svm<?php if($SVM != "")echo '_on'; ?>.png" id="imgsvm" onmouseover="Tip('Support Vector Machine method')"
                                                             onmouseout="UnTip()" onclick="changeSkin('imgsvm','svm');"></img></a>
                                            <a href="#"><img alt="CSP" src="images/csp<?php if($CSP != "")echo '_on'; ?>.png" id="imgcsp" onmouseover="Tip('Cysteines separation profiles method')"
                                                             onmouseout="UnTip()" onclick="changeSkin('imgcsp','csp');"></img></a>
                                            <a href="#"><img alt="CUSTOM" src="images/custom<?php if($CUSTOM != "")echo '_on'; ?>.png" id="imgcustom" onmouseover="Tip('Custom method')"
                                                             onmouseout="UnTip()" onclick="changeSkin('imgcustom','custom');"></img></a>
                                            <a href="#"><img alt="CUSTOM" src="images/custom2<?php if($CUSTOM2 != "")echo '_on'; ?>.png" id="imgcustom2" onmouseover="Tip('Custom method')"
                                                             onmouseout="UnTip()" onclick="changeSkin('imgcustom2','custom2');"></img></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p /></td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Enter protein's <b>FASTA</b> sequence:</label>
                                        </td>
                                        <td class="inputright">
                                            <textarea id="fastaProtein" name="fastaProtein" rows="5" cols="77"
                                                      onmouseover="Tip('Enter a protein sequence in FASTA format (a.k.a Pearson format)')"
                                                      onmouseout="UnTip()"
                                                      ><?php if(isset($fastaProtein)){echo $fastaProtein;}?></textarea>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Region where S-S bonds are not expected to occur:</label>
                                        </td>
                                        <td class="inputright">
                                            <label>From:</label>
                                            <input id="transmembranefrom" name="transmembranefrom" 
                                                   value="<?php if(isset($transmembranefrom)){echo $transmembranefrom;}?>"
                                                   onmouseover="Tip('Protein transmembrane region start')"
                                                   onmouseout="UnTip()" size="4" maxlength="4"></input>
                                            <label>to</label>
                                            <input id="transmembraneto" name="transmembraneto" 
                                                   value="<?php if(isset($transmembraneto)){echo $transmembraneto;}?>"
                                                   onmouseover="Tip('Protein transmembrane region end')"
                                                   onmouseout="UnTip()" size="4" maxlength="4"></input>
                                            <span style="color:red;font-size:10px;">(optional)</span>
                                        </td>
                                    </tr>                                    
                                </table>
                            </div>
                            <div id="msmsdetails" style="display:<?php if(strlen($MSMS) > 0){echo "display";}else{echo "none";}?>;">
                                <table class="input">
                                    <tr class="input">
                                        <td colspan="2" class="method">
                                            <label id="msmstitle"><br></br>MS/MS Details</label>
                                            <label class="info">(only if MS/MS method was selected)</label>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Upload a MS/MS data file:</label>
                                        </td>
                                        <td class="inputright">
                                            <input type="file" id="zipFile" name="zipFile" size="70"
                                                   onmouseover="Tip('Upload one of the following formats: mzXML, mzData, mzML or a ZIP containing DTA files')"
                                                   onmouseout="UnTip()" />
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
                                            <label id="lbions" onmouseover="Tip('Select which ion types will be considered in the analysis')" onmouseout="UnTip()">Multi-ion types selection:</label>
                                        </td>
                                        <td class="inputright">
                                            <i>a</i><input id="iona" type="checkbox" name="iona" value="a" 
                                                <?php if(!isset($alliontypes['a']) || strlen($alliontypes['a']) > 0) echo "checked";?> />
                                            <i>ao</i><input id="iona" type="checkbox" name="ionao" value="ao"
                                                <?php if(strlen($alliontypes['ao']) > 0) echo "checked";?> />
                                            <i>a*</i><input id="iona" type="checkbox" name="ionas" value="as" 
                                                <?php if(strlen($alliontypes['as']) > 0) echo "checked";?> />
                                            <i>b</i><input id="ionb" type="checkbox" name="ionb" value="b" 
                                                <?php if(!isset($alliontypes['b']) || strlen($alliontypes['b']) > 0) echo "checked";?> />
                                            <i>b*</i><input id="ionbs" type="checkbox" name="ionbs" value="bs" 
                                                <?php if(!isset($alliontypes['bs']) || strlen($alliontypes['bs']) > 0) echo "checked";?> />
                                            <i>bo</i><input id="ionbo" type="checkbox" name="ionbo" value="bo" 
                                                <?php if(!isset($alliontypes['bo']) || strlen($alliontypes['bo']) > 0) echo "checked";?> />
                                            <i>c</i><input id="ionc" type="checkbox" name="ionc" value="c" 
                                                <?php if(!isset($alliontypes['c']) || strlen($alliontypes['c']) > 0) echo "checked";?> />
                                            <i>x</i><input id="ionx" type="checkbox" name="ionx" value="x" 
                                                <?php if(!isset($alliontypes['x']) || strlen($alliontypes['x']) > 0) echo "checked";?> />
                                            <i>y</i><input id="iony" type="checkbox" name="iony" value="y" 
                                                <?php if(!isset($alliontypes['y']) || strlen($alliontypes['y']) > 0) echo "checked";?> />
                                            <i>y*</i><input id="ionys" type="checkbox" name="ionys" value="ys" 
                                                <?php if(!isset($alliontypes['ys']) || strlen($alliontypes['ys']) > 0) echo "checked";?> />
                                            <i>yo</i><input id="ionyo" type="checkbox" name="ionyo" value="yo" 
                                                <?php if(!isset($alliontypes['yo']) || strlen($alliontypes['yo']) > 0) echo "checked";?> />
                                            <i>z</i><input id="ionz" type="checkbox" name="ionz" value="z" 
                                                <?php if(!isset($alliontypes['z']) || strlen($alliontypes['z']) > 0) echo "checked";?> />
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Number of missing cleavages:</label>
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
                                        <td class="inputleft">Initial Matching threshold:</td>
                                        <td class="inputright">
                                            <input type="text" id="IMthreshold" name="IMthreshold" size="5" value="<?php if (isset($IMthreshold)) {echo $IMthreshold;}else {echo '1.0';} ?>"
                                                   onmouseover="Tip('Threshold used during the matching between precursor ions and disulfide bonded structures')"
                                                   onmouseout="UnTip()"></input>
                                            <span style="color:red;font-size:10px;">(default: +-1.0)</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="customdetails" style="display:<?php if(strlen($CUSTOM) > 0){echo "display";}else{echo "none";}?>;">
                                <table class="input">
                                    <tr class="input">
                                        <td colspan="2" class="method">
                                            <label id="msmstitle"><br></br>Input for Custom method</label>
                                            <label class="info">(only if Custom method was selected)</label>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Enter the disulfide bonds found and their respective scores separated by commas: <i>(i.e.:142-292,0.47,156-356,0.53)</i></label>
                                        </td>
                                        <td class="inputright">
                                            <textarea id="customdata" name="customdata" rows="3" cols="77"
                                                      onmouseover="Tip('The disulfide bonds and their respective scores should be entered in pairs separated by commas. (i.e. 142-292,0.47,156-356,0.53 should be entered for S-S bonds between cysteines 142-292 and 156-356, whose scores are 0.47 and 0.56, respectively.)')"
                                                      onmouseout="UnTip()"
                                                      ><?php if(isset($customdata)){echo $customdata;}?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="custom2details" style="display:<?php if(strlen($CUSTOM2) > 0){echo "display";}else{echo "none";}?>;">
                                <table class="input">
                                    <tr class="input">
                                        <td colspan="2" class="method">
                                            <label id="msmstitle"><br></br>Input for Custom method</label>
                                            <label class="info">(only if Custom method was selected)</label>
                                        </td>
                                    </tr>
                                    <tr class="input">
                                        <td class="inputleft">
                                            <label>Enter the disulfide bonds found and their respective scores separated by commas: <i>(i.e.:142-292,0.47,156-356,0.53)</i></label>
                                        </td>
                                        <td class="inputright">
                                            <textarea id="custom2data" name="custom2data" rows="3" cols="77"
                                                      onmouseover="Tip('The disulfide bonds and their respective scores should be entered in pairs separated by commas. (i.e. 142-292,0.47,156-356,0.53 should be entered for S-S bonds between cysteines 142-292 and 156-356, whose scores are 0.47 and 0.56, respectively.)')"
                                                      onmouseout="UnTip()"
                                                      ><?php if(isset($custom2data)){echo $custom2data;}?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="submit">
                                <table class="input">
                                    <tr class="input">
                                        <td colspan="2" align="center">
                                            <a id="submitlink" href="#submitlink"><img alt="Search for S-S bonds" src="images/next.png" id="imgsubmit" onmouseover="Tip('Click here to search for disulfide bonds');document.getElementById('imgsubmit').src='images/next_on.png';"
                                                         onmouseout="UnTip();document.getElementById('imgsubmit').src='images/next.png';" onclick="showProcessing();document.submitForm.submit();"></img></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="processing">
                                                <img alt="Loading" id="loadingimage" style="visibility:hidden;" src="images/loading.gif" />
                                                <label id="processing"></label>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="bondsdiv">
                                <table class="input">
                                    <tr id="trbondsdiv">
                                        <td class="inputrightresults">
                                            <?php
                                                if(isset($message)){
                                                    if(strtoupper(substr($message, 0, 5)) == "ERROR"){
                                                        echo '<font color="red">';
                                                    }
                                                    else{
                                                        echo '<font color="blue">';
                                                    }
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
                        </div>
                    </form>
                    <div id="graphdiv" class="graph">                            
                    </div>
                    <div id="listofbondsdiv" class="listofbonds">                            
                    </div>
                </div>
                <!-- End Left Column -->
            <!-- End Page Content -->
            <!-- Begin Footer -->
            <?php include "footer.php" ?>
            <!-- End Footer -->
            </div>
        </div><!-- End Container -->
    </body>
</html>
