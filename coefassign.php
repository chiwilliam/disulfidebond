<?php
    session_start();
    
    require_once $root."/classes/Common.class.php";
    include 'integration.php';
    
    $MSMS = $_SESSION['MSMS'];
    $SVM = $_SESSION['SVM'];
    $CSP = $_SESSION['CSP'];
    $CUSTOM = $_SESSION['CUSTOM'];
    $CUSTOM2 = $_SESSION['CUSTOM2'];
    $combStrategy = $_SESSION['strategies'];
    
    $fastaProtein = $_SESSION['fasta'];
    $transmembranefrom = $_SESSION['transmembranefrom'];
    $transmembraneto = $_SESSION['transmembraneto'];
    
    $protease = $_SESSION['protease'];
    $alliontypes = $_SESSION['ions'];
    $missingcleavages = $_SESSION['missingcleavages'];
    
    $customdata = $_SESSION['customdata'];
    $custom2data = $_SESSION['custom2data'];
    
    $root = $_SESSION['root'];
    $GlobalBonds = $_SESSION['bonds'];
    
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
                $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['coef'] = $coef;
                if($methods[$i] == "MSMS"){
                    $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['pp2value'] = number_format($GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['pp2value']*$coef,4);
                }
                else{
                    $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['score'] = number_format($GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['score']*$coef,4);
                }
            }
        }
    }
    
    $GlobalSScomb = IntegrateAllResults($combStrategy,$GlobalBonds);
                
    $integration = true;
    if($integration)
    {
        $message = getResults($GlobalSScomb,$root,$fastaProtein);                    
    }
    
    if($transmembranefrom == 0 ){
        $transmembranefrom = "";
    }
    if($transmembraneto == 0 ){
        $transmembraneto = "";
    }    
    
    include 'analysis.php';
    exit();
?>
