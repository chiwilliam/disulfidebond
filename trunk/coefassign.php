<?php
    session_start();
    
    $step = $_SESSION['step'];
    $root = $_SESSION['root'];
    $GlobalBonds = $_SESSION['bonds'];
    
    require_once $root."/classes/Common.class.php";
    include 'integration.php';
    
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
                    $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['ppvalue'] = number_format($GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['ppvalue']*$coef,4);
                }
                else{
                    $GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['score'] = number_format($GlobalBonds[$methods[$i]]['scores'][$bonds[$j]]['score']*$coef,4);
                }
            }
        }
    }
    
    if($step == 2){
        $step++;
        $_SESSION['coefbonds'] = $GlobalBonds;
        $_SESSION['step'] = $step;
        include 'strategies.php';
        exit();
    }
    
    $GlobalSScomb = IntegrateAllResults($combStrategy,$GlobalBonds);
                
    $message = getResults($GlobalSScomb,$root,$fastaProtein);                        
    
    include 'analysis.php';
    exit();
?>
