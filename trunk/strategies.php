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
                            of the results. At least one combination strategy is required, but the user
                            may want to choose all of them.
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
                                    
                                </table>
                            </div>
                            <div style="display:none;" id="coefassign" class="coefassign">
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
