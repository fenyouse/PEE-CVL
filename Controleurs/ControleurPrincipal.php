<?php

require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';
require_once 'Modeles/electeur.php';

  if(isset($_POST["Déconnexion"])) {
    Electeur::PostLogoutEleve($_SESSION['InfoEleve']);
    session_destroy();
    header ('Location:index.php');
  }

  //si il un utilisateur est connecter
  if (isset($_SESSION['InfoEleve'])) {

  }
  //bouton Accueil du Menu
  if(isset($_POST["Accueil"])) {
    $_SESSION['Menu']="Accueil";
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
        require_once 'Controleurs/ControleurCoAdmin.php';
        break;
    case "CoEleve":
        require_once 'Controleurs/ControleurCoEleve.php';
        break;
    case "ChangeMdp":
        require_once 'Controleurs/ControleurChangeMdp.php';
        break;
    case "Accueil":
        if (isset($_SESSION['InfoEleve'])) {
          require_once 'Controleurs/ControleurAccueil.php';
        }else {
          require_once 'Controleurs/ControleurAcceuilNonConnecter.php';
        }
        break;
    case "AccueilCPE":
            require_once 'Controleurs/ControleurCPE.php';
            break;
    case "AccueilTECH":
            require_once 'Controleurs/ControleurTECH.php';
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
