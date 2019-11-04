<?php $db = new MyPdo();
$manager=new PersonneManager($db);?>
<html>
	<h1>Ajouter une personne</h1>

<?php
  if(!empty($_POST["nom"])&&!empty($_POST["prenom"])&&!empty($_POST["tel"])&&!empty($_POST["mail"])&&!empty($_POST["login"])&&!empty($_POST["motDePasse"])){

	  $manager->ajouterPersonne($_POST["nom"],$_POST["prenom"],$_POST["tel"],$_POST["mail"],$_POST["login"],$_POST["motDePasse"]);
		$listeDiv=$manager->listeDivision();

		echo "Année : ";

		?><form method="post" action="#">
		<select name="annee"><?php
		while ($donnees = $listeDiv->fetch()){?>

			 		<option name="annee" id="annee" value="<?php echo $donnees['nom_div'] ?>" ><?php echo $donnees['nom_div'] ?></option>
			<?php
		}?></select>
	</form><?php


		$listeDep=$manager->listeDepartement();
		echo "Département : ";?>

		<form method="post" action="#">
			<select name="dep_nom"><?php
			while ($donnees = $listeDep->fetch()){?>
				 		<option value="<?php echo $donnees['nom_dep'] ?>" ><?php echo $donnees['nom_dep'] ?></option>
				<?php
			}?></select>
		</form><?php

		$annee=$_POST["annee"];
		$dep = $_POST["dep_nom"];

			$_POST["per_num"]=$manager->getNumPer($_POST["login"])->num;

?>
		<a href="index.php?page=1&nump=<?php echo $_POST["per_num"]?>&dep=<?php echo $dep?>"><button type="submit" > Valider </button><a>

		<?php


		//echo 'La personne '.$_POST["nom"].' a été ajouté';
  }
  else{



    ?>

<form method="post" >
<p> Nom :  <input type="text" id="nom" name="nom" > </p>
<p> Prenom :  <input type="text" id="prenom" name="prenom" > </p>
<p> Téléphone :  <input type="text" id="tel" name="tel" > </p>
<p> Mail :  <input type="text" id="mail" name="mail" > </p>
<p> Login :  <input type="text" id="login" name="login" > </p>
<p> Mot de passe :  <input type="text" id="motDePasse" name="motDePasse" > </p>

<button type="submit" > Valider </button>

<?php

}
?>
</form>
</html>
