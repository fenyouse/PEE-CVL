<?php


require_once 'Modeles/admin.php';

$erreur = "";

if(isset($_POST['loginAdmin'])){
  $erreur="formulaire vide";
}

if(isset($_POST) && !empty($_POST['loginAdmin']) && !empty($_POST['mdpAdmin'])){

  $AdminTmp = Admin::AuthentificationAdmin($_POST["loginAdmin"],$_POST["mdpAdmin"]);
  if ($AdminTmp!=null) {
      $_SESSION['InfoAdmin'] = $AdminTmp->getAId();

      $admin= Admin::mustFind( Admin::AuthentificationAdmin($_POST["loginAdmin"],$_POST["mdpAdmin"])->getAId());
      //var_dump($electeur);
      if ($admin!=null) {
        /*
        $login = $admin->getALogin();
        if (!Admin::TestMdpCrypte($login)){
          $_SESSION['Menu'] = "ChangeMdp";
          header ('Location:index.php');
        }else {
          */
          if ($admin->getADroit()=='TECH') {
            $_SESSION['Menu'] = "AccueilTECH";
            header ('Location:index.php');
          }else {
            $_SESSION['Menu'] = "AccueilCPE";
            header ('Location:index.php');
          }

        }

    //  }
  }else {
    $erreur="Login ou mot de passe incorrect";
  }

}







require_once 'Vues/ConnexionAdmin.php';?>
