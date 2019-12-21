<?php $db = new MyPdo();
$manager = new CitationManager($db);
$voteManager = new VoteManager($db); ?>
	<h1>Liste des citations déposées</h1>

<?php
$nombreCitation=$manager->getNombre()->nombreCitation ;
echo "Actuellement ".$nombreCitation." citation(s) enregistrée(s)";
 ?>
<table>
<tr>
	<th>Nom de l'enseignant</th>
	<th>Libellé</th>
	<th>Date</th>
	<th>Moyenne des notes</th>
	<?php if(!empty($_SESSION['num'])){
		?>
	<th> Noter </th>
	<?php		}  ?>
</tr>
<?php
$listeCitations=$manager->getList();
foreach ($listeCitations as $citation) {
	?>
	<tr>
		<td><?php echo $citation->getCitNomPers(); ?></td>
    <td><?php echo $citation->getCitLibelle(); ?></td>
    <td><?php echo $citation->getCitDate(); ?></td>
		<td><?php
			$numCit=$citation->getCitNum();
			$moyenne=$voteManager->getMoyenneVote($numCit);
			if(empty($moyenne)){
				echo 0;
			}else{
				echo $moyenne;
			}
		//if($voteManager->getMoyenneVote($citation->getCitNum())->moyVot!=NULL){
?></td>
		<?php if(!empty($_SESSION['num'])){
			?>
		<td>
			<?php
			$perm=$manager->getPermVote($_SESSION['num'],$citation->getCitNum());
				if($perm==true){
					?>
					<a href="index.php?page=15&numcit=<?php echo $citation->getCitNum();?>"><img class="iconeNoter" src="image/modifier.png" alt="imgModifier" title="Noter"/></a>
					<?php
				} else {

					?>
					<img class="iconeNoter" src="image/erreur.png" alt="imgErreur" title="PasNoter"/>
					<?php
				}

			?>
		</td>
	<?php		}  ?>
	</tr>
<?php }
?>


</table>
