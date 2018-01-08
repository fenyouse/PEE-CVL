<?php
//Marie

//redirections
require_once 'Modeles/admin.php';
require_once 'Modeles/electeur.php';
require_once 'Modeles/division.php';
require_once 'Modeles/suffrage.php';
require_once 'Modeles/candidat.php';
require_once 'FDPF/fpdf.php';

$erreur = "";

	//le Bouton importation de la liste des élèves redirige vers la fonction importation
	if(isset($_POST['Importer'])){
		require_once 'Fonctions/importlisteEleve.php';

	}
	//le Bouton exportation de la liste des résultats
	if(isset($_POST['submitRes'])){
		$SelectionSuffrage = $_POST['Suffrage'];
		//creation d'un pdf
		$pdf=new FPDF('P','cm','A4');
		//tableau du suffrage selectionner
		$LP = new Suffrages();
		$LP->remplir("SId='".$SelectionSuffrage."'",null);
		$LP->displaySelectPDF($pdf);
		//tableau des scores des candidats
		$LP = new Candidats();
		$req = "SELECT CId,CIdBinome,CNbV FROM candid where CIdSuffrage='".$SelectionSuffrage."' ;";
		$LP->remplirAVECRequete($req);
		$LP->displaySelectPDFCandidats($pdf);
		//tableau des ou du candidats ayant le maximum de votes
		$LP2 = new Candidats();
		$req2 = "SELECT CId,MAX(CNbV) FROM candid where CIdSuffrage='".$SelectionSuffrage."';";
		$LP2->remplirAVECRequete($req2);
		$LP2->displaySelectPDFElu($pdf);

		//fin de page
		$pdf->Text(10,27,"Signature du CPE :");
		$pdf->Text(16,27,utf8_decode("Signature de l'Elu :"));
		//fermeture du pdf
		$pdf->output();
		header("Location: " . $_SERVER['REQUEST_URI']);
	}

	//le Bouton exportation de la liste des login-élèves
	if(isset($_POST['submitLog'])){
		//creation d'un pdf
		$pdf=new FPDF('P','cm','A4');
		//tableau des log des élèves classés par division
		$LP = new Electeurs();
		$req = "SELECT EId,EIdDivis,ENom,EPrenom,EPwd,ELogin FROM elect order by EIdDivis;";
		$LP->remplirAVECRequete($req);
		$LP->displaySelectPDFElecteur($pdf);
		//fermeture du pdf
		$pdf->output();
		header("Location: " . $_SERVER['REQUEST_URI']);

	}

	//le Bouton qui permet de créer un élève
	if(isset($_POST['Valider'])){

		 if($_POST['EId']!="" and $_POST['Nom']!="" and  $_POST['Prenom']!="" and  $_POST['Login']!="" and  $_POST['mdp']!="" and $_POST['Divis']!=""){
			//recherche de l'id pour voir si l'électeur existe déjà ou non
			if(Electeur::mustFind($_POST['EId'])== false){
				//message d'erreur
				$erreur = "L'élève existe déjà !";
				echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
			}
			else{
				$divis = $_POST['Divis'];
				$EID = $_POST['EId'];
				$Nom = $_POST['Nom'];
				$Prenom = $_POST['Prenom'];
				$INE = $_POST['INE'];
				$Login = $_POST['Login'];
				$mdp = $_POST['mdp'];
				$divis = $_POST['Divis'];
				//insertion de l'enregistrement dans la base
				$TRAV = Electeur::SQLInsert(array($EID,$Nom,$Prenom,$INE,$mdp,$Login,$divis,0));
				//message fin traitement
				$message = "élève enregistré !";
				echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			}
		 }
		 else{
			 //message d'erreur
			$erreur = "Renseigner bien tout les champs !";
			echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
		}

	}
	//enregistre une nouvelle division
	if(isset($_POST['ValiderDivis'])){
		//var_dump($_POST['divisAjout']);
		if( $_POST['divisAjout']!=""){
			//recherche si la division existe déjà ou non
			if(Division::mustFind($_POST['divisAjout'])== false){
				 //message d'erreur
				$erreur = "La division existe déjà !";
				echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
			}
			else{
				$divisajout = $_POST['divisAjout'];
				//insertion de l'enregistrement dans la base
				$TRAV = Division::SQLInsert(array($divisajout));
				//message fin traitement
				$message = "Division enregistrée !";
				echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			}
		}
		else{
			 //message d'erreur
			$erreur = "Saisissez bien une division !";
			echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
		}
	}
	//suppression d'une division
	if(isset($_POST['ValiderSupp'])){
		//var_dump($_POST['Divis2']);
		$divisSupp = $_POST['Divis2'];
		//var_dump($divisSupp);
		//suppression d'une division dans la base
		$TRAV = Division::SQLDelete($divisSupp);
		//echo json_encode($TRAV,JSON_PRETTY_PRINT);
		//message fin traitement
		 $message = "Division supprimée !";
		 echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
	}

require_once 'Vues/Tech.php';


?>
