<?php
require_once '../Modeles/element.php';
require_once '../Modeles/pluriel.php';
require_once '../Modeles/si.php'; 
require_once '../Modeles/suffrage.php';
require_once '../Modeles/candidat.php';
	
	$codesuff = $_GET['idsuff'];
	$ObjSuff = Suffrage::mustFind($codesuff);
	$ObjSuff::getInstances()->displayTable();
	$ObjSuff->getCandidats()->displayTable2();
	
	//var_dump($ObjSuff);

	
	sleep(3);
?>
