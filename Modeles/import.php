<?php
extract(filter_input_array(INPUT_POST));

$db = new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');

$fichier=$_FILES["userfile"]["name"];
	if($fichier){ // ouverture du fichier temporaire
		$fp = fopen($_FILES["userfile"]["tmp_name"], "r");
	}
	else{ //fichier inconnu?>
		<p align="center" >- Importation echouee -</p>
		<p align="center" ><B>Désolé, mais vous n'avez pas specifié de chemin valide...</B></p>
	<?php exit();}
	//declaration de la variable cpt qui permettre de compter le nomde d'enregistrement réalisé
	$cpt=0;?>
	<p align="center">- Importation Réussie -</p>
	<?php //importation
	// ignore ligne 1
	$ignore = true ;
	while(!feof($fp)){
		$ligne =fgets($fp,4096);
		if (!$ignore) {
			//oncrée un tableau des éléments séparés pas des points virgule
			$ligne = explode(";",$ligne);
			$table = filter_input(INPUT_POST,'userfile');
			//permier éléments
			$liste[0] = (isset($ligne[0]) ) ? $ligne[0] : Null;
			$liste[1] = (isset($ligne[1]) ) ? $ligne[1] : Null;
			$liste[2] = (isset($ligne[2]) ) ? $ligne[2] : Null;
			$liste[3] = (isset($ligne[3]) ) ? $ligne[3] : Null;
			$liste[4] = (isset($ligne[4]) ) ? $ligne[4] : Null;
			$liste[5] = (isset($ligne[5]) ) ? $ligne[5] : Null;
			$liste[6] = (isset($ligne[6]) ) ? $ligne[6] : Null;
			$liste[7] = (isset($ligne[7]) ) ? $ligne[7] : Null;
			$champ1=$liste[0];
			$champ2=$liste[1];
			$champ3=$liste[2];
			$champ4=$liste[3];
			$champ5=$liste[4];
			$champ6=$liste[5];
			$champ7=$liste[6];
			$champ8=$liste[7];
			if($champ1!='')
			{
				$cpt++;
				

				//SGBDgetPrepare($req);
				//SGBDgetPrepareExecute($req);
			}
			$req =("INSERT INTO elect( EId,ENom,EPrenom,EPwd,ELogin,EIdDivis) VALUES('$champ2','$champ4','$champ5','$champ8','$champ7','$champ1')");
			//echo $req.'<br/>';
			//$sql = ("INSERT INTO elect( EId,ENom,EPrenom,EVote,EPwd,ELogin,EIdDivis,EDateLogin,EAdresseIP,ELastLogin,ESession,EDateLogout,EModif) VALUES('$champ2','$champ4','$champ5','','$champ8','$champ1','','','',0)");
			$result = $db-> query($req);
		}
		$ignore=false;
	}
//fermeture du fichier
	fclose($fp);
	?>
	<h2>Nombre de valeurs nouvellement enregistrées:</h2><b><?php echo $cpt;?></b>

