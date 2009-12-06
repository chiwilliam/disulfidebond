<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InitialMatchclass
 *
 * @author William
 */
class InitialMatchclass {

    public function formDisulfideBondedStructures($disulfideBondedPeptides){
        
        $DMS = array();

        $keys = array_keys($disulfideBondedPeptides);

        for($i=0;$i<count($keys);$i++){

            $key = $keys[$i];
            //peptide sequence
            $peptide = $disulfideBondedPeptides[$key]['sequence'];
            //position of located cysteines
            $cysteines = $disulfideBondedPeptides[$key]['cysteines'];

            switch(count($cysteines)){

                case 1:

                    for($j=($i+1);$j<count($keys);$j++){

                        $tmpKey = $keys[$j];
                        $tmpPeptide = $disulfideBondedPeptides[$tmpKey]['sequence'];
                        $tmpCysteines = $disulfideBondedPeptides[$tmpKey]['cysteines'];

                        $index = (string)(strlen($peptide)+strlen($tmpPeptide))."-".
                                 (string)(count($cysteines)+count($tmpCysteines))."-".
                                 round((rand(2,999)+rand(2,999))/2);
                        $DMS[$index] = array('peptides' => array($peptide,$tmpPeptide)
                                            ,'cysteines' => array($cysteines,$tmpCysteines));
                    }
                    break;

                case 2:

                    //treating intrabonds
                    $index = (string)(strlen($peptide))."-".(string)(count($cysteines))."-".round((rand(2,999)+rand(2,999))/2);
                    $DMS[$index] = array('peptides' => array($peptide)
                                        ,'cysteines' => array($cysteines));

                    //treating interbonds
                    for($j=($i+1);$j<count($keys);$j++){

                        $tmpKey = $keys[$j];
                        $tmpPeptide = $disulfideBondedPeptides[$tmpKey]['sequence'];
                        $tmpCysteines = $disulfideBondedPeptides[$tmpKey]['cysteines'];

                        //treating 1 disulfide bond case
                        $index = (string)(strlen($peptide)+strlen($tmpPeptide))."-".
                                 (string)(count($cysteines)+count($tmpCysteines))."-".
                                 round((rand(2,999)+rand(2,999))/2);
                        $DMS[$index] = array('peptides' => array($peptide,$tmpPeptide)
                                            ,'cysteines' => array($cysteines,$tmpCysteines));

                        //treating 2 disulfide bond case
                        for($k=($j+1);$k<count($keys);$k++){

                            $tmpKey2 = $keys[$k];
                            $tmpPeptide2 = $disulfideBondedPeptides[$tmpKey2]['sequence'];
                            $tmpCysteines2 = $disulfideBondedPeptides[$tmpKey2]['cysteines'];

                            $index = (string)(strlen($peptide)+strlen($tmpPeptide)+strlen($tmpPeptide2))."-".
                                     (string)(count($cysteines)+count($tmpCysteines)+count($tmpCysteines2))."-".
                                     round((rand(2,999)+rand(2,999))/2);
                            $DMS[$index] = array('peptides' => array($peptide,$tmpPeptide,$tmpPeptide2)
                                                ,'cysteines' => array($cysteines,$tmpCysteines,$tmpCysteines2));
                        }

                    }
                    break;

                case 3:

                    //treating intrabonds
                    $index = (string)(strlen($peptide))."-".(string)(count($cysteines))."-".round((rand(2,999)+rand(2,999))/2);
                    $DMS[$index] = array('peptides' => array($peptide)
                                        ,'cysteines' => array($cysteines));

                    //treating interbonds
                    for($j=($i+1);$j<count($keys);$j++){

                        $tmpKey = $keys[$j];
                        $tmpPeptide = $disulfideBondedPeptides[$tmpKey]['sequence'];
                        $tmpCysteines = $disulfideBondedPeptides[$tmpKey]['cysteines'];

                        //treating 1 disulfide bond case
                        $index = (string)(strlen($peptide)+strlen($tmpPeptide))."-".
                                 (string)(count($cysteines)+count($tmpCysteines))."-".
                                 round((rand(2,999)+rand(2,999))/2);
                        $DMS[$index] = array('peptides' => array($peptide,$tmpPeptide)
                                            ,'cysteines' => array($cysteines,$tmpCysteines));

                        //treating 2 disulfide bond case
                        for($k=($j+1);$k<count($keys);$k++){

                            $tmpKey2 = $keys[$k];
                            $tmpPeptide2 = $disulfideBondedPeptides[$tmpKey2]['sequence'];
                            $tmpCysteines2 = $disulfideBondedPeptides[$tmpKey2]['cysteines'];

                            $index = (string)(strlen($peptide)+strlen($tmpPeptide)+strlen($tmpPeptide2))."-".
                                     (string)(count($cysteines)+count($tmpCysteines)+count($tmpCysteines2))."-".
                                     round((rand(2,999)+rand(2,999))/2);
                            $DMS[$index] = array('peptides' => array($peptide,$tmpPeptide,$tmpPeptide2)
                                                ,'cysteines' => array($cysteines,$tmpCysteines,$tmpCysteines2));

                            //treating 3 disulfide bond case
                            for($l=($k+1);$l<count($keys);$l++){

                                $tmpKey3 = $keys[$l];
                                $tmpPeptide3 = $disulfideBondedPeptides[$tmpKey3]['sequence'];
                                $tmpCysteines3 = $disulfideBondedPeptides[$tmpKey3]['cysteines'];

                                $index = (string)(strlen($peptide)+strlen($tmpPeptide)+strlen($tmpPeptide2)+strlen($tmpPeptide3))."-".
                                         (string)(count($cysteines)+count($tmpCysteines)+count($tmpCysteines2)+count($tmpCysteines3))."-".
                                         round((rand(2,999)+rand(2,999))/2);
                                $DMS[$index] = array('peptides' => array($peptide,$tmpPeptide,$tmpPeptide2,$tmpPeptide3)
                                                    ,'cysteines' => array($cysteines,$tmpCysteines,$tmpCysteines2,$tmpCysteines3));
                            }
                        }
                    }
                    break;
            }
        }

        return $DMS;
    }

    public function subsetSum($disulfideBondedPeptides,$minPrecursor,$maxPrecursor){
        
        $AAs = new AAclass();
        $DMS = array();
        
        //change index organization
        //index will be peptides mass, swapping . for - as indexes do not accept double values
        $disulfideBondedPeptides = $this->reIndexSubsetSum($AAs, $disulfideBondedPeptides, $maxPrecursor);

        $keys = array_keys($disulfideBondedPeptides);
        $total = count($keys);
        $list1 = array();
        $list1['0000-00000-000'] = array('peptides' => array(), 'cysteines' => array());
        $list2 = array();

        for($i=0;$i<$total;$i++){

            //peptide key
            $key = $keys[$i];
            //peptide sequence
            $peptide = $disulfideBondedPeptides[$key]['sequence'];
            //position of located cysteines
            $cysteines = $disulfideBondedPeptides[$key]['cysteines'];
            //peptide mass
            $premass = substr($key,0,(strlen($key)-4));
            $mass = (double)str_replace('-', '.', $premass);
            
            unset($list2);
            $list1keys = array_keys($list1);
            for($j=0;$j<count($list1keys);$j++){

                $list1peptides = $list1[$list1keys[$j]]['peptides'];
                $list1peptides[] = $peptide;

                $list1cysteines = $list1[$list1keys[$j]]['cysteines'];
                $list1cysteines[] = $cysteines;

                $list1premass = substr($list1keys[$j],0,(strlen($list1keys[$j])-4));
                $list1mass = (double)str_replace('-', '.', $list1premass);
                $list1mass += $mass;

                if($list1mass <= $maxPrecursor){

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
                }
            }

            $list1 = array_merge($list1, $list2);
            ksort(&$list1);
            
        }

        //converts mass index to AAs-cysteines index format
        $DMS = $this->convertIndextoAAs($list1);
        
        unset($list1);
        unset($list2);
        return $DMS;
    }

    public function convertIndextoAAs($list1){

        //converts mass index to AAs-cysteines index format
        $DMS = array();

        $keys = array_keys($list1);

        for($i=1;$i<count($keys);$i++){
            $possibleStructure = true;
            $numberAAs = 0;
            $numberPeptides = 0;
            $numberCysteines = 0;
            for($j=0;$j<count($list1[$keys[$i]]['peptides']);$j++){
                $numberAAs += strlen($list1[$keys[$i]]['peptides'][$j]);
                $numberPeptides++;
                $numberCysteines += count($list1[$keys[$i]]['cysteines'][$j]);
            }

            //remove impossible arrangements
            if($numberPeptides <= 2 && $numberCysteines < 2)
                $possibleStructure = false;
            if($numberPeptides > 2 && ($numberCysteines < (2*$numberPeptides -2)))
                $possibleStructure = false;

            if($possibleStructure == true){
                $index = $numberAAs.'-'.$numberCysteines.'-'.round(rand(101,999));
                $DMS[$index] = $list1[$keys[$i]];
            }
        }

        return $DMS;
    }

    public function reIndexSubsetSum($AAs, $disulfideBondedPeptides, $maxPrecursor){

        $keys = array_keys($disulfideBondedPeptides);
        $total = count($keys);

        $peps = array();
        for($i=0;$i<$total;$i++){
            //get sequence
            $peptide = $disulfideBondedPeptides[$keys[$i]]['sequence'];
            //calculate mass
            $mass = $AAs->calculatePeptideMass($peptide, 'IM');

            if($mass <= $maxPrecursor){

                //generate index
                $tmp = explode('.', ((string)$mass));
                //ensure sorting works by adjusting index XXXX-XXXXX digits
                while(strlen($tmp[0]) < 4)
                    $tmp[0] = '0'.$tmp[0];
                while(strlen($tmp[1]) < 5)
                    $tmp[1] = $tmp[1].'0';
                $index = $tmp[0].'-'.$tmp[1].'-'.round(rand(101,999));
                //populate array
                $peps[$index] = array('sequence' => $peptide, 'cysteines' => $disulfideBondedPeptides[$keys[$i]]['cysteines']);
            }
        }
        //sort by mass
        ksort(&$peps);
        return $peps;
    }

    public function polynomialSubsetSum($PML, $IMthreshold, $disulfideBondedPeptides, $minPrecursor, $maxPrecursor){
        
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

                    //if #cysteines = #peptides and #peptides>1, structure CANNOT form another S-S bond
                    //represented by 000 at the end
                    $SSpossible = substr($list1keys[$z],11);
                    if($SSpossible == "000" && $z>0)
                    {
                        //skip structure
                    }
                    else
                    {
                        $list1peptides = $list1[$list1keys[$z]]['peptides'];
                        $list1peptides[] = $peptide;

                        $list1cysteines = $list1[$list1keys[$z]]['cysteines'];
                        $list1cysteines[] = $cysteines;

                        $list1premass = substr($list1keys[$z],0,(strlen($list1keys[$z])-4));
                        $list1mass = (double)str_replace('-', '.', $list1premass);
                        $list1mass += $mass;

                        $counter++;

                        //if(count($list1peptides) > 1 || (count($list1peptides) == 1 && count($list1cysteines) >= 2))
                        if(count($list1peptides) > 1)
                        {
                            //discount 2 H lost per S-S bond
                            $list1mass -= 2.01564;
                        }

                        if($list1mass <= ((double)($precursorMass) + (double)($IMthreshold))){

                            //generate index
                            $tmp = explode('.', ((string)$list1mass));
                            //ensure sorting works by adjusting index XXXX-XXXXX digits
                            while(strlen($tmp[0]) < 4)
                                $tmp[0] = '0'.$tmp[0];
                            while(strlen($tmp[1]) < 5)
                                $tmp[1] = $tmp[1].'0';

                            //if #cysteines = #peptides and #peptides>1, structure CANNOT form another S-S bond
                            //represented by 000 at the end
                            if(count($list1peptides) > 1 && (count($list1peptides) == count($list1cysteines)))
                            {
                                $index = $tmp[0].'-'.$tmp[1].'-000';
                            }
                            else
                            {
                                $index = $tmp[0].'-'.$tmp[1].'-'.round(rand(101,999));
                            }

                            //populate array
                            $list2[$index] = array('peptides' => $list1peptides, 'cysteines' => $list1cysteines);

                            if($list1mass >= ((double)($precursorMass) - (double)($IMthreshold))){
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
    }

    public function digestProtein($fastaProtein, $protease){

        //array to store digested peptides with cysteine-residues
        $digestion = array();
        //array to hold Cysteine positions in the peptide
        $cysteines = array();
        
        //peptide
        $peptide = "";

        switch($protease){
            //Trypsin
            case "T":

                $fastaProtein = ereg_replace("\r\n", "", $fastaProtein);
                $AAR = str_split($fastaProtein, 1);
                //Space added to the end to avoid out of bounds exception
                $AAR[] = "";
                //peptide start position
                $startpos = 1;
                //starts from first positions and goes until second last position
                for($i=0;$i<count($AAR)-1;$i++){
                    
                    if(($AAR[$i] == 'R' || $AAR[$i] == 'K') && $AAR[$i+1] != 'P'){
                        $peptide .= $AAR[$i];
                        //space added to treat strpos exception
                        if(count($cysteines) > 0){
                            //index
                            //number of cysteines - length of peptide - iteraction (to avoid overwritting)
                            $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".(string)($i);
                            $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                        }
                        $peptide = "";
                        $startpos = $i+2;
                        unset($cysteines);
                    }
                    else{
                        if($AAR[$i] == "C"){
                            $cysteines[] = strlen($peptide);
                        }
                        $peptide .= $AAR[$i];
                    }
                }
                //check if last peptide contains Cysteine residues
                if(count($cysteines) > 0){
                    $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".strlen($fastaProtein);
                    $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                }

                break;
            //chymotrypsin
            case "C":

                $fastaProtein = ereg_replace("\r\n", "", $fastaProtein);
                $AAR = str_split($fastaProtein, 1);
                //Space added to the end to avoid out of bounds exception
                $AAR[] = "";
                //peptide start position
                $startpos = 1;
                //starts from first positions and goes until second last position
                for($i=0;$i<count($AAR)-1;$i++){

                    if(($AAR[$i] == 'L' || $AAR[$i] == 'F' || $AAR[$i] == 'Y' || $AAR[$i] == 'W' || $AAR[$i] == 'M') && $AAR[$i+1] != 'P'){
                        $peptide .= $AAR[$i];
                        //space added to treat strpos exception
                        if(count($cysteines) > 0){
                            //index
                            //number of cysteines - length of peptide - iteraction (to avoid overwritting)
                            $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".(string)($i);
                            $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                        }
                        $peptide = "";
                        $startpos = $i+2;
                        unset($cysteines);
                    }
                    else{
                        if($AAR[$i] == "C"){
                            $cysteines[] = strlen($peptide);
                        }
                        $peptide .= $AAR[$i];
                    }
                }
                //check if last peptide contains Cysteine residues
                if(count($cysteines) > 0){
                    $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".strlen($fastaProtein);
                    $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                }

                break;
                        //chymotrypsin
            case "TC":

                $fastaProtein = ereg_replace("\r\n", "", $fastaProtein);
                $AAR = str_split($fastaProtein, 1);
                //Space added to the end to avoid out of bounds exception
                $AAR[] = "";
                //peptide start position
                $startpos = 1;
                //starts from first positions and goes until second last position
                for($i=0;$i<count($AAR)-1;$i++){

                    if(($AAR[$i] == 'R' || $AAR[$i] == 'K' || $AAR[$i] == 'L' || $AAR[$i] == 'F' || $AAR[$i] == 'Y' || $AAR[$i] == 'W' || $AAR[$i] == 'M') && $AAR[$i+1] != 'P'){
                        $peptide .= $AAR[$i];
                        //space added to treat strpos exception
                        if(count($cysteines) > 0){
                            //index
                            //number of cysteines - length of peptide - iteraction (to avoid overwritting)
                            $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".(string)($i);
                            $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                        }
                        $peptide = "";
                        $startpos = $i+2;
                        unset($cysteines);
                    }
                    else{
                        if($AAR[$i] == "C"){
                            $cysteines[] = strlen($peptide);
                        }
                        $peptide .= $AAR[$i];
                    }
                }
                //check if last peptide contains Cysteine residues
                if(count($cysteines) > 0){
                    $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".strlen($fastaProtein);
                    $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                }

                break;
            //Glu-C
            case "G":

                $fastaProtein = ereg_replace("\r\n", "", $fastaProtein);
                $AAR = str_split($fastaProtein, 1);
                //Space added to the end to avoid out of bounds exception
                $AAR[] = "";
                //peptide start position
                $startpos = 1;
                //starts from first positions and goes until second last position
                for($i=0;$i<count($AAR)-1;$i++){

                    if(($AAR[$i] == 'E') && $AAR[$i+1] != 'P'){
                        $peptide .= $AAR[$i];
                        //space added to treat strpos exception
                        if(count($cysteines) > 0){
                            //index
                            //number of cysteines - length of peptide - iteraction (to avoid overwritting)
                            $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".(string)($i);
                            $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                        }
                        $peptide = "";
                        $startpos = $i+2;
                        unset($cysteines);
                    }
                    else{
                        if($AAR[$i] == "C"){
                            $cysteines[] = strlen($peptide);
                        }
                        $peptide .= $AAR[$i];
                    }
                }
                //check if last peptide contains Cysteine residues
                if(count($cysteines) > 0){
                    $index = (string)(count($cysteines))."-".(string)(strlen($peptide))."-".strlen($fastaProtein);
                    $digestion[$index] = array('sequence' => $peptide,'cysteines' => $cysteines, 'start' => $startpos);
                }
                
                break;
        }

        return $digestion;
    }

    public function expandPeptidesByMissingCleavages($fasta, $protease, $peptides, $missingcleavages){

        $DBP = $peptides;

        $keys = array_keys($peptides);

        for($i=0;$i<count($peptides);$i++){

            $index = explode("-",$keys[$i]);
            $pep = $peptides[$keys[$i]];

            //position of peptide in protein sequence
            $pos = strpos($fasta, $pep['sequence']);

            //new peptide
            $newindex = "";
            $newcysteines = $pep['cysteines'];

            //use for pre and pos cleavage
            $preAAs = "";
            $prestart = "";
            $precysteines = array();

            //search for pre-cleavages (prefix)
            if($pos > 0){

                //AAs from prefix
                $AAs = str_split(substr($fasta,0,$pos));
                //add first AA
                $extraAAs = $AAs[$pos-1];
                //count of missing cleavages found
                $found = 0;
                $stop = false;
                //look for following AAs that are responsible for cleavages
                for($j=($pos-2);$j>=0;$j--){
                    switch ($protease){
                        case 'T':
                            if(($AAs[$j] == 'R' || $AAs[$j] == 'K') && $AAs[$j+1] != 'P'){
                                $found++;

                                //adjust cysteine position
                                for($s=0;$s<count($newcysteines);$s++){
                                   if($found == 1){
                                       $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs);
                                       $shift = strlen($extraAAs);
                                   }
                                   else{
                                    //discounts the length of the already computed first missed cleavage
                                    $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs)-$shift+1;
                                   }
                                }

                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($extraAAs.$pep['sequence']),
                                                        'cysteines' => $newcysteines, 'start' => ($j+2));

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $preAAs = $extraAAs.$pep['sequence'];
                                    $prestart = $j+2;
                                    $precysteines = $newcysteines;
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                                else{
                                    $extraAAs = $AAs[$j].$extraAAs;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+1-$pep['start'];
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs = $AAs[$j].$extraAAs;
                            }
                            break;
                        case 'C':
                                if(($AAs[$j] == 'L' || $AAs[$j] == 'F' || $AAs[$j] == 'Y' || $AAs[$j] == 'W' || $AAs[$j] == 'M') && $AAs[$j+1] != 'P'){
                                $found++;

                                //adjust cysteine position
                                for($s=0;$s<count($newcysteines);$s++){
                                   if($found == 1){
                                       $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs);
                                       $shift = strlen($extraAAs);
                                   }
                                   else{
                                    //discounts the length of the already computed first missed cleavage
                                    $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs)-$shift+1;
                                   }
                                }
                                
                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($extraAAs.$pep['sequence']),
                                                        'cysteines' => $newcysteines, 'start' => ($j+2));

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $preAAs = $extraAAs.$pep['sequence'];
                                    $prestart = $j+2;
                                    $precysteines = $newcysteines;
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                                else{
                                    $extraAAs = $AAs[$j].$extraAAs;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+1-$pep['start'];
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs = $AAs[$j].$extraAAs;
                            }
                            break;
                        case 'TC':
                                if(($AAs[$j] == 'R' || $AAs[$j] == 'K' || $AAs[$j] == 'L' || $AAs[$j] == 'F' || $AAs[$j] == 'Y' || $AAs[$j] == 'W' || $AAs[$j] == 'M') && $AAs[$j+1] != 'P'){
                                $found++;

                                //adjust cysteine position
                                for($s=0;$s<count($newcysteines);$s++){
                                   if($found == 1){
                                       $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs);
                                       $shift = strlen($extraAAs);
                                   }
                                   else{
                                    //discounts the length of the already computed first missed cleavage
                                    $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs)-$shift+1;
                                   }
                                }

                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($extraAAs.$pep['sequence']),
                                                        'cysteines' => $newcysteines, 'start' => ($j+2));

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $preAAs = $extraAAs.$pep['sequence'];
                                    $prestart = $j+2;
                                    $precysteines = $newcysteines;
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                                else{
                                    $extraAAs = $AAs[$j].$extraAAs;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+1-$pep['start'];
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs = $AAs[$j].$extraAAs;
                            }
                            break;
                        case 'G':
                                if(($AAs[$j] == 'E') && $AAs[$j+1] != 'P'){
                                $found++;

                                //adjust cysteine position
                                for($s=0;$s<count($newcysteines);$s++){
                                   if($found == 1){
                                       $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs);
                                       $shift = strlen($extraAAs);
                                   }
                                   else{
                                    //discounts the length of the already computed first missed cleavage
                                    $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs)-$shift+1;
                                   }
                                }
                                
                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($extraAAs.$pep['sequence']),
                                                        'cysteines' => $newcysteines, 'start' => ($j+2));

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $preAAs = $extraAAs.$pep['sequence'];
                                    $prestart = $j+2;
                                    $precysteines = $newcysteines;
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                                else{
                                    $extraAAs = $AAs[$j].$extraAAs;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+1-$pep['start'];
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs = $AAs[$j].$extraAAs;
                            }
                            break;
                    }
                    if($stop == true){
                        break;
                    }
                    else{
                        if($j == 0){

                            $found++;

                            //adjust cysteine position
                            for($s=0;$s<count($newcysteines);$s++){
                               if($found == 1){
                                   $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs);
                                   $shift = strlen($extraAAs);
                               }
                               else{
                                   //discounts the length of the already computed first missed cleavage
                                   $newcysteines[$s] = $newcysteines[$s]+strlen($extraAAs)-$shift+1;
                               }
                            }
                            
                            //index: # cysteines - # AAs - # missing cleavages
                            $newindex = "".(count($newcysteines))."-".
                            ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/($found+1));
                            //add peptide
                            $DBP[$newindex] = array('sequence' => ($extraAAs.$pep['sequence']),
                                                    'cysteines' => $newcysteines, 'start' => ($j+1));
                        
                            if($found == 1){
                                //use for pre and pos cleavage
                                $preAAs = $extraAAs.$pep['sequence'];
                                $prestart = $j+1;
                                $precysteines = $newcysteines;
                            }
                        }
                    }
                }
            }

            //new peptide
            $newindex = "";
            $newcysteines = $pep['cysteines'];

            //search for pos-cleavages
            if(($pos+strlen($pep['sequence'])) < strlen($fasta)){
                
                //AAs from sufix
                $AAs = str_split(substr($fasta,($pos+strlen($pep['sequence']))));
                //extra AAs
                $extraAAs = "";
                //count of missing cleavages found
                $found = 0;
                $stop = false;
                //look for following AAs that are responsible for cleavages
                for($j=0;$j<count($AAs);$j++){
                    switch ($protease){
                        case 'T':
                            if(($AAs[$j] == 'R' || $AAs[$j] == 'K') && $AAs[$j+1] != 'P'){
                                $found++;

                                $extraAAs .= $AAs[$j];

                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($pep['sequence'].$extraAAs),
                                                        'cysteines' => $newcysteines, 'start' => $pep['start']);

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $PrePosSequence = $preAAs.$extraAAs;
                                    $PrePosStart = $prestart;
                                    $PrePosCysteines = $precysteines;

                                    if(count($PrePosCysteines) > 0){
                                        //index: # cysteines - # AAs - # missing cleavages
                                        $newindex = "".(count($PrePosCysteines))."-".
                                        (strlen($PrePosSequence))."-".round(rand(2,999)/$found);
                                        //add peptide
                                        $DBP[$newindex] = array('sequence' => ($PrePosSequence),
                                                                'cysteines' => $PrePosCysteines, 'start' => $PrePosStart);
                                    }

                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+strlen($pep['sequence']);
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs .= $AAs[$j];
                            }
                            break;
                        case 'C':
                            if(($AAs[$j] == 'L' || $AAs[$j] == 'F' || $AAs[$j] == 'Y' || $AAs[$j] == 'W' || $AAs[$j] == 'M') && $AAs[$j+1] != 'P'){
                                $found++;

                                $extraAAs .= $AAs[$j];

                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($pep['sequence'].$extraAAs),
                                                        'cysteines' => $newcysteines, 'start' => $pep['start']);

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $PrePosSequence = $preAAs.$extraAAs;
                                    $PrePosStart = $prestart;
                                    $PrePosCysteines = $precysteines;

                                    if(count($PrePosCysteines) > 0){
                                        //index: # cysteines - # AAs - # missing cleavages
                                        $newindex = "".(count($PrePosCysteines))."-".
                                        (strlen($PrePosSequence))."-".round(rand(2,999)/$found);
                                        //add peptide
                                        $DBP[$newindex] = array('sequence' => ($PrePosSequence),
                                                                'cysteines' => $PrePosCysteines, 'start' => $PrePosStart);
                                    }
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+strlen($pep['sequence']);
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs .= $AAs[$j];
                            }
                            break;
                        case 'TC':
                                if(($AAs[$j] == 'R' || $AAs[$j] == 'K' || $AAs[$j] == 'L' || $AAs[$j] == 'F' || $AAs[$j] == 'Y' || $AAs[$j] == 'W' || $AAs[$j] == 'M') && $AAs[$j+1] != 'P'){
                                $found++;

                                $extraAAs .= $AAs[$j];

                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($pep['sequence'].$extraAAs),
                                                        'cysteines' => $newcysteines, 'start' => $pep['start']);

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $PrePosSequence = $preAAs.$extraAAs;
                                    $PrePosStart = $prestart;
                                    $PrePosCysteines = $precysteines;

                                    if(count($PrePosCysteines) > 0){
                                        //index: # cysteines - # AAs - # missing cleavages
                                        $newindex = "".(count($PrePosCysteines))."-".
                                        (strlen($PrePosSequence))."-".round(rand(2,999)/$found);
                                        //add peptide
                                        $DBP[$newindex] = array('sequence' => ($PrePosSequence),
                                                                'cysteines' => $PrePosCysteines, 'start' => $PrePosStart);
                                    }
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+strlen($pep['sequence']);
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs .= $AAs[$j];
                            }
                            break;
                        case 'G':
                                if(($AAs[$j] == 'E') && $AAs[$j+1] != 'P'){
                                $found++;

                                $extraAAs .= $AAs[$j];

                                //index: # cysteines - # AAs - # missing cleavages
                                $newindex = "".(count($newcysteines))."-".
                                ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/$found);
                                //add peptide
                                $DBP[$newindex] = array('sequence' => ($pep['sequence'].$extraAAs),
                                                        'cysteines' => $newcysteines, 'start' => $pep['start']);

                                if($found == 1){
                                    //use for pre and pos cleavage
                                    $PrePosSequence = $preAAs.$extraAAs;
                                    $PrePosStart = $prestart;
                                    $PrePosCysteines = $precysteines;

                                    if(count($PrePosCysteines) > 0){
                                        //index: # cysteines - # AAs - # missing cleavages
                                        $newindex = "".(count($PrePosCysteines))."-".
                                        (strlen($PrePosSequence))."-".round(rand(2,999)/$found);
                                        //add peptide
                                        $DBP[$newindex] = array('sequence' => ($PrePosSequence),
                                                                'cysteines' => $PrePosCysteines, 'start' => $PrePosStart);
                                    }
                                }

                                if($found == $missingcleavages){
                                    $stop = true;
                                }
                            }
                            else{
                                if($AAs[$j] == 'C'){
                                    $cys = array();
                                    $cys[] = $j+strlen($pep['sequence']);
                                    for($k=0;$k<count($newcysteines);$k++){
                                        $cys[] = $newcysteines[$k];
                                    }
                                    $newcysteines = $cys;
                                }
                                $extraAAs .= $AAs[$j];
                            }
                            break;
                    }
                    if($stop == true){
                        break;
                    }
                    else{
                        if($j == (count($AAs)-1)){
                            //index: # cysteines - # AAs - # missing cleavages
                            $newindex = "".(count($newcysteines))."-".
                            ((int)$index[1]+strlen($extraAAs))."-".round(rand(2,999)/($found+1));
                            //add peptide
                            $DBP[$newindex] = array('sequence' => ($pep['sequence'].$extraAAs),
                                                    'cysteines' => $newcysteines, 'start' => $pep['start']);
                        }
                    }
                }
            }
        }

        return $DBP;
    }

    public function Imatch($DMS,$PML, $IMthreshold){

        $matches = array();

        $keysDMS = array_keys($DMS);
        $keysPML = array_keys($PML);

        for($i=0;$i<count($keysDMS);$i++){
            for($j=0;$j<count($keysPML);$j++){
                $DMSmass = $DMS[$keysDMS[$i]]["mass"];
                $PMLmass = (float)substr($PML[$keysPML[$j]],0,strpos($PML[$keysPML[$j]]," "));
                //threshold used to correct MS/MS experiment variance
                //-1 due to the fact that the DTA file format is:
                //MH+ for the precursor ion, independent from the charge state
                //therefore the M = MH+ -1
                if(($DMSmass >= (($PMLmass-1)-($IMthreshold/2))) &&
                   ($DMSmass <= (($PMLmass-1)+($IMthreshold/2)))){
                    $matches[] = array("DMS" => $keysDMS[$i],"PML" => $keysPML[$j]);
                }
            }
        }

        return $matches;
    }
    
}
?>