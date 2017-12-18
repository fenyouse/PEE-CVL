<?php

require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';

  if(isset($_POST["Déconnexion"])) {
    session_destroy();
  }

  //si il un utilisateur est connecter
  if (isset($_SESSION['InfoEleve'])) {

  }

  if(isset($_POST["Accueil"])) {
    $_SESSION['Menu']="";
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

  switch ($_SESSION['Menu']) {
    case "MenuCo":
        //$_SESSION['Menu'] = "MenuCo";
        require_once 'Vues/MenuCo.php';
        break;
    case "CoAdmin":
        $_SESSION['Menu'] = "CoAdmin";
        require_once 'Controleurs/ControleurCoAdmin.php';
        break;
    case "CoEleve":
        $_SESSION['Menu'] = "CoEleve";
        require_once 'Controleurs/ControleurCoEleve.php';
        break;
    case "ChangeMdp":
        $_SESSION['Menu'] = "ChangeMdp";
        require_once 'Controleurs/ControleurChangeMdp.php';
        break;
}
  if(isset($_POST["Connexion"])) {
    //$_SESSION['Menu'] = "MenuCo";
    require_once 'Vues/MenuCo.php';
  }
  if(isset($_POST["ConnexionAdmin"])){
    $_SESSION['Menu'] = "CoAdmin";
    require_once 'Controleurs/ControleurCoAdmin.php';
  }
  if(isset($_POST["ConnexionEleve"])){
    $_SESSION['Menu'] = "CoEleve";
    require_once 'Controleurs/ControleurCoEleve.php';
  }
  if(isset($_POST["ChangeMdp"])) {
    $_SESSION['Menu'] = "ChangeMdp";
    require_once 'Controleurs/ControleurChangeMdp.php';
  }


  require_once 'Vues/footer.php';

?>
