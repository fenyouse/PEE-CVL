<?php
  require_once 'Vues/header.php';

	//référencer les classes utiles
	require_once 'Modeles/si.php';
	//recupération du SI, le seul le singleton
	$MonBeauSI = SI::getSI();
	//var_dump($MonBeauSI);//montrer l'id de l'objet

?>

<center><h1>Site de vote de Gustave Eiffel</h1></center>
<?php

  require_once 'Vues/menu.php';
  $Page ="";

  if (isset($_GET["vu"])) {
    $Page = $_GET["vu"];
  }
  if ( $Page == "Connexion") {
    require_once 'Vues/Connexion.php';
  }
  if ( $Page == "Accueil") {
    require_once 'Vues/AccueilNonConnecter.php';
  }

  require_once 'Vues/footer.php';

?>
