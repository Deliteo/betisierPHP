<?php $db = new MyPdo();
$manager=new CitationManager($db);
$managerPersonne=new PersonneManager($db)?>
<h1>Ajouter une citation</h1>
<?php


if(!empty($_POST['enseignant'])&&!empty($_POST['date'])&&!empty($_POST['citation'])){
  $citation->setCitNomPers($_POST['enseignant']);
  $citation->setCitDate($_POST['date']);
  $citation->setCitLibelle($_POST['citation']);
  $citation->setCitPerNumEtu($_SESSION['num']);

  if($manager->verifierPhrase($citation->getCitLibelle())==NULL){

    $manager->ajouterCitation($citation);

    unset($_POST['enseignant']);unset($_POST['date']);unset($_POST['citation']);
  }
  else{
    $citationDecompose=explode(" ",$_POST['citation']);
    $citation=$_POST['citation'];
    $_POST['citation']="";
    foreach($citationDecompose as $s)
    {
         if($manager->verifierMot($s)!=NULL){
           $_POST['citation'].=' --- ';
         }
         else{
           $_POST['citation'].=$s.' ';
         }
    }
    ?>
    <form method="post" action="#">
     <?php echo "Enseignant : ";?>
    <select name="enseignant" id="enseignant"><?php
     $listeEnseignant=$manager->getListEnseignant();?>


      <?php

      //print_r($listeEnseignant);
      foreach ($listeEnseignant as $donnees) :?>
            <option value ="<?php
            if(isset($_POST['enseignant'])){ echo $_POST['enseignant'];}
            else{echo $donnees->getNumPer();} ?>"><?php
            if(isset($_POST['enseignant'])){echo $managerPersonne->getNomPer($_POST['enseignant'])->nom;}
            else{echo $donnees->getNomPer();} ?></option>
        <?php
      endforeach ?></select>


      <p> Date Citation :  <input type="date" id="date" name="date"  value="<?php if(isset($_POST['date'])){ echo $_POST['date']; 	}?>"> </p>
      <p> Citation :  <input type="text" id="citation" name="citation"  value="<?php if(isset($_POST['citation'])){ echo $_POST['citation']; 	}?>"> </p>
      <?php
      if(!$manager->verifierPhrase($citation)==NULL){
        $citationDecompose=explode(" ",$citation);
        foreach($citationDecompose as $s)
        {
             if($manager->verifierMot($s)!=NULL){
               echo '<img class="erreur" src="image/erreur.png" alt="erreur" title="erreur"/> le mot : <FONT COLOR="red" >'.$s.'</FONT> est interdit<br>';
             }
        }
      }
        ?>
      <button type="submit" > Valider </button>
    </form>

  <?php

  }

}else{


  ?>
  <form method="post" action="#">
   <?php echo "Enseignant : ";?>
  <select name="enseignant" id="enseignant"><?php
  	$listeEnseignant=$manager->getListEnseignant();?>


    <?php

    //print_r($listeEnseignant);
    foreach ($listeEnseignant as $donnees) :?>
          <option value ="<?php
          if(isset($_POST['enseignant'])){ echo $_POST['enseignant'];}
          else{echo $donnees->getNumPer();} ?>"><?php
          if(isset($_POST['enseignant'])){echo $managerPersonne->getNomPer($_POST['enseignant'])->nom;}
          else{echo $donnees->getNomPer();} ?></option>
      <?php
    endforeach ?></select>


    <p> Date Citation :  <input type="date" id="date" name="date"  value="<?php if(isset($_POST['date'])){ echo $_POST['date']; 	}?>"> </p>
    <p> Citation :  <input type="text" id="citation" name="citation"  value="<?php if(isset($_POST['citation'])){ echo $_POST['citation']; 	}?>"> </p>
    <button type="submit" > Valider </button>
  </form>

<?php
}

?>
