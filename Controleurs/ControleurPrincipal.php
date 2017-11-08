<?php


  if(isset($_POST["login"],$_POST["mdp"])){
      $_SESSION['authe']= $MonBeauSI->authentification($_POST["login"],$_POST["mdp"]);

  }else{
      if(!isset($_SESSION['authe'])){
          $_SESSION['authe']=0;
      }
  }

  if(isset($_POST["loginAdmin"],$_POST["mdpAdmin"])){
      $_SESSION['authe']= $MonBeauSI->authentificationAdmin($_POST["loginAdmin"],$_POST["mdpAdmin"]);

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
    require_once 'Vues/MenuCo.php';
  }
  if(isset($_POST["ConnexionAdmin"])) {
    require_once 'Vues/ConnexionAdmin.php';
  }
  if(isset($_POST["ConnexionEleve"])) {
    require_once 'Vues/ConnexionEleve.php';
  }
  if(isset($_POST["ChangeMdp"])) {
    require_once 'Vues/ChangePassword.php';
  }

  require_once 'Vues/footer.php';

?>
