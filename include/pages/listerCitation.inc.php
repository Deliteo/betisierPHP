<?php $db = new MyPdo();
$manager = new CitationManager($db); ?>
	<h1>Liste des citations déposées</h1>
<table>
<tr>
	<th>Nom de l'enseignant</th>
	<th>Libellé</th>
	<th>Date</th>
	<th>Moyenne des notes</th>
</tr>
<?php
$listeCitations=$manager->getList();
foreach ($listeCitations as $citation) {
	?>
	<tr>
		<td><?php echo $citation->getCitNomPers(); ?></td>
    <td><?php echo $citation->getCitLibelle(); ?></td>
    <td><?php echo $citation->getCitDate(); ?></td>
		<td><?php echo $citation->getCitNote(); ?></td>

	</tr>
<?php }
?>


</table>