<?php $db = new MyPdo();
$manager = new CitationManager($db); ?>
<h1> Valider une citation </h1>

<?php if(!isset($_GET['numcit'])&&!isset($_GET['numcitbis'])){ ?>
  <table>
    <tr>
      <th>N° Citation</th>
      <th>Nom de l'enseignant</th>
      <th>Libellé</th>
      <th>Date</th>
    </tr>
    <?php
    $listeCitations=$manager->getListeCitationNonValide();
    foreach ($listeCitations as $citation) {
      ?>
      <tr>
        <td><a href="index.php?page=9&numcit=<?php echo $citation->getCitNum();?>"><?php echo $citation->getCitNum(); ?></a></td>
        <td><?php echo $citation->getCitNomPers(); ?></td>
        <td><?php echo $citation->getCitLibelle(); ?></td>
        <td><?php echo $citation->getCitDate(); ?></td>
      </tr>
    <?php }
    ?>


  </table>
<?php }
else if(!isset($_GET['numcitbis'])){
  $numeroCitation=$_GET['numcit'];

  ?>
  <p>Vous êtes en train de valider la citation suivante :</p>
  <form method="post" action="index.php?page=9&numcitbis=<?php echo $numeroCitation?>">
    <p> <b> Citation : </b> "<?php echo $manager->getLibelle($numeroCitation); ?>"  de <?php echo $manager->getNomPers($numeroCitation); ?> </p>
    <button type="submit"> Valider </button>
  </form>
  <?php
}else{
  $numeroCitation=$_GET['numcitbis'];
  $manager->validerCitation($numeroCitation);
  ?>
  <p> La citation a bien été validée </p>
  <?php
} ?>
