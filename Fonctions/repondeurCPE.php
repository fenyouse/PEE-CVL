<?php
//Marie

//redirections
require_once '../Modeles/element.php';
require_once '../Modeles/pluriel.php';
require_once '../Modeles/si.php'; 
require_once '../Modeles/suffrage.php';
require_once '../Modeles/candidat.php';
	
	//récupère le suffrage selectionner
	$codesuff = $_GET['idsuff'];
	//recherche le suffrage
	$ObjSuff = Suffrage::mustFind($codesuff);
	//affiche le tableau des suffrages
	$ObjSuff::getInstances()->displayTable();
	//affiche le tableau des candidats-binomes du suffrage
	$ObjSuff->getCandidats()->displayTable2();
	
	//var_dump($ObjSuff);

	
	sleep(3);
?>
