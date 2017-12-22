<?php
require_once 'Modeles/suffrage.php';
require_once 'Modeles/Candidat.php';
require_once 'Modeles/electeur.php';

	$erreur = "";

	// newref, newdes, newprix, newstock,  CodeCateg, Oldref
	function SQLUpdateVoteElec ($idEleve) {
		$date = NOW();
		$tmp = 'UPDATE elect SET EVote=FROM_UNIXTIME('.$date.') WHERE EId='.$idEleve.';';
		return SI::getSI()->SGBDgetPrepareExecute($tmp);
	}

		// newref, newdes, newprix, newstock,  CodeCateg, Oldref
 	function SQLUpdateVoteCandid (array $tableau) {
		$idModif = "";
		foreach($tableau as $idCandid){
			$idModif .= $idCandid." OR ";
		}
		$idModif = substr($idModif, 0, -3);
		$tmp = 'UPDATE candid SET CNbV=CNbV+1 WHERE CId='.$idModif.';';
		return SI::getSI()->SGBDgetPrepareExecute($tmp);
	}

	function SQLUpdateSuffrageBlanc ($idSuffrage) {
		$tmp = 'UPDATE suffrage SET SBlanc=SBlanc+1 WHERE SId='.$idSuffrage.';';
		return SI::getSI()->SGBDgetPrepareExecute($tmp);
	}

	function SQLUpdateSuffrageNul ($idSuffrage) {
		$tmp = 'UPDATE suffrage SET SNuls=SNuls+1 WHERE SId='.$idSuffrage.';';
		return SI::getSI()->SGBDgetPrepareExecute($tmp);
	}

	if (isset($_POST['tabCandid'])) {
		$votes = $_POST['tabCandid'];
		if(empty($votes)){
			SQLUpdateSuffrage($_POST['idSuffrage']);
			SQLUpdateVoteElec($_POST['idElec']);
		}
		else{
			SQLUpdateVoteElec($_POST['idElec']);
			SQLUpdateVoteCandid($votes); //N'est pas géré le vote blanc en plus d'autres votes
		}
	}

	require_once 'Vues/Vote.php';


 ?>
