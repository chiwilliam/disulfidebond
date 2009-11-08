<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfirmedMatchclass
 *
 * @author William
 */
class ConfirmedMatchclass {

    //function to screen fragments from a DTA file. The goal is to find all fragments
    //Do 3% screening and consider only the highest intensity picks as matches,
    //according to threshold
    public function screenDataHighPicks($data, $intensityLimit, $threshold){

        //get maximum intensity
        $keys = array_keys($data);
        $count = count($keys);
        $maxIntensity = $keys[0];
        for($i=1;$i<$count;$i++){
            if($keys[$i] > $maxIntensity){
                $maxIntensity = $keys[$i];
            }
        }
        //$intensity limit * maximum intensity = screening parameter
        $intensityScreen = (int)(round($maxIntensity*$intensityLimit));

        //screen fragments whose intensity is lower that intensityScreen
        $values = array();
        for($i=0;$i<$count;$i++){
            if($keys[$i] >= $intensityScreen){
                $values[$keys[$i]] = $data[$keys[$i]];
            }
        }
        unset($keys);
        unset($data);

        //use median values
        $keys = array_keys($values);
        $count = count($keys);
        $newvalues = array();

        for($i=0;$i<$count;$i++){
            
            //get all values starting from minumum to search for the highest pick
            if(isset($tmp))
                unset($tmp);
            $tmp = array();
            $tmp[$keys[$i]] = $values[$keys[$i]];
            for($j=$i+1;$j<$count;$j++){
                // +threshold due to +-threshold
                if($values[$keys[$j]] <= ($values[$keys[$i]] + $threshold)){
                    $tmp[$keys[$j]] = $values[$keys[$j]];
                }
                else{
                    break;
                }
            }

            //get provisory highest pick
            krsort(&$tmp,SORT_NUMERIC);
            reset(&$tmp);
            $pickmax = key(&$tmp);
            $keyentry = array_search($pickmax, $keys);

            //get all values starting from highest pick to search for the highest pick
            if(isset($tmp))
                unset($tmp);
            $tmp = array();
            $tmp[$keys[$keyentry]] = $values[$keys[$keyentry]];
            for($k=$keyentry;$k<$count;$k++){
                // +threshold due to +-threshold
                if($values[$keys[$k+1]] <= ($values[$keys[$k]] + $threshold)){
                    $tmp[$keys[$k+1]] = $values[$keys[$k+1]];
                }
                else{
                    break;
                }
            }

            //get highest pick
            krsort(&$tmp,SORT_NUMERIC);
            reset(&$tmp);
            $newvalues[key(&$tmp)] = $values[key(&$tmp)];

            //avoid repetition. starts search by next value (not analyzed yet)
            $i = $k;
            
        }

        /*
        for($i=0;$i<$count;$i++){
            $sum = $values[$i];
            $countsum = 1.0;
            $average = 0.0;
            for($j=$i+1;$j<$count;$j++){
                if($values[$j] < $values[$i]+$threshold){
                    $sum += $values[$j];
                    $countsum++;
                }
                else{
                    $average = $sum/$countsum;
                    $average = round($average,1);
                    $newvalues[] = $average;
                    $i = $j;
                    break;
                }
            }
        }
        */
        
        unset($values);

        return $newvalues;
    }

    //function to screen fragments from a DTA file. The goal is to find 50 fragments
    //Try 5% screening. If it retrieves more than 50, consider best 50 (highest intensity)
    //If it doesnt retrieve 50, try 4%, then 3% screening and retrieve better 50.
    public function screenData($data, $intensityLimit, $recordsLimit){

        //store original set in case another screening is necessary
        $tmp = $data;

        //get maximum intensity
        end(&$data);
        //5% of maximum intensity
        $maxIntensity = key(&$data);
        $intensityScreen = (int)(round($maxIntensity*$intensityLimit));
        //$move pointer to first fragment
        reset(&$data);
        //screen fragments whose intensity is lower that intensityScreen
        
        while($intensity = (int)(key(&$data))){
            if($intensity < $intensityScreen){
                unset($data[$intensity]);
            }
            next(&$data);
        }

        $totalRecords = count($data);
        while($totalRecords < $recordsLimit){
            if($intensityLimit < 0.02){
                return $data;
            }
            else{
            $intensityLimit -= 0.01;
            $data = $this->screenData($tmp, $intensityLimit, $recordsLimit);
            $totalRecords = count($data);
            }
        }

        switch($totalRecords){
            case ($totalRecords <= $recordsLimit):
                return $data;
                break;
            case ($totalRecords > $recordsLimit):
                reset(&$data);
                $j = 0;
                while($j < ($totalRecords-$recordsLimit)){
                    $intensity = key(&$data);
                    next(&$data);
                    unset($data[$intensity]);
                    $j++;
               }
               return $data;
                break;
        }
        
    }

    public function formFMS($peptides, $cysteines){

        $FMS = array();

        //check if only intrabond case
        $pepNumber = count($peptides);

        if($pepNumber == 1){
            //intrabond only
            $this->retrieveIntraBondFMSElements(&$FMS, $peptides[0], $cysteines[0]);
        }
        else{
            for($i=0;$i<count($pepNumber);$i++){
                //intrabond only or fragments
                $this->retrieveIntraBondFMSElements(&$FMS, $peptides[$i], $cysteines[$i]);
            }

            //treat interbonds
            $this->retrieveInterBondFMSElements(&$FMS, $peptides, $cysteines);
        }

        return $FMS;
    }

    public function retrieveIntraBondFMSElements(&$FMS, $peptide, $cysteines){

        $AAs = new AAclass();

        //Y-ions
        for($i=0;$i<strlen($peptide);$i++){
            $fragment = substr($peptide,$i);
            $peplength = strlen($peptide);
            $mass = $AAs->calculatePeptideMass($fragment,"CM");

            if($i<= $cysteines[(count($cysteines)-2)]){
                //subtract 2Da due to disulfide bond
                $mass -= 2.01564;
            }
            
            //OH on C-terminus and H on N-terminus mass plus 1Da for Y ions
            //because of an extra H in the amino group NH3+
            $mass += 19.01838;
            $FMS[(int)(round($mass))] = array("mass" => $mass,
                "fragment" => $fragment, "peptide" => $peptide,
                "ion" => ('Y'.($peplength-$i)));
        }
        //B-ions
        for($i=strlen($peptide);$i>0;$i--){
            $fragment = substr($peptide,0,$i);
            $mass = $AAs->calculatePeptideMass($fragment,"CM");

            if($i>$cysteines[count($cysteines)-1]){
                //subtract 2Da due to disulfide bond
                $mass -= 2.01564;
            }

            //H on N-terminus mass
            $mass += 1.00782;
            $FMS[(int)(round($mass))] = array("mass" => $mass,
                "fragment" => $fragment, "peptide" => $peptide,
                "ion" => ('B'.($i)));
        }
    }

    public function retrieveInterBondFMSElements(&$FMS, $peptides, $cysteines){
        
        $AAs = new AAclass();

        $cysPos = array();

        //search for cysteines on peptides
        //FOR FIRST PEPTIDE
        //if 1 cysteine per peptide mark that cysteine for both b-ions and y-ions
        if(count($cysteines[0]) == 1){
            $cysPos["b0"] = $cysteines[0][0];
            $cysPos["y0"] = $cysPos["b0"];
        }
        //if more than 1 cysteine per peptide mark the first cysteine for b-ions and the last cysteine for y-ions
        //this way will allow all possible interbond (disulfide bond) combinations
        else{
            $cysPos["b0"] = $cysteines[0][0];
            $cysPos["y0"] = $cysteines[0][count($cysteines[0])-1];
        }

        //FOR SECOND PEPTIDE
        if(count($cysteines[1]) == 1){
            $cysPos["b1"] = $cysteines[1][0];
            $cysPos["y1"] = $cysPos["b1"];
        }
        //if more than 1 cysteine per peptide mark the first cysteine for b-ions and the last cysteine for y-ions
        //this way will allow all possible interbond (disulfide bond) combinations
        else{
            $cysPos["b1"] = $cysteines[1][1];
            $cysPos["y1"] = $cysteines[1][count($cysteines[1])-1];
        }

        //calculate peptide lengths
        $length0 = strlen($peptides[0]);
        $length1 = strlen($peptides[1]);

        //define possible combinations
        //b-ions peptide 0 with b-ions peptide 1
        for($i=($length0-1);$i>=$cysPos["b0"];$i--){
            for($j=($length1-1);$j>=$cysPos["b1"];$j--){

                $fragment1 = substr($peptides[0], 0, $i+1);
                $fragment2 = substr($peptides[1], 0, $j+1);

                $mass1 = $AAs->calculatePeptideMass($fragment1,"CM");
                //add 1Da for H on N-terminus
                $mass1 += 1.00782;
                $mass2 = $AAs->calculatePeptideMass($fragment2,"CM");
                //add 1Da for H on N-terminus
                $mass2 += 1.00782;
                
                $mass = $mass1+$mass2;
                //remove 2Da for 2 H lost when disulfide bond is formed
                $mass -= 2.01564;

                if(((strpos($fragment1,'C') > 0) || substr($fragment1, 0, 1) == 'C') 
                    && ((strpos($fragment2,'C') > 0) || substr($fragment2, 0, 1) == 'C')){
                    $FMS[(int)(round($mass))] = array("mass" => $mass,
                        "fragment" => ($fragment1.'<=>'.$fragment2),
                        "peptide" => ($peptides[0].'<=>'.$peptides[1]),
                        "ion" => ('B'.($i+1).'<=>'.'b'.($j+1)));
                }
            }
        }

        //define possible combinations
        //b-ions peptide 0 with y-ions peptide 1
        for($i=($length0-1);$i>=$cysPos["b0"];$i--){
            for($j=0;$j<=$cysPos["y1"];$j++){

                $fragment1 = substr($peptides[0], 0, $i+1);
                $fragment2 = substr($peptides[1], $j, $length1-$j);

                $mass1 = $AAs->calculatePeptideMass($fragment1,"CM");
                //add 1Da for H on N-terminus
                $mass1 += 1.00782;
                $mass2 = $AAs->calculatePeptideMass($fragment2,"CM");
                //add 17Da for OH on N-terminus and 1Da for H on C-terminus
                $mass2 += 18.01056;
                //add 1Da for the proton in the Y ion
                $mass2 += 1.00782;

                $mass = $mass1+$mass2;
                //remove 2Da for 2 H lost when disulfide bond is formed
                $mass -= 2.01564;

                if(((strpos($fragment1,'C') > 0) || substr($fragment1, 0, 1) == 'C')
                    && ((strpos($fragment2,'C') > 0) || substr($fragment2, 0, 1) == 'C')){
                    $FMS[(int)(round($mass))] = array("mass" => $mass,
                        "fragment" => ($fragment1.'<=>'.$fragment2),
                        "peptide" => ($peptides[0].'<=>'.$peptides[1]),
                        "ion" => ('B'.($i+1).'<=>'.'y'.($length1-$j)));
                }
            }
        }

        //define possible combinations
        //y-ions peptide 0 with b-ions peptide 1
        for($i=0;$i<=$cysPos["y0"];$i++){
            for($j=($length1-1);$j>=$cysPos["b1"];$j--){

                $fragment1 = substr($peptides[0], $i, $length0-$i);
                $fragment2 = substr($peptides[1], 0, $j+1);

                $mass1 = $AAs->calculatePeptideMass($fragment1,"CM");
                //add 17Da for OH on N-terminus and 1Da for H on C-terminus
                $mass1 += 18.01056;
                //add 1Da for the proton in the Y ion
                $mass1 += 1.00782;
                $mass2 = $AAs->calculatePeptideMass($fragment2,"CM");
                //add 1Da for H on N-terminus
                $mass2 += 1.00782;

                $mass = $mass1+$mass2;
                //remove 2Da for 2 H lost when disulfide bond is formed
                $mass -= 2.01564;

                if(((strpos($fragment1,'C') > 0) || substr($fragment1, 0, 1) == 'C')
                    && ((strpos($fragment2,'C') > 0) || substr($fragment2, 0, 1) == 'C')){
                    $FMS[(int)(round($mass))] = array("mass" => $mass,
                        "fragment" => ($fragment1.'<=>'.$fragment2),
                        "peptide" => ($peptides[0].'<=>'.$peptides[1]),
                        "ion" => ('Y'.($length0-$i).'<=>'.'b'.($j+1)));
                }
            }
        }

        //define possible combinations
        //y-ions peptide 0 with y-ions peptide 1
        for($i=0;$i<=$cysPos["y0"];$i++){
            for($j=0;$j<=$cysPos["y1"];$j++){

                $fragment1 = substr($peptides[0], $i, $length0-$i);
                $fragment2 = substr($peptides[1], $j, $length1-$j);

                $mass1 = $AAs->calculatePeptideMass($fragment1,"CM");
                //add 17Da for OH on N-terminus and 1Da for the H on C-terminus
                $mass1 += 18.01056;
                //add 1Da for the extra proton at Y ion
                $mass1 += 1.00782;

                $mass2 = $AAs->calculatePeptideMass($fragment2,"CM");
                //add 17Da for OH on N-terminus and 1Da for the H on C-terminus
                $mass2 += 18.01056;
                //add 1Da for the extra proton at Y ion
                $mass1 += 1.00782;

                $mass = $mass1+$mass2;
                //remove 2Da for 2 H lost when disulfide bond is formed
                $mass -= 2.01564;

                if(((strpos($fragment1,'C') > 0) || substr($fragment1, 0, 1) == 'C')
                    && ((strpos($fragment2,'C') > 0) || substr($fragment2, 0, 1) == 'C')){
                    $FMS[(int)(round($mass))] = array("mass" => $mass,
                        "fragment" => ($fragment1.'<=>'.$fragment2),
                        "peptide" => ($peptides[0].'<=>'.$peptides[1]),
                        "ion" => ('Y'.($length0-$i).'<=>'.'y'.($length1-$j)));
                }
            }
        }
        
    }

    public function Cmatch($FMS,$TML, $precursor, $CMthreshold){

        $matches = array();

        /*
        //Confirmed match minimum threshold +- 0.5; therefore subtract 1
        $minMass = ($TML[0]["mass"])-1;
        //Confirmed match maximum threshold +- 1.5; therefore add 3
        $maxMass = ($TML[count($TML)-1]["mass"])+3;

        $FMS = $this->shrinkFMS($FMS, $minMass, $maxMass);
        */
        
        reset(&$FMS);
        while($tmp = current(&$FMS)){
            $mass = $tmp["mass"];
            /*
            if($mass <= 2000){
                $CMthreshold *= 1;
            }
            else{
                if($mass <= 3000){
                    $CMthreshold *= 1.5;
                }
                else{
                    $CMthreshold *= 2.0;
                }
            }
            */
            for($i=0;$i<count($TML);$i++){
                if($mass > ($TML[$i]["mass"] - $CMthreshold) &&
                   $mass < ($TML[$i]["mass"] + $CMthreshold)){
                    //debugging
                    //tries to identify good CMs
                    //check mass from all the structures, including the variance, depending on the charge state
                    $tmp["matches"] = array("FMS" => $mass, "TML" => $TML[$i]["mass"], "variance" => $TML[$i]["charge"]/2);
                    if(($mass - $TML[$i]["mass"]) > 0){
                        $tmp["deviation"] = ($mass - $TML[$i]["mass"]);
                    }
                    else{
                        $tmp["deviation"] = ($TML[$i]["mass"] - $mass);
                    }

                    //for debugging
                    $FMSkey = key(&$FMS);
                    $TMLkey = $i;
                    $tmp["debug"] = array("FMS" => $FMSkey, "TML" => $TMLkey);
                    //end debugging

                    $matches[] = $tmp;
                }
            }
            next(&$FMS);
        }

        return $matches;

    }

    public function FMSPolynomial($TML, $peptides, $cysteines, $CMthreshold){

        $result = array();




        //PolynomialSubsetSum
        /*
        $counter=0;

        $DMS = array();
        $IM = array();

        $AAs = new AAclass();

        //change index organization
        //index will be peptides mass, swapping . for - as indexes do not accept double values
        $disulfideBondedPeptides = $this->reIndexSubsetSum($AAs, $disulfideBondedPeptides, $maxPrecursor);

        //get value used to trim lists
        $delta = $AAs->getDelta($disulfideBondedPeptides);

        $PMLkeys = array_keys($PML);
        for($k=0;$k<count($PMLkeys);$k++){

            $precursor = $PML[$PMLkeys[$k]];
            $precursorMass = substr($precursor,0,strpos($precursor, ' '));

            $keys = array_keys($disulfideBondedPeptides);
            $total = count($keys);
            $list1 = array();
            $list1['0000-00000-000'] = array('peptides' => array(), 'cysteines' => array());
            $list2 = array();

            for($w=0;$w<$total;$w++){

                //peptide key
                $key = $keys[$w];
                //peptide sequence
                $peptide = $disulfideBondedPeptides[$key]['sequence'];
                //position of located cysteines
                $cysteines = $disulfideBondedPeptides[$key]['cysteines'];
                //peptide mass
                $premass = substr($key,0,(strlen($key)-4));
                $mass = (double)str_replace('-', '.', $premass);

                unset($list2);
                $list1keys = array_keys($list1);
                for($z=0;$z<count($list1keys);$z++){

                    $list1peptides = $list1[$list1keys[$z]]['peptides'];
                    $list1peptides[] = $peptide;

                    $list1cysteines = $list1[$list1keys[$z]]['cysteines'];
                    $list1cysteines[] = $cysteines;

                    $list1premass = substr($list1keys[$z],0,(strlen($list1keys[$z])-4));
                    $list1mass = (double)str_replace('-', '.', $list1premass);
                    $list1mass += $mass;

                    $counter++;

                    if(count($list1peptides) > 1){
                        //discount 2 H lost per S-S bond
                        $list1mass -= (2*count($list1peptides) -2);
                    }

                    if($list1mass <= ((double)($precursorMass-1.0) + (double)($IMthreshold))){

                        //generate index
                        $tmp = explode('.', ((string)$list1mass));
                        //ensure sorting works by adjusting index XXXX-XXXXX digits
                        while(strlen($tmp[0]) < 4)
                            $tmp[0] = '0'.$tmp[0];
                        while(strlen($tmp[1]) < 5)
                            $tmp[1] = $tmp[1].'0';
                        $index = $tmp[0].'-'.$tmp[1].'-'.round(rand(101,999));
                        //populate array
                        $list2[$index] = array('peptides' => $list1peptides, 'cysteines' => $list1cysteines);

                        if($list1mass >= ((double)($precursorMass-1.0) - (double)($IMthreshold))){
                            unset($pepMatch);
                            unset($pepDMS);
                            $pepMatch['0000-00000-000'] = array('peptides' => array(), 'cysteines' => array());
                            $pepMatch[$index] = array('peptides' => $list1peptides, 'cysteines' => $list1cysteines);
                            $pepDMS = $this->convertIndextoAAs($pepMatch);

                            if(count($pepDMS) > 0){

                                $IM[] = array("DMS" => key(&$pepDMS),"PML" => $PMLkeys[$k]);

                                $DMS = array_merge($DMS,$pepDMS);

                            }
                        }
                    }
                }
                if(isset($list2)){
                    $list1 = array_merge($list1, $list2);
                    ksort(&$list1);

                    $list1 = $AAs->trimListBigger($list1,$delta);
                    //$list1 = $AAs->trimListSmaller($list1,$delta);
                    //$list1alpha = $AAs->trimListSmaller($list1,$delta);
                    //$list1beta = $AAs->trimListBigger($list1,$delta);
                    //$list1 = array_merge($list1alpha, $list1beta);
                }
            }
        }

        unset($list1);
        unset($list2);

        $result['DMS'] = $DMS;
        $result['IM'] = $IM;

        return $result;
        */

    }

    public function expandTMLByCharges($data, $precursor, $TMLthreshold){

        $TML = array();

        //subtract 1 due to the fact that in a DTA format file, the precursor mass
        //is measured as M+H.
        $precursormass = (float)substr($precursor, 0, strpos($precursor, " "))-1;
        $charge = (int)(substr($precursor, strpos($precursor, " ")+1,1));

        $count = count($data);
        $keys = array_keys($data);

        for($c=1; $c<=$charge; $c++){
            //formula => M = m/z * n - n => m/z = (M+n)/n
            //derived from m/z = (M+nH)^+n, where n = charge state and m/z mass to charge ratio
            for($i=0;$i<$count;$i++){
                $mzvalue = $data[$keys[$i]];
                //$massvalue = ($mzvalue*$c)-$c;
                $massvalue = ($mzvalue*$c);
                if($massvalue <= ($precursormass+$TMLthreshold)){
                    $TML[] = array("mass" => $massvalue, "charge" => $c, "intensity" => $keys[$i]);
                }
            }
        }
/*
            //formula => M = m/z * n - n => m/z = (M+n)/n
            //derived from m/z = (M+nH)^+n, where n = charge state and m/z mass to charge ratio
            $frag3max = ($precursormass+3)/3;
            $frag2max = ($precursormass+2)/2;
            $frag1max = ($precursormass+1)/1;

            for($i=0;$i<count($data);$i++){
                $value = $data[$i];
                switch($value){
                    case ($value <= $frag3max):
                        //fragment can be +3, +2 or +1
                        $TML[] = array("mass" => ($value*3)-3, "charge" => 3);
                        $TML[] = array("mass" => ($value*2)-2, "charge" => 2);
                        $TML[] = array("mass" => ($value*1)-1, "charge" => 1);
                        break;
                    case ($value <= $frag2max):
                        //fragment can be just +2 or +1
                        $TML[] = array("mass" => ($value*2)-2, "charge" => 2);
                        $TML[] = array("mass" => ($value*1)-1, "charge" => 1);
                        break;
                    case ($value <= $frag1max):
                        //fragment can be only +1
                        $TML[] = array("mass" => ($value*1)-1, "charge" => 1);
                        break;
                }
            }
*/
        
        //sort TML by mass
        sort(&$TML);

        return $TML;
    }

    public function shrinkFMS($data, $minMass, $maxMass){

        reset(&$data);
        while($tmp = current(&$data)){
            $var = $tmp["mass"];
            if($var < $minMass){
                unset($data[key(&$data)]);
            }
            else
                break;
        }
        end(&$data);
        while($tmp = current(&$data)){
            $var = $tmp["mass"];
            if($var > $maxMass){
                array_pop(&$data);
                end(&$data);
            }
            else
                break;
        }

        return $data;
    }

}
?>
