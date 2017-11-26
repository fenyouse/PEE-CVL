<?php
require_once '../Modeles/admin.php';
require_once '../Modeles/si.php';
?>

 
<center>
<div class="well center-block" style="max-width:500px;margin-top:50px">
<h4>Les Administrateurs :</h4>
<?php
$MonBeauSI = SI::getSI() ;
?>

<table class="table">
	<tr>
	<th>Login</th>
	<th>Mot de passe</th>
	<th>Droit</th>
	</tr>
	<?php
	$LP = new Admins();
	$LP->remplir();
	Admin::getInstances()->displayTable();
	?>
</table>
<h4>Modifier un Administrateur :</h4>
<form class="form-inline" method="../index.php">
<?php
	$LPD = new Admins();
	$LPD->remplir();
	Admin::getInstances()->displaySelect();
?>

<div class="form-group">
     <input name="mpmodif" type="text" class="form-control" id="mdpAdmin" placeholder="Mot de passe">
</div>
<br></br>

<p>Droit :
	<select style="width:auto" class="form-control" type="Text" name="droitmodif" required="required">
				<option value="01">CPE</option>      
				<option value="02">TECH</option>          
</select></p>

<br></br>
<input class="btn btn-default btn-lg btn-block" type="submitModif" value="Valider" name="Valider"class="bouton" />
<br></br>

<h4>Nouvel Administrateur :</h4>

	<div class="form-group">
      <label name="login" class="sr-only" for="InputLogin">Login</label>
      <input type="text" class="form-control" id="loginAmdin" placeholder="Login">
    </div>
    <div class="form-group">
      <label class="sr-only" for="InputPassword">Mot de passe</label>
      <input name="mdpnew" type="password" class="form-control" id="mdpAdmin" placeholder="Mot de passe">
	</div>
	<br></br>
	<p>Droit :
	<select style="width:auto" class="form-control" type="Text" name="droitnew" required="required">
				<option value="01">CPE</option>      
				<option value="02">TECH</option>          
	</select></p>
	<input class="btn btn-default btn-lg btn-block" type="submitNew" value="Valider" name="Valider"class="bouton" />
 </form>
 <br></br>
 
 <h4>Supprimer un Administrateur :</h4>
<?php
	$LPD = new Admins();
	$LPD->remplir();
	Admin::getInstances()->displaySelect();
?>
<br></br>
<input class="btn btn-default btn-lg btn-block" type="submitSupp" value="Valider" name="Valider"class="bouton" />


</div>	

</center>

