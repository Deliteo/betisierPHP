<?php $db = new MyPdo();
$manager = new CitationManager($db);
$managerVote = new VoteManager($db);
$numeroCitation = $_GET['numcit'];?>
<h1> Noter une citation</h1>

<?php
if(empty($_POST['note'])){
  ?>
  <form method="post" action="#">
    <p> <b> Citation : </b> "<?php echo $manager->getLibelle($numeroCitation); ?>"  de <?php echo $manager->getNomPers($numeroCitation); ?> </p>
    <p> <b> Note : </b>  <input type="text" id="note" name="note" size="1">
      <button type="submit"> Valider </button>

    </form>
    <?php
  }
  else{
    $note=$_POST['note'];
    $managerVote->voterCitation($numeroCitation,$_SESSION['num'],$note);
    ?>
    <p> Votre vote a bien été enregistré <br>
      <br>
      Redirection automatique dans 2 secondes.
    </p>
    <meta http-equiv="refresh" content="2;url=index.php?page=6"/>
    <?php
  }
  ?>
