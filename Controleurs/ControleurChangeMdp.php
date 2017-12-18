<?php
require_once 'Modeles/electeur.php';

$erreur = "";

if(isset($_POST)){
  if (isset($_POST['newMDP']) && isset($_POST['newMDPbis'])) {
    if ($_POST['newMDP']!=$_POST['newMDPbis']) {
      $erreur = "les nouveaux mot de passe ne sont pas les memes ";
    }else {
      if (!empty($_POST['newMDP']) && !empty($_POST['newMDPbis']) && !empty($_POST['oldMDP'])) {
        $login=Electeur::mustFind($_SESSION['InfoEleve'])->getELogin();
        //var_dump($login);
        $update=Electeur::UpdatePassword($login,$_POST['oldMDP'],$_POST['newMDPbis']);
        var_dump($update['pgerror']);
        if ($update['pgerror']==0) {
          $_SESSION['Menu'] = "Accueil";
          header ('Location:index.php');
        }
      } else {
        $erreur ="champs vide";
      }
    }
  }
}



var_dump($erreur);






require_once 'Vues/ChangePassword.php'; ?>
