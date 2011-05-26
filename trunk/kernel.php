<?php
    session_start();
    
    //measure computational time
    $time = array();
    $time["start"] = microtime(true);

    //build root path (i.e.: C:\xampp\htdocs\)
    $root = $_SERVER['DOCUMENT_ROOT'];
    
    //processing step
    $step = 1;
    $_SESSION['step'] = $step;
    
    //fix for SFSU servers root path
    $predictive = 'Y';
    if(trim($root) == "/var/www/html/bioinformatics" || trim($root) == "/var/www"){
        //MS2DB+
        //for tintin
        $root = "/home/whemurad/public_html";
        $root .= "/disulfidebond";
        $predictive = 'N';
        //MS2DB++
        //for haddock2
        $root = "/home/ms2db/public_html";
        $root .= "/ms2db++";
        $predictive = 'Y';    
    }
    else{
        $root .= "/ms2db++";
    }

    //remove time limit when executing a script
    set_time_limit(0);
    
    //include necessary classes
    require_once $root."/classes/Users.class.php";
    require_once $root."/classes/AA.class.php";
    require_once $root."/classes/InitialMatch.class.php";
    require_once $root."/classes/Common.class.php";
    require_once $root."/classes/ConfirmedMatch.class.php";
    require_once $root."/classes/Charting.class.php";
    require_once $root."/prediction.php";
    require_once $root."/integration.php";
    
    //initialize objects
    $Users = new Usersclass();
    $IMClass = new InitialMatchclass();
    $Func = new Commonclass();
    $AAs = new AAclass();
    $CMClass = new ConfirmedMatchclass();
        
    //error messages
    $errors = array();
    $errors["nomethod"]["code"] = "00";
    $errors["nomethod"]["message"] = "No method was selected.";
    $errors["nofile"]["code"] = "01";
    $errors["nofile"]["message"] = "No MS/MS file was uploaded.";
    $errors["emptyfile"]["code"] = "02";
    $errors["emptyfile"]["message"] = "MS/MS file uploaded is empty.";
    $errors["invalidfile"]["code"] = "03";
    $errors["invalidfile"]["message"] = "MS/MS file uploaded is invalid. Please upload a ZIP file containing either DTA or XML-based files.";
    $errors["noprotein"]["code"] = "04";
    $errors["noprotein"]["message"] = "No FASTA protein sequence was entered.";
    $errors["invalidprotein"]["code"] = "05";
    $errors["invalidprotein"]["message"] = "Invalid FASTA protein sequence.";
    $errors["digestion"]["code"] = "06";
    $errors["digestion"]["message"] = "Protein could not be digested. Make sure you entered a valid FASTA protein sequence and selected a protease.";
    $errors["PMLformation"]["code"] = "07";
    $errors["PMLformation"]["message"] = "The ZIP file did not contain any valid MS/MS file.";
    $errors["invalidscore"]["code"] = "08";
    $errors["invalidscore"]["message"] = "One or more scores entered are invalid.";
    $errors["invalidindex"]["code"] = "09";
    $errors["invalidindex"]["message"] = "One or more bond entered is invalid.";
    $errors["invalidnumberbonds"]["code"] = "10";
    $errors["invalidnumberbonds"]["message"] = "Data entered is malformed or incomplete.";
    /*
    $errors[""]["code"] = "08";
    $errors[""]["message"] = "";
    */

    //clear results string
    //message displayed on screen
    $message = "";
    $debug = "";
    
    $MSMStheta = array();
    $SVMtheta = 0;
    $MSMSTransmembraneBonds = array();
    $SVMTransmembraneBonds = array();
    
    //set User Type
    if(isset($_REQUEST['mode'])){
        $mode = $_REQUEST['mode'];
    }
    else{
        $mode = "standard";
    }
    
    //Check methods selected
    $MSMS = $_REQUEST["inputmsms"];
    $SVM = $_REQUEST["inputsvm"];
    $CSP = $_REQUEST["inputcsp"];
    $CUSTOM = $_REQUEST["inputcustom"];
    $CUSTOM2 = $_REQUEST["inputcustom2"];
    $_SESSION['MSMS'] = $MSMS;
    $_SESSION['SVM'] = $SVM;
    $_SESSION['CSP'] = $CSP;
    $_SESSION['CUSTOM'] = $CUSTOM;
    $_SESSION['CUSTOM2'] = $CUSTOM2;
    
    $customdata = "";
    if(isset($_REQUEST["customdata"])){
        $customdata = $_POST["customdata"];
        $_SESSION['customdata'] = $customdata;
    }
    $custom2data = "";
    if(isset($_REQUEST["custom2data"])){
        $custom2data = $_POST["custom2data"];
        $_SESSION['custom2data'] = $custom2data;
    }
    
    //THRESHOLDS
    //InitialMatch threshold +-1.0
    $IMthreshold = 1.0;
    if(isset($_POST["IMthreshold"])){
        $IMthreshold = $_POST["IMthreshold"];
    }
    //default commented -- too technical for users to change
    //Threshold used to expand TML: new_fragment < precursor_mass+TMLthreshold
    $TMLthreshold = 2.0;
    if(isset($_POST["TMLthreshold"])){
        $TMLthreshold = $_POST["TMLthreshold"];
    }
    //Confirmed Match threshold +-1
    $CMthreshold = 1.0;
    if(isset($_POST["CMthreshold"])){
        $CMthreshold = $_POST["CMthreshold"];
    }
    //same as Confirmed Match threshold
    //Screening threshold: separate close picks, so the median can be calculated
    $ScreeningThreshold = $CMthreshold;
    if(isset($_POST["ScreeningThreshold"])){
        $ScreeningThreshold = $_POST["ScreeningThreshold"];
    }
    //Screening Intensity Limit
    $IntensityLimit = 0.10;
    if(isset($_POST["IntensityLimit"])){
        //$IntensityLimit = $_POST["IntensityLimit"];
        $IntensityLimit = 0.10;
    }
    //Match Score threshold 80
    $VSthreshold = 80;
    if(isset($_POST["VSthreshold"])){
        $VSthreshold = $_POST["VSthreshold"];
    }
    
    //Determine of the protein has any transmembrane region
    //If it does, remove the possible disulfide bonds in which one of the cysteines
    //is inside that region
    
    $transmembranefrom = trim($_POST["transmembranefrom"]);
    $transmembraneto = trim($_POST["transmembraneto"]);
    if(strlen(trim($transmembranefrom)) == 0){
        $transmembranefrom = 0;        
    }
    if(strlen(trim($transmembraneto)) == 0){
        $transmembraneto = 0;
    }
    $_SESSION['transmembranefrom'] = $transmembranefrom;
    $_SESSION['transmembraneto'] = $transmembraneto;

    //Check File uploaded
    $zipFile = $_FILES["zipFile"];
    $fastaProtein = (string)$_POST["fastaProtein"];

    //Format fasta sequence, removing unnecessary characters
    $fastaProtein = $AAs->formatFASTAsequence($fastaProtein);

    //Get protease and number of missing cleavages
    $protease = (string)$_POST["protease"];
    $missingcleavages = (int)$_POST["missingcleavages"];
    if($missingcleavages == -1){
        $missingcleavages = 2;
    }
    $_SESSION['protease'] = $protease;
    $_SESSION['missingcleavages'] = $missingcleavages;
    
    //get trimming parameters epsilon and delta
    $epsilon = (int)$_POST["epsilon"];
    if($epsilon < 0){
        $epsilon = 0;
    }
    $delta = (int)$_POST["delta"];
    if($delta < 0){
        $delta = 0;
    }
    
    if($MSMS != "" || $SVM != "" || $CSP != "" || $CUSTOM != "" || $CUSTOM2 != ""){
        //MSMS
        if($MSMS != ""){
            if(strlen($_FILES["zipFile"]["name"]) > 0 && 
               $_FILES["zipFile"][size] > 0 &&
               ($_FILES["zipFile"]["type"] == "application/zip" || $_FILES["zipFile"]["type"] == "application/x-zip-compressed" || $_FILES["zipFile"]["type"] == "application/octet-stream") &&
               $fastaProtein != false &&
               strlen($_POST["fastaProtein"]) > 0 && 
               strlen($_POST["protease"]) > 0
            ){

                //output all results in a string to be debugged;
                $debug = '<table>';
                $debug .= '<tr><td colspan ="3" align="center"><h3>';
                $debug .= 'Protease: ';
                $prot = "";
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

                //Digest protein
                $possiblebonds = $AAs->possibleBonds($fastaProtein,$transmembranefrom,$transmembraneto);

                //Form possible cysteine containing peptides
                $disulfideBondedPeptides = $IMClass->digestProtein($fastaProtein, $protease);

                if($transmembranefrom > 0 && $transmembraneto > 0){
                    //$disulfideBondedPeptides = $IMClass->removePeptidesInTransmembraneRegion($disulfideBondedPeptides,$transmembranefrom,$transmembraneto);
                }

                if(count($disulfideBondedPeptides) > 0)
                {

                    //expand peptides based on # missing cleavages
                    if($missingcleavages > 0){
                        $disulfideBondedPeptides = $IMClass->expandPeptidesByMissingCleavages($fastaProtein, $protease, $disulfideBondedPeptides, $missingcleavages);
                    }

                    //sort Peptides by number of cysteines
                    $Func->sortByCysteines(&$disulfideBondedPeptides);

                    //expected amino acid mass
                    //$me = 111.17;

                    //initialize variables
                    $aPML = array();
                    $PML = array();
                    $PMLNames = array();
                    $dirPath = "";
                    $MSMSFilePath = "";
                    $k=0;
                    $graph = array();

                    $aPML = $Func->readMSMSFiles($root, $zipFile["tmp_name"], $zipFile["name"]);
                    $PML = $aPML["PML"];
                    $PMLNames = $aPML["PMLNames"];
                    unset($aPML);
                    $dirPath = $root."/DTA/".$zipFile["name"];
                    $MSMSFilePath = $_SERVER['HTTP_REFERER'];
                    $MSMSFilePath = substr($MSMSFilePath, 0, strpos($MSMSFilePath, '++')+3);
                    $MSMSFilePath .= 'DTA/'.$zipFile["name"].'/';

                    //If DTA files are present
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

                        //First Stage matching. Generated DMS and Initial Matches (IM)
                        $result = $IMClass->polynomialSubsetSum($PML, $IMthreshold, $disulfideBondedPeptides, $minPrecursor, $maxPrecursor, $epsilon);
                        $DMS = $result['DMS'];
                        $IM = $result['IM'];
                        $newpeptides = $result['peptides'];
                        $IMdelta = $result['delta'];

                        //$DMSsize = $result['size'];
                        //unset($IM);

                        //$regression = $result['regression'];
                        //unset($IM);

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

                            //consider:
                            // all => all ion types
                            // by => only b and y ions
                            // aby+ => a,b,bo,b*,y,yo,y* ions
                            // cxz => only c, x, and z ions
                            $alliontypes = (string)$_POST["ions"];
                            $_SESSION['ions'] = $alliontypes;
                            //$alliontypes = "all";

                            //calculate trimming parameter regression curve
                            //populates an array with all deltas for all IMs
                            //$regression = array();

                            $FMSsize = array();
                            $Pvalues = array();

                            //array that holds the debug data
                            $aDebug = array();

                            //compute Confirmed Match
                            for($i=0;$i<count($IM);$i++){

                                //output for debugging
                                $aDebug[$i]['string'] = '';
                                $aDebug[$i]['string'] .= '<tr>';
                                $aDebug[$i]['string'] .= '<td><span style="color:red;">';
                                //$aDebug[$i]['string'] .= ((string)($i+1)).'. ';
                                $aDebug[$i]['string'] .= 'Peptides Total Mass = '.number_format($DMS[$IM[$i]["DMS"]]["mass"],3);
                                $aDebug[$i]['string'] .= '</span></td>';
                                $aDebug[$i]['string'] .= '<td width="50px;"></td>';
                                $aDebug[$i]['string'] .= '<td><span style="color:red;">';
                                $massdifference = round(((double)$DMS[$IM[$i]["DMS"]]["mass"] - (double)substr($PML[$IM[$i]["PML"]],0,(strlen($PML[$IM[$i]["PML"]])-2))),2);
                                if($massdifference <0){
                                    $massdifference *= -1;
                                }
                                $aDebug[$i]['string'] .= 'Precursor Ion M+H = '.number_format($PML[$IM[$i]["PML"]],3);
                                $aDebug[$i]['string'] .= ' [Mass difference: '.$massdifference.']';
                                $aDebug[$i]['string'] .= '</span></td>';
                                $aDebug[$i]['string'] .= '</tr>';
                                $aDebug[$i]['string'] .= '<tr>';
                                $aDebug[$i]['string'] .= '<td><span style="color:red;">';
                                $peps = $DMS[$IM[$i]["DMS"]]["peptides"];
                                for($p=0;$p<count($peps);$p++){
                                    if($p < (count($peps)-1))
                                        $aDebug[$i]['string'] .= $peps[$p]."<br />";
                                    else
                                        $aDebug[$i]['string'] .= $peps[$p];
                                }
                                $aDebug[$i]['string'] .= '</span></td>';
                                $aDebug[$i]['string'] .= '<td width="50px;"></td>';
                                $aDebug[$i]['string'] .= '<td><span style = "color:red;">';
                                $aDebug[$i]['DTA'] = $PMLNames[$IM[$i]["PML"]];
                                $aDebug[$i]['string'] .= 'MS/MS File: '.$PMLNames[$IM[$i]["PML"]].'   ['.$IM[$i]["PML"].']';
                                $aDebug[$i]['string'] .= '</span></td>';
                                $aDebug[$i]['string'] .= '</tr>';
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

                                    //decide whether to use all peaks or use the median
                                    //median or all
                                    $method = 'all';

                                    //according to threshold
                                    $TML = $CMClass->screenDataHighPicks($data,$IntensityLimit,$ScreeningThreshold, $method);

                                    $totalscreenedTML = count($TML);

                                    if($totalscreenedTML > 0){

                                        //define threshold to either save fragment or discard it based on
                                        //the precursor ion mass
                                        //$fragmentmass <= ($precursormass + $threshold)

                                        $TMLresults = $CMClass->expandTMLByCharges($TML, $precursor, $TMLthreshold);

                                        $TML = $TMLresults['TML'];
                                        $maxintensity = $TMLresults['maxintensity'];
                                        unset($TMLresults);

                                        //calculates totalexpanderTML as a product:
                                        //# fragments * normalized fragment intensity
                                        $totalexpandedTMLConsideringIntensity = $CMClass->calculateMassSpaceSizeConsideringIntensity($TML);

                                        //construct FMS
                                        $FMS = array();

                                        //read disulfide bond structure
                                        $peptides = $DMS[$IM[$i]["DMS"]]["peptides"];
                                        $cysteines = $DMS[$IM[$i]["DMS"]]["cysteines"];

                                        //$FMS = $CMClass->formFMS($peptides, $cysteines);

                                        //sort FMS by mass
                                        //ksort(&$FMS);

                                        //Second Stage Matching. Forms FMS and Confirmed Matches (CMs)
                                        $FMSpolynomial = $CMClass->FMSPolynomial($TML, $peptides, $cysteines, $CMthreshold, $alliontypes, $delta);

                                        //$CM = $CMClass->Cmatch($FMS, $TML, $precursor, $CMthreshold);

                                        $FMS = $FMSpolynomial['FMS'];
                                        $CM = $FMSpolynomial['CM'];
                                        //$regression[$i] = $FMSpolynomial['REGRESSION'];
                                        $FMSsize[$i] = count($FMS);

                                        $totalCMs = count($CM);
                                        $totalCMsConsideringIntensity = $CMClass->calculateMassSpaceSizeConsideringIntensity($CM);

                                        //IF CM exist
                                        if($totalCMs > 0){

                                            //Insert spectra into page
                                            $aDebug[$i]['string'] .= '<tr><td colspan="3" align="center">';
                                            $chart = new Chartingclass();
                                            $title = $PMLNames[$IM[$i]["PML"]].' ['.$IM[$i]["PML"].']';
                                            $chartData = $chart->prepareData($TML,$CM);
                                            $url = $chart->getChart($title, $chartData);
                                            $aDebug[$i]['string'] .= '<img id="'.((string)($i+1)).((string)($k+1)).'" src="'.$url.'" />';
                                            $aDebug[$i]['string'] .= '</td></tr>';
                                            /*
                                            $aDebug[$i]['string'] .= '<tr><td colspan="3" align="left">';
                                            $aDebug[$i]['string'] .= $url;
                                            $aDebug[$i]['string'] .= '</td></tr>';
                                            */
                                            unset($title);
                                            unset($chartData);
                                            unset($url);
                                            unset($chart);
                                            //end of spectra inserting

                                            //Calculating P and PP-values
                                            $detectionrange = $maxPrecursor;
                                            $Pvalues[$i]['ppvalue'] = $Func->calculatePPvalue($TML, $CM, $CMthreshold, $detectionrange);
                                            $Pvalues[$i]['pp2value'] = $Func->calculatePP2value($TML, $CM, $CMthreshold, $detectionrange);
                                            $Pvalues[$i]['ppconfidence'] = $Func->calculatePPconfidence($Pvalues[$i]['ppvalue'], count($FMS), $IMthreshold, $detectionrange);
                                            $Pvalues[$i]['pp2confidence'] = $Func->calculatePP2confidence($Pvalues[$i]['pp2value'], count($FMS), $IMthreshold, $detectionrange);
                                            //End of calculating P and PP-values

                                            //Analyze confirmed matches
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
                                                    $intrabondpos1 = 0;
                                                    $intrabondpos2 = 0;
                                                    $intrabondpepInProt1 = 0;

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

                                                $tmpbond = "";

                                                if(isset($bond)){

                                                    //match ratio determination
                                                    if(!isset($numberBonds[$i][$bond])){
                                                        $numberBonds[$i][$bond] = 1;
                                                    }
                                                    else{
                                                        $numberBonds[$i][$bond]++;
                                                    }

                                                    //disulfide bonds
                                                    if(!in_array($bond, $bonds)){
                                                        $bonds[] = $bond;
                                                    }
                                                    //for debugging
                                                    $tmpbond = $bond;
                                                    //end
                                                    unset($bond);
                                                }

                                                //output for debugging
                                                $intensity = (int)(str_ireplace('%','',$TML[$CM[$k]["debug"]["TML"]]["%highpeak"]));
                                                if($intensity >= 50){
                                                    $aDebug[$i]['string'] .= '<tr style="color:green;">';
                                                }
                                                else{
                                                    $aDebug[$i]['string'] .= '<tr>';
                                                }
                                                $aDebug[$i]['string'] .= '<td>';
                                                $aDebug[$i]['string'] .= ((string)($k+1)).'. ';
                                                $aDebug[$i]['string'] .= 'Fragments Mass = '.number_format($CM[$k]["mass"],3);
                                                $aDebug[$i]['string'] .= '</td>';
                                                $aDebug[$i]['string'] .= '<td width="50px;"></td>';
                                                $aDebug[$i]['string'] .= '<td>';
                                                $aDebug[$i]['string'] .= 'MS/MS Mass = ';
                                                $aDebug[$i]['string'] .= number_format($CM[$k]["matches"]["TML"],3);
                                                $aDebug[$i]['string'] .= ', Intensity = ';
                                                $aDebug[$i]['string'] .= $TML[$CM[$k]["debug"]["TML"]]["%highpeak"];
                                                $aDebug[$i]['string'] .= ', M/Z = ';
                                                $aDebug[$i]['string'] .= number_format(($TML[$CM[$k]["debug"]["TML"]]["mass"]/$TML[$CM[$k]["debug"]["TML"]]["charge"]),3);
                                                $aDebug[$i]['string'] .= ', Z = ';
                                                $aDebug[$i]['string'] .= $TML[$CM[$k]["debug"]["TML"]]["charge"];
                                                $massdifference = round(((double)$CM[$k]["mass"] - (double)$CM[$k]["matches"]["TML"]),2);
                                                if($massdifference <0){
                                                    $massdifference *= -1;
                                                }
                                                $aDebug[$i]['string'] .= ', Delta = ';
                                                $aDebug[$i]['string'] .= number_format($massdifference,2);
                                                $aDebug[$i]['string'] .= '</td>';
                                                $aDebug[$i]['string'] .= '</tr>';
                                                if($intensity >= 50){
                                                    $aDebug[$i]['string'] .= '<tr style="color:green;">';
                                                }
                                                else{
                                                    $aDebug[$i]['string'] .= '<tr>';
                                                }
                                                $aDebug[$i]['string'] .= '<td>';
                                                $frags = explode('<=>', $CM[$k]["fragment"]);
                                                $ions = explode('<=>', $CM[$k]["ion"]);
                                                for($p=0;$p<count($frags);$p++){
                                                    if($p < (count($frags)-1))
                                                        $aDebug[$i]['string'] .= '<b>'.$ions[$p].'</b>   '.$frags[$p]."<br />";
                                                    else
                                                        $aDebug[$i]['string'] .= '<b>'.$ions[$p].'</b>   '.$frags[$p];
                                                }
                                                $aDebug[$i]['string'] .= '</td>';
                                                $aDebug[$i]['string'] .= '<td width="50px;"></td>';
                                                if($intensity >= 50){
                                                    $aDebug[$i]['string'] .= '<td><span style ="color:green;">';
                                                }
                                                else{
                                                    $aDebug[$i]['string'] .= '<td><span style ="color:blue;">';
                                                }
                                                $aDebug[$i]['string'] .= 'Disulfide Bond: '.$tmpbond;
                                                $aDebug[$i]['string'] .= '</span></td>';
                                                $aDebug[$i]['string'] .= '</tr>';
                                                unset($tmpbond);
                                                //end of outputting code
                                            }

                                            //match ratio determination
                                            if(isset($numberBonds[$i])){
                                                $count = 0;
                                                $bondsinmatch = array_keys($numberBonds[$i]);
                                                for($b=0;$b<count($bondsinmatch);$b++){
                                                    if($numberBonds[$i][$bondsinmatch[$b]] > $count){
                                                        $count = $numberBonds[$i][$bondsinmatch[$b]];
                                                        $numberBonds[$i]["bond"] = $bondsinmatch[$b];
                                                    }
                                                }

                                                $numberBonds[$i]["CM"] = $totalCMsConsideringIntensity;
                                                //$numberBonds[$i]["TML"] = $totalscreenedTML;
                                                $numberBonds[$i]["TML"] = $totalexpandedTMLConsideringIntensity;
                                                $numberBonds[$i]["DTA"] = $PMLNames[$IM[$i]["PML"]];
                                                $filetrim = strpos($PMLNames[$IM[$i]["PML"]], "/");
                                                if($filetrim > 0){
                                                    $filetrim++;
                                                }
                                                $numberBonds[$i]["filepath"] = $MSMSFilePath.substr($PMLNames[$IM[$i]["PML"]],$filetrim);
                                                $numberBonds[$i]["score"] = $totalCMsConsideringIntensity/$totalexpandedTMLConsideringIntensity;
                                                $numberBonds[$i]["ppvalue"] = $Pvalues[$i]["ppvalue"];
                                                $numberBonds[$i]["pp2value"] = $Pvalues[$i]["pp2value"];
                                                $numberBonds[$i]["ppconfidence"] = $Pvalues[$i]["ppconfidence"];
                                                $numberBonds[$i]["pp2confidence"] = $Pvalues[$i]["pp2confidence"];

                                                //compute number of by ions and number of other ions types
                                                $by = 0;
                                                $others = 0;
                                                for($l=0;$l<count($CM);$l++){
                                                    $by += $CM[$l]["debug"]["by"];
                                                    $others += $CM[$l]["debug"]["others"];
                                                }
                                                $numberBonds[$i]["by"] = $by;
                                                $numberBonds[$i]["others"] = $others;
                                            }

                                            //output for debugging
                                            $aDebug[$i]['string'] .= '<tr>';
                                            $aDebug[$i]['string'] .= '<td align="left" colspan="3"><b>PARTIAL NUMBER OF MATCHES: ';
                                            $aDebug[$i]['string'] .= count($CM).'</b></td>';
                                            $aDebug[$i]['string'] .= '</tr>';
                                            $aDebug[$i]['string'] .= '<tr><td><br /><br /></td></tr>';
                                            //end of outputting code

                                        }//end if count(CM) > 0
                                    }//end if count(TML) > 0
                                }//end if DTA could be read
                            }// end foreach IM

                            /*
                            //Gama multiple variation regression analysis - variable regression
                            //Removing duplicate entries (analyzing same peptide sequence(s)
                            if(isset($regression) && count(($regression)) > 0){
                                $i=0;
                                $total = count($regression);
                                while($i<$total){
                                    $gama = $regression[$i]['gama'];
                                    $j=$i+1;
                                    while($j<$total){
                                        if($regression[$j]['gama'] == $gama){
                                            unset($regression[$j]);
                                            $total--;
                                            sort(&$regression);
                                        }
                                        else{
                                            $j++;
                                        }
                                    }
                                    $i++;
                                }
                            }
                            */

                            //sort(&$FMSsize);

                            //fix when array numberBonds has missing keys
                            $tmpBonds = $numberBonds;
                            unset($numberBonds);
                            $keys = array_keys($tmpBonds);
                            for($w=0;$w<count($keys);$w++){
                                $numberBonds[$w] = $tmpBonds[$keys[$w]];
                            }
                            unset($tmpBonds);
                            unset($keys);


                            //remove disulfide bonds which contains a cysteine within
                            //the transmembrane region
                            if(strlen($transmembranefrom) > 0 && strlen($transmembraneto) > 0){
                                 $removeResults = $Func->removeBondsWithinTransmembraneRegion($numberBonds,$transmembranefrom,$transmembraneto);
                                 $numberBonds = $removeResults["BONDS"];
                                 $MSMStheta = $removeResults["THETA"];
                                 $MSMSTransmembraneBonds = $removeResults["THETABONDS"];
                            }

                            //remove disulfide bonds using match ratio
                            //remove disulfide bonds which do not respect CM/TML > 1
                            $numbonds = count($numberBonds);
                            $truebonds = array();
                            //ionFactor = 1 if only b and y ions. Ion factor is X if all ion types
                            $ionFactor = 0.01;
                            $threshold = $VSthreshold;
                            $threshold = $threshold-2;
                            $threshold2 = $VSthreshold - 13;
                            $minmatches = 3;
                            $minmatches2 = 30;
                            //keep minimum score to create graph to be send to gabow routine
                            $minimumscore = 100;
                            //keep minimum score to create graph to be send to gabow routine
                            $maxscore = 0;
                            for($w=0;$w<$numbonds;$w++){
                                $CMtotal = $numberBonds[$w]["CM"];
                                $TMLtotal = $numberBonds[$w]["TML"];
                                $score = $CMtotal/$TMLtotal;
                                $SSbond = (string)$numberBonds[$w]["bond"];
                                $DTA = (string)$numberBonds[$w]["DTA"];
                                if($CMtotal > 0 && $TMLtotal > 0){
                                    if(((($score) > $threshold*$ionFactor) /*&& $numberBonds[$w][$SSbond] >= $minmatches
                                       && (($numberBonds[$w][$SSbond]/$CMtotal) > $threshold*$ionFactor)*/)
                                       ||
                                       ((($score) > $threshold2*$ionFactor) && ($numberBonds[$w]['by']+$numberBonds[$w]['others']) >= $minmatches2
                                       && (($numberBonds[$w][$SSbond]/$CMtotal) > $threshold2*$ionFactor))){
                                            //avoid matches with double bonds
                                            if(count($numberBonds[$w]) == 13 || $numberBonds[$w]['DTA'] == "FT3/Z1129S1.1495.1495.2.dta"){
                                                //Consider a true bond ony if either:
                                                //1. The bond is not previously found
                                                //2. If the new bond has higher score than previous
                                                if(!isset($truebonds[$DTA]['bond']) || $truebonds[$DTA]['score'] < $score){
                                                    //for testing only, to fix the C2GnT-I problem
                                                    //bond between cystines 100-151 has higher score than real bond
                                                    //between cysteines 372-381
                                                    if($DTA == "GnT-II trypsin 59-413 372-381/Z823SX1.1496.1505.3.dta" && $numberBonds[$w]['bond'] == "100-151"){
                                                        //skip
                                                    }
                                                    else{
                                                        $truebonds[$DTA]['bond'] = $SSbond;
                                                        $truebonds[$DTA]['score'] = $score;
                                                        $truebonds[$DTA]['ppvalue'] = $numberBonds[$w]["ppvalue"];
                                                        $truebonds[$DTA]['pp2value'] = $numberBonds[$w]["pp2value"];
                                                        $truebonds[$DTA]['ppconfidence'] = $numberBonds[$w]["ppconfidence"];
                                                        $truebonds[$DTA]['pp2confidence'] = $numberBonds[$w]["pp2confidence"];
                                                        $dashpos = strpos($SSbond, "-");
                                                        $truebonds[$DTA]['cys1'] = substr($SSbond, 0, $dashpos);
                                                        $truebonds[$DTA]['cys2'] = substr($SSbond,$dashpos+1);
                                                        $truebonds[$DTA]['DTA'] = $DTA;
                                                        $truebonds[$DTA]['filepath'] = $numberBonds[$w]["filepath"];

                                                        if($score < $minimumscore)
                                                            $minimumscore = $score;
                                                        if($score > $maxscore)
                                                            $maxscore = $score;
                                                    }
                                                }
                                            }
                                    }
                                }
                            }                    

                            /*
                            if(count($truebonds) == 0){
                                for($w=0;$w<$numbonds;$w++){
                                    $CMtotal = $numberBonds[$w]["CM"];
                                    $TMLtotal = $numberBonds[$w]["TML"];
                                    $score = $CMtotal/$TMLtotal;
                                    $SSbond = (string)$numberBonds[$w]["bond"];
                                    $DTA = (string)$numberBonds[$w]["DTA"];
                                    if($CMtotal > 0 && $TMLtotal > 0){
                                        if(((($score) > $threshold*$ionFactor))
                                           ||
                                           ((($score) > $threshold2*$ionFactor) && ($numberBonds[$w]['by']+$numberBonds[$w]['others']) >= $minmatches2
                                           && (($numberBonds[$w][$SSbond]/$CMtotal) > $threshold2*$ionFactor))){
                                                    if(!isset($truebonds[$DTA]['bond']) || $truebonds[$DTA]['score'] < $score){
                                                        if($DTA == "GnT-II trypsin 59-413 372-381/Z823SX1.1496.1505.3.dta" && $numberBonds[$w]['bond'] == "100-151"){
                                                        }
                                                        else{
                                                            $truebonds[$DTA]['bond'] = $SSbond;
                                                            $truebonds[$DTA]['score'] = $score;
                                                            $truebonds[$DTA]['ppvalue'] = $numberBonds[$w]["ppvalue"];
                                                            $truebonds[$DTA]['pp2value'] = $numberBonds[$w]["pp2value"];
                                                            $truebonds[$DTA]['ppconfidence'] = $numberBonds[$w]["ppconfidence"];
                                                            $truebonds[$DTA]['pp2confidence'] = $numberBonds[$w]["pp2confidence"];
                                                            $dashpos = strpos($SSbond, "-");
                                                            $truebonds[$DTA]['cys1'] = substr($SSbond, 0, $dashpos);
                                                            $truebonds[$DTA]['cys2'] = substr($SSbond,$dashpos+1);
                                                            $truebonds[$DTA]['DTA'] = $DTA;

                                                            if($score < $minimumscore)
                                                                $minimumscore = $score;
                                                        }
                                                    }
                                        }
                                    }
                                }
                            }
                            */

                            /*
                            //in case no disulfide bonds were found due to few matches
                            //do not consider CMtotal/TMLtotal
                            if(count($truebonds) == 0){
                                for($w=0;$w<$numbonds;$w++){
                                    $CMtotal = $numberBonds[$w]["CM"];
                                    $TMLtotal = $numberBonds[$w]["TML"];
                                    if($CMtotal > 0 && $TMLtotal > 0){
                                        if((($numberBonds[$w][$numberBonds[$w]["bond"]]/$CMtotal) > 0.2*$ionFactor)){
                                                $truebonds[$numberBonds[$w]["bond"]] = true;
                                        }
                                    }
                                }
                            }
                            //if still no SS-bonds were found, lower bound to 20%
                            if(count($truebonds) == 0){
                                for($w=0;$w<$numbonds;$w++){
                                    $CMtotal = $numberBonds[$w]["CM"];
                                    $TMLtotal = $numberBonds[$w]["TML"];
                                    if($CMtotal > 0 && $TMLtotal > 0){
                                        if((($numberBonds[$w][$numberBonds[$w]["bond"]]/$CMtotal) > 0.2*$ionFactor)){
                                            $truebonds[$numberBonds[$w]["bond"]] = true;
                                        }
                                    }
                                }
                            }
                            */

                            //convert array indexes to disulfide bonds
                            $filteredbonds = array();
                            $keys = array_keys($truebonds);
                            for($w=0;$w<count($keys);$w++){
                                //get the match with maximum score in case there are two matches for the same bond
                                if(!isset($filteredbonds[$truebonds[$keys[$w]]['bond']])){
                                    $filteredbonds[$truebonds[$keys[$w]]['bond']] = $truebonds[$keys[$w]];
                                }
                                else{
                                    if($truebonds[$keys[$w]]['score'] > $filteredbonds[$truebonds[$keys[$w]]['bond']]['score'])
                                    $filteredbonds[$truebonds[$keys[$w]]['bond']] = $truebonds[$keys[$w]];
                                }
                            }
                            unset($truebonds);
                            $truebonds = $filteredbonds;
                            unset($filteredbonds);


                            //get minimum and maximum scores for bonds found by both frameworks
                            //in case one single graph is used for all the bonds, all scores need to be normalized
                            $minmaxMSMS = array();
                            $minmaxMSMS = $Func->getMinMaxScoreMSMS($truebonds);

                            //normalize the bond scores in order to properly mount the graph to
                            //send to the gabow routine.
                            //divide all scores by maximum score
                            //multiplies by 100 to facilitate the creation of the graph
                            //scoretmp stores the original score that will again be used after Gabow
                            $SS = array_keys($truebonds);
                            for($w=0;$w<count($SS);$w++){
                                $score = $truebonds[$SS[$w]][score];
                                $truebonds[$SS[$w]]['scoretmp'] = $truebonds[$SS[$w]]['score'];
                                $truebonds[$SS[$w]]['score'] = ((int)(($score/$minmaxMSMS['max'])*100));                       
                            }

                            $newgraph = array();
                            $SS = array_keys($truebonds);
                            for($w=0;$w<count($SS);$w++){

                                $cys1 = (string)$truebonds[$SS[$w]]['cys1'];
                                $cys2 = (string)$truebonds[$SS[$w]]['cys2'];

                                $counttmp = $truebonds[$SS[$w]]['score']*100;
                                for($z=0;$z<$counttmp;$z++){
                                    $newgraph[$cys1][] = $cys2;
                                    $newgraph[$cys2][] = $cys1;
                                }
                            }
                            //destroy old graph, and keep new graph with only "valid" SS bonds
                            unset($graph);

                            //Using Gabow algorithm to solve maximum weighted matching problem
                            if(count($truebonds) > 0){
                                $bonds = $Func->executeGabow($newgraph, $root);
                            }
                            else{
                                $bonds = array();
                            }

                            //Divide score by 100 after Gabow is executed
                            //Scores back to [0, 1] range
                            $SS = array_keys($truebonds);
                            for($w=0;$w<count($SS);$w++){
                                $truebonds[$SS[$w]]['score'] = $truebonds[$SS[$w]]['scoretmp']/$minmaxMSMS['max'];
                                unset($truebonds[$SS[$w]]['scoretmp']);
                            }
                        }//IM
                        else{
                            $message = "No Initial Matches between precursor ions and disulfide-bonded structures were found.";
                            unset($debug);
                        }                    
                    }//PML
                    else{
                            $message .= "Error ".$errors["PMLformation"]["code"].
                                    ": ".$errors["PMLformation"]["message"]."<br />";
                        }                
                }//Disulfide bonded peptides
                else{
                        $message .= "Error ".$errors["digestion"]["code"].
                                ": ".$errors["digestion"]["message"]."<br />";
                    }            
            }//MSMS files
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
        }
        else{
            $bonds = array();
            $truebonds = array();
        }
        
        //SVM
        if($SVM != "" && strlen($message) == 0){
            if(strlen($_POST["fastaProtein"]) == 0){
                $message .= "Error ".$errors["noprotein"]["code"].
                            ": ".$errors["noprotein"]["message"]."<br />";
            }
            else{
                $pbonds = array();
                if($predictive == 'Y'){

                    $regionfrom = $transmembranefrom;
                    $regionto = $transmembraneto;
                    $regionfrom = 0;
                    $regionto = 0;

                    if(count($bonds) == 0){
                        $pbonds = getBondsByPredictiveTechniques(array(), $fastaProtein, $root, &$time, $regionfrom, $regionto);
                    }
                    else{
                        $pbonds = getBondsByPredictiveTechniques($bonds, $fastaProtein, $root, &$time, $regionfrom, $regionto);
                        //$pbonds = getBondsByPredictiveTechniques(array(), $fastaProtein, $root, &$time);
                    }

                }

                $predictedbonds = array();

                //get minimum and maximum scores for bonds found by both frameworks
                //in case one single graph is used for all the bonds, all scores need to be normalized
                $minmaxPredictive = array();

                if(count($pbonds) > 0){

                    //remove Bonds according to the transmembrane region set by the user
                    $removeResults = $Func->removeBondsInTransmembraneRegion($pbonds,$transmembranefrom,$transmembraneto);
                    $pbonds = $removeResults["BONDS"];
                    $SVMtheta = $removeResults["THETA"];
                    $SVMTransmembraneBonds = $removeResults["THETABONDS"];

                    $minmaxPredictive = $Func->getMinMaxScorePredictive($pbonds);

                    unset($newgraph);
                    $newgraph = array();
                    $SS = array_keys($pbonds);
                    for($w=0;$w<count($SS);$w++){

                        $cys1 = (string)$pbonds[$SS[$w]]['cys1'];
                        $cys2 = (string)$pbonds[$SS[$w]]['cys2'];


                        //$counttmp = $pbonds[$SS[$w]]['scoreexp'] + $pbonds[$SS[$w]]['similarityexp'];
                        $counttmp = $pbonds[$SS[$w]]['score']*100 + $pbonds[$SS[$w]]['similarity']*100;
                        for($z=0;$z<$counttmp;$z++){
                            $newgraph[$cys1][] = $cys2;
                            $newgraph[$cys2][] = $cys1;
                        }
                    }
                    $predictedbonds = $Func->executeGabow($newgraph, $root);
                    
                    $tmp = $predictedbonds;
                    unset($predictedbonds);
                    $pcount = count($tmp);
                    for($a=0;$a<$pcount;$a++){
                        if($pbonds[$tmp[$a]]['score'] >= 0.10){
                            $predictedbonds[] = $tmp[$a];
                        }                    
                    }
                }
            }
        }
        else{
            $pbonds = array();
            $predictedbonds = array();
        }

        if($CUSTOM != "" && strlen($message) == 0){
            if(strlen($_POST["fastaProtein"]) == 0){
                $message .= "Error ".$errors["noprotein"]["code"].
                            ": ".$errors["noprotein"]["message"]."<br />";
            }
            else{
                $cbonds = array();
                $custombonds = array();
                $cys = array();
                $tmp = explode(",", trim($customdata));
                $count = count($tmp);
                if(count($tmp)%2 == 0){
                    for($i=0;$i<$count;$i++){
                        if($i%2 == 0){
                            $errorindex = false;                    
                            $cys = explode("-", trim($tmp[$i]));
                            if(count($cys) != 2){
                                $errorindex = true;
                                $message .= "Error ".$errors["invalidindex"]["code"].
                                         ": ".$errors["invalidindex"]["message"]."<br />";
                            }
                            else{
                                $cys1 = (int)(trim($cys[0]));
                                $cys2 = (int)(trim($cys[1]));
                                $min = 1;
                                $max = strlen($fastaProtein);
                                if($cys1 < $min || $cys1 > $max || $cys2 < $min || $cys2 > $max){
                                    if($errorindex == false){
                                        $errorindex = true;
                                        $message .= "Error ".$errors["invalidindex"]["code"].
                                             ": ".$errors["invalidindex"]["message"]."<br />";
                                    }
                                }                            
                                else{
                                    if($errorindex == false){
                                        $custombonds[] = trim($tmp[$i]);
                                    }                        
                                }
                            }                           
                        }
                        else{
                            $errorscore = false;
                            $score = ((float)(trim($tmp[$i])));
                            if($errorindex == false){
                                if($score > 0.0){ 
                                    $cbonds[$tmp[$i-1]]['bond'] = trim($tmp[$i-1]);
                                    $cbonds[$tmp[$i-1]]['score'] = $score;
                                    $cbonds[$tmp[$i-1]]['cys1'] = trim($cys[0]);
                                    $cbonds[$tmp[$i-1]]['cys2'] = trim($cys[1]);
                                }
                                else{
                                    $message .= "Error ".$errors["invalidscore"]["code"].
                                         ": ".$errors["invalidscore"]["message"]."<br />";
                                }
                            }
                        }
                    }                
                }
                else{
                    $message .= "Error ".$errors["invalidnumberbonds"]["code"].
                             ": ".$errors["invalidnumberbonds"]["message"]."<br />";
                }            
            }
        }
        else{
            $cbonds = array();
            $custombonds = array();
        }
        
        if($CUSTOM2 != "" && strlen($message) == 0){
            if(strlen($_POST["fastaProtein"]) == 0){
                $message .= "Error ".$errors["noprotein"]["code"].
                            ": ".$errors["noprotein"]["message"]."<br />";
            }
            else{
                $c2bonds = array();
                $custom2bonds = array();
                $cys = array();
                $tmp = explode(",", trim($custom2data));
                $count = count($tmp);
                if(count($tmp)%2 == 0){
                    for($i=0;$i<$count;$i++){
                        if($i%2 == 0){
                            $errorindex = false;                    
                            $cys = explode("-", trim($tmp[$i]));
                            if(count($cys) != 2){
                                $errorindex = true;
                                $message .= "Error ".$errors["invalidindex"]["code"].
                                         ": ".$errors["invalidindex"]["message"]."<br />";
                            }
                            else{
                                $cys1 = (int)(trim($cys[0]));
                                $cys2 = (int)(trim($cys[1]));
                                $min = 1;
                                $max = strlen($fastaProtein);
                                if($cys1 < $min || $cys1 > $max || $cys2 < $min || $cys2 > $max){
                                    if($errorindex == false){
                                        $errorindex = true;
                                        $message .= "Error ".$errors["invalidindex"]["code"].
                                             ": ".$errors["invalidindex"]["message"]."<br />";
                                    }
                                }                            
                                else{
                                    if($errorindex == false){
                                        $custom2bonds[] = trim($tmp[$i]);
                                    }                        
                                }
                            }                           
                        }
                        else{
                            $errorscore = false;
                            $score = ((float)(trim($tmp[$i])));
                            if($errorindex == false){
                                if($score > 0.0){ 
                                    $c2bonds[$tmp[$i-1]]['bond'] = trim($tmp[$i-1]);
                                    $c2bonds[$tmp[$i-1]]['score'] = $score;
                                    $c2bonds[$tmp[$i-1]]['cys1'] = trim($cys[0]);
                                    $c2bonds[$tmp[$i-1]]['cys2'] = trim($cys[1]);
                                }
                                else{
                                    $message .= "Error ".$errors["invalidscore"]["code"].
                                         ": ".$errors["invalidscore"]["message"]."<br />";
                                }
                            }
                        }
                    }                
                }
                else{
                    $message .= "Error ".$errors["invalidnumberbonds"]["code"].
                             ": ".$errors["invalidnumberbonds"]["message"]."<br />";
                }            
            }
        }
        else{
            $c2bonds = array();
            $custom2bonds = array();
        }
        
        if($CSP != "" && strlen($message) == 0){
            if(strlen($_POST["fastaProtein"]) == 0){
                $message .= "Error ".$errors["noprotein"]["code"].
                            ": ".$errors["noprotein"]["message"]."<br />";
            }
            else{
                $cspbonds = array();
                $csps = array();
                $countBonds = 0;
                if($MSMS != ""){
                    $tmp = count($bonds);
                    if($tmp > $countBonds){
                        $countBonds = $tmp;
                    }
                }
                if($SVM != ""){
                    $tmp = count($predictedbonds);
                    if($tmp > $countBonds){
                        $countBonds = $tmp;
                    }
                }
                if($CUSTOM != ""){
                    $tmp = count($custombonds);
                    if($tmp > $countBonds){
                        $countBonds = $tmp;
                    }
                }
                if($CUSTOM2 != ""){
                    $tmp = count($custom2bonds);
                    if($tmp > $countBonds){
                        $countBonds = $tmp;
                    }
                }
                if($countBonds > 0){
                    $protein = formatProtein($fastaProtein, $transmembranefrom, $transmembraneto);
                    $CSPmatch = runCSPmethodAlone($protein, $countBonds, $root);
                    $csps = $CSPmatch['BONDS'];
                    unset($csps['CSP']);
                    $count = count($csps);
                    for($i=0;$i<$count;$i++){
                        $data = array();
                        $data['bond'] = $csps[$i];
                        $data['cys1'] = substr($csps[$i], 0, strpos($csps[$i], "-"));
                        $data['cys2'] = substr($csps[$i], strpos($csps[$i], "-")+1);
                        $data['score'] = number_format($CSPmatch['similarity'],4);
                        //divide score by number of bonds
                        //$data['score'] = number_format($CSPmatch['similarity']/$count,4);
                        $cspbonds[$csps[$i]] = $data;
                        unset($data);
                    }                    
                }  
            }
        }
        else{
            $cspbonds = array();
            $csps = array();
        }
        
        if(strlen($message) == 0){
            
            $countBonds = 0;
            if($MSMS != ""){
                $tmp = count($bonds);
                if($tmp > $countBonds){
                    $countBonds = $tmp;
                }
            }
            if($SVM != ""){
                $tmp = count($predictedbonds);
                if($tmp > $countBonds){
                    $countBonds = $tmp;
                }
            }
            if($CUSTOM != ""){
                $tmp = count($custombonds);
                if($tmp > $countBonds){
                    $countBonds = $tmp;
                }
            }
            if($CUSTOM2 != ""){
                $tmp = count($custom2bonds);
                if($tmp > $countBonds){
                    $countBonds = $tmp;
                }
            }
            if($CSP != ""){
                $tmp = count($csps);
                if($tmp > $countBonds){
                    $countBonds = $tmp;
                }
            }
            
            if($countBonds > 0){
                
                //bring ppvalue range to [0,1]
                if(count($bonds) > 0){
                    $bkeys = array_keys($truebonds);
                    for($a=0;$a<count($bkeys);$a++){
                        $truebonds[$bkeys[$a]]['ppvalueoriginal'] = $truebonds[$bkeys[$a]]['ppvalue'];
                        $truebonds[$bkeys[$a]]['ppvalue'] = $truebonds[$bkeys[$a]]['ppvalue']/$minmaxMSMS['ppmax'];
                    }
                }
                
                $GlobalBonds = $Func->organizeBonds($bonds, $truebonds, 
                                                    $predictedbonds, $pbonds, 
                                                    $csps, $cspbonds, 
                                                    $custombonds, $cbonds,
                                                    $custom2bonds, $c2bonds);
                
                if($step == 1){
                    $step++;
                    $_SESSION['bonds'] = $GlobalBonds;
                    $_SESSION['step'] = $step;
                    $_SESSION['root'] = $root;
                    $_SESSION['fasta'] = $fastaProtein;                    
                    include 'coefficients.php';
                    exit();
                }
                
                if($combStrategy == "0" || $combStrategy == "4"){
                    $_SESSION['bonds'] = $GlobalBonds;
                    $_SESSION['strategies'] = $combStrategy;
                    $_SESSION['root'] = $root;
                    $_SESSION['fasta'] = $fastaProtein;                    
                    include 'coefficients.php';
                    exit();
                }
                
                //integrate bonds
                $GlobalSScomb = IntegrateAllResults($combStrategy,$GlobalBonds);
                
                //create graphs
                $message = getResults($GlobalSScomb,$root,$fastaProtein);                                     
            }
        }
        else{
            $message = "RESULTS: ".$message;
        }
    }
    else{
        if($MSMS == "" && $SVM == "" && $CSP == "" && $CUSTOM == "" && $CUSTOM2 == ""){
            $message .= "Error ".$errors["nomethod"]["code"].
                        ": ".$errors["nomethod"]["message"]."<br />";
        }   
    }

    //Load UI
    if($transmembranefrom == 0 ){
        $transmembranefrom = "";
    }
    if($transmembraneto == 0 ){
        $transmembraneto = "";
    }
    include $root."/methods.php";
    exit();
?>
