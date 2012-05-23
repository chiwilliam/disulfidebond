<?php

$root = $_SERVER['DOCUMENT_ROOT']."/ms2db++";
require_once $root."/prediction.php";
require_once $root."/integration.php";
require_once $root."/classes/Common.class.php";
    
include 'statistics.php';

$Func = new Commonclass();
$proteins = getProteins(0);

$count = count($proteins);
for($i=0;$i<$count;$i++){
    $pid = $proteins[$i][0];
    $bonds = getBondsForProtein($pid);
    $proteins[$i][] = $bonds;
}

//run SVM and CSP combined
for($i=0;$i<$count;$i++){
    
    $bonds = array();
    
    $bonds = prepareBonds($proteins[$i][5]);
    
    $bonds = $Func->organizeBonds(array(), array(), 
                                        $bonds['SVMlabel'], $bonds['SVMscore'], 
                                        $bonds['CSPlabel'], $bonds['SVMscore'], 
                                        array(), array(),
                                        array(), array());

    $bonds = $Func->calculateWeights($bonds);
    $combStrategy = array("1" => true,"2" => true,"3" => true,"4" => true,"5" => false,"6" => false);
    
    $bonds = IntegrateAllResults($combStrategy,$bonds);
    
    $tmpbonds = array();
    $tmpbonds = $bonds[1];
    $kbonds = array_keys($tmpbonds);
    for($j=0;$j<count($tmpbonds);$j++){
        if($kbonds[$j] != "THETA"){
            $cysteines = explode("-",$kbonds[$j]);
            $score = $tmpbonds[$kbonds[$j]]['score'];
            $method = 'Dempster';
            saveBondMethod($proteins[$i][0], $cysteines[0], $cysteines[1], $score, $method);
        }
    }
    unset($tmpbonds);
    
    $tmpbonds = array();
    $tmpbonds = $bonds[2];
    $kbonds = array_keys($tmpbonds);
    for($j=0;$j<count($tmpbonds);$j++){
        if($kbonds[$j] != "THETA"){
            $cysteines = explode("-",$kbonds[$j]);
            $score = $tmpbonds[$kbonds[$j]]['score'];
            $method = 'Yager';
            saveBondMethod($proteins[$i][0], $cysteines[0], $cysteines[1], $score, $method);
        }
    }
    unset($tmpbonds);
    
    $tmpbonds = array();
    $tmpbonds = $bonds[3];
    $kbonds = array_keys($tmpbonds);
    for($j=0;$j<count($tmpbonds);$j++){
        if($kbonds[$j] != "THETA"){
            $cysteines = explode("-",$kbonds[$j]);
            $score = $tmpbonds[$kbonds[$j]]['score'];
            $method = 'Campos';
            saveBondMethod($proteins[$i][0], $cysteines[0], $cysteines[1], $score, $method);
        }
    }
    unset($tmpbonds);
    
    $tmpbonds = array();
    $tmpbonds = $bonds[4];
    $kbonds = array_keys($tmpbonds);
    for($j=0;$j<count($tmpbonds);$j++){
        if($kbonds[$j] != "THETA"){
            $cysteines = explode("-",$kbonds[$j]);
            $score = $tmpbonds[$kbonds[$j]]['score'];
            $method = 'Shafer';
            saveBondMethod($proteins[$i][0], $cysteines[0], $cysteines[1], $score, $method);
        }
    }
    unset($tmpbonds);

}

echo 'Done!';

?>
