<?php  
// masque les messages erreurs
ini_set("display_errors",0);error_reporting(0);
//$MonBeauSI = SI::getSI();
?>
<html lang="fr">
	<head>
	<meta charset="utf-8" />
	<title>Compte Technicien</title>
</head>
<body>
<center>
<h3> Veuillez choisir un fichier *.csv : </h3>
<form method="post" enctype="multipart/form-data" action="../Modeles/importlisteEleve.php">
<input name="userfile" type="file" value="table" />
<input name="submit" type="submit" value="Importer" /></form>

<h3>Exportation des Résultats du suffrage : </h3>
<!--<p>Selection du suffrage :</p>-->
<?php
// require_once '../Modeles/suffrage.php';
// $lesSuffrages = new Suffrages();
// $lesSuffrages ->remplir();
// Suffrage::getInstances()->displaySelect();
?>
<form method="post" action="../Modeles/exportationResultats.php">
<input name="submit" type="submit" value="Exporter" /></form>

<h3>Exportation des Login des étudiants : </h3>
<form method="post" action="../Modeles/exportationLogin.php">
<input name="submit" type="submit" value="Exporter" /></form>
</center>
</body>
</html>
