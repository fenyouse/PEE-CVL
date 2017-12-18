<?php
require_once 'Modeles/electeur.php';

$erreur = "";

if(isset($_POST['login'])){
  $erreur="formulaire vide";
}

if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])){

  $_SESSION['InfoEleve']=Electeur::AuthentificationEleve($_POST["login"],$_POST["mdp"]);
  if ($_SESSION['InfoEleve']!='') {
    $_SESSION['Menu'] = "ChangeMdp";
    header ('Location:index.php');
  }

}

require_once 'Vues/ConnexionEleve.php';
?>
