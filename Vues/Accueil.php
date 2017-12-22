<div class="well center-block text-center">
  <?php
  $lessuffrages = new Suffrages();
  $lessuffrages->remplir("SDateDeb < NOW()",$order=null);

  if ($lessuffrages->getNombre()==0) {
    echo "Il n'y a pas de suffrage en cours";
  }else {
    Suffrage::getInstances()->displayTable();
  }

  ?>
</div>
