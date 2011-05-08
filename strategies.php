<?php session_start(); $_SESSION['step'] = 3; ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Strategies Selection</title>
        <link href="styles/style1.css" media="screen" rel="stylesheet" title="CSS" type="text/css" />
        <link href="styles/style.css" rel="stylesheet" type="text/css" />        
    </head>
    <body>
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
                    <div class="readme" id="readme">
                        <p style="margin-left:30px;text-align:justify;">
                            In this step, the user can choose from different combination strategies to 
                            determine the global disulfide connectivity pattern. Each combination strategy
                            has its advantages, thus aiding in the user analysis and improving the quality 
                            of the results. At least one combination strategy is required. The user
                            may want to choose any or all of them. For a more detailed description of each
                            click on its equation or visit our
                            <a class="alwaysblue" target="_blank" href="help.php">HELP</a>
                            section.
                        </p>
                    </div>
                    <div id="column_l">
                        <!-- #BeginEditable "content" -->
                        <form action="strategyassign.php" name="submitForm" id="submitForm" enctype="multipart/form-data" method="post">
                            <div id="errormessage" class="errormessage">
                                <table class="errormessage">
                                    <tr class="input">
                                        <td colspan="2" align="center">
                                            <label id="error" class="error"><?php if(strlen($error) > 0) echo $error."<br/>"; ?></label>
                                        </td>
                                    </tr>                                    
                                </table>
                            </div>
                            <div id="hiddenfields">
                                <input type="hidden" value="<?php echo $S1; ?>" name="inputstrategy1" id="inputstrategy1"/>
                                <input type="hidden" value="<?php echo $S2; ?>" name="inputstrategy2" id="inputstrategy2"/>
                                <input type="hidden" value="<?php echo $S3; ?>" name="inputstrategy3" id="inputstrategy3"/>
                                <input type="hidden" value="<?php echo $S4; ?>" name="inputstrategy4" id="inputstrategy4"/>
                                <input type="hidden" value="<?php echo $S5; ?>" name="inputstrategy5" id="inputstrategy5"/>
                                <input type="hidden" value="<?php echo $S6; ?>" name="inputstrategy6" id="inputstrategy6"/>
                            </div>
                            <div id="strategyselection" class="strategyselection">
                                <table class="strategyselection">
                                    <tr class="strategyselect">
                                        <td class="strategyselectiontitle" colspan="3">
                                            <label id="labelstrategy1">Combination Strategy 1</label>
                                        </td>
                                    </tr>
                                    <tr class="comb">
                                        <td class="checkmark">
                                            <img style="visibility:hidden;" alt="Combination Strategy 1 Selected" src="images/selected.png" id="checkmarkstrategy1"></img>
                                        </td>
                                        <td class="strategy">
                                            <a onclick="window.open('help/strategy1.html', 'Help - Strategy 1', 
                                            'width=640,height=480,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0')" 
                                            id="linkformula1" href="#linkformula1">
                                                <img alt="Equation for Strategy 1" src="images/strategy1.png"></img>
                                            </a>
                                        </td>
                                        <td class="selection">
                                            <a id="linkstrategy1" href="#linkstrategy1">
                                                <img alt="Select Combination Strategy 1" src="images/select.png" id="selectimgstrategy1" 
                                                onmouseover="document.getElementById('selectimgstrategy1').src='images/select_on.png';"
                                                onmouseout="document.getElementById('selectimgstrategy1').src='images/select.png';" 
                                                onclick="selectStrategy('strategy1');">
                                                </img>
                                                <img style="display:none;" alt="Remove Combination Strategy 1" src="images/remove.png" id="removeimgstrategy1" 
                                                onmouseover="document.getElementById('removeimgstrategy1').src='images/remove_on.png';"
                                                onmouseout="document.getElementById('removeimgstrategy1').src='images/remove.png';" 
                                                onclick="deselectStrategy('strategy1');">
                                                </img>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <tr class="strategyselect">
                                        <td class="strategyselectiontitle" colspan="3">
                                            <label id="labelstrategy2"><br></br>Combination Strategy 2</label>
                                        </td>
                                    </tr>
                                    <tr class="comb">
                                        <td class="checkmark">
                                            <img style="visibility:hidden;" alt="Combination Strategy 2 Selected" src="images/selected.png" id="checkmarkstrategy2"></img>
                                        </td>
                                        <td class="strategy">
                                            <a onclick="window.open('help/strategy2.html', 'Help - Strategy 2', 
                                            'width=640,height=480,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0')" 
                                            id="linkformula2" href="#linkformula2">
                                                <img alt="Equation for Strategy 2" src="images/strategy2.png"></img>
                                            </a>
                                        </td>
                                        <td class="selection">
                                            <a id="linkstrategy2" href="#linkstrategy2">
                                                <img alt="Select Combination Strategy 2" src="images/select.png" id="selectimgstrategy2" 
                                                onmouseover="document.getElementById('selectimgstrategy2').src='images/select_on.png';"
                                                onmouseout="document.getElementById('selectimgstrategy2').src='images/select.png';" 
                                                onclick="selectStrategy('strategy2');">
                                                </img>
                                                <img style="display:none;" alt="Remove Combination Strategy 2" src="images/remove.png" id="removeimgstrategy2" 
                                                onmouseover="document.getElementById('removeimgstrategy2').src='images/remove_on.png';"
                                                onmouseout="document.getElementById('removeimgstrategy2').src='images/remove.png';" 
                                                onclick="deselectStrategy('strategy2');">
                                                </img>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <tr class="strategyselect">
                                        <td class="strategyselectiontitle" colspan="3">
                                            <label id="labelstrategy3"><br></br>Combination Strategy 3</label>
                                        </td>
                                    </tr>
                                    <tr class="comb">
                                        <td class="checkmark">
                                            <img style="visibility:hidden;" alt="Combination Strategy 3 Selected" src="images/selected.png" id="checkmarkstrategy3"></img>
                                        </td>
                                        <td class="strategy">
                                            <a onclick="window.open('help/strategy3.html', 'Help - Strategy 3', 
                                            'width=640,height=480,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0')" 
                                            id="linkformula3" href="#linkformula3">
                                                <img alt="Equation for Strategy 3" src="images/strategy3.png"></img>
                                            </a>
                                        </td>
                                        <td class="selection">
                                            <a id="linkstrategy3" href="#linkstrategy3">
                                                <img alt="Select Combination Strategy 3" src="images/select.png" id="selectimgstrategy3" 
                                                onmouseover="document.getElementById('selectimgstrategy3').src='images/select_on.png';"
                                                onmouseout="document.getElementById('selectimgstrategy3').src='images/select.png';" 
                                                onclick="selectStrategy('strategy3');">
                                                </img>
                                                <img style="display:none;" alt="Remove Combination Strategy 3" src="images/remove.png" id="removeimgstrategy3" 
                                                onmouseover="document.getElementById('removeimgstrategy3').src='images/remove_on.png';"
                                                onmouseout="document.getElementById('removeimgstrategy3').src='images/remove.png';" 
                                                onclick="deselectStrategy('strategy3');">
                                                </img>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <tr class="strategyselect">
                                        <td class="strategyselectiontitle" colspan="3">
                                            <label id="labelstrategy4"><br></br>Combination Strategy 4</label>
                                        </td>
                                    </tr>
                                    <tr class="comb">
                                        <td class="checkmark">
                                            <img style="visibility:hidden;" alt="Combination Strategy 4 Selected" src="images/selected.png" id="checkmarkstrategy4"></img>
                                        </td>
                                        <td class="strategy">
                                            <a onclick="window.open('help/strategy4.html', 'Help - Strategy 4', 
                                            'width=640,height=480,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0')" 
                                            id="linkformula4" href="#linkformula4">
                                                <img alt="Equation for Strategy 4" src="images/strategy4.png"></img>
                                            </a>
                                        </td>
                                        <td class="selection">
                                            <a id="linkstrategy4" href="#linkstrategy4">
                                                <img alt="Select Combination Strategy 4" src="images/select.png" id="selectimgstrategy4" 
                                                onmouseover="document.getElementById('selectimgstrategy4').src='images/select_on.png';"
                                                onmouseout="document.getElementById('selectimgstrategy4').src='images/select.png';" 
                                                onclick="selectStrategy('strategy4');">
                                                </img>
                                                <img style="display:none;" alt="Remove Combination Strategy 4" src="images/remove.png" id="removeimgstrategy4" 
                                                onmouseover="document.getElementById('removeimgstrategy4').src='images/remove_on.png';"
                                                onmouseout="document.getElementById('removeimgstrategy4').src='images/remove.png';" 
                                                onclick="deselectStrategy('strategy4');">
                                                </img>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="display:none;" id="coefassign" class="coefassign">
                                <br></br>
                                <table class="coefassign">
                                    <?php
                                        $bonds = array();
                                        $methods = array();
                                        
                                        $data = $_SESSION['coefbonds'];
                                        $count = count($data);
                                        $keys = array_keys($data);
                                        
                                        for($i=0;$i<$count;$i++){
                                            $count2 = count($data[$keys[$i]]['bonds']);
                                            if($count2 > 0){
                                                //get bonds
                                                for($j=0;$j<$count2;$j++){
                                                    $bonds[$data[$keys[$i]]['bonds'][$j]] = $data[$keys[$i]]['bonds'][$j];
                                                }
                                                //get methods
                                                $methods[$keys[$i]] = $keys[$i];
                                            }                                            
                                        }
                                        
                                        $rows = count($bonds);
                                        $cols = count($methods);
                                        
                                        //header
                                        echo '<tr class="results">';
                                        echo '<td class="bonds"></td>';
                                        $keys = array_keys($methods);
                                        for($i=0;$i<$cols;$i++){
                                            echo '<td class="methods"><img alt="'.$keys[$i].'" src="images/'.strtolower($keys[$i]).'_on.png"></img></td>';
                                        }
                                        echo '</tr>';
                                        
                                        //score, coeficient labels
                                        echo '<tr class="results">';
                                        echo '<td class="bonds"><label class="bonds"><i>Bonds</i></label></td>';
                                        $keys = array_keys($methods);
                                        for($i=0;$i<$cols;$i++){
                                            echo '<td class="methods"><label class="score"><i>Score</i></label><label class="coef"><i>Confidence</i></label></td>';
                                        }
                                        echo '</tr>';
                                        
                                        //bonds
                                        $keys = array_keys($bonds);
                                        $methodkeys = array_keys($methods);
                                        for($i=0;$i<$rows;$i++){
                                            echo '<tr class="results">';
                                            echo '<td class="bonds"><label class="bonds">'.$keys[$i].'</label></td>';
                                            for($j=0;$j<$cols;$j++){
                                                if($methodkeys[$j] == "MSMS"){
                                                    $score = number_format($data[$methodkeys[$j]]['scores'][$keys[$i]]['ppvalue'],4);
                                                    $info = "";
                                                    if($score > 0){
                                                        $info = "MS/MS file: ".$data[$methodkeys[$j]]['scores'][$keys[$i]]['DTA'];
                                                    }
                                                }
                                                else{
                                                    $score = number_format($data[$methodkeys[$j]]['scores'][$keys[$i]]['score'],4);
                                                    $info = "";
                                                }
                                                if(!isset($score)){
                                                    $score = 0.0;
                                                }
                                                $coef = 1.0;
                                                $inputscore = 'score_'.$keys[$i].'_'.$methodkeys[$j];
                                                $inputcoef = 'coef_'.$keys[$i].'_'.$methodkeys[$j];
                                                if(strlen($info) > 0){
                                                    echo '<td class="methods"><input onmouseover="Tip(\''.$info.'\');" onmouseout="UnTip();" id="'.$inputscore.'" name="'.$inputscore.'" class="score" size="7" value="'.$score.'"></input><input id="'.$inputcoef.'" name="'.$inputcoef.'" class="coef" size="7" value="'.$coef.'"></input></td>';
                                                }
                                                else{
                                                    echo '<td class="methods"><input id="'.$inputscore.'" name="'.$inputscore.'" class="score" size="7" value="'.$score.'"></input><input id="'.$inputcoef.'" name="'.$inputcoef.'" class="coef" size="7" value="'.$coef.'"></input></td>';
                                                }
                                                
                                            }
                                            echo '</tr>';
                                        }                                    
                                    ?>
                                </table>
                            </div>
                            <div id="submit" class="submit">
                                <table class="input">
                                    <tr class="input">
                                        <td colspan="2" align="center">
                                            <a id="processlink" href="#processlink"><img alt="Search for S-S bonds" src="images/next.png" id="imgsubmit" onmouseover="Tip('Click here to search for disulfide bonds');document.getElementById('imgsubmit').src='images/next_on.png';"
                                               onmouseout="UnTip();document.getElementById('imgsubmit').src='images/next.png';" onclick="document.submitForm.submit();"></img></a>
                                        </td>
                                    </tr>                                          
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Page Content -->
                <!-- Begin Footer -->
                <?php include "footer.php" ?>
                <!-- End Footer -->
            </div>
        </div><!-- End Container -->
    </body>
</html>
