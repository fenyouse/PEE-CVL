<?php
require_once 'Modeles/electeur.php';

$erreur = "";

if(isset($_POST['login'])){
  $erreur="formulaire vide";
}

if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])){

  $ElecteurTmp = Electeur::AuthentificationEleve($_POST["login"],$_POST["mdp"]);
  if ($ElecteurTmp!=null) {
      $_SESSION['InfoEleve'] = $ElecteurTmp->getEId();

      $electeur= Electeur::mustFind( Electeur::AuthentificationEleve($_POST["login"],$_POST["mdp"])->getEId());
      //var_dump($electeur);
      if ($electeur!=null) {
        $login = $electeur->getELogin();
        if (!Electeur::TestMdpCrypte($login)){
          $_SESSION['Menu'] = "ChangeMdp";
          header ('Location:index.php');
        }else {
          $_SESSION['Menu'] = "Accueil";
          header ('Location:index.php');
        }

      }
  }



}

require_once 'Vues/ConnexionEleve.php';
?>
