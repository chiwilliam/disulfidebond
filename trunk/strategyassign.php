<?php
    session_start();
    
    $step = $_SESSION['step'];
    $fastaProtein = $_SESSION['fasta'];
    $root = $_SESSION['root'];
    $GlobalBonds = $_SESSION['coefbonds'];
    
    $errors = array();
    $errors["nostrategy"]["code"] = "11";
    $errors["nostrategy"]["message"] = "At least one combination strategy needs to be selected!";
        
    require_once $root."/classes/Common.class.php";
    include 'integration.php';
    
    $S1 = $_REQUEST["inputstrategy1"];
    $S2 = $_REQUEST["inputstrategy2"];
    $S3 = $_REQUEST["inputstrategy3"];
    $S4 = $_REQUEST["inputstrategy4"];
    $S5 = $_REQUEST["inputstrategy5"];
    $S6 = $_REQUEST["inputstrategy6"];
    $_SESSION['S1'] = $S1;
    $_SESSION['S2'] = $S2;
    $_SESSION['S3'] = $S3;
    $_SESSION['S4'] = $S4;
    $_SESSION['S5'] = $S5;
    $_SESSION['S6'] = $S6;
    
    $combStrategy = array("1" => false,"2" => false,"3" => false,"4" => false,"5" => false,"6" => false);
    $countStrategies = 0;
    
    if(strlen($S1) > 0){
        $combStrategy['1'] = true;
        $countStrategies++;
    }
    if(strlen($S2) > 0){
        $combStrategy['2'] = true;
        $countStrategies++;
    }
    if(strlen($S3) > 0){
        $combStrategy['3'] = true;
        $countStrategies++;
    }
    if(strlen($S4) > 0){
        $combStrategy['4'] = true;
        $countStrategies++;
    }
    if(strlen($S5) > 0){
        $combStrategy['5'] = true;
        $countStrategies++;
    }
    if(strlen($S6) > 0){
        $combStrategy['6'] = true;
        $countStrategies++;
    }    
    
    //account for coefficients
    $methods = array_keys($GlobalBonds);
    $count = count($methods);
    for($i=0;$i<$count;$i++){
        $count2 = count($GlobalBonds[$methods[$i]]['bonds']);
        if($count2 > 0){
            $bonds = $GlobalBonds[$methods[$i]]['bonds'];
            for($j=0;$j<$count2;$j++){
                $inputid = 'coef_'.$bonds[$j].'_'.$methods[$i];
                $coef = $_POST[$inputid];
                $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['coefcombination'] = $coef;
                if($methods[$i] == "MSMS"){
                    $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['ppvalue'] = number_format($GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['ppvalue']*$coef,4);
                }
                else{
                    $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['score'] = number_format($GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['score']*$coef,4);
                }
            }
        }
    }
    
    if($countStrategies > 0){
    
        $GlobalSScomb = IntegrateAllResults($combStrategy,$GlobalBonds);

        $message = getResults($GlobalSScomb,$root,$fastaProtein);
        
        $TXTFile = getTextFile($GlobalSScomb,$root);
        $XMLFile = getXMLFile($GlobalSScomb,$root);
        $DebugFile = formXMLDebug($root);

        $step++;
        $_SESSION['step'] = $step;

        include 'results.php';
    }
    else{
        $error = "Error ".$errors["nostrategy"]["code"].": ".$errors["nostrategy"]["message"]."<br />";
        include 'strategies.php';
    }
?>
