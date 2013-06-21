<?php session_start(); $_SESSION['step'] = 2; ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Coefficients Assignment</title>
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
                    <div class="readme" id="readme">
                        <p style="margin-left:30px;text-align:justify;">
                            Please assign the reliability value to each disulfide bond.
                            Initially, all reliability values are assign as 1.0 (maximum reliability).
                            While a reliability value of 1.0 means the disulfide bond is highly trustworthy,
                            a reliability value of 0.0 means the disulfide bond should be discarded.
                            <br/><br/>
                            If the MS/MS method was selected, the user can check the precursor ion
                            mass by pointing the cursor over the score field.
                        </p>
                    </div>
                    <div id="column_l">
                        <!-- #BeginEditable "content" -->
                        <form action="coefassign.php" name="submitForm" id="submitForm" enctype="multipart/form-data" method="post">
                            <div class="coefassign">
                                <table class="coefassign">
                                    <?php
                                        $bonds = array();
                                        $methods = array();
                                        
                                        $data = $_SESSION['bonds'];
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
                                            echo '<td class="methods"><label class="score"><i>Score</i></label><label class="coef"><i>Reliability</i></label></td>';
                                        }
                                        echo '</tr>';
                                        
                                        //bonds
                                        $keys = array_keys($bonds);
                                        $methodkeys = array_keys($methods);
                                        for($i=0;$i<$rows;$i++){
                                            echo '<tr class="results">';
                                            $bondlabel = "";
                                            if(isset($data['MSMS']['scores'][$keys[$i]])){
                                                $bondlabel = '<td class="bonds"><a onmouseout="UnTip()" onmouseover="Tip(\'PP2 score: '.number_format($data['MSMS']['scores'][$keys[$i]]['pp2value'],0).' (The pp2 score evaluates whether the total abundance (intensity) of confirmatory matches could be a random).\')" class="bonds" href="'.$data['MSMS']['scores'][$keys[$i]]['filepath'].'" target="_blank">'.$keys[$i].'</a></td>';
                                            }
                                            else{
                                                $bondlabel = '<td class="bonds"><label class="bonds">'.$keys[$i].'</label></td>';
                                            }
                                            echo $bondlabel;for($j=0;$j<$cols;$j++){
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
                                                    echo '<td class="methods"><input onmouseover="Tip(\''.$info.'\');" onmouseout="UnTip();" id="'.$inputscore.'" name="'.$inputscore.'" class="score" size="6" value="'.$score.'"></input><input id="'.$inputcoef.'" name="'.$inputcoef.'" class="coef" size="6" value="'.$coef.'"></input></td>';
                                                }
                                                else{
                                                    echo '<td class="methods"><input id="'.$inputscore.'" name="'.$inputscore.'" class="score" size="6" value="'.$score.'"></input><input id="'.$inputcoef.'" name="'.$inputcoef.'" class="coef" size="6" value="'.$coef.'"></input></td>';
                                                }
                                                
                                            }
                                            echo '</tr>';
                                        }                                    
                                    ?>
                                </table>
                                <p><br></br></p>
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
