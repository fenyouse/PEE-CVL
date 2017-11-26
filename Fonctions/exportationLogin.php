<?php
//////////////////////////EXPORTATION EN PDF////////////////////////////
require_once '../FDPF/fpdf.php';

$pdf=new FPDF('P','cm','A4');

//Titres des colonnes
$header= array('Division','Nom','Prenom','Mp','Login');

$pdf->SetFont('Arial','B',14);
$pdf->AddPage();
$pdf->SetXY(6,2);
$pdf->Cell(3, 1,utf8_decode('Identifiants des élèves par Division'));
$pdf->Image('../img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
$pdf->SetFillColor(96,96,96);
$pdf->SetTextColor(255,255,255);
$db_link =new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');
//liste des candidats générales
//nouvelle méthode 
//$TRAV = candid::SQLAffiche...;
//echo json_encode($TRAV,JSON_PRETTY_PRINT);
//
//ancien méthode
$req="SELECT EIdDivis,ENom,EPrenom,EPwd,ELogin FROM elect order by EIdDivis ;";
$eleve = $db_link-> query($req);
//

$pdf->SetXY(2.5,4);
//for($i=0;$i<sizeof($header);$i++)
    $pdf->cell(3,1,$header[0],1,0,'C',1);
	$pdf->cell(5,1,$header[1],1,0,'C',1);
	$pdf->cell(3,1,$header[2],1,0,'C',1);
	$pdf->cell(2,1,$header[3],1,0,'C',1);
	$pdf->cell(3,1,$header[4],1,0,'C',1);

$pdf->SetFillColor(0xdd,0xdd,0xdd);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

$pdf->SetXY(2.5,$pdf->GetY()+1);
$fond=0;
$divis = ['EIdDivis'];
$j=0;
while($row=$eleve->fetch())
  {
   $divis2 = $row['EIdDivis'];
   if($j >1){
   if ($divis2 != $divis){
	   $pdf->Image('../img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
	   $pdf->AddPage();
	   $pdf->SetXY(2.5,$pdf->GetY()+1);
   }}
   $pdf->cell(3,0.7,$row['EIdDivis'],1,0,'C',$fond);
   $divis = $row['EIdDivis'];
   $pdf->cell(5,0.7,$row['ENom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row['EPrenom'],1,0,'C',$fond);
   $pdf->cell(2,0.7,$row['EPwd'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row['ELogin'],1,0,'C',$fond);

   $pdf->SetXY(2.5,$pdf->GetY()+0.7);
   $fond=!$fond;
   $j=$j+1;
  }

$pdf->output();
?>