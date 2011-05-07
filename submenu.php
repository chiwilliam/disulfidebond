
<div id="subnavigation" class="subhorizontalmenu">
    <ul>
        <li <?php if($page == "methods" ) echo 'class="selected"';?>><a href="methods.php" onmouseover="Tip('Methods Selection')" onmouseout="UnTip()">1. Methods Selection</a></li>
        <li <?php if($page == "coefficients" || $page == "kernel" ) echo 'class="selected"';?>><a href="<?php if($step > 1) echo 'coefficients.php'; else echo 'javascript:void(0)'; ?>" onmouseover="Tip('Confidence Assignment')" onmouseout="UnTip()">2. Confidence Assignment</a></li>
        <li <?php if($page == "strategies" || $page == "coefassign" || ($page == "strategyassign" && strlen($error) > 0) ) echo 'class="selected"';?>><a href="<?php if($step > 2) echo 'strategies.php'; else echo 'javascript:void(0)'; ?>" onmouseover="Tip('Combination Strategies')" onmouseout="UnTip()">3. Combination Strategies</a></li>
        <li <?php if($page == "results" || ($page == "strategyassign" && strlen($error) == 0) ) echo 'class="selected"';?>><a href="<?php if($step > 3) echo 'results.php'; else echo 'javascript:void(0)'; ?>" onmouseover="Tip('Global Connectivity')" onmouseout="UnTip()">4. Global Connectivity</a></li>
    </ul>
</div>