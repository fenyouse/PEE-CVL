<?php
require_once 'Modeles/electeur.php';

$erreur = "";

if(isset($_POST)){
  if (isset($_POST['newMDP']) && isset($_POST['newMDPbis'])) {
    if ($_POST['newMDP']!=$_POST['newMDPbis']) {
      $erreur = "les nouveaux mot de passe ne sont pas identique ";
    }else {
      if (!empty($_POST['newMDP']) && !empty($_POST['newMDPbis']) && !empty($_POST['oldMDP'])) {
        $electeur=Electeur::mustFind($_SESSION['InfoEleve']);
        $login=$electeur->getELogin();
        if ($_POST['oldMDP']!=$electeur->getEPwd()) {
          $erreur = "l'ancien mot de passe ne correspond pas";
        }else {
          //var_dump($login);
          $update=Electeur::UpdatePassword($login,$_POST['oldMDP'],$_POST['newMDPbis']);
          //var_dump($update['pgerror']);
          if ($update['pgerror']==0) {
            $_SESSION['Menu'] = "Accueil";
            header ('Location:index.php');
          }
        }

      } else {
        $erreur ="champs vide";
      }
    }
  }
}



//var_dump($erreur);






require_once 'Vues/ChangePassword.php'; ?>
