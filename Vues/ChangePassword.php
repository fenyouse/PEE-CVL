<div class="well center-block" id="changeMDP">
  <h3>Changement de mot de passe</h3>
  <?php
  if ($erreur!="") {
    echo '<p class="bg-warning text-center">';
    echo $erreur;
    echo '</p>';
  }
  ?>
  <form class="form-horizontal" method="post">
    <div class="form-group
    <?php if($erreur!=""){
       echo('has-error');
     }
     ?>
    ">
      <label  for="InputOldPassword" class="control-label">Ancien mot de passe</label>
      <div>
      <input type="password" name="oldMDP" class="form-control" id="oldMDP" placeholder="Old Mot de passe">
      </div>
    </div>
    <div class="form-group
    <?php if($erreur!=""){
       echo('has-error');
     }
     ?>
    ">
      <label  for="InputNewPassword" class="control-label">Nouveaux mot de passe</label>
      <div>
      <input type="password" name="newMDP" class="form-control" id="newMDP" placeholder="Mot de passe">
      </div>
    </div>
    <div class="form-group
    <?php if($erreur!=""){
       echo('has-error');
     }
     ?>
    ">
      <label  for="InputNewPasswordConf" class="control-label">Comfirmer nouveau mot de passe</label>
      <div>
      <input type="password"  name="newMDPbis" class="form-control" id="newMDPbis" placeholder="Mot de passe">
      </div>
    </div>

    <button type="submit" class="btn btn-default">Changer le mot de passe</button>
  </form>
</div>
