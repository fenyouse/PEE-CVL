<div class="well center-block" id="connexionform">
  <?php
  if ($erreur!="") {
    echo '<p class="bg-warning text-center">';
    echo $erreur;
    echo '</p>';
  }
  ?>
  <form class="form-inline" method="post">
    <h3>Connexion Admin</h3>
    <div class="form-group
    <?php if($erreur!=""){
       echo('has-error');
     }
     ?>
    ">
      <label class="sr-only" for="InputLogin">Login</label>
      <input type="text" class="form-control" name="loginAdmin" id="loginAdmin" placeholder="Login">
    </div>
    <div class="form-group
    <?php if($erreur!=""){
       echo('has-error');
     }
     ?>
    ">
      <label class="sr-only" for="InputPassword">Mot de passe</label>
      <input type="password" class="form-control" name="mdpAdmin" id="mdpAdmin" placeholder="Mot de passe">
    </div>

    <button type="submit" class="btn btn-default">Connecter</button>
  </form>
</div>
