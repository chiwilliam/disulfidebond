<?php

include 'statistics.php';

$file = "uniprotDB.dat";
$data = file_get_contents($file);

$aData = explode("//", $data);

foreach ($aData as $row) {
    $sequence = trim(substr($row, strpos($row, ";")+1));
    $sequence = str_replace(" ", "", $sequence);
    $sequence = str_replace("\n", "", $sequence);
    $sequence = str_replace("\r\t", "", $sequence);
    $length = trim(substr($row, strpos($row, "--")+3, (strpos($row, ";")-strpos($row, "--"))));
    $length = trim(str_replace("SQ","", $length));
    $length = trim(str_replace("SEQUENCE","", $length));
    $length = str_replace(" AA;","", $length);
    $length = $length;
    $bonds = trim(substr($row, 0, strpos($row, "--")));
    $aBonds = explode("**", $bonds);
    
    //save protein
    $proteinID = saveProtein($sequence,$length);
    
    if($proteinID > 0){
        foreach($aBonds as $bond){
            $bond = trim(str_replace("FT", "", $bond));
            $bond = trim(str_replace("DISULFID", "", $bond));
            $bond = trim(str_replace("    ", "*", $bond));
            $cysteines = explode("*", $bond);
            $cys1 = $cysteines[0];
            $cys2 = $cysteines[1];

            //save bonds
            saveBond($proteinID,$cys1,$cys2);
        }
    }
    
}

echo "Done";

?>
