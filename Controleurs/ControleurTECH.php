<?php
require_once 'Modeles/admin.php';
require_once 'Modeles/electeur.php';
require_once 'Modeles/division.php';

//3 formulaires
	//le Bouton importation de la liste des élèves redirige vers la fonction importation
	if(isset($_POST['Importer'])){
		require_once 'Fonctions/importlisteEleve.php';
	}
	//le Bouton exportation de la liste des résultats redirige vers la fonction qui traite les resultats du suffrage
	if(isset($_POST['submitRes'])){
		require_once 'Fonctions/exportationResultats.php';
	}
	//le Bouton exportation de la liste des login-élèves redirige vers la fonction importation
	if(isset($_POST['submitLog'])){
		require_once 'Fonctions/exportationLogin.php';
	}
	
	//le Bouton qui permet de gérer les id et log des admins
	if(isset($_POST['Valider'])){
		// if($_POST['EId']!="" and $_POST['Nom']!="" and  $_POST['Prenom']!="" and  $_POST['Login']!="" and  $_POST['mdp']!="" and $_POST['Divis']!=""){
			// // if(Electeur::mustFind($_POST['EId'])== true){
				// // $message = "L'élève existe déjà !";
				// // echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
			// // }
			// // else{
				// // $divis = $_POST['Divis'];
				// // $EID = $_POST['EId'];
				// // $Nom = $_POST['Nom'];
				// // $Prenom = $_POST['Prenom'];
				// // $INE = $_POST['INE'];
				// // $Login = $_POST['Login'];
				// // $mdp = $_POST['mdp'];
				// // $divis = $_POST['Divis'];
				
				// // $TRAV = Electeur::SQLInsert(array($EID,$Nom,$Prenom,$INE,$mdp,$Login,$divis,0));
				// // header("Location: " . $_SERVER['REQUEST_URI']);
				// // $message = "élève enregistré";
				// // echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
				// // exit();
			// // }
		// }
		// else{
			$message = "Renseigner bien tout les champs !";
			echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
		//}
	}
require_once 'Vues/Tech.php';

?>