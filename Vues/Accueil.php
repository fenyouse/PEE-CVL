<div class="well center-block">
  <?php
  $lessuffrages = new Suffrages();
  $lessuffrages->remplir("SDateDeb > NOW()",$order=null);

  Suffrage::getInstances()->displayTable();
  ?>
</div>
