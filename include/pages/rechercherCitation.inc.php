<?php $db = new MyPdo();
$manager = new CitationManager($db); ?>
<h1> Rechercher une citation </h1>
<?php
if(empty($_POST['nomEnseignant'])&&empty($_POST['dateCitation'])&&empty($_POST['noteCitation'])){
  ?>
  <form method="post" action="#">
    <p> Nom et prenom de l'enseignant : <input type="text" id="nomEnseignant" name="nomEnseignant"></p>
    <p> Date : <input type="text" id="dateCitation" name="dateCitation" ></p>
    <p> Note : <input type="text" id="noteCitation" name="noteCitation" ></p>
    <button type="submit"> Rechercher </button>
  </form>
<?php }
else{
  $nomEnseignant=$_POST['nomEnseignant'];
  $date=$_POST['dateCitation'];
  $note=$_POST['noteCitation'];
  $listeCitations=$manager->rechercherCitation($nomEnseignant,$date,$note);
  if(!empty($listeCitations)){
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

      foreach ($listeCitations as $citation) {
        ?>
        <tr>
          <td><?php echo $citation->getCitNomPers(); ?></td>
          <td><?php echo $citation->getCitLibelle(); ?></td>
          <td><?php echo $citation->getCitDate(); ?></td>
          <td><?php echo $citation->getCitNote(); ?></td>
          <?php if(!empty($_SESSION['num'])){
            ?>
            <td>
              <?php
              $perm=$manager->getPermVote($_SESSION['num'],$citation->getCitNum());
              if($perm==true){
                ?>
                <a href="index.php?page=15&numcit=<?php echo $citation->getCitNum();?>"><img class="logo" src="image/modifier.png" alt="imgModifier" title="Noter"/></a>
                <?php
              } else {

                ?>
                <img class="logo" src="image/erreur.png" alt="imgErreur" title="PasNoter"/>
                <?php
              }

              ?>
            </td>
          <?php		}  ?>
        </tr>
      <?php }
      ?>


    </table>
    <?php
  }
  else{
    ?>
    <p> Pas de résultats </p>
    <?php
  }
}
?>
