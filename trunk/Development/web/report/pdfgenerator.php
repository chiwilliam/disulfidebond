<?php
   require_once('../fpdf/fpdf.php');
   class PDF extends FPDF
{

function FancyTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(40,25,30,35,25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,number_format($row[1]),'LR',0,'R',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}

function Header()
{
    global $title;
    $title="Post Table and Charts";
    //Logo
    $this->Image('logo.jpg',10,8,33);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Calculate width of title and position
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    //Colors of frame, background and text
    $this->SetDrawColor(0,80,180);
    $this->SetFillColor(230,230,0);
    $this->SetTextColor(220,50,50);
    //Thickness of frame (1 mm)
    $this->SetLineWidth(1);
    //Title
    $this->Cell($w,9,$title,1,1,'C',true);
    //Line break
    $this->Ln(10);
}

function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function BasicTable($header,$data)
{
    //Header
    foreach($header as $col)
        $this->Cell(30,7,$col,1);
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(30,6,$col,1);
        $this->Ln();
    }
}
}
session_start();
$datamap = $_SESSION['report'];
$mystring =$_SESSION['piechartimage'];
$pos = strpos($mystring,'"',15);
$piechart=substr($mystring,10,$pos-9);
$mystring =$_SESSION['barchartimage'];
$pos = strpos($mystring,'"',15);
$barchart=substr($mystring,10,$pos-9);
$size = count($datamap);
$pdf=new PDF();
$pdf->SetFont('Arial','',8);
$pdf->AddPage();
//Column titles
$header= array();
$header[0]='Member';
$row = $datamap[0];
         for($j=0; $j<count($row); $j++){
                  
                  $mystring = $row[$j];
                  $findme1   = '>';
                  $findme2   = '</a>';
                  $pos1 = strpos($mystring, $findme1);
                  $pos2 = strpos($mystring, $findme2);
                  $header[$j+1]=substr($mystring,$pos1+1,$pos2-$pos1-1);
                  //$pdf->Cell(40,j*10,substr($mystring,$pos1+1,$pos2-$pos1-1));
         }
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
                    $data[$i][$j]=substr($mystring,$pos1+1,$pos2-$pos1-1);
                  }
                  else
                   $data[$i][$j]=$row[$j];
               }
   }
//$pdf->BasicTable($header,$data);
$pdf->AliasNbPages();
$image = @file_get_contents($piechart);
$handle = fopen ('name.png', "w");
fwrite($handle, $image);
fclose($handle);
$image = @file_get_contents($barchart);
$handle = fopen ('name2.png', "w");
fwrite($handle, $image);
fclose($handle);
$pdf->Image('name.png', 20, 80,80,40);
$pdf->Image('name2.png', 110, 80,60,40);
//$pdf->BasicTable($header,$data);
$pdf->FancyTable($header,$data);
//$pdf->ImprovedTable($header,$data);
$pdf->Output();

?>