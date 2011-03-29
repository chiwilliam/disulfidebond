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
        
        $method = "1";
        $global = getIntegratedScores($M1bonds,$M2bonds,$method);
        
        return $global;        
    }
    
    function getIntegratedScores($M1bonds, $M2bonds,$method){
        
        $global = array();
        
        switch($method){
            case "1":
                
                $denominator = getMethod1Denominator($M1bonds,$M2bonds);
                
                $keys = array_keys($M1bonds);
                $count = count($keys);

                for($i=0;$i<$count;$i++){
                    if($keys[$i] != "THETA"){
                        $numerator = getMethod1Numerator($keys[$i],$M1bonds,$M2bonds);
                        $global[$keys[$i]]['score'] = $numerator/$denominator;
                    }
                }
                
                break;
            
            case "2":
               break;
            
            default:
                break;
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
                $denominator += ($tmp+$tmp2);
            }
        }        
        
        return $denominator;
    }
    
    function getMethod1Numerator($key,$M1bonds,$M2bonds){
        
        $tmp = ($M1bonds[$key]['score']*$M2bonds[$key]['score']);
        $tmp2 = ($M1bonds[$key]['score']*$M2bonds['THETA']['score']);
        
        $numerator += ($tmp+$tmp2);
        
        return $numerator;
    }

?>
