<?php

require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';
require_once 'Modeles/electeur.php';
require_once 'Modeles/admin.php';

  if(isset($_POST["Déconnexion"])) {
    Electeur::PostLogoutEleve($_SESSION['InfoEleve']);
    session_destroy();
    header ('Location:index.php');
  }
  if (isset($_SESSION['InfoEleve'])) {
    $electeur= Electeur::mustFind($_SESSION['InfoEleve']);
    if ($electeur->getEVote()==Null) {
      Electeur::PostLogoutEleve($_SESSION['InfoEleve']);
      session_destroy();
      header ('Location:index.php');
    }
  }

  if(isset($_POST["Connexion"])) {
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

  //bouton Accueil du Menu
  if(isset($_POST["Accueil"])) {
    $_SESSION['Menu']="";

    if (isset($_SESSION['InfoEleve'])) {
        require_once 'Controleurs/ControleurVote.php';
    }else {
      if (isset($_SESSION['InfoAdmin'])) {
          $admin = Admin::mustFind($_SESSION['InfoAdmin']);
          if ($admin->getADroit()=="TECH") {
              require_once 'Controleurs/ControleurTECH.php';
          }else {
              if ($admin->getADroit()=="CPE") {
                  require_once 'Controleurs/ControleurCPE.php';
              }
          }
      }else {
            require_once 'Controleurs/ControleurAccueil.php';
        }
    }
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
    case "AccueilCPE":
            require_once 'Controleurs/ControleurCPE.php';
            break;
    case "AccueilTECH":
            require_once 'Controleurs/ControleurTECH.php';
            break;


    }





?>
