<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Output_CSV1.csv");
header("Pragma: no-cache");
header("Expires: 0");
$cr= "\n";

 session_start();
$datamap = $_SESSION['report'];
$size = count($datamap);



$header[0]='Member'.',';
$row = $datamap[0];
         for($j=0; $j<count($row); $j++){

                  $mystring = $row[$j];
                  $findme1   = '>';
                  $findme2   = '</a>';
                  $pos1 = strpos($mystring, $findme1);
                  $pos2 = strpos($mystring, $findme2);
                  $header[$j+1]=substr($mystring,$pos1+1,$pos2-$pos1-1).',';

                  //$pdf->Cell(40,j*10,substr($mystring,$pos1+1,$pos2-$pos1-1));
         }
         $header[count($row)] .= $cr;
$data= array();
for($i=1; $i<$size; $i++){
         $row = $datamap[$i];
         for($j=0; $j<count($row); $j++){
                  if ($j==0) {
                    $mystring = $row[$j];
                    $findme1   = '>';
                    $findme2   = '</a>';
                    $pos1 = strpos($mystring, $findme1);
                    $pos2 = strpos($mystring, $findme2);
                    $data[$i][$j]=substr($mystring,$pos1+1,$pos2-$pos1-1).',';
                  }
                  else
                   $data[$i][$j]=$row[$j].',';
               }
   }

 for($p=0;$p<sizeof($header);$p++)
       echo $header[$p];

 for($t=1; $t<$size; $t++){
         $row = $datamap[$t];
         for($s=0; $s<count($row); $s++){
            echo $data[$t][$s];
         }
         echo $cr;
     }
?>
