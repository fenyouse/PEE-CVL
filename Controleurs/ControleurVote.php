<?php

	// newref, newdes, newprix, newstock,  CodeCateg, Oldref
	function SQLUpdateVoteElec ($idEleve) {
		$date = time();
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

	function SQLUpdateSuffrage ($idSuffrage) {
		$tmp = 'UPDATE suffrage SET SBlanc=SBlanc+1 WHERE SId='.$idSuffrage.';';
		return SI::getSI()->SGBDgetPrepareExecute($tmp);
	}

	// newref, newdes, newprix, newstock,  newcodecat
	function SQLInsert (array $tableau) {
		$tmp = 'INSERT INTO  produit (PDTReference, PDTDesignation, PDTPrix, PDTStock, PDTIdCAT) VALUES (?, ?, ?, ?, ?)';
		return SI::getSI()->SGBDexecuteQuery($tmp, $tableau);
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
