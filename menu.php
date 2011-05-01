<?php
    $page = $_SERVER['REQUEST_URI'];
    $page = str_replace("/ms2db++/", "", $page);
    $page = str_replace("/~ms2db", "", $page);
    $page = str_replace(".php", "", $page);
    $index = strpos($page, "?");
    if($index > 0){
        $page = substr($page, 0, $index);
    }    
?>


<div id="navigation" class="horizontalmenu">
    <ul>
        <li <?php if($page == "index" || strlen($page) == 0) echo 'class="selected"';?>><a href="index.php" onmouseover="Tip('MS2DB Home Page')" onmouseout="UnTip()">Home</a></li>
        <li <?php if($page == "analysis" || $page == "coefficients" || $page == "kernel" || $page == "coefassign") echo 'class="selected"';?>><a href="analysis.php" onmouseover="Tip('MS2DB++ Disulfide Bond Determination')" onmouseout="UnTip()">Find Disulfide Connectivity</a></li>
        <li <?php if($page == "datasets") echo 'class="selected"';?>><a href="datasets.php" onmouseover="Tip('MS2DB Datasets')" onmouseout="UnTip()">Datasets</a></li>
        <li <?php if($page == "publications") echo 'class="selected"';?>><a href="publications.php" onmouseover="Tip('MS2DB Publications')" onmouseout="UnTip()">Publications</a></li>
        <li <?php if($page == "contactus") echo 'class="selected"';?>><a href="contactus.php" onmouseover="Tip('MS2DB Contact Us')" onmouseout="UnTip()">Contact Us</a></li>
        <li <?php if($page == "ms2db+") echo 'class="selected"';?>><a target="_blank" href="http://haddock2.sfsu.edu/~ms2db/disulfidebond/" onmouseover="Tip('MS2DB+ (MS/MS only) Disulfide Bond Determination')" onmouseout="UnTip()">MS2DB+</a></li>
        <li <?php if($page == "help" || $page == "help_ms2db+") echo 'class="selected"';?>><a href="help.php" onmouseover="Tip('MS2DB Help')" onmouseout="UnTip()">Help</a></li>
        
    </ul>
</div>