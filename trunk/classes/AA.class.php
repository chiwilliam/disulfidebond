<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AAclass
 *
 * @author William
 */
class AAclass {

    var $AAs = array();

    public function  __construct() {
        
        $this->AAs['A'] = 71.0788;
        $this->AAs['R'] = 156.1875;
        $this->AAs['N'] = 114.1038;
        $this->AAs['D'] = 115.0886;
        $this->AAs['C'] = 103.1388;
        $this->AAs['E'] = 129.1155;
        $this->AAs['Q'] = 128.1307;
        $this->AAs['G'] = 57.0519;
        $this->AAs['H'] = 137.1411;
        $this->AAs['I'] = 113.1594;
        $this->AAs['L'] = 113.1594;
        $this->AAs['K'] = 128.1741;
        $this->AAs['M'] = 131.1926;
        $this->AAs['O'] = 114.1472;
        $this->AAs['F'] = 147.1766;
        $this->AAs['P'] = 97.1167;
        $this->AAs['S'] = 87.0782;
        $this->AAs['T'] = 101.1051;
        $this->AAs['W'] = 186.2132;
        $this->AAs['Y'] = 163.1760;
        $this->AAs['V'] = 99.1326;

        /*Monoisotopic values
        $this->AAs['A'] = 71.03711;
        $this->AAs['R'] = 156.10111;
        $this->AAs['N'] = 114.04293;
        $this->AAs['D'] = 115.02694;
        $this->AAs['C'] = 103.00919;
        $this->AAs['E'] = 129.04259;
        $this->AAs['Q'] = 128.05858;
        $this->AAs['G'] = 57.02146;
        $this->AAs['H'] = 137.05891;
        $this->AAs['I'] = 113.08406;
        $this->AAs['L'] = 113.08406;
        $this->AAs['K'] = 128.09496;
        $this->AAs['M'] = 131.04049;
        $this->AAs['O'] = 114.07931;
        $this->AAs['F'] = 147.06841;
        $this->AAs['P'] = 97.05276;
        $this->AAs['S'] = 87.03203;
        $this->AAs['T'] = 101.04768;
        $this->AAs['W'] = 186.07931;
        $this->AAs['Y'] = 163.06333;
        $this->AAs['V'] = 99.06841;
         */

    }

    public function  __get($name) {
        return $this->AAs[$name];
    }

    public function calculatePeptideMass($peptide, $matchtype = ""){
        $mass = (float)0.0;

        $AAs = str_split($peptide, 1);

        for($i=0;$i<count($AAs);$i++){
            $mass += $this->__get($AAs[$i]);
        }
        //add OH + H mass to each peptide in the disulfide bond structure for the Initial Match
        //For the confirmed match, do not add because fragment do not have the OH + H groups
        if($matchtype == "IM")
            $mass += 18.01056;
        
        return $mass;
    }

    //function that calculates the masses of all peptide structures on DMS
    public function calculateMassSpaceMass($DMS){

        $keys = array_keys($DMS);

        for($i=0;$i<count($keys);$i++){
            $mass = 0;

            for($j=0;$j<count($DMS[$keys[$i]]["peptides"]);$j++){
                $mass += $this->calculatePeptideMass($DMS[$keys[$i]]["peptides"][$j],"IM");
            }

            if($j>1)
            {
                //subtract H lost with disulfide bond
                //interchain
                $mass -= (2.01564*count($DMS[$keys[$i]]["peptides"])-2.01564);
            }
            else
            {
                //subtract H lost with disulfide bond
                //intrachain
                $mass -= 2.01564;
            }
                
            $DMS[$keys[$i]]["mass"] = $mass;
        }

        return $DMS;

    }

    public function getDelta($peptides){

        $total = count($peptides);
        $keys = array_keys($peptides);
        $sum = 0;
        for($i=0;$i<$total;$i++){
            $sum += (int)substr($keys[$i],0,4);
        }
        $average = $sum/$total;

        $first = (int)substr($keys[0],0,4);
        $last = (int)substr($keys[$total-1],0,4);

        $delta = (double)($last-$first)/$average;
        $delta = (double)$delta/(2*count($peptides));

        return $delta;
    }

    public function trimListBigger($list,$delta){

        $trimmed = array();

        $keys = array_keys($list);

        $index = count($keys)-1;

        $trimmed[$keys[$index]] = $list[$keys[$index]];

        $last = (int)(substr($keys[$index], 0, 4));

        for($i=($index-1); $i>=0;$i--){
            $current = (int)(substr($keys[$i],0,4));
            if($last > ((1+$delta)*$current)){
                $trimmed[$keys[$i]] = $list[$keys[$i]];
                $last = $current;
            }
        }

        $totalList = count($keys);
        $totalTrimmed = count($trimmed);

        ksort(&$trimmed);

        return $trimmed;
    }

    public function trimListSmaller($list,$delta){

        $trimmed = array();

        $keys = array_keys($list);

        $index = 0;

        $trimmed[$keys[$index]] = $list[$keys[$index]];

        $last = (int)(substr($keys[$index], 0, 4));

        for($i=1; $i<count($keys);$i++){
            $current = (int)(substr($keys[$i],0,4));
            if($last < ((1-$delta)*$current)){
                $trimmed[$keys[$i]] = $list[$keys[$i]];
                $last = $current;
            }
        }

        $totalList = count($keys);
        $totalTrimmed = count($trimmed);

        return $trimmed;
    }

    public function getDeltaCM($peptides){

        //In this function I'm not considering if it is a B or Y ion.
        //Im also not considering that it loses 2Da per S-S bond
        //REASON: Low influence in final delta result

        $total = count($peptides);
        //biggest mass: W - 186.2132Da
        $min = 186.2132;
        for($i=0;$i<$total;$i++){
            $average[$i] = 0;
        }
        //smallest mass: G - 57.0519Da
        $max = 57.0519;

        for($i=0;$i<$total;$i++){

            $sum = 0;
            $AAs = str_split($peptides[$i]);
            $countAAs = count($AAs);
            for($j=0;$j<$countAAs;$j++){
                $mass = $this->calculatePeptideMass($AAs[$j]);
                if($mass < $min){
                    $min = $mass;
                }
                if($mass > $max){
                    $max = $mass;
                }
                $sum += $mass;
            }
            $average[$i] = $sum/$countAAs;
            $AAs[$i] = $countAAs;

        }

        $overallaverage = 1;
        $overallAAs = 1;
        //Didn't use 0 to avoid divison by 0 in case an error happens

        for($i=0;$i<$total;$i++){
            $overallaverage += $average[$i];
            $overallAAs += $AAs[$i];
        }
        $overallaverage = $overallaverage/$total;
        $overallAAs = $overallAAs/$total;

        $delta = (double)($max-$min)/$overallaverage;
        $delta = (double)$delta/(2*$overallAAs);

        return $delta;

    }

    public function formatFASTAsequence($fastaProtein){

        $tmp = explode("\r\n", $fastaProtein);
        for($i=0;$i<count($tmp);$i++){
            if(substr($tmp[$i], 0, 1) == '>'){
                unset($tmp[$i]);
            }
        }
        $fastaProtein = implode("", $tmp);

        $fastaProtein = strtoupper($fastaProtein);

        $fastaProtein = str_replace("-", "", $fastaProtein);
        $fastaProtein = str_replace("*", "", $fastaProtein);

        $AAs = str_split($fastaProtein, 1);
        $length = count($AAs);

        for($i=0;$i<$length;$i++){
            $isValid = $this->isAAValid($AAs[$i]);
            if($isValid == false){
                $fastaProtein = false;
                break;
            }
        }

        return $fastaProtein;
    }

    public function isAAValid($AA){
        $result = false;

        if($AA == "A" || $AA == "R" || $AA == "N" || $AA == "D" || $AA == "C" ||
           $AA == "E" || $AA == "Q" || $AA == "G" || $AA == "H" || $AA == "I" ||
           $AA == "L" || $AA == "K" || $AA == "M" || $AA == "O" || $AA == "F" ||
           $AA == "P" || $AA == "S" || $AA == "T" || $AA == "W" || $AA == "Y" ||
           $AA == "V" ){

            $result = true;
        }
        
        return $result;
    }

    public function possibleBonds($sequence){
        
        $cysteines = array();
        $bonds = array();
        $length = strlen($sequence);

        for($i=1;$i<=$length;$i++){
            $AA = substr($sequence, $i-1,1);
            if($AA == "C"){
                $cysteines[] = $i;
            }
        }
        
        $length = count($cysteines);

        for($i=0;$i<$length-1;$i++){
            for($j=$i+1;$j<$length;$j++)
            {
                $bonds[] = $cysteines[$i]."-".$cysteines[$j];
            }
        }

        return $bonds;
    }
}
?>
