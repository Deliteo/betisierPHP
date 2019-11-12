<?php $db = new MyPdo();
$manager=new CitationManager($db);?>
<h1>Ajouter une citation</h1>
<?php
if(!empty($_POST['enseignant'])&&!empty($_POST['date'])&&!empty($_POST['citation'])){
  echo $_POST['citation'];
  echo $_POST['date'];
  echo $_POST['citation'];
  echo $_SESSION['num'];
}
else{

  ?>
  <form method="post" action="#">
   <?php echo "Enseignant : ";?>
  <select name="enseignant"><?php
  	$listeEnseignant=$manager->getListEnseignant();
    print_r($listeEnseignant);
    while ($donnees = $listeEnseignant->fetch()){?>
          <option name="enseignant" id="enseignant" value="<?php echo $donnees['per_nom'] ?>" ><?php echo $donnees['per_nom'] ?></option>
      <?php
    }?></select><br>
    <p> Date Citation :  <input type="date" id="date" name="date"  value="<?php if(isset($_POST['date'])){ echo $_POST['date']; 	}?>"> </p>
    <p> Citation :  <input type="text" id="citation" name="citation"  value="<?php if(isset($_POST['citation'])){ echo $_POST['citation']; 	}?>"> </p>
    <button type="submit" > Valider </button>
  </form>
<?php
}
?>
