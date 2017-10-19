<?php
  require_once 'Vues/header.php';

	//référencer les classes utiles
	require_once 'Modeles/si.php';
	//recupération du SI, le seul le singleton
	$MonBeauSI = SI::getSI();
	//var_dump($MonBeauSI);//montrer l'id de l'objet


  require_once 'Controleurs/ControleurPrincipal.php';

?>
