<?php

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

  if (!isset($_SESSION['Menu'])) {
    $_SESSION['Menu']="";
  }

  if($_SESSION['Menu']=="MenuCo"||(isset($_POST["Connexion"]))) {
    //$_SESSION['Menu'] = "MenuCo";
    require_once 'Vues/MenuCo.php';
  }
  if(isset($_POST["ConnexionAdmin"])||$_SESSION['Menu']=="CoAdmin") {
    $_SESSION['Menu'] = "CoAdmin";
    require_once 'Controleurs/ControleurCoAdmin.php';
  }
  if(isset($_POST["ConnexionEleve"])||$_SESSION['Menu']=="CoEleve") {
    $_SESSION['Menu'] = "CoEleve";
    require_once 'Controleurs/ControleurCoEleve.php';
  }
  if(isset($_POST["ChangeMdp"])||$_SESSION['Menu']=="ChangeMdp") {
    $_SESSION['Menu'] = "ChangeMdp";
    require_once 'Controleurs/ControleurChangeMdp.php';
  }

  require_once 'Vues/footer.php';

?>
