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

    public function calculatePeptideMass($peptide, $matchtype){
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
                //subtract H lost with disulfide bond
                $mass -= (2*count($DMS[$keys[$i]]["peptides"])-2);
                
                $DMS[$keys[$i]]["mass"] = $mass;
        }

        return $DMS;

    }
}
?>
