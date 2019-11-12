<?php $db = new MyPdo();
$manager=new PersonneManager($db);
$managerEtudiant=new EtudiantManager($db);
$managerSalarie=new SalarieManager($db);
?>
<html>
	<h1>Ajouter une personne</h1>

<?php
  if(!empty($_POST["nom"])&&!empty($_POST["prenom"])&&!empty($_POST["tel"])&&!empty($_POST["mail"])&&!empty($_POST["login"])&&!empty($_POST["motDePasse"])&&$_POST["categorie"]=="etudiant"&&!$manager->perExiste($_POST['login'])==true){

		$manager->ajouterPersonne($_POST["nom"],$_POST["prenom"],$_POST["tel"],$_POST["mail"],$_POST["login"],$_POST["motDePasse"]);
		$listeDiv=$managerEtudiant->listeDivision();

		echo "Annee : ";

		?><form method="post" action="#">
		<select name="division"><?php
		foreach($listeDiv as $donnees=>$listeDiv):?>
			 		<option name="division" id="division" value="<?php echo $listeDiv['nom_div'] ?>" ><?php echo $listeDiv['nom_div'] ?></option>
			<?php
		endforeach?></select><br>
	<?php


		$listeDep=$managerEtudiant->listeDepartement();
		echo "Département : ";?>


			<select name="nom_dep" id="nom_dep"><?php
			foreach ($listeDep as $donnees=>$listeDep) :?>
				 		<option value ="<?php echo $listeDep['nom_dep']?>"><?php echo $listeDep['nom_dep'] ?></option>
				<?php
			endforeach ?></select>
			<button type="submit">valider</button>
		</form><?php



			$_SESSION["per_num"]=$manager->getNumPer($_POST["login"])->num;
?>

		<?php


		//echo 'La personne '.$_POST["nom"].' a été ajouté';
  }
  else{
		if(!empty($_POST["nom"])&&!empty($_POST["prenom"])&&!empty($_POST["tel"])&&!empty($_POST["mail"])&&!empty($_POST["login"])&&!empty($_POST["motDePasse"])&&$_POST["categorie"]=="employe"){

			$salt="48@!alsd";
			$motDePasse=sha1(sha1($_POST["motDePasse"]).$salt);
			$manager->ajouterPersonne($_POST["nom"],$_POST["prenom"],$_POST["tel"],$_POST["mail"],$_POST["login"],$motDePasse);
			$listeForm=$managerSalarie->listeFormation();


			?><form method="post" action="#">
				 <p>Telephone professionnel : <input type="text" name="telPro" /></p>
				 <?php echo "Fonction : ";?>
			<select name="formation"><?php
			foreach ($listeForm as $donnees => $listeForm) :?>

						<option name="formation" id="formation" value="<?php echo $listeForm['fon_libelle'] ?>" ><?php echo $listeForm['fon_libelle'] ?></option>
				<?php
			endforeach?></select><br>
				<button type="submit">valider</button>
			</form><?php

				$_SESSION["per_num"]=$manager->getNumPer($_POST["login"])->num;

		}
		else{
			if(isset($_POST["division"])){

				$numDep=$managerEtudiant->getNumDep($_POST["nom_dep"])->dep_num;
				$divNum=$managerEtudiant->getNumDiv($_POST["division"])->div_num;

				$managerEtudiant->ajouterEtudiant($_SESSION["per_num"],$numDep,$divNum);
				echo "l'étudiant a été ajouté";

			}
			if(isset($_POST["formation"])){
				$telPro=$_POST['telPro'];
				$numForm=$managerSalarie->getNumFonction($_POST['formation'])->fon_num;


				$managerSalarie->ajouterSalarie($_SESSION["per_num"],$telPro,$numForm);
				echo "le salarie a été ajouté";
			}
	    ?>

	<form method="post" >
	<p> Nom :  <input type="text" id="nom" name="nom"  value="<?php if(isset($_POST['nom'])){ echo $_POST['nom']; 	}?>"> </p>
	<p> Prenom :  <input type="text" id="prenom" name="prenom"  value="<?php if(isset($_POST['prenom'])){ echo $_POST['prenom']; 	}?>"> </p>
	<p> Téléphone :  <input type="text" id="tel" name="tel" value="<?php if(isset($_POST['tel'])){ echo $_POST['tel']; 	}?>"> </p>
	<p> Mail :  <input type="text" id="mail" name="mail" value="<?php if(isset($_POST['mail'])){ echo $_POST['mail']; 	}?>"> </p>
	<p> Login :  <input type="text" id="login" name="login" value="<?php if(isset($_POST['login'])){ echo $_POST['login']; 	}?>"> </p>
	<p> Mot de passe :  <input type="password" id="motDePasse" name="motDePasse" value="<?php if(isset($_POST['motDePasse'])){ echo $_POST['motDePasse']; 	}?>"> </p>
	<form method="POST" name="cat">
	categorie
		<input type="radio" name="categorie" value="etudiant" checked > etudiant
		<input type="radio" name="categorie" value="employe"> employe<br>
		<button type="submit" > Valider </button>

	</form>



<?php
		if(isset($_POST['login'])){
			if($manager->perExiste($_POST['login'])==true){
				echo "cet identifiant est déjà pris";
			}
		}

	}
}
?>
</form>
</html>
