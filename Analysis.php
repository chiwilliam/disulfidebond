<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/disulfidebond/classes/Users.class.php";
    $Users = new Usersclass();

    if($_REQUEST["mode"] == "advanced"){

        $mode = "advanced";
        $advancedusers = $Users->getAdvancedUserHTML();
        
        include $_SERVER['DOCUMENT_ROOT']."/disulfidebond/index.php";
        
    }
    else{
        require_once $_SERVER['DOCUMENT_ROOT']."/disulfidebond/classes/AA.class.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/disulfidebond/classes/InitialMatch.class.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/disulfidebond/classes/Common.class.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/disulfidebond/classes/ConfirmedMatch.class.php";

        $IMClass = new InitialMatchclass();
        $Func = new Commonclass();
        $AAs = new AAclass();
        $CMClass = new ConfirmedMatchclass();

        //error messages
        $errors = array();
        $errors["nofile"]["code"] = "01";
        $errors["nofile"]["message"] = "No file was uploaded.";
        $errors["emptyfile"]["code"] = "02";
        $errors["emptyfile"]["message"] = "File uploaded is empty.";
        $errors["invalidfile"]["code"] = "03";
        $errors["invalidfile"]["message"] = "File uploaded is invalid. Please upload a ZIP file containing DTA files inside.";
        $errors["noprotein"]["code"] = "04";
        $errors["noprotein"]["message"] = "No FASTA protein sequence was entered.";
        $errors["invalidprotein"]["code"] = "05";
        $errors["invalidprotein"]["message"] = "Invalid FASTA protein sequence.";
        $errors["digestion"]["code"] = "06";
        $errors["digestion"]["message"] = "Protein could not be digested. Make sure you entered a valid FASTA protein sequence and selected a protease.";
        $errors["PMLformation"]["code"] = "07";
        $errors["PMLformation"]["message"] = "The ZIP file did not contain any DTA file.";
        /*
        $errors[""]["code"] = "08";
        $errors[""]["message"] = "";
        */

        //clear results string
        //message displayed on screen
        $message = "";

        //THRESHOLDS
        //InitialMatch threshold +-1.0
        if(isset($_POST["IMthreshold"])){
            $IMthreshold = $_POST["IMthreshold"];
            //set User Type
            $mode = "advanced";
        }
        else{
            $IMthreshold = 1.0;
        }        
        //Threshold used to expand TML: new_fragment < precursor_mass+TMLthreshold
        if(isset($_POST["TMLthreshold"])){
            $TMLthreshold = $_POST["TMLthreshold"];
        }
        else{
            $TMLthreshold = 2.0;
        }        
        //Confirmed Match threshold +-1
        if(isset($_POST["CMthreshold"])){
            $CMthreshold = $_POST["CMthreshold"];
        }
        else{
            $CMthreshold = 1.0;
        }        
        //Screening threshold: separate close picks, so the median can be calculated
        if(isset($_POST["ScreeningThreshold"])){
            $ScreeningThreshold = $_POST["ScreeningThreshold"];
        }
        else{
            $ScreeningThreshold = 2.0;
        }
        //Screening Intensity Limit
        if(isset($_POST["IntensityLimit"])){
            $IntensityLimit = $_POST["IntensityLimit"];
        }
        else{
            $IntensityLimit = 0.03;
        }

        //If User is Advanced, create Advanced User Div
        if($mode == "advanced"){
            $advancedusers = $Users->getAdvancedUserHTML($IMthreshold,$TMLthreshold,$ScreeningThreshold,$IntensityLimit,$CMthreshold);
        }
        
        $zipFile = $_FILES["zipFile"];
        $fastaProtein = (string)$_POST["fastaProtein"];

        $fastaProtein = $AAs->formatFASTAsequence($fastaProtein);

        $protease = (string)$_POST["protease"];
        //$cleavages = (int)$_POST["cleavages"];
        $missingcleavages = (int)$_POST["missingcleavages"];
        if($missingcleavages == -1){
            $missingcleavages = 2;
        }

        if(strlen($_FILES["zipFile"]["name"]) > 0 && $_FILES["zipFile"][size] > 0 &&
           ($_FILES["zipFile"]["type"] == "application/zip" || $_FILES["zipFile"]["type"] == "application/x-zip-compressed") &&
           $fastaProtein != false &&
           strlen($_POST["fastaProtein"]) > 0 && strlen($_POST["protease"]) > 0){

            //output all results in a string to be debugged;
            $debug = '<table>';
            $debug .= '<tr><td colspan ="3" align="center"><h3>';
            $debug .= 'Protease: ';
            switch($protease){
                case 'T':
                    $prot = 'Trypsin';
                    break;
                case 'C':
                    $prot = 'Chymotrypsin';
                    break;
                case 'TC':
                    $prot = 'Trypsin & Chymotrypsin';
                    break;
                case 'G':
                    $prot = 'Glu-C';
                    break;
            }
            $debug .= $prot;
            $debug .= ', Missing Cleavages: '.$missingcleavages;
            $debug .= '</h3></td></tr>';

            //digest protein
            $possiblebonds = $AAs->possibleBonds($fastaProtein);

            $disulfideBondedPeptides = $IMClass->digestProtein($fastaProtein, $protease);

            if(count($disulfideBondedPeptides) > 0)
            {

                //expand peptides based on # missing cleavages
                if($missingcleavages > 0){
                    $disulfideBondedPeptides = $IMClass->expandPeptidesByMissingCleavages($fastaProtein, $protease, $disulfideBondedPeptides, $missingcleavages);
                }

                //sort Peptides by number of cysteines
                $Func->sortByCysteines(&$disulfideBondedPeptides);

                //expected amino acid mass
                $me = 111.17;

                //read DTA files
                $zip = zip_open($zipFile["tmp_name"]);
                if($zip){
                    $dirPath = $_SERVER['DOCUMENT_ROOT']."/disulfidebond/DTA/".$zipFile["name"];
                    if(!is_dir($dirPath)){
                        mkdir($dirPath);
                    }
                    $iterations = 0;
                    while($zip_entry = zip_read($zip)){
                        if(zip_entry_open($zip, $zip_entry)){

                            $filename = zip_entry_name($zip_entry);
                            $extension = strtoupper(substr($filename, strlen($filename)-3));

                            if($extension == "DTA"){

                                $data = zip_entry_read($zip_entry,zip_entry_filesize($zip_entry));

                                //subtract one due to DTA format for precursor ions mass Mr
                                //index is number of AA - number of charges - calculated mass
                                $index = (string)((int)((substr($data,0,strpos($data," "))-1.0) / $me))."-".
                                         substr($data,(strpos($data," ")+1),1)."-".
                                         substr($data,0,strpos($data,"."))."-".(string)$iterations;
                                $index = substr($data,0,strpos($data,"."))."-".
                                         substr($data,(strpos($data," ")+1),1)."-".(string)$iterations;
                                $iterations++;

                                if(strlen($data) > 0){

                                    $PML[$index] = substr($data,0,strpos($data," ",strlen(substr($data,0,strpos($data," ")))+1));
                                    $PMLNames[$index] = $filename;

                                    //store data in a local file
                                    $path = $_SERVER['DOCUMENT_ROOT']."/disulfidebond/DTA/".$zipFile["name"]."/".$index.".txt";
                                    file_put_contents($path, $data);
                                }
                            }
                        }
                    }
                }

                if(count($PML) > 0){

                    //remove defective DTA entries
                    $pmlkeys = array_keys($PML);
                    for($i=0;$i<count($pmlkeys);$i++){
                        if(!is_string($PML[$pmlkeys[$i]])){
                            unset($PML[$pmlkeys[$i]]);
                            unset($PMLNames[$pmlkeys[$i]]);
                        }
                    }

                    //sort PML by mass
                    $Func->sortByMass(&$PML);

                    //check mass boundaries
                    $minPrecursor = $Func->getMinPrecursorMass($PML);
                    $maxPrecursor = $Func->getMaxPrecursorMass($PML);

                    //check mass boundaries by number of AA
                    $minPrecursorAAs = (int)($Func->getMinPrecursorAAs($PML));
                    $maxPrecursorAAs = (int)($Func->getMaxPrecursorAAs($PML));

                    //calculate $DMS
                    //$DMS = $IMClass->subsetSum($disulfideBondedPeptides, $minPrecursor, $maxPrecursor);
                    //$DMS = $IMClass->formDisulfideBondedStructures($disulfideBondedPeptides);

                    $numPeptides = count($disulfideBondedPeptides);
                    $numPML = count($PML);
                    //$numDMS = count($DMS);

                    $result = $IMClass->polynomialSubsetSum($PML, $IMthreshold, $disulfideBondedPeptides, $minPrecursor, $maxPrecursor);
                    $DMS = $result['DMS'];
                    $IM = $result['IM'];

                    //$DMSsize = count($DMS);

                    //sort PML by mass
                    //$Func->sortByMass(&$DMS);

                    //$DMSsize = count($DMS);

                    //eliminate impossible combinations on DMS
                    //-1 and +1 to balance standar deviation of match index
                    //$DMS = $Func->shrinkDMS($DMS,$minPrecursorAAs-1,$maxPrecursorAAs+1);

                    //$totalDMSexp = count($DMSexp);

                    //calculate mass of DMS elements
                    if(isset($DMS))
                        $DMS = $AAs->calculateMassSpaceMass($DMS);

                    //$DMSsize = count($DMS);

                    //compute Initial Match
                    //$IM = $IMClass->Imatch($DMS, $PML, $IMthreshold);

                    //count number of cysteine-containing peptides
                    //$valueK = count($disulfideBondedPeptides);

                    if(count($IM) > 0){

                        //report results for paper
                        /*
                        $reportdata['DBP'] = count($disulfideBondedPeptides);
                        $reportdata['DMS'] = count($DMS);
                        $reportdata['PML'] = count($PML);
                        $reportdata['IM'] = count($IM);
                        */

                        /*
                         * debugging mode
                        $message .= "Disulfide Bonded Structures found after Initial Match:<br><br>";
                        for($i=0;$i<count($IM);$i++){
                            $message .= "Structure #".($i+1).":<br>";
                            $message .= "Precursor Ion mass: "
                                        .substr($PML[$IM[$i]["PML"]],0,strpos($PML[$IM[$i]["PML"]]," "))
                                        ."<br>";
                            for($j=0;$j<count($DMS[$IM[$i]["DMS"]]["peptides"]);$j++){
                                $message .= "Peptide #".($j+1).": ";
                                $message .= $DMS[$IM[$i]["DMS"]]["peptides"][$j];
                                $message .= "<br>";
                            }
                            $message .= "<br>";
                        }
                        */

                        $bonds = array();
                        //debugging
                        //saves number of CMs per IM
                        $numberBonds = array();

                        //compute Confirmed Match
                        for($i=0;$i<count($IM);$i++){

                            //output for debugging
                            if($i > 0)
                                $debug .= '<tr><td><br /><br /></td></tr>';
                            $debug .= '<tr>';
                            $debug .= '<td><span style="color:red;">';
                            $debug .= ((string)($i+1)).'. ';
                            $debug .= 'Peptides Total Mass = '.$DMS[$IM[$i]["DMS"]]["mass"];
                            $debug .= '</span></td>';
                            $debug .= '<td width="50px;"></td>';
                            $debug .= '<td><span style="color:red;">';
                            $massdifference = round(((double)$DMS[$IM[$i]["DMS"]]["mass"] - (double)substr($PML[$IM[$i]["PML"]],0,(strlen($PML[$IM[$i]["PML"]])-2))),2);
                            if($massdifference <0){
                                $massdifference *= -1;
                            }
                            $debug .= 'Precursor Ion M+H = '.$PML[$IM[$i]["PML"]];
                            $debug .= ' [Mass difference: '.$massdifference.']';
                            $debug .= '</span></td>';
                            $debug .= '</tr>';
                            $debug .= '<tr>';
                            $debug .= '<td><span style="color:red;">';
                            $peps = $DMS[$IM[$i]["DMS"]]["peptides"];
                            for($p=0;$p<count($peps);$p++){
                                if($p < (count($peps)-1))
                                    $debug .= $peps[$p]."<br />";
                                else
                                    $debug .= $peps[$p];
                            }
                            $debug .= '</span></td>';
                            $debug .= '<td width="50px;"></td>';
                            $debug .= '<td><span style = "color:red;">';
                            $debug .= 'DTA File: '.$PMLNames[$IM[$i]["PML"]].'   ['.$IM[$i]["PML"].']';
                            $debug .= '</span></td>';
                            $debug .= '</tr>';
                            //end of outputting code

                            //construct TML
                            $data = file($dirPath."/".$IM[$i]["PML"].".txt");
                            $numberfragments = count($data);

                            if($numberfragments > 0){

                                //store precursor ion
                                $precursor = $data[0];
                                unset($data[0]);

                                //transform array: keys will be the intensity and values will be the m/z
                                /*
                                $newvalues = array();
                                for($j=1;$j<$numberfragments;$j++){
                                    $index = (int)substr($data[$j],strpos($data[$j], " ")+1);
                                    $value = (float)substr($data[$j],0,strpos($data[$j], " "));
                                    $newvalues[$index] = $value;
                                }
                                unset($data);
                                 *
                                 */

                                //Try Screening 5%. If it doesnt work, program decreases automatically
                                //until it finds 50 records with higher intensity than limit
                                //$TML = $CMClass->screenData($newvalues,0.05,50);

                                //function to screen fragments from a DTA file. The goal is to find all fragments
                                //Do 3% screening and consider only the highest intensity picks as matches,

                                //according to threshold
                                $TML = $CMClass->screenDataHighPicks($data,$IntensityLimit,$ScreeningThreshold);

                                $totalscreenedTML = count($TML);

                                if($totalscreenedTML > 0){

                                    //define threshold to either save fragment or discard it based on
                                    //the precursor ion mass
                                    //$fragmentmass <= ($precursormass + $threshold)
                                    
                                    $TML = $CMClass->expandTMLByCharges($TML, $precursor, $TMLthreshold);

                                    $totalexpandedTML = count($TML);

                                    //construct FMS
                                    $FMS = array();

                                    //read disulfide bond structure
                                    $peptides = $DMS[$IM[$i]["DMS"]]["peptides"];
                                    $cysteines = $DMS[$IM[$i]["DMS"]]["cysteines"];

                                    //$FMS = $CMClass->formFMS($peptides, $cysteines);

                                    //sort FMS by mass
                                    //ksort(&$FMS);

                                    $FMSpolynomial = $CMClass->FMSPolynomial($TML, $peptides, $cysteines, $CMthreshold);

                                    //$CM = $CMClass->Cmatch($FMS, $TML, $precursor, $CMthreshold);

                                    $FMS = $FMSpolynomial['FMS'];
                                    $CM = $FMSpolynomial['CM'];

                                    $totalCMs = count($CM);

                                    if($totalCMs > 0){

                                        //debugging
                                        //$test2 = count($CM);
                                        //report results for paper
                                        /*
                                        $reportdata['FMS'] = count($FMS);
                                        $reportdata['TML'] = count($TML);
                                        $reportdata['CM'] = count($CM);
                                        $reportdata['sumCM'] += count($CM);
                                        */

                                        for($k=0;$k<$totalCMs;$k++){

                                            if(strpos($CM[$k]['peptide'],'<=>') > 0){

                                                $fragments = explode('<=>', $CM[$k]["fragment"]);
                                                $peptides = explode('<=>', $CM[$k]["peptide"]);

                                                $pepInProt1 = $Func->getStartPosition($disulfideBondedPeptides, $peptides[0]);
                                                $pepInProt2 = $Func->getStartPosition($disulfideBondedPeptides, $peptides[1]);

                                                $pos1 = strpos($fragments[0], "C");
                                                $pos2 = strpos($fragments[1], "C");

                                                if($pos1 === false || $pos2 === false){
                                                    //skip as it is not possible to form a disulfide bond
                                                }
                                                else{
                                                    $pos1 = strpos($peptides[0], $fragments[0])+$pos1;
                                                    $pos2 = strpos($peptides[1], $fragments[1])+$pos2;

                                                    $pos1 = $pepInProt1+$pos1;
                                                    $pos2 = $pepInProt2+$pos2;

                                                    if($pos1 != $pos2){
                                                        $graph[$pos1][] = $pos2;
                                                        $graph[$pos2][] = $pos1;
                                                    }

                                                    if($pos1<$pos2){
                                                        $bond = $pos1.'-'.$pos2;
                                                    }
                                                    if($pos1>$pos2){
                                                        $bond = $pos2.'-'.$pos1;
                                                    }

                                                }

                                                unset($pos1);
                                                unset($pos2);
                                                unset($pepInProt1);
                                                unset($pepInProt2);
                                                unset($fragments);
                                                unset($peptides);

                                            }
                                            else{

                                                $fragment = $CM[$k]["fragment"];
                                                $peptide = $CM[$k]["peptide"];

                                                if($CM[$k][cysteines] >= 2){

                                                    $intrabondpepInProt1 = $Func->getStartPosition($disulfideBondedPeptides, $peptide);

                                                    $intrabondpos1 = strpos($fragment, "C");
                                                    $intrabondpos2 = strpos($fragment, "C",$intrabondpos1+1);

                                                    $intrabondpos1 = strpos($peptide, $fragment)+$intrabondpos1;
                                                    $intrabondpos2 = strpos($peptide, $fragment)+$intrabondpos2;

                                                    $intrabondpos1 = $intrabondpepInProt1+$intrabondpos1;
                                                    $intrabondpos2 = $intrabondpepInProt1+$intrabondpos2;

                                                    if($intrabondpos1 != $intrabondpos2){
                                                        $graph[$intrabondpos1][] = $intrabondpos2;
                                                        $graph[$intrabondpos2][] = $intrabondpos1;
                                                    }

                                                    if($intrabondpos1<$intrabondpos2){
                                                        $bond = $intrabondpos1.'-'.$intrabondpos2;
                                                    }
                                                    if($intrabondpos1>$intrabondpos2){
                                                        $bond = $intrabondpos2.'-'.$intrabondpos1;
                                                    }
                                                }

                                                unset($intrabondpos1);
                                                unset($intrabondpos2);
                                                unset($intrabondpepInProt1);
                                                unset($fragment);
                                                unset($peptide);
                                            }

                                            if(isset($bond)){
                                                if(!isset($numberBonds[$bond])){
                                                    $numberBonds[$bond] = 1;
                                                }
                                                else{
                                                    $numberBonds[$bond]++;
                                                }

                                                if(!in_array($bond, $bonds)){
                                                    $bonds[] = $bond;
                                                }
                                                //for debugging
                                                $tmpbond = $bond;
                                                //end
                                                unset($bond);
                                            }

                                            //output for debugging
                                            $debug .= '<tr>';
                                            $debug .= '<td>';
                                            $debug .= ((string)($i+1)).'.'.((string)($k+1)).'. ';
                                            $debug .= 'Fragments Mass = '.$CM[$k]["mass"];
                                            $debug .= '</td>';
                                            $debug .= '<td width="50px;"></td>';
                                            $debug .= '<td>';
                                            $debug .= 'DTA Mass = ';
                                            $debug .= $CM[$k]["matches"]["TML"];
                                            $debug .= ', Intensity = ';
                                            $debug .= $TML[$CM[$k]["debug"]["TML"]]["intensity"];
                                            $debug .= ', M/Z = ';
                                            $debug .= ($TML[$CM[$k]["debug"]["TML"]]["mass"]/$TML[$CM[$k]["debug"]["TML"]]["charge"]);
                                            $debug .= ', Z = ';
                                            $debug .= $TML[$CM[$k]["debug"]["TML"]]["charge"];
                                            $massdifference = round(((double)$CM[$k]["mass"] - (double)$CM[$k]["matches"]["TML"]),2);
                                            if($massdifference <0){
                                                $massdifference *= -1;
                                            }
                                            $debug .= ', Delta = ';
                                            $debug .= $massdifference;
                                            $debug .= '</td>';
                                            $debug .= '</tr>';
                                            $debug .= '<tr>';
                                            $debug .= '<td>';
                                            $frags = explode('<=>', $CM[$k]["fragment"]);
                                            $ions = explode('<=>', $CM[$k]["ion"]);
                                            for($p=0;$p<count($frags);$p++){
                                                if($p < (count($frags)-1))
                                                    $debug .= '<b>'.$ions[$p].'</b>   '.$frags[$p]."<br />";
                                                else
                                                    $debug .= '<b>'.$ions[$p].'</b>   '.$frags[$p];
                                            }
                                            $debug .= '</td>';
                                            $debug .= '<td width="50px;"></td>';
                                            $debug .= '<td><span style ="color:blue;">';
                                            $debug .= 'Disulfide Bond: '.$tmpbond;
                                            $debug .= '</span></td>';
                                            $debug .= '</tr>';
                                            unset($tmpbond);
                                            //end of outputting code
                                        }

                                        //output for debugging
                                        $debug .= '<tr>';
                                        $debug .= '<td align="left" colspan="3"><b>PARTIAL NUMBER OF MATCHES: ';
                                        $debug .= count($CM).'</b></td>';
                                        $debug .= '</tr>';
                                        //end of outputting code

                                    }//end if count(CM) > 0
                                }//end if count(TML) > 0
                            }//end if DTA could be read
                        }// end foreach IM

                        //Using Gabow algorithm to solve maximum weighted matching problem
                        if(count($bonds) > 0){
                            $bonds = $Func->executeGabow($graph);
                        }

                        for($i=0;$i<count($bonds);$i++){
                            //$message .= "<b>Disulfide Bond found(".$numberBonds[$bonds[$i]].")  on positions: ".$bonds[$i]."</b><br><br>";
                            $message .= "<b>Disulfide Bond found on positions: ".$bonds[$i]."</b><br><br>";
                        }

                        if(count($bonds) == 0){
                            unset($debug);
                            $message .= "Disulfide Bonds not found!";
                        }
                        else{

                            //sensitivity, specificity, accuracy, and Mathew's coefficient
                            $SSbonds = count($bonds);
                            $countpossiblebonds = count($possiblebonds);
                            for($i=0;$i<$SSbonds;$i++){
                                for($j=0;$j<$countpossiblebonds;$j++){
                                    if($bonds[$i] == $possiblebonds[$j]){
                                        unset($possiblebonds[$j]);
                                    }
                                }
                            }
                            $nonExistingBonds = count($possiblebonds);
                            $message .= "<b>Non-existing Bonds : ".$nonExistingBonds."</b><br><br>";

                            $debug .= "</table>";

                            //populate disulfide bonds graph
                            $AAsarray = str_split($fastaProtein,1);
                            $totalAAs = count($AAsarray);
                            $totalbonds = count($bonds);
                            $allbonds = array();

                            //define AAs to have colored background
                            for($i=0;$i<$totalbonds;$i++){
                                $cys = explode('-', $bonds[$i]);
                                $allbonds[] = $cys[0];
                                $allbonds[] = $cys[1];
                            }

                            //DISULFIDE BOND VISUALIZATION GRAPH
                            //start table
                            $numColumns = 30;
                            $SSgraph = '<table class="graphtable">';

                            for($i=0;$i<$totalAAs;$i++){
                                //start row
                                if($i%$numColumns == 0){
                                    if($i == 0){
                                        $SSgraph .= '<tr align="center">';
                                    }
                                    else{
                                        $SSgraph .= '</tr><tr align="center">';
                                    }
                                }

                                //fill columns
                                //check if columns participates in any disulfide bond
                                $isBonded = false;
                                for($j=0;$j<count($allbonds);$j++){
                                    if($allbonds[$j] == ($i+1)){
                                        $isBonded = true;
                                        break;
                                    }
                                }
                                //if it does, color background
                                if($isBonded){
                                    $SSgraph .= '<td class="graphselectedtd">'.$AAsarray[$i].'</td>';
                                }
                                else{
                                    $SSgraph .= '<td class="graphtd">'.$AAsarray[$i].'</td>';
                                }

                                //end row
                                if($i == ($totalAAs-1)){

                                    $missingcolumns = $numColumns-($totalAAs%$numColumns);
                                    for($j=0;$j<$missingcolumns;$j++){
                                        $SSgraph .= '<td class="graphtd"></td>';
                                    }

                                    $SSgraph .= '</tr>';
                                }
                            }

                            //Javascript to draw S-S bonds
                            $SSgraphJS = '<script type="text/javascript">';
                            for($j=0;$j<$totalbonds;$j++){
                                $cysteines = explode('-', $bonds[$j]);
                                $SSgraphJS .= "myDrawFunction(".($cysteines[0]-1).",".($cysteines[1]-1).",20,20,30,'yellow',3);";
                            }
                            $SSgraphJS .= '</script>';

                            //close table
                            $SSgraph .= "</table>";

                        }

                    }
                    else{
                        $message = "No Initial Matches between precursor ions and disulfide-bonded structures were found.";
                        unset($debug);
                    }
                }
                else{
                    $message .= "Error ".$errors["PMLformation"]["code"].
                            ": ".$errors["PMLformation"]["message"]."<br />";
                }
            }
            else{
                $message .= "Error ".$errors["digestion"]["code"].
                            ": ".$errors["digestion"]["message"]."<br />";
            }
        }
        else{
            if(strlen($_FILES["zipFile"]["name"]) == 0){
                $message .= "Error ".$errors["nofile"]["code"].
                            ": ".$errors["nofile"]["message"]."<br />";
            }
            if(strlen($_FILES["zipFile"]["size"]) == 0){
                $message .= "Error ".$errors["emptyfile"]["code"].
                            ": ".$errors["emptyfile"]["message"]."<br />";
            }
            if($_FILES["zipFile"]["size"] > 0 && $_FILES["type"] != "application/zip"){
                $message .= "Error ".$errors["invalidfile"]["code"].
                            ": ".$errors["invalidfile"]["message"]."<br />";
            }
            if(strlen($_POST["fastaProtein"]) == 0){
                $message .= "Error ".$errors["noprotein"]["code"].
                            ": ".$errors["noprotein"]["message"]."<br />";
            }
            if($fastaProtein == false){
                $message .= "Error ".$errors["invalidprotein"]["code"].
                            ": ".$errors["invalidprotein"]["message"]."<br />";
            }

            unset($debug);
        }

        include $_SERVER['DOCUMENT_ROOT']."/disulfidebond/index.php";
    }
    

?>
