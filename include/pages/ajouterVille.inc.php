<?php $db = new MyPdo();
$manager=new VilleManager($db);
$ville=new Ville()?>
<h1>Ajouter une ville</h1>

<?php
  if(isset($_POST["name"])){
    $ville->setNomVille($_POST["name"]);
    $manager->ajouterVille($ville);
    echo '<img class="valid" src="image/valid.png" alt="valid" title="valid"/> La ville '.$_POST["name"].' a été ajoutée';
  }
  else{
    ?>

<form method="post" >
<p> Nom :  <input type="text" id="name" name="name" > </p>

<button type="submit" > Valider </button>
</form>
<?php
}
?>

