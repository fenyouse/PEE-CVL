<?php
  session_start();
  require_once 'Vues/header.php';

	//référencer les classes utiles
	require_once 'Modeles/si.php';
	//recupération du SI, le seul le singleton
	$MonBeauSI = SI::getSI();
	var_dump($MonBeauSI);//montrer l'id de l'objet
  var_dump($_SESSION);

  require_once 'Controleurs/ControleurPrincipal.php';

?>
