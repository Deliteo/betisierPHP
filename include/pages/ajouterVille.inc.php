<?php $db = new MyPdo();
$manager=new VilleManager($db);
$ville=new Ville()?>
<html>
<h1>Ajouter une ville</h1>

<?php
  if(isset($_POST["name"])){
    $ville->setNomVille($_POST["name"]);
    $manager->ajouterVille($ville);
    echo 'La ville '.$_POST["name"].' a été ajouté';
  }
  else{


    ?>

<form method="post" >
<p> Nom :  <input type="text" id="name" name="name" > </p>

<button type="submit" > Valider </button>

<?php

}
?>
</form>
</html>
