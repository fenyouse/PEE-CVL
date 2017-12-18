<center>
</br>
</br>
  <form method="post">
    <button  class="btn btn-default" name="Accueil" >Accueil</button >
<?php



if (isset($_SESSION['InfoEleve'])||isset($_SESSION['InfoAdmin'])) {
    echo ('<button  class="btn btn-default" name="Déconnexion" >Déconnexion</button >');



}else {
  if ((!isset($_POST['Connexion']))&&(!isset($_POST["ConnexionEleve"]))&&(!isset($_POST["ConnexionAdmin"]))&&(!isset($_POST["loginAdmin"]))&&(!isset($_POST["login"]))){
    echo('<button  class="btn btn-default" name="Connexion" >Connexion</button >');



  }
}

?>

  </form>
</br>
</br>
</center>
