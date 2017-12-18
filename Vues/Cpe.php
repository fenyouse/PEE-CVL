

<script>
// instanciation objet pour appeler le serveur
function makeHttpr() {
	var xmlhttp;
	if (window.XMLHttpRequest) {
// code for IE7+, Firefox, Chrome, Opera, Safari
	   xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
	   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

function appelAjaxGet(chaineGet) {
	var xHttp;
	xHttp = makeHttpr() ;
	xHttp.onreadystatechange=function()  {
		if (xHttp.readyState==4 && xHttp.status==200) {
			traiterRetour(xHttp.responseText);
		}
	}
	xHttp.open("GET", chaineGet, true);
	xHttp.send();
}

function appelAjaxPost() {
	var xHttp;
	xHttp = makeHttpr() ;
	xHttp.onreadystatechange=function()  {
		if (xHttp.readyState==4 && xHttp.status==200) {
			traiterRetour(xHttp.responseText);
		}
	}
	xHttp.open("POST", "ajax_test.asp", true);
	xHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHttp.send("fname=Pascal&lname=Giorgi");
}

function traiterRetour(flot) {
	//alert(repon) ;
	var oDiv = document.getElementById("details");
	oDiv.innerHTML = flot;
}
function demanderDetails(objSelect) {
	//alert(objSelect.value);
	var oDiv = document.getElementById("details");
	oDiv.innerHTML = "veuillez patienter SVP ...";
    appelAjaxGet("Fonctions/repondeurCPE.php?idsuff="+objSelect.value);
}
</script>
<center>
<div class="well center-block" style="max-width:500px;margin-top:100px">

		<form method="post" class="form-inline" action="index.php">
		
			<h4>Ajouter un Candidat : </h4>
			<br></br>
			<p> Selectionner l'élection à laquelle ils participent : </p>
			<?php  
			$lessuffrages = new Suffrages();
			$lessuffrages->remplir();
			Suffrage::getInstances()->displaySelect();
			?>
			<div class="well center-block" style="max-width:500px;margin-top:50px" id="details">
			</div>
			<input type="text" class="form-control" name="IdCand" id="CId" placeholder="Id du candidat">
		
			<input type="text" class="form-control" name="IdBin" id="idBinome" placeholder="Id de son binôme">
			<br></br>
			
			<input class="btn btn-default btn-lg btn-block" type="submit" value="Valider" name="Validercandidat"class="bouton" />
			<br></br>
			
			<h4>Création d'une élection : </h4>
			<br></br>
			
			<p>Selectionner le nombre max de vote possible pour électeurs: 
			<input style="max-width:50px" type="number" min="2" value="5" max="10" name="NbChoix"/></p>
			<br></br>
			
			<p>Date de début de l'élection : </p>
			<select style="width:auto" class="form-control" type="Text" name="day1" required="required">
			<?php
				for ($i=1;$i<=31;$i++) {
						?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
				}
			?>    
			</select>
			
			<select style="width:auto" class="form-control" type="Text" name="month1" required="required">
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
			<select style="width:auto" class="form-control" type="Text" name="year1" required="required">
				<?php
					for ($i=date('Y');$i<=date('Y')+1;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
					}
				?>
			</select>
			<select style="width:auto" class="form-control" type="Text" name="h1" required="required">
				<?php
					for ($i=6;$i<=22;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?><p>h</p></option><?php
					}
				?>
			</select>
			<br></br>
			
			<p>Date de fin de l'élection :</p>
			
			<select style="width:auto" class="form-control" type="Text" name="day2" required="required">
			<?php
				for ($i=1;$i<=31;$i++) {
						?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
				}
			?>    
			</select>

			<select style="width:auto" class="form-control" type="Text" name="month2" required="required">
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
			
			<select  style="width:auto" class="form-control" type="Text" name="year2" required="required">
				<?php
					for ($i=date('Y');$i<=date('Y')+1;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
					}
				?>
			</select>
			<select style="width:auto" class="form-control" type="Text" name="h2" required="required">
				<?php
					for ($i=6;$i<=22;$i++) {
							?><option value="<?php echo $i; ?>"><?php echo $i; ?><p>h</p></option><?php
					}
				?>
			</select>
			<br></br>
			
			<p>Descritpion de l'élection : </p>
			<Textarea  type="textera" name="Desc" rows=4 cols=60 wrap=physical></Textarea>
			<br></br>
			<input class="btn btn-default btn-lg btn-block" type="submit" value="Valider" name="Valider"class="bouton" />
			
		
		</form>

</div>
</center>

