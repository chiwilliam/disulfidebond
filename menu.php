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
        <li <?php if($page == "index" || strlen($page) == 0) echo 'class="selected"'; else echo 'class="notselected"'; ?>><a href="index.php" onmouseover="Tip('MS2DB Home Page')" onmouseout="UnTip()"><label <?php if($page == "index" || strlen($page) == 0) echo 'class="selected"'; else echo 'class="notselected"'; ?>>Home</label></a></li>
        <li <?php if($page == "methods" || $page == "kernel" || $page == "coefficients" || $page == "coefassign" || $page == "strategies" || $page == "strategyassign" || $page == "results") echo 'class="selected"'; else echo 'class="notselected"'; ?>><a href="methods.php" onmouseover="Tip('MS2DB++ Disulfide Bond Determination')" onmouseout="UnTip()"><label <?php if($page == "methods" || $page == "kernel" || $page == "coefficients" || $page == "coefassign" || $page == "strategies" || $page == "strategyassign" || $page == "results") echo 'class="selected"'; else echo 'class="notselected"'; ?>>Find Disulfide Connectivity</label></a></li>
        <li <?php if($page == "datasets") echo 'class="selected"'; else echo 'class="notselected"'; ?>><a href="datasets.php" onmouseover="Tip('MS2DB Datasets')" onmouseout="UnTip()"><label <?php if($page == "datasets") echo 'class="selected"'; else echo 'class="notselected"'; ?>>Datasets</label></a></li>
        <li <?php if($page == "publications") echo 'class="selected"'; else echo 'class="notselected"'; ?>><a href="publications.php" onmouseover="Tip('MS2DB Publications')" onmouseout="UnTip()"><label <?php if($page == "publications") echo 'class="selected"'; else echo 'class="notselected"'; ?>>Publications</label></a></li>
        <li <?php if($page == "contactus") echo 'class="selected"'; else echo 'class="notselected"'; ?>><a href="contactus.php" onmouseover="Tip('MS2DB Contact Us')" onmouseout="UnTip()"><label <?php if($page == "contactus") echo 'class="selected"'; else echo 'class="notselected"'; ?>>Contact Us</label></a></li>
        <li <?php if($page == "ms2db+") echo 'class="selected"'; else echo 'class="notselected"'; ?>><a target="_blank" href="http://haddock2.sfsu.edu/~ms2db/disulfidebond/" onmouseover="Tip('MS2DB+ (MS/MS only) Disulfide Bond Determination')" onmouseout="UnTip()"><label <?php if($page == "ms2db+") echo 'class="selected"'; else echo 'class="notselected"'; ?>>MS2DB+</label></a></li>
        <li <?php if($page == "help" || $page == "help_ms2db+") echo 'class="selected"'; else echo 'class="notselected"'; ?>><a href="help.php" onmouseover="Tip('MS2DB Help')" onmouseout="UnTip()"><label <?php if($page == "help" || $page == "help_ms2db+") echo 'class="selected"'; else echo 'class="notselected"'; ?>>Help</label></a></li>
        
    </ul>
</div>

<?php
    if($page == "methods" || $page == "kernel" || $page == "coefficients" || $page == "coefassign" || 
       $page == "strategies" || $page == "strategyassign" || $page == "results"){
        include 'submenu.php';
    }
?>