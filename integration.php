<?php

    function integrateBonds($M1bonds, $M2bonds){
        
        $global = array();
        
        $M1keys = array_keys($M1bonds);
        $M2keys = array_keys($M2bonds);
        
        $count = count($M2keys);
        for($i=0;$i<$count;$i++){
            if(!in_array($M2keys[$i], $M1keys)){
                $M1bonds[$M2keys[$i]]['score'] = 0;
            }
        }
        $count = count($M1keys);
        for($i=0;$i<$count;$i++){
            if(!in_array($M1keys[$i], $M2keys)){
                $M2bonds[$M1keys[$i]]['score'] = 0;
            }
        }
        
        $global = getIntegratedScores($M1bonds,$M2bonds);
        
        return $global;        
    }
    
    function getIntegratedScores($M1bonds, $M2bonds){
        
        $global = array();
        
        $denominator = getMethod1Denominator($M1bonds,$M2bonds);

        $keys = array_keys($M1bonds);
        $count = count($keys);

        for($i=0;$i<$count;$i++){
            if($keys[$i] != "THETA"){
                $numerator = getMethod1Numerator($keys[$i],$M1bonds,$M2bonds);
                if($denominator > 0){
                    $global[$keys[$i]]['score'] = $numerator/$denominator;
                }
                else{
                    $global[$keys[$i]]['score'] = 0;
                }
            }
        }
        
        return $global;
    }
    
    function getMethod1Denominator($M1bonds,$M2bonds){
        
        $denominator = 0;
        
        $keys = array_keys($M1bonds);
        $count = count($keys);
        
        for($i=0;$i<$count;$i++){
            if($keys[$i] != "THETA"){
                $tmp = ($M1bonds[$keys[$i]]['score']*$M2bonds[$keys[$i]]['score']);
                $tmp2 = ($M1bonds[$keys[$i]]['score']*$M2bonds['THETA']['score']);
                $tmp3 = ($M1bonds[$keys[$i]]['THETA']*$M2bonds[$keys[$i]]['score']);
                $denominator += ($tmp+$tmp2+$tmp3);
            }
        }        
        
        return $denominator;
    }
    
    function getMethod1Numerator($key,$M1bonds,$M2bonds){
        
        $tmp = ($M1bonds[$key]['score']*$M2bonds[$key]['score']);
        $tmp2 = ($M1bonds[$key]['score']*$M2bonds['THETA']['score']);
        $tmp3 = ($M1bonds['THETA']['score']*$M2bonds[$key]['score']);
        
        $numerator += ($tmp+$tmp2+$tmp3);
        
        return $numerator;
    }   
        
    function integrateBondsPowerSet($M1bonds, $M2bonds){
        
            $bonds = array();
            $M1set = array();
            $M2set = array();
            
            //get all different disulfide bonds
            $merge = array_merge($M1bonds,$M2bonds);
            $merge = array_keys($merge);
            
            //calculate power set based on all bonds found by both methods
            $BaseSet = getPowerSet($merge);
            
            //assign the scores to each power set combination based on the set of input bonds
            //combinations with score 0 are discarded
            //probability function to assign scores to combinations based on each input bond
            $M1set = assignScoresToPowerSet($BaseSet,$M1bonds);
            $M2set = assignScoresToPowerSet($BaseSet,$M2bonds);
            
            //normalize all scores such that their sum is 1
            $M1set = normalizeScore($M1set);
            $M2set = normalizeScore($M2set);
            
            //merge scores from each method
            //does the intersection (multiplication) operation (matrix)
            $MergeSet = getMergedSet($M1set,$M2set);
            
            //list bonds separately, summing the scores of different entries for the same bond
            //all bonding combinations with more than one disulfide bond is added to theta
            //outputs only primitive hypothesis -> h1, h2, h3, etc... not h1 U h2, h1 U h3, etc...
            $bonds = calculateScore($MergeSet);
            
            return $bonds;
    }
    
    function getPowerSet($bonds){
        
        $count = count($bonds);
        $members = pow(2,$count);
        
        $return = array();
        
        for($i=0;$i<$members;$i++){
            //represent number in bits, using enough bit to represent 2^count
            $b = sprintf("%0".$count."b",$i);
            $out = array();
            for($j=0;$j<$count;$j++){
                //if bit at position $j = 1
                if($b{$j} == '1'){
                    $out[] = $bonds[$j];
                }
            }
            if(count($out)>0){
                $return[] = $out;
            }
        }
        
        $powerset = removeImpossibleCombinations($return);
        
        return $powerset;
        
    }
    
    function removeImpossibleCombinations($return)
    {
        $count = count($return);
        $powerset = array();
        for($i=0;$i<$count;$i++)
        {
            $counti = count($return[$i]);
            if($counti > 1)
            {
                $cys = array();
                for($j=0;$j<$counti;$j++)
                {
                    $tmp = explode("-", $return[$i][$j]);
                    for($k=0;$k<count($tmp);$k++)
                    {
                        $cys[$tmp[$k]] = $tmp[$k];
                    }
                }
                //all cysteines are different
                if(count($cys) == ($counti*2))
                {
                    $powerset[] = $return[$i];
                }
            }
            else
            {
                $powerset[] = $return[$i];
            }
        }
        return $powerset;
    }    
    
    function assignScoresToPowerSet($BaseSet,$bonds){
        
        $set = array();
        $nonzeroscore = pow(10, -4);
        
        $keys = array_keys($bonds);
        $count = count($BaseSet);
        
        for($i=0;$i<$count;$i++){
            $tmp = array();
            $tmp = $BaseSet[$i];
            
            //if only 1 bond: Bi
            if(count($tmp) == 1){
                $auxBond = array();
                $auxBond[] = $tmp[0];
                if(in_array($tmp[0], $keys)){
                    $score = getUnionScore(array($bonds[$tmp[0]]['score'],$tmp[0]));
                }
                else{
                    $score = 0;
                }
                if($score == 0){
                    $score = $nonzeroscore;
                }
                if($score > 0){
                    $set[] = array('bonds' => $auxBond, 'score' => $score);
                }                    
            }
            //more than 1 bond: Bi union Bj etc...
            else{
                $scores = array();
                for($j=0;$j<count($tmp);$j++){
                    if(in_array($tmp[$j], $keys)){
                        $scores[$j] = $bonds[$tmp[$j]]['score'];
                    }
                    else{
                        $scores[$j] = 0;
                    }
                }
                $scores[] = $tmp;
                $score = getUnionScore($scores);
                if($score == 0){
                    $score = $nonzeroscore;
                }
                if($score > 0){
                    $set[] = array('bonds' => $tmp, 'score' => $score);
                }
            }            
        }
        
        return $set;
        
    }
    
    function getUnionScore($scores){
        
        $score = 0;
        $totalscore = 0;
        $penalty = 0;
        $count = count($scores)-1;
        
        for($i=0;$i<$count;$i++){
            $totalscore += $scores[$i];
        }
        
        //formula is [Summation E from 1 to n of (2^(SCOREn-penalty) - 1)] divided by n
        //if any score is a zero (the method did not find that bond, apply a penalty
        //penalty is: totalscore divided by number of scores and a factor
        //the factor is 1/2 when score = 0 and -1/4 when score > 0
        for($i=0;$i<$count;$i++){
            if($scores[$i] == 0){
                $penalty = ($totalscore/$count)*0.5*-1.0;
            }
            else{
                $penalty = ($totalscore/$count)*0.25;
            }
            $score += (pow(2, $scores[$i]+$penalty)-1);
        }
        $score = number_format($score/$count,4);
        $score = max(array(0.0,$score));
        
        return number_format($score,4);        
    }
    
    function normalizeScore($bonds){
        
        $totalscore = 0;
        $count = count($bonds);
        
        for($i=0;$i<$count;$i++){
            $totalscore += $bonds[$i]['score'];
        }
        
        if($totalscore > 0){
            for($i=0;$i<$count;$i++){
                $bonds[$i]['score'] = number_format($bonds[$i]['score']/$totalscore,4);
            }
        }
        
        return $bonds;
    }
    
    function getMergedSet($M1set,$M2set){
        
        $set = array();
        
        $count = count($M1set);
        $count2 = count($M2set);
        
        for($i=0;$i<$count;$i++){
            for($j=0;$j<$count2;$j++){
                $M1 = $M1set[$i];
                $M2 = $M2set[$j];
                
                $keysM1 = $M1['bonds'];
                $keysM2 = $M2['bonds'];
                $countM1M2 = count($keysM1)+count($keysM2);
                
                $M1M2 = mergeBonds($keysM1,$keysM2);
                $countMerge = count($M1M2);
                
                if($countMerge == $countM1M2){
                    //intersection is empty
                    //$set[] = array('bonds' => $M1M2, 'score' => 0);
                }
                else{
                    $merge = array();
                    for($k=0;$k<count($keysM1);$k++){
                        if(in_array($keysM1[$k], $keysM2)){
                            $merge[] = $keysM1[$k];
                        }
                    }
                    $data = array('bonds' => $merge, 'score' => number_format($M1['score']*$M2['score'],4));
                    $set[] = $data;
                }                
            }
        }
        
        return $set;
    }
    
    function mergeBonds($bonds1,$bonds2){
        
        $bonds = array();
        $bonds = $bonds1;
        $count = count($bonds2);
        
        for($i=0;$i<$count;$i++){
            if(!in_array($bonds2[$i], $bonds1)){
                $bonds[] = $bonds2[$i];
            }
        }
        
        return $bonds;
    }
    
    function calculateScore($method, $MergeSet){
        
        /*
         * Array bonds must be in the format:
         * $bonds[142-292][score] = $score
         * $bonds[156-356][score] = $score
         */
        $bonds = array();
        
        $totalscore = 0;
        $theta = array();
        $totaltheta = 0;
        $count = count($MergeSet);
        
        //calculate denominator
        switch ($method) {
            case '1':
                //denominator is the sum of all the non-zero intersections
                for($i=0;$i<$count;$i++){
                    if($MergeSet[$i]['score'] > 0){                
                        $totalscore += $MergeSet[$i]['score'];
                    }
                }
                break;
            case '2':
                //do not use the denominator
                $totalscore = 1;
                break;
            case '3':
                //denominator is 1 + log(1/K), where K is the sum of all the non-zero intersections
                $K=0;
                for($i=0;$i<$count;$i++){
                    if($MergeSet[$i]['score'] > 0){                
                        $K += $MergeSet[$i]['score'];
                    }
                }
                if($K == 0){
                    //very small number
                    $K = pow(10, -10);
                }
                $totalscore += (1+log10(1/$K));
                break;
        }     
        
        //calculate numerators and theta
        for($i=0;$i<$count;$i++){            
            if($MergeSet[$i]['score'] > 0){                
                if(count($MergeSet[$i]['bonds']) == 1){                    
                    if(isset($bonds[$MergeSet[$i]['bonds'][0]]['score'])){
                        $bonds[$MergeSet[$i]['bonds'][0]]['score'] += number_format($MergeSet[$i]['score']/$totalscore,4);
                    }
                    else{
                        $bonds[$MergeSet[$i]['bonds'][0]]['score'] = number_format($MergeSet[$i]['score']/$totalscore,4);
                    }
                }
                else{
                    $key = '';
                    for($k=0;$k<count($MergeSet[$i]['bonds']);$k++){
                        if($k == 0){
                            $key = trim($MergeSet[$i]['bonds'][$k]);
                        }
                        else{
                            $key .= '/'.trim($MergeSet[$i]['bonds'][$k]);
                        }                        
                    }
                    if(isset($theta[$key])){
                        $theta[$key]['score'] += $MergeSet[$i]['score'];
                    }
                    else{
                        $theta[$key]['bonds'] = $MergeSet[$i]['bonds'];
                        $theta[$key]['score'] = $MergeSet[$i]['score'];
                    }
                    $totaltheta += $MergeSet[$i]['score'];
                    $totaltheta = number_format($totaltheta/$totalscore,4);
                }                
            }                        
        }
        
        if(count($theta) > 0){
            $bonds['THETA'] = $theta;
            $bonds['THETA']['TOTAL'] = $totaltheta;
        }
        
        return $bonds;
    }
    
    function calculateScoreDecision($Sets){
        /*
         * Array bonds must be in the format:
         * $bonds[142-292][score] = $score
         * $bonds[156-356][score] = $score
         */
        $tmp = array();
        $bonds = array();
        
        $countmethods = count($Sets);
        for($i=0;$i<$countmethods;$i++){
            $countbonds = count($Sets[$i]);
            for($j=0;$j<$countbonds;$j++){
                //ONE SINGLE BOND
                if(count($Sets[$i][$j]['bonds']) == 1){
                    if(isset($Sets[$i][$j]['coeficient'])){
                        $coeficient = $Sets[$i][$j]['coeficient'];
                    }
                    else{
                        $coeficient = 1.0;
                    }                    
                    $score = $Sets[$i][$j]['score'];
                    $score = number_format($score*$coeficient,4);
                    $tmp[$Sets[$i][$j]['bonds'][0]][] = $score;
                }
            }
        }
        
        $keys = array_keys($tmp);
        $countbonds = count($keys);
        for($i=0;$i<$countbonds;$i++){
            $score = 0;
            $countscores = count($tmp[$keys[$i]]);
            for($j=0;$j<$countscores;$j++){
                $score += $tmp[$keys[$i]][$j];
            }
            $score = number_format($score/$countscores,4);
            $bonds[$keys[$i]]['score'] = $score;
        }
        
        return $bonds;
    }
    
    function integrateGlobalBondsPowerSet($method, $MSMSbonds, $SVMbonds, $CSPbonds, $CUSTOMbonds, $CUSTOM2bonds){
        
            $bonds = array();
            
            $M1set = array();
            $M2set = array();
            $M3set = array();
            $M4set = array();
            $M5set = array();
            
            $Sets = array();
            
            //get all different disulfide bonds
            $merge = array_merge($MSMSbonds,$SVMbonds);
            $merge = array_merge($merge,$CSPbonds);
            $merge = array_merge($merge,$CUSTOMbonds);
            $merge = array_merge($merge,$CUSTOM2bonds);
            $merge = array_keys($merge);
            
            //calculate power set based on all bonds found by both methods
            $BaseSet = getPowerSet($merge);
            
            //assign the scores to each power set combination based on the set of input bonds
            //combinations with score 0 are discarded
            //probability function to assign scores to combinations based on each input bond
            if(count($MSMSbonds) > 0){
                $MSMSset = assignScoresToPowerSet($BaseSet,$MSMSbonds);
            }
            if(count($SVMbonds) > 0){
                $SVMset = assignScoresToPowerSet($BaseSet,$SVMbonds);
            }
            if(count($CSPbonds) > 0){
                $CSPset = assignScoresToPowerSet($BaseSet,$CSPbonds);
            }
            if(count($CUSTOMbonds) > 0){
                $CUSTOMset = assignScoresToPowerSet($BaseSet,$CUSTOMbonds);
            }
            if(count($CUSTOM2bonds) > 0){
                $CUSTOM2set = assignScoresToPowerSet($BaseSet,$CUSTOM2bonds);
            }
            
            //normalize all scores such that their sum is 1
            if(count($MSMSset) > 0){
                $MSMSset = normalizeScore($MSMSset);
                $Sets[] = $MSMSset;
            }
            if(count($SVMset) > 0){
                $SVMset = normalizeScore($SVMset);
                $Sets[] = $SVMset;
            }
            if(count($CSPset) > 0){
                $CSPset = normalizeScore($CSPset);
                $Sets[] = $CSPset;
            }
            if(count($CUSTOMset) > 0){
                $CUSTOMset = normalizeScore($CUSTOMset);
                $Sets[] = $CUSTOMset;
            }
            if(count($CUSTOM2set) > 0){
                $CUSTOM2set = normalizeScore($CUSTOM2set);
                $Sets[] = $CUSTOM2set;
            }
            
            if($method == "4"){
                $bonds['4'] = calculateScoreDecision($Sets);
            }
            else{
                //merge scores from each method
                //does the intersection (multiplication) operation (matrix)
                $MergeSet = getGlobalMergedSet($Sets);
                if($method == 0){
                    //list bonds separately, summing the scores of different entries for the same bond
                    //all bonding combinations with more than one disulfide bond is added to theta
                    //outputs only primitive hypothesis -> h1, h2, h3, etc... not h1 U h2, h1 U h3, etc...
                    $bonds['1'] = calculateScore("1",$MergeSet);
                    $bonds['2'] = calculateScore("2",$MergeSet);
                    $bonds['3'] = calculateScore("3",$MergeSet);
                    $bonds['4'] = calculateScoreDecision($Sets);
                }
                else{
                    $bonds[$method] = calculateScore($method,$MergeSet);
                }
            }
            
            return $bonds;
    }
    
    function getGlobalMergedSet($Sets){
        
        $merge = array();
        $count = count($Sets);
        
        switch ($count) {
            case 1:
                $merge = $Sets[0];
                break;
            case 2:
                $merge = getMergedSet($Sets[0], $Sets[1]);
                break;
            case 3:
                $merge = getMergedSet($Sets[0], $Sets[1]);
                $merge = getMergedSet($merge, $Sets[2]);
                break;
            case 4:
                $merge = getMergedSet($Sets[0], $Sets[1]);
                $merge = getMergedSet($merge, $Sets[2]);
                $merge = getMergedSet($merge, $Sets[3]);
                break;
            case 5:
                $merge = getMergedSet($Sets[0], $Sets[1]);
                $merge = getMergedSet($merge, $Sets[2]);
                $merge = getMergedSet($merge, $Sets[3]);
                $merge = getMergedSet($merge, $Sets[4]);
                break;
        }
        
        return $merge;        
    }

?>
