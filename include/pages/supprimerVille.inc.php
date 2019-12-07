<?php $db = new MyPdo();
$manager=new PersonneManager($db);
$managerVille=new VilleManager($db);
$managerEtudiant=new EtudiantManager($db);
$managerSalarie=new SalarieManager($db);
$managerCitation=new CitationManager($db);
$managerDepartement=new DepartementManager($db);
$managerVote=new VoteManager($db);
$managerPersonne=new PersonneManager($db);


?>

<h1>Supprimer Ville</h1>

<?php
if(!isset($_POST['ville'])){

  if(isset($_POST['supprimer'])&&$_POST['supprimer']=="oui"){

    $listeDepartement=$managerVille->getDepartement($_SESSION['numVille']);
    ?><?php

    if($listeDepartement!=null){

    foreach ($listeDepartement as $donnees=>$listeDepartement) :

      $listePersonne=$managerDepartement->getPersonne($listeDepartement->dep_num);
      if($listePersonne!=null){
        foreach ($listePersonne as $donnees=>$listePersonne) :

          $listeCitation=$managerCitation->getCitationEtu($listePersonne->per_num);
          if($listeCitation!=null){
            foreach ($listeCitation as $donnees=>$listeCitation) :
              $managerCitation->supprimerCitationEtu($listePersonne->per_num);

            endforeach;
          }
          $managerCitation->supprimerVotePer($listePersonne->per_num);
          $managerCitation->supprimerVoteCit($listePersonne->per_num);
          $managerEtudiant->supprimerEtudiant($listePersonne->per_num);
          $managerPersonne->supprimerPersonne($listePersonne->per_num);

        endforeach;

      }
      $managerDepartement->supprimerDepartement($listeDepartement->dep_num);
    endforeach;

  }
  $managerVille->supprimerVille($_SESSION['numVille']);

echo "La ville a été supprimée";
    ?><?php
  }



  $listeVille=$managerVille->listeVille();
  ?>
  	<form method="post" action="#">
  	<select name="ville"><?php
  	foreach ($listeVille as $donnees=>$listeVille) :?>
  				<option value="<?php echo $listeVille['ville'] ?>" ><?php echo $listeVille['ville'] ?></option>
  		<?php
  	endforeach ?></select><br>
  	<button type="submit" > Valider </button>
  	</select>

  	 <?php
 }

 else{
 	$_SESSION['numVille']=$managerVille->getNumVil($_POST['ville'])->num;
 	echo "Voulez vous vraiment supprimer ".$_POST['ville']." ?";

 		?>
 		<form method="post" >

 		<input type="radio" name="supprimer" value="oui"   checked > oui
 		<input type="radio" name="supprimer" value="non"  > non <br>
 		<button type="submit" >   Valider </button>
 			</form>
 		<?php
 		}
