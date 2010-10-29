<?php
    
    //build root path (i.e.: C:\xampp\htdocs\)
    $root = $_SERVER['DOCUMENT_ROOT'];
    //fix for tintin root path
    if(trim($root) == "/var/www/html/bioinformatics"){
        $root = "/home/whemurad/public_html";
        $istintin = "yes";
    }
    include $root."/disulfidebond/prediction/functionsDAT.php";
    include $root."/disulfidebond/prediction/functionsCSP.php";
    
    function getBondsByPredictiveTechniques($bonds,$FASTA){
        
        //$bonds is the array holding all bonds found by the MS/MS method
        //the structure is
        /*
         * $bond[0] = "C1-C2"
         * $bond[1] = "C3-C4"
         * $bond[2] = "C5-C6"
         */
        //$FASTA is the protein's FASTA sequence
        
        //$pbonds is the array holding all bonds found by the predictive method (SVMs)
        //and follows the same format mentioned above
        $pbonds = array();
        $protein = array();
        $CSPmatch = array();
        
        $protein = formatProtein($FASTA);
        
        //This is the function that changes according to the SVMs used!
        //Level-1 SVM
        $result = runSVM($protein);
        
        $pbonds = getTruebonds($protein,$result,$bonds);
        
        //Level-2 SVM
        $CSPmatch = confirmBondsViaSVM2(&$protein, &$pbonds, $bonds);
        
        unset($bonds);
        unset($protein);
        unset($result);
        
        return $pbonds;
    }
    
    function formatProtein($FASTA){
        
        $prot = array();
        
        $prot['FASTA'] = $FASTA;
        $prot['AAs'] = (int)(trim(strlen($FASTA)));
        
        $cys = getCysteines($FASTA);
        
        $bonds = getBonds($cys);
        
        $prot['BONDS'] = $bonds;
        
        unset($cys);
        unset($bonds);
        
        return $prot;
    }
    
    function runSVM($protein){
        
        $result = array();
        $SVMdata = array();
        
        $SVMdata = getSVMdata($protein);
        
        $filename = generateRandomString();
        
        $folder = "SVM";
        $svmfilename = getFileName($folder,$filename);
        $svmfilenamepredict = $svmfilename.".predict";
        $save = file_put_contents($svmfilename, $SVMdata);
        
        $model = getFileName("prediction", "allsvm.model");
        $command = getFileName("prediction", "svm-predict.exe");
        $command .= " -b 1 ".$svmfilename." ".$model." ".$svmfilenamepredict;
        exec($command);
        
        $tmp = file_get_contents($svmfilenamepredict);
        $result = explode("\n", $tmp);
        unset($tmp);
        array_pop(&$result);
        array_shift(&$result);
        
        return $result;
    }
    
    function getCysteines($FASTA){
        
        $cys = array();
        $AAs = array();
        $AAs = str_split($FASTA,1);
        $length = count($AAs);
        
        for($i=0;$i<$length;$i++){
            if($AAs[$i] == 'C'){
                $cys[] = $i+1;
            }
        }
        
        return $cys;
    }
    
    function getBonds($cys){
        
        $bonds = array();
        
        $count = count($cys);
        $bondcount = 0;
        for($i=0;$i<$count-1;$i++){
            for($j=$i+1;$j<$count;$j++){
                $bonds[$bondcount]['BOND'] = $cys[$i].'-'.$cys[$j];
                $bonds[$bondcount]['DOC'] = $cys[$j]-$cys[$i];
                $bondcount++;
            }
        }
        
        return $bonds;
    }
    
    function getSVMdata($protein){
        
        $SVMdata = array();
        
        //form the 13 window: 6AAs+C+6AAs
        $windowsize = 13;        
        //Disulfide Bonds
        $class = "0";
        $count = count($protein['BONDS']);
        for($j=0;$j<$count;$j++){
            $protein['BONDS'][$j]['WINDOWS'] = getWindows($windowsize,$protein['FASTA'],$protein['BONDS'][$j]['BOND']);
            $SVMdata[] = getFeatures($class,$protein['BONDS'][$j]['WINDOWS']['C1'],$protein['BONDS'][$j]['WINDOWS']['C2'],$protein['BONDS'][$j]['DOC']);
        }
        
        return $SVMdata;
    }
    
    function getFileName($folder,$filename){
        
        $path = "";
        
        //build root path (i.e.: C:\xampp\htdocs\)
        $root = $_SERVER['DOCUMENT_ROOT'];
        //fix for tintin root path
        if(trim($root) == "/var/www/html/bioinformatics"){
            $root = "/home/whemurad/public_html";
        }
        $path = $root."/disulfidebond/".$folder."/".$filename;
        
        return $path;
    }
    
    function generateRandomString() {
        
        $length = 10;
        $characters = "abcdefghijklmnopqrstuvwxyz";
        $string = "";    

        for($i=0;$i<$length;$i++){
            $string .= $characters[mt_rand(0, strlen($characters))];
        }

        return $string;
    }
    
    function getTruebonds($protein,$result, $bonds){
        
        $pbonds = array();        
        $tmpbonds = array();
        $counterbonds = 0;
        
        $count = count($result);
        for($i=0;$i<$count;$i++){
            $data = explode(" ", $result[$i]);
            if($data[0] == "1"){
                $bond = $protein['BONDS'][$i]['BOND'];
                $score = $data[1];
                $tmpbonds[$counterbonds]['BOND'] = $bond;
                $tmpbonds[$counterbonds]['SCORE'] = $score;
                $tmpbonds[$counterbonds]['INDEX'] = $i;
                $counterbonds++;                
            }
        }
        
        $pbonds = filterBonds($tmpbonds,$bonds);
        
        unset($tmpbonds);
        return $pbonds;        
    }
    
    function filterBonds($tmpbonds,$bonds){
        
        $pbonds = array();
        $tmpcys = array();
        
        for($j=0;$j<count($bonds);$j++){
            $cys = explode("-", $bonds[$j]);
            $tmpcys[] = $cys[0];
            $tmpcys[] = $cys[1];
        }                
            
        $count = count($tmpbonds);
        for($i=0;$i<$count;$i++){
            //remove bonds already found by MS/MS
            if(!in_array($tmpbonds[$i]['BOND'], $bonds)){
                $cys = explode("-", $tmpbonds[$i]['BOND']);
                $cys1 = $cys[0];
                $cys2 = $cys[1];                
                //remove bonds that are impossible due to bonds found by MS/MS
                if(!(in_array($cys1, $tmpcys) || in_array($cys2, $tmpcys))){
                    $pbonds[$tmpbonds[$i]['BOND']]['bond'] = $tmpbonds[$i]['BOND'];
                    $pbonds[$tmpbonds[$i]['BOND']]['index'] = $tmpbonds[$i]['INDEX'];
                    $pbonds[$tmpbonds[$i]['BOND']]['cys1'] = $cys1;
                    $pbonds[$tmpbonds[$i]['BOND']]['cys2'] = $cys2;
                    $pbonds[$tmpbonds[$i]['BOND']]['score'] = round($tmpbonds[$i]['SCORE'],3);
                    //use exp() function two times to give more importance to higher scores. 
                    //See exponential function graph online!
                    $pbonds[$tmpbonds[$i]['BOND']]['scoreexp'] = round(exp(exp($pbonds[$tmpbonds[$i]['BOND']]['score'])),3);
                }                
            }
        }
        
        return $pbonds;
    }
    
    function confirmBondsViaSVM2(&$protein, &$pbonds, $msbonds){
        
        $filenameDB = getFileName("prediction", "uniprotDB.dat");
        $proteinDB = getProtein($filenameDB);
        $maxProteinLengthDB = getMaxProteinLength(&$proteinDB);
        
        //remove non-bonds from all possible combinations
        $protein['BONDS'] = updateToValidBonds($pbonds, $msbonds);
        
        //remove Bonds that received higher score, but will not as high as other bonds
        //clean the graph to speed up Gabow and avoid false positives
        $pbonds = getBondsByMaxScoreExpFromSVM($pbonds);
        $protein['BONDS'] = removeBondsByMaxScoreExpFromSVM($protein['BONDS'], array_keys($pbonds));
        
        $bonds = array_keys($pbonds);        
        $count = count($bonds);
        for($i=0;$i<$count;$i++){
            $pbonds[$bonds[$i]]['csp'] = getCSP($bonds[$i], $msbonds);
            $pbonds[$bonds[$i]]['relativelength'] = round(strlen($protein['FASTA'])/$maxProteinLengthDB,3);
            $protein['BONDS'][$i]['CSP'] = $pbonds[$bonds[$i]]['csp'];
            $protein['BONDS'][$i]['relativelength'] = round($pbonds[$bonds[$i]]['relativelength'],3);
        }

        $countDB = count($proteinDB);
        for($i=0;$i<$countDB;$i++){
            $proteinDB[$i]['CSP'] = getCSPKnownConnectivity($proteinDB[$i]);
        }

        $CSPmatches = array();
        $CSPmatches = getCSPData(&$protein,&$proteinDB);
        
        unset($proteinDB);

        for($i=0;$i<count($CSPmatches);$i++){
            $CSPmatches[$i]['similarity'] = calculateSimilarity($CSPmatches[$i]['CSP']);
        }
        
        for($i=0;$i<$count;$i++){
            $pbonds[$bonds[$i]]['cspd'] = $CSPmatches[$i]['CSP'];
            $pbonds[$bonds[$i]]['proteinDBmatch'] = $CSPmatches[$i]['match'];
            $pbonds[$bonds[$i]]['similarity'] = round($CSPmatches[$i]['similarity'],3);
            $protein['BONDS'][$i]['CSPd'] = $CSPmatches[$i]['CSP'];
            $protein['BONDS'][$i]['proteinDBmatch'] = $CSPmatches[$i]['match'];
            $protein['BONDS'][$i]['similarity'] = round($CSPmatches[$i]['similarity'],3);
        }
        
        return $CSPmatches;
    }
    
    function updateToValidBonds($pbonds, $msbonds){
        
        $bonds = array();
        
        for($i=0;$i<count($msbonds);$i++){
            $cys1 = substr($msbonds[$i], 0, strpos($msbonds[$i], "-"));
            $cys2 = substr($msbonds[$i], strpos($msbonds[$i], "-")+1);
            $DOC = $cys2-$cys1;
            $bonds[] = array("BOND" => $msbonds[$i], "DOC" => $DOC);
        }
        
        $keys = array_keys($pbonds);
        for($i=0;$i<count($keys);$i++){
            $cys1 = substr($keys[$i], 0, strpos($keys[$i], "-"));
            $cys2 = substr($keys[$i], strpos($keys[$i], "-")+1);
            $DOC = $cys2-$cys1;
            $bonds[] = array("BOND" => $keys[$i], "DOC" => $DOC);
        }
        
        return $bonds;
    }
    
    function getBondsByMaxScoreExpFromSVM($pbonds){

        $bonds = array();
        $cys = array();
        $scoreexp = 0;
        $maxscorebond = 0;
        $threshold = 2.0;
        
        $keys = array_keys($pbonds);
        $count = count($keys);

        for($i=0;$i<$count;$i++){
            $icys1 = substr($keys[$i], 0, strpos($keys[$i], "-"));
            $scoreexp = $pbonds[$keys[$i]]['scoreexp'];
            $maxscorebond = $i;
            for($j=0;$j<$count;$j++){
                if($i != $j){
                    $cys = explode("-", $keys[$j]);
                    if($icys1 == $cys[0]){
                        if($pbonds[$keys[$j]]['scoreexp'] > $scoreexp){
                            $scoreexp = $pbonds[$keys[$j]]['scoreexp'];
                            $maxscorebond = $j;
                        }
                    }
                }
            }
            if(!in_array($keys[$maxscorebond], $bonds)){
                $bonds[$keys[$maxscorebond]] = $pbonds[$keys[$maxscorebond]];
            }
        }

        return $bonds;
    }
    
    function removeBondsByMaxScoreExpFromSVM($bonds, $pbonds){
        
        $newbonds = array();
        
        for($i=0;$i<count($bonds);$i++){
            if(in_array($bonds[$i]['BOND'], $pbonds)){
                $newbonds[] = $bonds[$i];
            }
        }
        
        return $newbonds;        
    }

?>
