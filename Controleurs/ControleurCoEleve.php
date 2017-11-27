<?php
$erreur = "";

if(isset($_POST['login'])){
  $erreur="formulaire vide";
}

if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])){
    $_SESSION['authe']= $MonBeauSI->AuthentificationEleve($_POST["login"],$_POST["mdp"]);
    if ($_SESSION['authe']=1){
      if ($MonBeauSI->TestMdpCrypte($_POST["login"])<6){
        $_SESSION['InfoEleve']=$MonBeauSI->IdentificationEleve($_POST["login"],$_POST["mdp"]);
        $_SESSION['Menu']=="ChangeMdp";
      }else{
        //Accueil eleve
      }
    }else{
      $erreur="mauvais login ou/et mdp";
    }
}else{
    if(!isset($_SESSION['authe'])){
        $_SESSION['authe']=0;
    }
}




require_once 'Vues/ConnexionEleve.php'; ?>
