
	<?php $db = new MyPdo();
	$managerVille=new VilleManager($db);
  $ville=new Ville($db);
	?>
	<h1>Modifier une ville </h1>
<?php

if(!isset($_POST['ville'])){

if(isset($_POST['villenew'])){
  $managerVille->modifierVille($_POST['villenew'],$_SESSION['numVille']);
  echo "La ville a été modifiée";
}

$listeVille=$managerVille->listeVille();
?>
  <form method="post" action="#">
  <select name="ville"><?php
  foreach ($listeVille as $donnees=>$listeVille) :?>
        <option value="<?php echo $listeVille['ville'] ?>" ><?php echo $listeVille['ville'] ?></option>
    <?php
  endforeach ?></select><br>
  <button type="submit" > Valider </button>
  </select>

   <?php
}

else{
?>
  <form method="post" >
  <?php
$_SESSION['numVille']=$managerVille->getNumVil($_POST['ville'])->num;
echo "Quel est le nouveau nom de ".$_POST['ville']." ?";?>
<p>   <input type="text" id="villenew" name="villenew" value="<?php echo $_POST['ville'];?>"> </p>
<button type="submit" >   Valider </button>
  </form>
<?php
}

 ?>
