<?php


if(isset($_POST["login"],$_POST["mdp"])){
    $_SESSION['authe']= $MonBeauSI->authentification($_POST["login"],$_POST["mdp"]);

}else{
    if(!isset($_SESSION['authe'])){
        $_SESSION['authe']=0;
    }
}

  $Page ="";

  if (isset($_GET["vu"])) {
    $Page = $_GET["vu"];
  }
  if ( $Page == "Connexion") {
    require_once 'Vues/Connexion.php';
  }

  if ( $Page == "Accueil") {
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

  if ( $Page == "ChangeMdp") {
    require_once 'Vues/ChangePassword.php';
  }
  require_once 'Vues/footer.php';

?>
