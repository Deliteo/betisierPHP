<?php $db = new MyPdo();
$manager=new VilleManager($db);?>
<h1>Liste des villes</h1>
<?php
$nombreVilles=$manager->getNombre()->nombreVilles ;

echo "Actuellement ".$nombreVilles." villes sont enregistrées";
?>
	<table>
	<tr>
		<th>Numéro</th>
		<th>Nom</th>
	</tr>
	<?php
	$listeVilles=$manager->getList();
	
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
