<?php
    ini_set("memory_limit", "2000M");

    $filename = "C:\\Users\\William\\Desktop\\SFSU\\SVM\\Uniprot\\42.7\\uniprot_sprot.dat";
    $wfilename = "C:\\Users\\William\\Desktop\\SFSU\\SVM\\Uniprot\\42.7\\uniprot_sprot2.dat";
    $filearray = array();
    
    $filestr = file_get_contents($filename);
    $filearray = explode("//", $filestr);
    
    unset($filestr);
    
    //Count size of original array
    echo 'Original array: '.count($filearray).'<br/>';
    
    $results = array();
    
    //Extract only proteins which have disulfide bonds in it.
    //copy the disulfide bonds and the FASTA sequence
    for($i=0;$i<count($filearray);$i++){
        $start = strpos($filearray[$i], "FT   DISULFID");
        $end = strpos($filearray[$i], "SQ   SEQUENCE",$start);
        if($start > 0){            
            $results[] = "// ".substr($filearray[$i],$start,($end-$start)).  substr($filearray[$i],$end);
        }
    }
    
    unset($filearray);
    
    //Count Filtered array
    echo '<br/>DISULFID filtered array: '.count($results).'<br/>';
    
    $filearray = array();
    
    //Extract only proteins which have HIGH QUALITY disulfide bonds in it.
    //No probable, potential, by similarity, alternate
    //copy the disulfide bonds and the FASTA sequence
    for($i=0;$i<count($results);$i++){
        $start = strpos($results[$i], "FT   DISULFID");
        $end = strpos($results[$i], "SQ   SEQUENCE",$start);
        $string = substr($results[$i],$start,($end-$start));
        $tmp = array();
        $tmp = explode("FT", $string);
        
        for($j=0;$j<count($tmp);$j++){
            if(strpos($results[$i], "DISULFID") > 0){
                $tmp[$j] = "FT".$tmp[$j];
            }
            else{
                unset($tmp[$j]);
            }
        }
        ksort(&$tmp);
        $filearray[] = implode("", $tmp);
        
        unset($tmp);
    }
    
    unset($results);
    
    //Count Newly filtered array
    echo '<br/>Refined DISULFID filtered array: '.count($filearray).'<br/>';
    
    
    //Write to File
    file_put_contents($wfilename, $filearray);    
    
    unset($filearray);
?>
