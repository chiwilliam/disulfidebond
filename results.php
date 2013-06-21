<?php session_start(); $_SESSION['step'] = 4; ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Connectivity Results</title>
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
                </div>
                <div id="column_l">
                    <!-- #BeginEditable "content" -->
                    <div id="bondsdiv">
                        <table class="input">
                            <tr id="trbondsdiv">
                                <td class="inputrightresults">
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
                    <div id="files">
                        <p class="files">
                            <br></br>
                            *Download the results in
                            <a href="<?php echo $TXTFile; ?>" target="_blank">TXT</a>
                            or
                            <a href="<?php echo $XMLFile; ?>" target="_blank">XML</a>                            
                        </p>
                        <p class="files">
                            **Intermediary scores: <a href="<?php echo $DebugFile; ?>" target="_blank">XML</a>
                        </p>
                    </div>
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
