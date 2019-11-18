<?php $db = new MyPdo();
$manager = new CitationManager($db);
$numeroCitation = $_GET['numcit'];?>
<h1> Noter une citation</h1>

<form method="post" action="#">
<p> <b> Citation : </b> "<?php echo $manager->getLibelle($numeroCitation); ?>"  de <?php echo $manager->getNomPers($numeroCitation); ?> </p>
<p> <b> Note : </b>  <input type="text" id="note" name="note">
  <button type="submit"> Valider </button>

</form>
