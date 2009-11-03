<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    require_once $_SERVER['DOCUMENT_ROOT']."/DisulfideBond/classes/AA.class.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/DisulfideBond/classes/InitialMatch.class.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/DisulfideBond/classes/Common.class.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/DisulfideBond/classes/ConfirmedMatch.class.php";

    $IMClass = new InitialMatchclass();
    $Func = new Commonclass();
    $AAs = new AAclass();
    $CMClass = new ConfirmedMatchclass();

    //clear results string
    //message displayed on screen
    $message = "";
    
    //expected amino acid mass
    $me = 111.17;
    //InitialMatch threshold +-1.0
    $IMthreshold = 1.0;
    
    $zipFile = $_FILES["zipFile"];
    $fastaProtein = (string)$_POST["fastaProtein"];

    $tmp = explode("\r\n", $fastaProtein);
    for($i=0;$i<count($tmp);$i++){
        if(substr($tmp[$i], 0, 1) == '>'){
            unset($tmp[$i]);
        }
    }
    $fastaProtein = implode("", $tmp);
    
    $fastaProtein = strtoupper($fastaProtein);
    $protease = (string)$_POST["protease"];
    //$cleavages = (int)$_POST["cleavages"];
    $missingcleavages = (int)$_POST["missingcleavages"];
    if($missingcleavages == -1){
        $missingcleavages = 2;
    }

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

    if(isset($_FILES["zipFile"]) && $_FILES["zipFile"][size] > 0 &&
       isset($_POST["fastaProtein"]) && isset($_POST["protease"])){
        
        //digest protein
        $disulfideBondedPeptides = $IMClass->digestProtein($fastaProtein, $protease);

        //expand peptides based on # missing cleavages
        if($missingcleavages > 0){
            $disulfideBondedPeptides = $IMClass->expandPeptidesByMissingCleavages($fastaProtein, $protease, $disulfideBondedPeptides, $missingcleavages);
        }

        //sort Peptides by number of cysteines
        $Func->sortByCysteines(&$disulfideBondedPeptides);

        //read DTA files
        $zip = zip_open($zipFile["tmp_name"]);
        if($zip){
            $dirPath = "DTA/".$zipFile["name"];
            if(!is_dir($dirPath)){
                mkdir($dirPath);
            }
            $iterations = 0;
            while($zip_entry = zip_read($zip)){
                if(zip_entry_open($zip, $zip_entry)){
                    $data = zip_entry_read($zip_entry,zip_entry_filesize($zip_entry));

                    $filename = zip_entry_name($zip_entry);

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
                        $path = "DTA/".$zipFile["name"]."/".$index.".txt";
                        file_put_contents($path, $data);
                    }

                }
            }
        }

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
                $debug .= 'Precursor Ion M+H = '.$PML[$IM[$i]["PML"]];
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
                
                //store precursor ion
                $precursor = $data[0];
                unset($data[0]);

                //transform array: keys will be the intensity and values will be the m/z
                $numberfragments = count($data);
                $newvalues = array();
                for($j=1;$j<$numberfragments;$j++){
                    $newvalues[(int)substr($data[$j],strpos($data[$j], " ")+1)] = (float)substr($data[$j],0,strpos($data[$j], " "));
                }
                unset($data);
                
                //Try Screening 5%. If it doesnt work, program decreases automatically
                //until it finds 50 records with higher intensity than limit
                //$TML = $CMClass->screenData($newvalues,0.05,50);

                //function to screen fragments from a DTA file. The goal is to find all fragments
                //Do 3% screening and consider only the highest intensity picks as matches,
                //according to threshold
                $TML = $CMClass->screenDataHighPicks($newvalues,0.03,2.0);

                //unset original dataset
                unset($newvalues);

                //define threshold to either save fragment or discard it based on
                //the precursor ion mass
                //$fragmentmass <= ($precursormass + $threshold)
                $TMLthreshold = 2;

                $TML = $CMClass->expandTMLByCharges($TML, $precursor, $TMLthreshold);

                //construct FMS
                $FMS = array();

                //read disulfide bond structure
                $peptides = $DMS[$IM[$i]["DMS"]]["peptides"];
                $cysteines = $DMS[$IM[$i]["DMS"]]["cysteines"];

                $FMS = $CMClass->formFMS($peptides, $cysteines);

                //sort FMS by mass
                ksort(&$FMS);

                //Confirmed Match threshold +-1
                $CMthreshold = 1;

                //$FMSpolynomial = $CMClass->FMSPolynomial($TML, $peptides, $cysteines, $CMthreshold);

                $CM = $CMClass->Cmatch($FMS, $TML, $precursor, $CMthreshold);

                //debugging
                //$test2 = count($CM);
                //report results for paper
                /*
                $reportdata['FMS'] = count($FMS);
                $reportdata['TML'] = count($TML);
                $reportdata['CM'] = count($CM);
                $reportdata['sumCM'] += count($CM);
                */

                for($k=0;$k<count($CM);$k++){

                    if(strpos($CM[$k]['peptide'],'<=>') > 0){

                        $fragments = explode('<=>', $CM[$k]["fragment"]);
                        $peptides = explode('<=>', $CM[$k]["peptide"]);

                        $pepInProt1 = $Func->getStartPosition($disulfideBondedPeptides, $peptides[0]);
                        $pepInProt2 = $Func->getStartPosition($disulfideBondedPeptides, $peptides[1]);

                        $pos1 = strpos($fragments[0], "C");
                        $pos2 = strpos($fragments[1], "C");

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
                    $debug .= 'Fragments Total Mass = '.$CM[$k]["mass"];
                    $debug .= '</td>';
                    $debug .= '<td width="50px;"></td>';
                    $debug .= '<td>';
                    $debug .= 'DTA Fragment Mass = ';
                    $debug .= $CM[$k]["matches"]["TML"];
                    $debug .= ', Intensity = ';
                    $debug .= $TML[$CM[$k]["debug"]["TML"]]["intensity"];
                    $debug .= ', M/Z = ';
                    $debug .= ($TML[$CM[$k]["debug"]["TML"]]["mass"]/$TML[$CM[$k]["debug"]["TML"]]["charge"]);
                    $debug .= ', Charge = ';
                    $debug .= $TML[$CM[$k]["debug"]["TML"]]["charge"];
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
                $debug .= '<td align="left" colspan="3"><b>NUMBER OF S-S BONDS: ';
                $debug .= count($CM).'</b></td>';
                $debug .= '</tr>';
                //end of outputting code
            }

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
                $debug .= "</table>";
            }

        }
        else{
            $message = "No disulfide bonded structures found during Initial Match.";
            unset($debug);
        }
    }
    else{
        $message = "Please fill out requested information!";
        unset($debug);
    }

    include $_SERVER['DOCUMENT_ROOT']."/DisulfideBond/index.php";
    

?>
