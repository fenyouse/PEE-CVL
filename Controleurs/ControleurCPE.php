<?php
//Marie

//redirections
require_once 'Modeles/suffrage.php';
require_once 'Modeles/electeur.php';
require_once 'Modeles/candidat.php';

$erreur = "";

//insertion des données du formulaires Cpe.php
	//ajout des candidats par suffrage
	if(isset($_POST['Validercandidat'])){
		//var_dump(Electeur::mustFind($_POST['IdCand']));
		//verif si champ vide ou non
		if($_POST['IdCand']!="" and $_POST['IdBin']!=""){
			//recherche si les id existe dans la table electeur
			if(Electeur::mustFind($_POST['IdCand'])== true and Electeur::mustFind($_POST['IdBin'])== true){
				//echo $TRAV['pgerror'];
				//echo " /////////// ";
				$selection = $_POST['selection'];
				$idcandid = $_POST['IdCand'];
				$idbinome = $_POST['IdBin'];
				$TRAV = Candidat::SQLInsert(array($idcandid,$idbinome,$selection));
				//si il y a duplication de la clef primaire alors envoie un message d'erreur, sinon on envois que le traitement est fait
				if($TRAV['pgerror'] !="23000"){
					header("Location: " . $_SERVER['REQUEST_URI']);
					$message = "Candidat enregistré !";
					echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
					exit();
				}
				else{
					$erreur = "L'élève est déjà enregistré !";
					echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
				}
			}
			else{
				$erreur = "Vérifier que l'Id du candidat ou du binôme existe bien !";
				echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
			}
		}
		else{
			$erreur = "Attention ! Il faut saisir les deux Identifiants !";
			echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
		}
	}
	//ajout d'un suffrage
	if(isset($_POST['Valider'])){
		if($_POST['Desc']!=""){
			//si il y a une description on compare les dates de début et fin
			$datedebut = $_POST['year1']."-".$_POST['month1']."-".$_POST['day1']." ".$_POST['h1'].":00:00";
			$datefin =  $_POST['year2']."-".$_POST['month2']."-".$_POST['day2']." ".$_POST['h2'].":00:00";
			$Desc = $_POST['Desc'];
			// si date de début est plus grande il y a un message d'erreur
			if(strtotime($datedebut) > strtotime($datefin)){
				$erreur = "Attention ! La date de début du suffrage est plus grande que la date de fin !";
				echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
			}
			else{
				//initialise le choix
				$NbChoix = $_POST['NbChoix'];
				//insertion suffrage, nouvelle méthode
				$TRAV = Suffrage::SQLInsert(array($NbChoix,$datedebut,$datefin,$Desc));
				//echo json_encode($TRAV,JSON_PRETTY_PRINT);
				// Redirect la page (empêcher le renvoit du formulaire quand on rafraichit)
				$message = "Election enregistrer";
				echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			}
		}
		else{
			//message erreur si pas de description
			$erreur = "Attention ! Veuillez saisir une description pour l'élection !!";
			echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
			require_once "index.php";
		}
	}
require_once 'Vues/Cpe.php';


?>
