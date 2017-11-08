<?php


if(isset($_POST["login"],$_POST["mdp"])){
    $_SESSION['authe']= $MonBeauSI->authentification($_POST["login"],$_POST["mdp"]);

}else{
    if(!isset($_SESSION['authe'])){
        $_SESSION['authe']=0;
    }
}


  if(isset($_POST["Accueil"])) {
    /*
    if ($_SESSION['idUser']==null) {
      require_once 'Controleurs/ControleurAccueilNonConnecter.php';
    }else {
    */
      require_once 'Controleurs/ControleurAccueil.php';
    /*
    }
    */

  }

  if(isset($_POST["Connexion"])) {
    require_once 'Vues/Connexion.php';
  }

  if(isset($_POST["ChangeMdp"])) {
    require_once 'Vues/ChangePassword.php';
  }

  require_once 'Vues/footer.php';

?>
