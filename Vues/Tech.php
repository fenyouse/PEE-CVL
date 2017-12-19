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

<h4>Nouvel élève :</h4>
<form class="form-inline" method="post" action="index.php">

	<div class="form-group">
      <label name="EId" class="sr-only" for="InputId">EId</label>
      <input type="text" class="form-control"  placeholder="EId">
    </div>
	<div class="form-group">
      <label name="Nom" class="sr-only" for="InputNom">Nom</label>
      <input type="text" class="form-control"  placeholder="Nom">
    </div>
	<div class="form-group">
      <label name="INE" class="sr-only" for="InputINE">INE</label>
      <input type="text" class="form-control"  placeholder="INE">
    </div>
	<div class="form-group">
      <label name="Prenom" class="sr-only" for="InputPrenom">Prenom</label>
      <input type="text" class="form-control"  placeholder="Prenom">
    </div>
	<div class="form-group">
      <label name="Login" class="sr-only" for="InputLogin">Login</label>
      <input type="text" class="form-control"  placeholder="Login">
    </div>
    <div class="form-group">
      <label class="sr-only" for="InputPassword">Mot de passe</label>
      <input name="mdp" type="password" class="form-control" placeholder="Mot de passe">
	</div>
<br></br>
	<p>Division :
<?php
	$LPD = new Divisions();
	$LPD->remplir();
	Division::getInstances()->displaySelect("Divis");
?>
<br></br></form>

	<input class="btn btn-default btn-lg btn-block" type="submit" value="Valider" name="Valider"class="bouton" />
 
 <br></br>
 
</div>
</center>

