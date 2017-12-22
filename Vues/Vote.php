

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

<script src="js/jquery-3.2.1.min.js"></script>

<center>
<div class="well center-block" style="max-width:500px;margin-top:100px">
		<?php
		if ($erreur!="") {
			echo '<p class="bg-warning text-center">';
			echo $erreur;
			echo '</p>';
		}
		?>
		<form method="post" class="form-inline" action="index.php" onsubmit="return confirmation();">

			<h4>Selectionner les candidats que vous souhaitez élire : </h4>
			<br></br>
			<?php


			//Si un seul suffrage, selectionne le premier element du tableau
			//pour lequel la date de fin est posterieur a la date actuelle
			$lesSuffrage = new Suffrages();
			$lesSuffrage->remplir("SDateFin > NOW()", null);

			//Affecte aux candidats la valeur de la clé étrangère Suffrage
			$lesCandidats = new Candidats();
			$lesCandidats->remplir("CIdSuffrage =".$lesSuffrage->getFirst()->getSId(), null);

			foreach($lesCandidats->getArray() as $unCandid){
				echo '<input type="checkbox" name="tabCandid[]" value="'.$unCandid->getEleve()->getEId().'">
				<label for="'.$unCandid->getEleve()->getEId().'">
    			'.$unCandid->getEleve()->getEPrenom().' '.$unCandid->getEleve()->getENom().'
 				et '.$unCandid->getBinome()->getEPrenom().' '.$unCandid->getBinome()->getENom().' </label>';
 				echo '</br>';
			}
			?>
			<input type="checkbox" name="SBlanc" value="Blanc">

			<input type="hidden" name="idElec" value="<?php echo $_SESSION['InfoEleve'];?>">
			<input type="hidden" name="idSuffrage" value="<?php echo $lesSuffrage->getFirst()->getSId();?>">
			<label for="Blanc"> Voter blanc </label>
			</br>
			<input type="submit" name="VoteSubmit" text="Valider le(s) vote(s)" disabled>


		</form>

<script>

function confirmation(){
    return confirm("Êtes-vous sur de votre choix de vote ?");
}

$( document ).ready(function() {
    console.log( "ready!" );
});

$('input[name="SBlanc"]').change(function(){
	if($('input[name="SBlanc"]:checked').length > 0 || $('input[name="tabCandid[]"]:checked').length > 0){
		$('input[name="VoteSubmit"]').prop('disabled', false);
	}
	else {
		$('input[name="VoteSubmit"]').prop('disabled', true);
	}
});

$('input[name="tabCandid[]"]').change(function(){
	if($('input[name="SBlanc"]:checked').length > 0 || $('input[name="tabCandid[]"]:checked').length > 0){
		$('input[name="VoteSubmit"]').prop('disabled', false);
	}
	else {
		$('input[name="VoteSubmit"]').prop('disabled', true);
	}
});
</script>

</div>
</center>
