<?php
require_once '../Vues/Tech.php';
require_once "../Modeles/si.php";
require_once '../Modeles/element.php';
require_once '../Modeles/pluriel.php';
require_once '../Modeles/admin.php';


//3 formulaires
	//le Bouton importation de la liste des élèves redirige vers la fonction importation
	if(isset($_POST['Importer'])){
		require_once '../Fonctions/importlisteEleve.php';
	}
	//le Bouton exportation de la liste des résultats redirige vers la fonction qui traite les resultats du suffrage
	if(isset($_POST['submitRes'])){
		require_once '../Fonctions/exportationResultats.php';
	}
	//le Bouton exportation de la liste des login-élèves redirige vers la fonction importation
	if(isset($_POST['submitLog'])){
		require_once '../Fonctions/exportationLogin.php';
	}
	
	//le Bouton qui permet de gérer les id et log des admins
	if(isset($_POST['submitAdmin'])){
		require_once '../Vues/GestionAdmins.php';
		if(isset($_POST['submitModif'])){
			//code modif
			$log;
			$mdpAdmin;
			$droitmodif;
			$TRAV = Admin::SQLUpdate(array($log,$mdpAdmin,$droitmodif,));
		}
		if(isset($_POST['submitNew'])){
			$login;
			$mdpnew;
			$droitnew;
			$TRAV = Admin::SQLInsert(array($login,$mdpnew,$droitnew));
		}
		if(isset($_POST['submitSupp'])){
			$log;
			$TRAV = Admin::SQLDelete(.$log.);
		}
	}
?>