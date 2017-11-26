<?php
require_once '../Vues/Cpe.php';
require_once "../Modeles/si.php";
require_once '../Modeles/suffrage.php';



//insertion des données du formulaires Cpe.php
	if(isset($_POST['Valider'])){
		if($_POST['Desc']!=""){
			//si il y a une description on compare les dates de début et fin
			$datedebut = $_POST['year1']."-".$_POST['month1']."-".$_POST['day1']." ".$_POST['h1'].":00:00";
			$datefin =  $_POST['year2']."-".$_POST['month2']."-".$_POST['day2']." ".$_POST['h2'].":00:00";
			$Desc = $_POST['Desc'];
			// si date de début est plus grande il y a un message d'erreur
			if(strtotime($datedebut) > strtotime($datefin)){
				$message = "Attention ! La date de début du suffrage est plus grande que la date de fin !";
				echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			}
			else{
				//initialise le choix
				$NbChoix = $_POST['NbChoix'];
				
				//insertion suffrage, nouvelle méthode
				$TRAV = Suffrage::SQLInsert(array($NbChoix,$datedebut,$datefin,$Desc));
				//echo json_encode($TRAV,JSON_PRETTY_PRINT);
				//
				
				//test insertion suffrage dans bdd
				//$bdd = new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');
				//$bdd->exec=('INSERT INTO `suffrage`(`SChoix`, `SDateDeb`, `SDateFin`, `SDescription`) VALUES ("'.$NbChoix.'","'.$datedebut.'","'.$datefin.'","'.$Desc.'")');
				//
				require_once "index.php";
				$message = "Election enregistrer";
				echo '<script type="text/javascript">window.alert("'.$message.'");</script>';	
			}
		}
		else{
			//message erreur si pas de description
			$message = "Attention ! Veuillez saisir une description pour l'élection !!";
			echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			require_once "index.php";
		}
	}
?>