<?php
//////////////////////////EXPORTATION EN PDF////////////////////////////
require_once '../FDPF/fpdf.php';

$pdf=new FPDF('P','cm','A4');
////////////////////////////////////////
//Suffrage
////////////////////////////////////////
$header0= array('','');
$pdf->SetFont('Arial','B',14);
$pdf->AddPage();
$pdf->SetXY(7,2);
$pdf->Cell(5,1,'Election de Gustave Eiffel');
$pdf->Image('../img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
$pdf->SetFillColor(96,96,96);
$pdf->SetTextColor(255,255,255);
$db_link =new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');

//liste des candidats générales
$req="SELECT SDateDeb,SDateFin,SDescription,SBlancs,SNuls FROM suffrage WHERE CURRENT_DATE()>SDateFin ORDER By SDateFin DESC LIMIT 1 ;";
$eleve0 = $db_link-> query($req);
//

$pdf->SetXY(5,4);
$pdf->cell(5,0.5,$header0[0],0,0,1);
$pdf->cell(5,0.5,$header0[1],0,0,1);


$pdf->SetFillColor(0xdd,0xdd,0xdd);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

$pdf->SetXY(5,$pdf->GetY()+1);
$fond=0;

$pdf->Text(5,4.5,"Description :");
$pdf->Text(5,6,utf8_decode("Date de début :"));
$pdf->Text(5,7,"Date de fin :");
$pdf->Text(13,6,"Vote Blancs :");
$pdf->Text(13,7,"Vote Nuls :");

while($row0=$eleve0->fetch())
  {
   $pdf->Text(8,6,$row0['SDateDeb'],1,0,$fond);
   $pdf->Text(8,7,$row0['SDateFin'],1,0,$fond);
   $pdf->Text(8,4.5,$row0['SDescription'],1,0,$fond);
   $pdf->Text(16,6,$row0['SBlancs'],1,0,$fond);
   $pdf->Text(16,7,$row0['SNuls'],1,0,$fond);
   
   $pdf->SetXY(3,$pdf->GetY()+0.7);
   $fond=!$fond;
  }

////////////////////////////////////////
//Resultats par candidats
////////////////////////////////////////
//Titres des colonnes
$header= array('Division','Nom','Prenom','Binome','NbVote');


$pdf->SetFont('Arial','B',12);

//$pdf->AddPage();
$pdf->SetXY(7,8.5);
$pdf->Cell(5, 1, utf8_decode('Résultats des candidats :'));
$pdf->SetFillColor(96,96,96);
$pdf->SetTextColor(255,255,255);
$db_link =new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');

//liste des candidats générales
$req="SELECT EIdDivis,ENom,EPrenom,CIdBinome,CNbV FROM elect,candid where candid.CId = elect.Elogin order by EIdDivis ;";
$eleve = $db_link-> query($req);
//

$pdf->SetXY(3,10);
for($i=0;$i<sizeof($header);$i++)
    $pdf->cell(3,1,$header[$i],1,0,'C',1);

$pdf->SetFillColor(0xdd,0xdd,0xdd);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);

$pdf->SetXY(3,$pdf->GetY()+1);
$fond=0;
while($row=$eleve->fetch())
  {
   $pdf->cell(3,0.7,$row['EIdDivis'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row['ENom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row['EPrenom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row['CIdBinome'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row['CNbV'],1,0,'C',$fond);

   $pdf->SetXY(3,$pdf->GetY()+0.7);
   $fond=!$fond;
  }
 

////////////////////////////////////////
//Elu et son binome
///////////////////////////////////////
//Titres des colonnes
$header2= array('Division','Nom','Prenom','INE','EId');

$pdf->SetFont('Arial','B',12);

//$pdf->AddPage();

$pdf->SetXY(7,20.5);
$pdf->Cell(5, 1, utf8_decode('Elu et son Binôme :'));
$pdf->SetFillColor(96,96,96);
$pdf->SetTextColor(255,255,255);
$db_link =new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');

//Elu et son binome
$req2="SELECT EIdDivis,ENom,EPrenom,ECodeINE,MAX(CNbV),CIdBinome,EId FROM elect,candid where candid.CId = elect.Elogin order by ENom;";
$eleve2 = $db_link-> query($req2);
//

$pdf->SetXY(3,22);
for($i=0;$i<sizeof($header2);$i++)
    $pdf->cell(3,1,$header2[$i],1,0,'C',1);

$pdf->SetFillColor(0xdd,0xdd,0xdd);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);

$pdf->SetXY(3,$pdf->GetY()+1);
$fond=0;
while($row2=$eleve2->fetch())
  {
   $pdf->cell(3,0.7,$row2['EIdDivis'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row2['ENom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row2['EPrenom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row2['ECodeINE'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row2['EId'],1,0,'C',$fond);
   
   $pdf->SetXY(3,$pdf->GetY()+0.7);
   $fond=!$fond;
   $binome = $row2['CIdBinome'];
  }

//binome
$req3="SELECT EIdDivis,ENom,EPrenom,ECodeINE,EId FROM elect where ELogin = '".$binome."';";
$eleve3 = $db_link-> query($req3);
//

 while($row3=$eleve3->fetch())
  {
   $pdf->cell(3,0.7,$row3['EIdDivis'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row3['ENom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row3['EPrenom'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row3['ECodeINE'],1,0,'C',$fond);
   $pdf->cell(3,0.7,$row3['EId'],1,0,'C',$fond);

   $pdf->SetXY(3,$pdf->GetY()+0.7);
   $fond=!$fond;
  }

  $pdf->Text(10,27,"Signature du CPE :");
  $pdf->Text(16,27,utf8_decode("Signature de l'Elu :"));
 
 //fin pdf
$pdf->output();

?>
