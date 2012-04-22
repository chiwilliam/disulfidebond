<?php

function DBconnect(){

    $db = new mysqli("localhost", "root", "xmas", "ms2db++");
    if ($db->connect_errno) {
        echo 'Could not connect to database';
        exit;
    }
    return $db;
    
}

function saveProtein($sequence,$length){
    
    $proteinID = 0;
    
    $db = DBconnect();
    
    $uQuery = 'insert into protein (sequence,length) VALUES ("'.$sequence.'",'.$length.')';
    $db->query($uQuery);
    
    if(strlen(trim($db->error)) == 0){
        $sQuery = 'select proteinid from protein order by proteinid desc limit 0,1';
        $result = $db->query($sQuery);
        if($result){
            $obj = $result->fetch_object();
            $proteinID = $obj->proteinid;
        }
    }    
    
    return $proteinID;
}

function saveBond($proteinID,$cys1,$cys2){
    
    $db = DBconnect();
    
    $uQuery = 'insert into truebonds (proteinid, cys1, cys2) VALUES ('.$proteinID.','.$cys1.','.$cys2.')';
    $db->query($uQuery);
    
}

function saveBondMethod($proteinID,$cys1,$cys2,$score, $method){
    
    $db = DBconnect();
    
    $uQuery = 'insert into bonds (proteinid, cys1, cys2, score, method) VALUES ('.$proteinID.','.$cys1.','.$cys2.','.$score.',\''.$method.'\')';
    $db->query($uQuery);
    
}

function getProteins($pid){
    
    if(!isset($pid)){
        $pid = 0;
    }
    
    $proteins = array();
    $db = DBconnect();
    
    $sQuery = 'select * from protein where proteinid > '.((string)($pid)).' order by proteinid';
    $result = $db->query($sQuery);
    
    while($row = $result->fetch_row()){
        $proteins[] = $row;
    }
    
    return $proteins;
}

function getBondsForProtein($pid){
    
    $bonds = array();
    
    if($pid == 0){
        return $bonds;
    }
    
    $db = DBconnect();
    
    $sQuery = "select bondid, cys1, cys2, score from bonds where method = 'SVM' and proteinid = ".((string)($pid))." order by bondid";
    $result = $db->query($sQuery);
    
    while($row = $result->fetch_row()){
        $bonds['SVM'][] = $row;
    }
    
    $sQuery = "select bondid, cys1, cys2, score from bonds where method = 'CSP' and proteinid = ".((string)($pid))." order by bondid";
    $result = $db->query($sQuery);
    
    while($row = $result->fetch_row()){
        $bonds['CSP'][] = $row;
    }
    
    return $bonds;
}

function prepareBonds($bonds){
    
    $newBonds = array();
    $newBonds['SVMlabel'] = array();
    $newBonds['SVMscore'] = array();
    $newBonds['CSPlabel'] = array();
    $newBonds['CSPscore'] = array();
    
    $tmp = $bonds['SVM'];
    for($i=0;$i<count($tmp);$i++){
        $newBonds['SVMlabel'][] = $tmp[$i][1]."-".$tmp[$i][2];
        $newBonds['SVMscore'][$tmp[$i][1]."-".$tmp[$i][2]]['bond'] = $tmp[$i][1]."-".$tmp[$i][2];
        $newBonds['SVMscore'][$tmp[$i][1]."-".$tmp[$i][2]]['cys1'] = $tmp[$i][1];
        $newBonds['SVMscore'][$tmp[$i][1]."-".$tmp[$i][2]]['cys2'] = $tmp[$i][2];
        $newBonds['SVMscore'][$tmp[$i][1]."-".$tmp[$i][2]]['score'] = $tmp[$i][3];
    }
    unset($tmp);
    
    $tmp = $bonds['CSP'];
    for($i=0;$i<count($tmp);$i++){
        $newBonds['CSPlabel'][] = $tmp[$i][1]."-".$tmp[$i][2];
        $newBonds['CSPscore'][$tmp[$i][1]."-".$tmp[$i][2]]['bond'] = $tmp[$i][1]."-".$tmp[$i][2];
        $newBonds['CSPscore'][$tmp[$i][1]."-".$tmp[$i][2]]['cys1'] = $tmp[$i][1];
        $newBonds['CSPscore'][$tmp[$i][1]."-".$tmp[$i][2]]['cys2'] = $tmp[$i][2];
        $newBonds['CSPscore'][$tmp[$i][1]."-".$tmp[$i][2]]['score'] = $tmp[$i][3];
    }
    
    return $newBonds;
}

?>
