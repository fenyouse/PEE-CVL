<?php
require_once 'Modeles/electeur.php';

$erreur = "";

if(isset($_POST['login'])){
  $erreur="formulaire vide";
}

if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])){

  $ElecteurTmp = Electeur::AuthentificationEleve($_POST["login"],$_POST["mdp"]);
  //var_dump($ElecteurTmp);
  if ($ElecteurTmp!=null) {

      $electeur= Electeur::mustFind( Electeur::AuthentificationEleve($_POST["login"],$_POST["mdp"])->getEId());

      if ($electeur->getEVote()==Null) {

        if (($electeur->getEDateLogin()<date('Y-m-d H:i:s')+1800)||($electeur->getEModif()==0)) {

          $_SESSION['InfoEleve'] = $ElecteurTmp->getEId();

          //var_dump($electeur);
          if ($electeur!=null) {
            $login = $electeur->getELogin();
            if (!Electeur::TestMdpCrypte($login)){
              $_SESSION['Menu'] = "ChangeMdp";
              header ('Location:index.php');
            }else {
              $_SESSION['Menu']="Vote";
              header ('Location:index.php');
            }
          }
        }else {
          $erreur = "déja connecté";
        }


      }else {
        $erreur = "déja voté";
      }

  }else {
    $erreur="Login ou mot de passe incorrect";
  }



}

require_once 'Vues/ConnexionEleve.php';
?>
