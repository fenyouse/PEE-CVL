<?php
require_once "../Modeles/si.php";
?>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<title>Compte CPE</title>
	</head>
		
	<body>
		<form method="post" action="Cpe.php">
		
			<center>
			<h2>Création d'une élection </h2>
			<p>Le nombre de candidat maximum pour les électeurs : </p>
			<input type="number" min="2" value="5" max="10" name="NbChoix"/>
			
			
			<p>Date de début de l'élection : </p>
			
			<select type="Text" name="day1" required="required">
			<?php
				for ($i=1;$i<=31;$i++) {
						?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
				}
			?>    
			</select>
			<?php 
			
			?>
			<select type="Text" name="month1" required="required">
				<option value="01">Janvier</option>      
				<option value="02">Fevrier</option>      
				<option value="03">Mars</option>      
				<option value="04">Avril</option>      
				<option value="05">Mai</option>      
				<option value="06">Juin</option>      
				<option value="07">Juillet</option>      
				<option value="08">Aout</option>      
				<option value="09">Septembre</option>      
				<option value="10">Octobre</option>      
				<option value="11">Novembre</option>      
				<option value="12">Decembre</option>      
			</select>
			<select type="Text" name="year1" required="required">
				<?php
					for ($i=date('Y');$i<=date('Y')+1;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
					}
				?>
			</select>
			<select type="Text" name="h1" required="required">
				<?php
					for ($i=6;$i<=22;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?><p>h</p></option><?php
					}
				?>
			</select>

			<p>Date de fin de l'élection :</p>
			<select type="Text" name="day2" required="required">
			<?php
				for ($i=1;$i<=31;$i++) {
						?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
				}
			?>    
			</select>
			<?php 
			
			?>
			<select type="Text" name="month2" required="required">
				<option value="01">Janvier</option>      
				<option value="02">Fevrier</option>      
				<option value="03">Mars</option>      
				<option value="04">Avril</option>      
				<option value="05">Mai</option>      
				<option value="06">Juin</option>      
				<option value="07">Juillet</option>      
				<option value="08">Aout</option>      
				<option value="09">Septembre</option>      
				<option value="10">Octobre</option>      
				<option value="11">Novembre</option>      
				<option value="12">Decembre</option>      
			</select>
			<select type="Text" name="year2" required="required">
				<?php
					for ($i=date('Y');$i<=date('Y')+1;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
					}
				?>
			</select>
			<select type="Text" name="h2" required="required">
				<?php
					for ($i=6;$i<=22;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?><p>h</p></option><?php
					}
				?>
			</select>
			
			<p>Descritpion de l'élection : </p>
			<Textarea type="textera" name="Desc" rows=4 cols=40 wrap=physical></Textarea>
			<br></br>
			<input type="submit" value="Valider" name="Valider"class="bouton" />
			
		</center>
		</form>
<?php

//insertion des données du formulaires

$reponse=true;
	if(isset($_POST['Valider'])){
		// if($_POST['Desc']=""){
			$datedebut = $_POST['year1']."-".$_POST['month1']."-".$_POST['day1']." ".$_POST['h1'].":00:00";
			$datefin =  $_POST['year2']."-".$_POST['month2']."-".$_POST['day2']." ".$_POST['h2'].":00:00";
			$Desc = $_POST['Desc'];
			$NbChoix = $_POST['NbChoix'];
			$bdd = new PDO('mysql:host=127.0.0.1;dbname=cvl','root','');
			//$bdd->exec
			$req=('INSERT INTO `suffrage`(`SChoix`, `SDateDeb`, `SDateFin`, `SDescription`) VALUES ("'.$NbChoix.'","'.$datedebut.'","'.$datefin.'","'.$Desc.'")');
			SGBDgetPrepareExecute($req);
			require_once "Cpe.php";
			$message = "Election enregistrer";
			echo '<script type="text/javascript">window.alert("'.$message.'");</script>';		
		// }
		// else{
			// echo "Veuillez saisir une description pour l'élection !!";
			// $reponse=false;
			// require_once "Vuecpe.php";
		// }
	}




?>
</body>
</html>


