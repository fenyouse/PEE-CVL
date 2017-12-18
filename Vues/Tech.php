<?php  
// masque les messages erreurs
ini_set("display_errors",0);error_reporting(0);

?>

 
<center>
<div class="well center-block" style="max-width:400px;margin-top:100px">

<h4>Importation de la Liste des élèves : </h4>
<p> Veuillez choisir un fichier *.csv : </p>

<form  method="post" enctype="multipart/form-data" action="index.php">
<input style="padding-bottom:40px" class="form-control" name="userfile" type="file" value="table" />
<input class="btn btn-default btn-lg btn-block" name="Importer" type="submit" value="Importer" /></form>
<br></br>

<h4>Exportation des Résultats du suffrage : </h4>
<form  method="post" action="index.php">
<input class="btn btn-default btn-lg btn-block"  name="submitRes" type="submit" value="Exporter" /></form>
<br></br>

<h4>Exportation des Login des étudiants : </h4>
<form  method="post" action="index.php">
<input class="btn btn-default btn-lg btn-block" name="submitLog" type="submit" value="Exporter" /></form>
<br></br>

<button class="btn btn-default btn-lg btn-block" type="submit" name="submitAdmin" class="btn btn-default"> Gestion des Administrateurs </button>

</div>
</center>

