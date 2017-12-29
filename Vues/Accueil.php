<div id="Acceuildesc" class="well center-block text-center" >
  <?php
  $lessuffrages = new Suffrages();
  $lessuffrages->remplir("SDateDeb < NOW()",$order=null);

  if ($lessuffrages->getNombre()==0) {
    echo "Il n'y a pas de suffrage en cours";
  }else {
    echo "<p><b>Date de début : </b>";
    echo Suffrage::getInstances()->getFirst()->getSDateDeb();
    echo "</p><p><b>Date de fin : </b>";
    echo Suffrage::getInstances()->getFirst()->getSDateFin();
    echo "</p><p><b>Description : </b>";
    echo Suffrage::getInstances()->getFirst()->getSDescription();
    echo "</p>";
  }

  ?>
</div>
