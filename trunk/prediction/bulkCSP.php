<?php

$root = $_SERVER['DOCUMENT_ROOT']."/ms2db++";
require_once $root."/prediction.php";
    
include 'statistics.php';

$pid = 0;
if(isset($_REQUEST['pid'])){
    $pid = $_REQUEST['pid'];
}

$proteins = getProteins($pid);

//run CSP
$countProt = count($proteins);
for($i=0;$i<$countProt;$i++){
    
    $numCys = ((int)($proteins[$i][3]));
    $proteinIDdebug = "";
    
    if($numCys <= 41){
        $cspbonds = array();
        $protein = formatProtein($proteins[$i][1], 0, 0);

        $D = -1;
        for($q=2;$q>0;$q--){
            $CSPmatchTmp = runCSPmethodAlone($protein, $q, $root);
            if($D < 0){
                if(count($CSPmatchTmp) > 4){
                    $D = $CSPmatchTmp['divergence'];
                    $CSPmatch = $CSPmatchTmp;
                }
            }
            else{
                if(count($CSPmatchTmp) > 4){
                    $D = $CSPmatchTmp['divergence'];
                    if($D < $CSPmatch['divergence']){
                        $CSPmatch = $CSPmatchTmp;
                    }
                }
            }
        }
    
        if($D >= 0){
            $csps = $CSPmatch['BONDS'];
            unset($csps['CSP']);
            $count = count($csps);
            for($j=0;$j<$count;$j++){
                $data = array();
                $data['bond'] = $csps[$j];
                $data['cys1'] = substr($csps[$j], 0, strpos($csps[$j], "-"));
                $data['cys2'] = substr($csps[$j], strpos($csps[$j], "-")+1);
                $data['score'] = number_format($CSPmatch['similarity'],4);
                $data['weightD'] = number_format($CSPmatch['divergence'],4);
                $data['weightCSPs'] = $CSPmatch['matches'];

                //divide score by number of bonds
                $cspbonds[$csps[$j]] = $data;
                unset($data);
            }
        }

        foreach($cspbonds as $bond){        
            saveBondMethod($proteins[$i][0], $bond['cys1'], $bond['cys2'], $bond['score'], 'CSP');
        }
    }
    else{
        $proteinIDdebug .= $proteins[$i][0].", ";
    }
}

echo 'Done!<br><br>';
echo $proteinIDdebug;

?>
