<?php $db = new MyPdo();
$manager=new VilleManager($db);?>
	<h1>Liste des villes</h1>
	<table>
	<tr>
		<th>Numéro</th>
		<th>Nom</th>
	</tr>
	<?php
	$listeVilles=$manager->getList();
	$nombreVilles=$manager->getNombre()->nombreVilles ;

	echo "Actuellement ".$nombreVilles." villes sont enregistrées";
	foreach ($listeVilles as $ville) {
		?>

		<tr>
			<td><?php echo $ville->getNumVille();?></td>
			<td><?php echo $ville->getNomVille();?></td>
		</tr>
		<?php
	}
	 ?>
 </table>
