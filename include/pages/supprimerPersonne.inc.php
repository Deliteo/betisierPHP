<?php $db = new MyPdo();
$manager=new PersonneManager($db);
$managerEtudiant=new EtudiantManager($db);
$managerSalarie=new SalarieManager($db);
$managerCitation=new CitationManager($db);

?>
<h1>Supprimer personne</h1>

<?php
if(!isset($_POST['personne'])){

if(isset($_POST['supprimer'])&&$_POST['supprimer']=="oui"){

	if($manager->estEtudiant($_SESSION['numPersonne'])){
		$managerCitation->supprimerCitationEtu($_SESSION['numPersonne']);
		$managerEtudiant->supprimerEtudiant($_SESSION['numPersonne']);
	}
	else{
		$managerCitation->supprimerCitationSal($_SESSION['numPersonne']);
		$managerSalarie->supprimerSalarie($_SESSION['numPersonne']);
	}

	$manager->supprimerPersonne($_SESSION['numPersonne']);
	echo "La personne a été supprimée";

}


$listeLogin=$manager->listePersonne();
?>


	<p>Choisissez la personne à supprimer :</p>
	<form method="post" action="#">
	<select id="suppPers" name="personne"><?php
	foreach ($listeLogin as $donnees=>$listeLogin) :?>
				<option value="<?php echo $listeLogin['log'] ?>" ><?php echo $listeLogin['log'] ?></option>
		<?php
	endforeach ?></select><br>
	
	</select>
	<button type="submit" > Valider </button>
	</form>
	 <?php

}
else{
	$_SESSION['numPersonne']=$manager->getNumPer($_POST['personne'])->num;
	echo "Voulez vous vraiment supprimer ".$_POST['personne']." ?";

	if($manager->estEtudiant($_SESSION['numPersonne'])){
		?>
		<form method="post" >

		<input type="radio" name="supprimer" value="oui"   checked > oui
		<input type="radio" name="supprimer" value="non"  > non <br>
		<button type="submit" >   Valider </button>
			</form>
		<?php
		}
		else{
		?>

		<form method="post" >

			<input type="radio" name="supprimer" value="oui" checked  > oui
			<input type="radio" name="supprimer" value="non"  > non<br>
			<button type="submit" >  Valider </button>

		</form>

		<?php
	}

}

?>
