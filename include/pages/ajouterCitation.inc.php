<h1>Ajouter une citation</h1>
<?php
if(isset($_POST['enseignant'])&&isset($_POST['date'])&&isset($_POST['citation'])){
  echo $_POST['citation'];
  echo $_POST['date'];
  echo $_POST['citation'];
}
else{

  ?>
  <form method="POST">
    <p> Enseignant :  <input type="text" id="enseignant" name="enseignant"  value="<?php if(isset($_POST['enseignant'])){ echo $_POST['enseignant'];     }?>"> </p>
    <p> Date Citation :  <input type="date" id="date" name="date"  value="<?php if(isset($_POST['date'])){ echo $_POST['date'];     }?>"> </p>
    <p> Citation :  <input type="text" id="citation" name="citation"  value="<?php if(isset($_POST['citation'])){ echo $_POST['citation'];     }?>"> </p>
    <button type="submit" > Valider </button>
  </form>
<?php
}
?>
