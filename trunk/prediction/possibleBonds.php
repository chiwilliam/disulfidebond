<?php

include 'statistics.php';

$proteins = getProteins(0);

for($i=0;$i<count($proteins);$i++){
    $possibleBonds = getPossibleBonds(((int)($proteins[$i][3])));
    savePossibleBonds($proteins[$i][0], $possibleBonds);
}


?>
