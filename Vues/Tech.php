<?php
//Marie///
// masque les messages erreurs
ini_set("display_errors",0);error_reporting(0);

?>


<center>
  <div class="well center-block" id="formblock">
    <!--message d'erreur, contour en rouge sur le champ de l'erreur
  	<?php
  	if ($erreur!="") {
  		echo '<p class="bg-warning text-center">';
  		echo $erreur;
  		echo '</p>';
  	}
  	?>
  -->
	
	
    <h4>Importation de la Liste des élèves : </h4>
    <p> Veuillez choisir un fichier *.csv : </p>
    <form  method="post" enctype="multipart/form-data" action="index.php">
	<!--Bouton parcourir pour importer le fichier-->
      <input style="padding-bottom:40px" class="form-control" name="userfile" type="file" value="table" />
      <input class="btn btn-primary btn-lg btn-block" name="Importer" type="submit" value="Importer" />
    </form>
    </br>
    </br>

    <h4>Exportation des Résultats du suffrage : </h4>
    <form  method="post" action="index.php">
	<!--Selection du suffrage pour avoir ses resultats dans le pdf-->
    	<p>Suffrage :
    <?php
    	$LPD = new Suffrages();
    	$LPD->remplir();
    	Suffrage::getInstances()->displaySelectSimple("Suffrage");
    ?></p>
      <input class="btn btn-primary btn-lg btn-block"  name="submitRes" type="submit" value="Exporter" />
    </form>
    </br>
    </br>

    <h4>Exportation des Login des étudiants : </h4>
    <form  method="post" action="index.php">
      <input class="btn btn-primary btn-lg btn-block" name="submitLog" type="submit" value="Exporter" />
    </form>
    </br>
    </br>
    </div>

    <div class="well center-block" id="formblock">
    <!-- tableau affiche les divisions-->
    <?php
    	$LPD = new Divisions();
    	$LPD->remplir();
    	Division::getInstances()->displayTable("Divis2");
    ?>

    <h4>Nouvelle division :</h4>
    <form class="form-inline" method="post" action="index.php">
    	<div class="form-group
		<!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
          <label class="sr-only">Division</label>
          <input type="text" class="form-control" name="divisAjout" id="divisAjout"  placeholder="Division">
        </div>
    	</br>
      </br>
    	<input class="btn btn-primary btn-lg btn-block" type="submit" value="Valider" name="ValiderDivis"class="bouton" />
      </br>
      </br>
    </form>

    <h4>Suppression d'une division :</h4>
    <form class="form-inline" method="post" action="index.php">
      <p>Division :
	  <!-- Selection de la division pour suppression-->
    <?php
    	$LPD = new Divisions();
    	$LPD->remplir();
    	Division::getInstances()->displaySelect("Divis2");
    ?></p>
    	<input class="btn btn-primary btn-lg btn-block" type="submit" value="Supprimer" name="ValiderSupp"class="bouton" />
      </br>
      </br>
    </form>


    <h4>Nouvel élève :</h4>
    <form class="form-inline" method="post" action="index.php">

    	<div class="form-group
		<!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
          <label class="sr-only" >EId</label>
          <input type="text" class="form-control" name="EId" id="EId"  placeholder="EId">
        </div>
    	<div class="form-group
		<!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
          <label class="sr-only" >Nom</label>
          <input type="text" class="form-control" name="Nom" id="Nom"  placeholder="Nom">
        </div>
    	<div class="form-group
		<!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
          <label  class="sr-only" >INE</label>
          <input type="text" class="form-control" name="INE" id="INE" placeholder="INE">
        </div>
    	<div class="form-group
		<!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
          <label  class="sr-only">Prenom</label>
          <input type="text" class="form-control" name="Prenom" id="Prenom" placeholder="Prenom">
        </div>
    	<div class="form-group
		<!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
          <label class="sr-only">Login</label>
          <input type="text" class="form-control" name="Login" id="login" placeholder="Login">
      </div>
      <div class="form-group
	  <!--message d'erreur-->
        <?php if($erreur!=""){
           echo('has-error');
         }
         ?>">
        <label class="sr-only" for="InputPassword">Mot de passe</label>
        <input name="mdp" type="password" id="mdp" class="form-control" placeholder="Mot de passe">
      </div>
      </br>
      </br>
    	<p>Division :
		<!-- Selection de la division pour création d'un élève-->
    <?php
    	$LPD = new Divisions();
    	$LPD->remplir();
    	Division::getInstances()->displaySelect("Divis");
    ?></p>
      </br>
      </br>

      <input class="btn btn-primary btn-lg btn-block" type="submit" value="Valider" name="Valider"class="bouton" />
    </form>
    </br>
    </br>

  </div>
</center>
