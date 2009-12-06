<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Commonclass
 *
 * @author William
 */
class Commonclass {

    public function sortByCysteines(&$array){
        uksort(&$array,array($this,"_cmpCysteines"));
    }

    //sort array by cysteines
    private function _cmpCysteines($a,$b){
        $indexA = explode('-',$a);
        $indexB = explode('-',$b);
        if((int)$indexA[0] > (int)$indexB[0]){
            return -1;
        }
        if((int)$indexA[0] < (int)$indexB[0]){
            return 1;
        }
        if((int)$indexA[0] == (int)$indexB[0]){
            if((int)$indexA[1] >= (int)$indexB[1]){
                return -1;
            }
            else{
                return 1;
            }
        }
    }

    public function sortByMass(&$array){
        uksort(&$array,array($this,"_cmpMass"));
    }

    //sort array by mass
    private function _cmpMass($a,$b){
        $indexA = explode('-',$a);
        $indexB = explode('-',$b);
        if((int)$indexA[0] > (int)$indexB[0]){
            return -1;
        }
        if((int)$indexA[0] < (int)$indexB[0]){
            return 1;
        }
        if((int)$indexA[0] == (int)$indexB[0]){
            if((int)$indexA[1] > (int)$indexB[1]){
                return -1;
            }
            if((int)$indexA[1] < (int)$indexB[1]){
                return 1;
            }
            if((int)$indexA[1] == (int)$indexB[1]){
                if((int)$indexA[2] > (int)$indexB[2]){
                    return -1;
                }
                else{
                    return 1;
                }
            }
        }
    }

    //get highest precursor ion mass
    public function getMaxPrecursorMass($PML){

        reset(&$PML);
        $max = key(&$PML);

        $value = $PML[$max];
        $value = (double)substr($value, 0, strpos($value,' '));

        return $value;
    }

    //get lowest precursor ion mass
    public function getMinPrecursorMass($PML){

        end(&$PML);
        $min = key(&$PML);

        $value = $PML[$min];
        $value = (double)substr($value, 0, strpos($value,' '));

        return $value;
    }

    //get number of AA from precursor ion of maximum mass
    public function getMaxPrecursorAAs($PML){

        reset(&$PML);
        $max = key(&$PML);
        
        return substr($max,0,strpos($max,"-"));
    }

    //get number of AA from precursor ion of minimum mass
    public function getMinPrecursorAAs($PML){

        end(&$PML);
        $min = key(&$PML);

        return substr($min,0,strpos($min,"-"));
    }

    //function to shrink DMS to only possible disulfide bonded structures
    public function shrinkDMS($DMS,$min,$max){

        $keys = array_keys($DMS);

        for($i=0;$i<count($keys);$i++){

            $test = $DMS[$keys[$i]];

            $mass = (int)(substr($keys[$i],0,strpos($keys[$i],"-")));
            if($mass < $min || $mass > $max){
                unset($DMS[$keys[$i]]);
            }
        }

        return $DMS;
    }

    /*function to shrink PML to consider number similar masses from DMS values
     * For example:
     * One DMS value has key: 23-3-0 (means the structure has 23 AAs)
     * Therefore consider values on PML, whose number of AA's is 22,23,24
     * which means: PML-1 <= DMS <= PML+1
     * +-1 is because the variation is less than the mass of a single AA
     */
    public function shrinkPML($PML,$DMS){

        $keysDMS = array_keys($DMS);
        $keysPML = array_keys($PML);

        for($i=0;$i<count($keysDMS);$i++){
            $keysDMS[$i] = (int)(substr($keysDMS[$i],0,strpos($keysDMS[$i],"-")));
        }

        for($i=0;$i<count($keysPML);$i++){
            $AAPML = (int)(substr($keysPML[$i],0,strpos($keysPML[$i],"-")));
            if(in_array(($AAPML-1), $keysDMS) || in_array($AAPML, $keysDMS) || in_array(($AAPML+1), $keysDMS)){
                //do nothing
            }
            else{
                unset($PML[$keysPML[$i]]);
            }
        }
        
        return $PML;
    }

    //function to get starting position of a peptide in a protein sequence
    public function getStartPosition($disulfideBondedPeptides,$peptide){

        $startposition = 0;
        
        $keys = array_keys($disulfideBondedPeptides);
        for($i=0;$i<count($keys);$i++){
            $pep = $disulfideBondedPeptides[$keys[$i]]['sequence'];
            if($pep == $peptide){
                $startposition = $disulfideBondedPeptides[$keys[$i]]['start'];
                break;
            }
        }
        
        return $startposition;
    }

    //function to execute Gabow's algorithm given a input file
    public function executeGabow($graph){

        //input string that will be converted to the input file for wmatch
        $input = "";
        //initialize total number of edges. Will be used in line 1 of the input file
        $totaledges = 0;

        //initialize total number of vertices. Will be used in line 1 of the input file
        $vertices = count($graph);

        //create some complementary arrays to convert the position of the cysteines
        //(label) to an index that will be used in the input file for wmatch
        $keys = array_keys($graph);
        sort(&$keys,SORT_NUMERIC);
        for($i=0;$i<$vertices;$i++){
            $index[$keys[$i]] = $i+1;
        }

        //for each vertex, add its edges with respective weightes to the input file
        for($i=0;$i<$vertices;$i++){
            
            //unset variables to avoid it from carrying garbage
            unset($matches);
            unset($edges);
            unset($edgeskeys);

            //given one vertex, find all the possible edges
            $matches = $graph[$keys[$i]];
            for($j=0;$j<count($matches);$j++){
                //indexes are the cysteine positions converted into an integer that
                //will be interpreted by the wmatch executable and values are the
                //edge weights
                $edges[$index[$matches[$j]]] += 1;
            }

            //add to total edges
            $totaledges += count($edges);

            //mount vertex info to populate the vertex line in the input file
            $vertex = $index[$keys[$i]];
            $label = $keys[$i];
            $edgeskeys = array_keys($edges);
            //#edges label 0 0 \n\n
            $input .= count($edgeskeys)." ".$label." 0 0 \n\n";

            //for each vertex, calculate the possible edges with its respective weight
            //hold edge weights on array values
            ksort(&$edges,SORT_NUMERIC);
            //hold edge indexes on array values
            sort(&$edgeskeys,SORT_NUMERIC);
            for($k=0;$k<count($edges);$k++){
                //#index #weight \n\n
                $input .= $edgeskeys[$k]." ".$edges[$edgeskeys[$k]]." \n\n";
            }
        }

        //calculate final number of edges. divide by 2 because are edges are duplicated
        //i.e. 142-292 and 292-142 are the same S-S bond
        //totaledges needs to be a natural number
        if($totaledges%2 > 0){
            $totaledges--;
        }
        $totaledges = $totaledges/2;
        //first line of input file: carries total number of vertices and edges
        //#vertices #edges U \n\n
        $input = $vertices." ".$totaledges." U \n\n".$input."\n";

        //prepare file paths
        $path = $_SERVER['DOCUMENT_ROOT']."/disulfidebond/gabow/".$vertices.$totaledges."U";

        if($_ENV['OS'] == "Windows_NT"){
            $path = str_replace("/", "\\", $path);
        }

        $extensionIN = ".in";
        $extensionOUT = ".out";

        //delete old files if they exist
        if(file_exists($path.$extensionIN)){
            unlink($path.$extensionIN);
        }

        //save input string to input file
        file_put_contents($path.$extensionIN, $input);

        //write command to be executed to run wmatch executable
        if($_ENV['OS'] == "Windows_NT"){
            $command = $_SERVER['DOCUMENT_ROOT']."/disulfidebond/gabow/wmatch.exe ".
                       $path.$extensionIN." > ".$path.$extensionOUT;
            $command = str_replace("/", "\\", $command);
        }
        else{
            $command = $_SERVER['DOCUMENT_ROOT']."/disulfidebond/gabow/./wmatch ".
                       $path.$extensionIN." > ".$path.$extensionOUT;
        }
        
        //execute command
        exec($command);

        //delete files created
        if(file_exists($path.$extensionIN)){
            unlink($path.$extensionIN);
        }
        if(file_exists($path.$extensionOUT)){
            //read output file to output string
            $output = file_get_contents($path.$extensionOUT);
            unlink($path.$extensionOUT);
        }

        //extract maximum weighted match results
        if($_ENV['OS'] == "Windows_NT"){
            $output = str_replace("\r\n", " ", $output);
            $results = explode(" ", trim($output));
        }
        else{
            $output = str_replace(" ","",$output);
            $results = array();
            
            for($l=0;$l<strlen($output);$l++){
                $results[$l] = substr($output, $l, 1);
            }
        }

        //create an array with all chosen V-E-V (vertex-edge-vertex) combinations
        for($i=0;$i<count($results);$i+=2){
            //dilsufide bond: i.e. 142-292
            $bond = $keys[$results[$i]-1]."-".$keys[$results[$i+1]-1];
            //reverse disulfide bond to avoid creating duplicated disulfide bonds
            $reversebond = $keys[$results[$i+1]-1]."-".$keys[$results[$i]-1];
            $exist = false;
            //if disulfide bond already exists, skip without creating a duplicate
            if(count($bonds) > 0){
                $exist = array_search($reversebond, $bonds);
            }
            //if disulfide bond is new, add to S-S bonds array
            if($exist === false && $results[$i] != "0" && $results[$i+1] != "0"){
                $bonds[] = $keys[$results[$i]-1]."-".$keys[$results[$i+1]-1];
            }
        }

        //return final array with selected disulfide bonds according to Gabow's
        //algorithm to solve maximum weighted matching problems
        return $bonds;
    }
}
?>
