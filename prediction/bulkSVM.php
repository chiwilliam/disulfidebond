<?php

$root = $_SERVER['DOCUMENT_ROOT']."/ms2db++";
require_once $root."/prediction.php";
require_once $root."/classes/Common.class.php";
    
include 'statistics.php';

$Func = new Commonclass();
$proteins = getProteins(0);

//run SVM
$count = count($proteins);
for($i=0;$i<$count;$i++){
    
    $pbonds = array();
    
    //SVM
    $time = array();
    $time["start"] = microtime(true);
    
    $pbonds = getBondsByPredictiveTechniques(array(), $proteins[$i][1], $root, &$time, 0, 0);
    
    if(count($pbonds) > 0){
        
        $pbondstmp = array();
        $Gabowresults = $Func->sortTruebonds($pbonds);
        $pbondstmp = $Gabowresults['graphbonds'];
        $bondstmp = $Gabowresults['readybonds'];

        $newgraph = array();
        $SS = array_keys($pbondstmp);
        for($w=0;$w<count($SS);$w++){

            $cys1 = (string)$pbondstmp[$SS[$w]]['cys1'];
            $cys2 = (string)$pbondstmp[$SS[$w]]['cys2'];


            //$counttmp = $pbonds[$SS[$w]]['scoreexp'] + $pbonds[$SS[$w]]['similarityexp'];
            $counttmp = $pbondstmp[$SS[$w]]['score']*100 + $pbondstmp[$SS[$w]]['similarity']*100;
            for($z=0;$z<$counttmp;$z++){
                $newgraph[$cys1][] = $cys2;
                $newgraph[$cys2][] = $cys1;
            }
        }

        if(count($pbondstmp) > 0){
            $predictedbonds = $Func->executeGabow($newgraph, $root);
        }
        else{
            $predictedbonds = array();
        }

        unset($pbondstmp);

        //patch to fix the issue with the Gabow script.
        $predictedbonds = $Func->combineTrueBonds($predictedbonds,$bondstmp);

        $tmp = $predictedbonds;
        unset($predictedbonds);
        $pcount = count($tmp);
        for($a=0;$a<$pcount;$a++){
            if($pbonds[$tmp[$a]]['score'] >= 0.10){
                $predictedbonds[] = $tmp[$a];
            }                    
        }
        
    }    
    
    if(count($predictedbonds) > 0){
        foreach($predictedbonds as $bond){        
            $cysteines = explode("-",$bond);
            saveBondMethod($proteins[$i][0], $cysteines[0], $cysteines[1], $pbonds[$bond]['score'], 'SVM');
        }
    }
}

echo 'Done';

?>
