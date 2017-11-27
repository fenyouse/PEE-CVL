<?php

if(isset($_POST["loginAdmin"],$_POST["mdpAdmin"])){
    $_SESSION['authe']= $MonBeauSI->authentificationAdmin($_POST["loginAdmin"],$_POST["mdpAdmin"]);
    echo '<script type="text/javascript">windows.alert("'.$_SESSION['authe'].'");</script>';
}else{
    $_SESSION['authe']=0;
    echo '<script type="text/javascript">windows.alert("'.$_SESSION['authe'].'");</script>';
}

require_once 'Vues/ConnexionAdmin.php';


 ?>
