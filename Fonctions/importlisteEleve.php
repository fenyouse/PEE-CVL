<?php
//Marie

extract(filter_input_array(INPUT_POST));

//$db = new PDO('mysql:host=127.0.0.1;dbname=cvl','#','#');

//récupère le nom du fichier
$fichier=$_FILES["userfile"]["name"];
//récupère son extention
$type_file = pathinfo($fichier,PATHINFO_EXTENSION);

//vérification de l'extention du fichier
if($type_file =="csv"){
	if($fichier){ // ouverture du fichier temporaire
		$fp = fopen($_FILES["userfile"]["tmp_name"], "r");
	}
	else{
		//message d'erreur si fichier inconnu
		$message = utf8_decode("- Importation Echouée - ");?>
		 <p align="center" > <?php echo '<script type="text/javascript">window.alert("'.$message.'");</script>'?> </p>
		 <p align="center" ><B>Désolé, mais vous n'avez pas specifié de chemin valide...</B></p>
	 <?php exit();}
	//declaration de la variable cpt qui permettre de compter le nomde d'enregistrement réalisé
	$cpt=0;
	//message après traitement
	$message = utf8_decode("- Importation Réussie - ");?>
	<p align="center"><?php echo '<script type="text/javascript">window.alert("'.$message.'");</script>' ?></p>
	<?php //importation
	// ignore ligne 1
	$ignore = true ;
	while(!feof($fp)){
		$ligne =fgets($fp,4096);

		if (!$ignore) {
			//on crée un tableau des éléments séparés pas des points virgule
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
				//insertion liste élève
				$TRAV = Electeur::SQLInsert(array($champ2,$champ4,$champ5,$champ3,$champ8,$champ7,$champ1,0));
			}
		}
		$ignore=false;

	}
}
else{//message d'erreur si l'extention n'est pas respecter
	exit("Attention ! Le fichier n'est pas en csv, veuillez en importer un nouveau !");
}
//fermeture du fichier
	fclose($fp);

	?>
