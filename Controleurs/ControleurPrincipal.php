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
    if ($electeur->getEVote()!=Null) {
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

    if (isset($_SESSION['InfoEleve'])) {
        $_SESSION['Menu']="Vote";
        require_once 'Controleurs/ControleurVote.php';
    }else {
      if (isset($_SESSION['InfoAdmin'])) {
          $admin = Admin::mustFind($_SESSION['InfoAdmin']);
          if ($admin->getADroit()=="TECH") {
              $_SESSION['Menu']="AccueilTECH";
              require_once 'Controleurs/ControleurTECH.php';
          }else {
              if ($admin->getADroit()=="CPE") {
                  $_SESSION['Menu']="AccueilCPE";
                  require_once 'Controleurs/ControleurCPE.php';
              }
          }
      }else {
            $_SESSION['Menu']="Accueil";
            require_once 'Controleurs/ControleurAccueil.php';
        }
    }
  }

  //page par default
  if (!isset($_SESSION['Menu'])) {
    $_SESSION['Menu']="Accueil";
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
    case "Vote":
            require_once 'Controleurs/ControleurVote.php';
            break;
    case "Accueil":
            require_once 'Controleurs/ControleurAccueil.php';
            break;



    }





?>
