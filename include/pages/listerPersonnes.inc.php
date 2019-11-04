
	<?php $db = new MyPdo();
	$manager=new PersonneManager($db);?>
	<h1>Liste des personnes enregistrées</h1>
		<table>
		<tr>
			<th>Numéro</th>
			<th>Nom</th>
			<th>Prenom</th>
		</tr>
		<?php
		$listeNom=$manager->getList();
		$nombrePersonnes=$manager->getNombre()->nombrePersonne ;

		echo "Actuellement ".$nombrePersonnes." personnes enregistrées";

		foreach ($listeNom as $personne) {
			?>

			<tr>
				<td><a href="index.php?page=2&nump=<?php echo $personne->getNumPer();?>"</a> <?php echo $personne->getNumPer();?> </td>
				<td><?php echo $personne->getNomPer();?></td>
				<td><?php echo $personne->getPrenomPer();?></td>
			</tr>
			<?php
		}
		 ?>
	 </table>
	 <?php
	 if(isset($_GET["nump"])){

		 if($manager->estEtudiant($_GET["nump"])){
			 ?>

			 <table>
			 <tr>
				 <th>Prénom</th>
				 <th>Mail</th>
				 <th>Tel</th>
				 <th>Departement</th>
				 <th>Ville</th>
			 </tr>
			 <?php
			 $personne_prenom=$manager->getPrenomPer($_GET["nump"])->prenom;
			 $personne_mail=$manager->getMailPer($_GET["nump"])->mail;
			 $personne_tel=$manager->getTelPer($_GET["nump"])->tel;

			 	$personne_dep=$manager->getDepPer($_GET["nump"])->dep;
			 	$personne_vil=$manager->getVilPer($_GET["nump"])->vil;


			 ?>

			 <tr>
				 <td><?php echo $personne_prenom?></td>
				 <td><?php echo $personne_mail?></td>
				 <td><?php echo $personne_tel?></td>
				 <td><?php echo $personne_dep?></td>
				 <td><?php echo $personne_vil?></td>
			 </tr>
		 </table>
		 <?php
		}

	 else{
		?>

		<table>
		<tr>
			<th>Prénom</th>
			<th>Mail</th>
			<th>Tel</th>
			<th>Tel Pro</th>
			<th>Fonction</th>
		</tr>
		<?php

		$personne_prenom=$manager->getPrenomPer($_GET["nump"])->prenom;
		$personne_mail=$manager->getMailPer($_GET["nump"])->mail;
		$personne_tel=$manager->getTelPer($_GET["nump"])->tel;
		$personne_telPro=$manager->getTelPro($_GET["nump"])->telPro;
		$personne_fonction=$manager->getFonction($_GET["nump"])->fonction;
		?>
		<tr>
			<td><?php echo $personne_prenom?></td>
			<td><?php echo $personne_mail?></td>
			<td><?php echo $personne_tel?></td>
			<td><?php echo $personne_telPro?></td>
			<td><?php echo $personne_fonction?></td>
		</tr>
	</table>
		<?php
	 }
 }
	 ?>
