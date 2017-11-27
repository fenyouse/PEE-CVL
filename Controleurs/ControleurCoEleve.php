<?php

if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])){
    $test="test";
    var_dump($test);
    $_SESSION['authe']= $MonBeauSI->AuthentificationEleve($_POST["login"],$_POST["mdp"]);

    if ($MonBeauSI->TestMdpCrypte($_POST["login"])<6){
      $_SESSION['test']=="ChangeMdp";
    }else{
      //Accueil eleve
      $_SESSION['test']=="CoEleve";
    }
}else{
    if(!isset($_SESSION['authe'])){
        $_SESSION['authe']=0;
    }
}



require_once 'Vues/ConnexionEleve.php'; ?>
