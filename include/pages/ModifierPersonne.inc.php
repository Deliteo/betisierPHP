
	<?php $db = new MyPdo();
	$manager=new PersonneManager($db);
	$managerEtudiant=new EtudiantManager($db);
	$managerSalarie=new SalarieManager($db);
	$managerCitation=new CitationManager($db);
	?>
	<h1>Modifier une personne enregistrée</h1>
<?php
if(!empty($_POST["nom"])&&!empty($_POST["prenom"])&&!empty($_POST["tel"])&&!empty($_POST["mail"])&&!empty($_POST["login"])&&!empty($_POST["motDePasse"])){
		$manager->modifierPersonne($_POST["nom"],$_POST["prenom"],$_POST["tel"],$_POST["mail"],$_POST["login"],$manager->crypterPWD($_POST["motDePasse"]),$_GET["nump"]);

		if($_SESSION["personne_etudiant"]&&$_POST["categorie"]=="etudiant"){
			$_SESSION["meme_categorie"]=true;
		}
		else{
			if(!$_SESSION["personne_etudiant"]&&!$_POST["categorie"]=="etudiant"){
				$_SESSION["meme_categorie"]=true;
			}
			else{
				$_SESSION["meme_categorie"]=false;
			}
		}


		if($_SESSION["meme_categorie"]){
			if($_POST["categorie"]=="etudiant"){
				$listeDiv=$managerEtudiant->listeDivision();
				?>
				<form method="post" action="#">
				<select name="division"><?php
				foreach ($listeDiv as $donnees=>$listeDiv) :?>
					 		<option value="<?php echo $listeDiv['nom_div'] ?>" ><?php echo $listeDiv['nom_div'] ?></option>
					<?php
				endforeach ?></select><br>
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
			}
			else{
				$listeForm=$managerSalarie->listeFormation();


				?><form method="post" action="#">
					 <p>Telephone professionel : <input type="text" name="telPro" value ="<?php echo $manager->getTelPro($_GET["nump"])->telPro  ?>" /></p>
					 <?php echo "Fonction : ";?>
				<select name="formation"><?php
				foreach ($listeForm as $donnees=>$listeForm) :?>

							<option name="formation" id="formation" value="<?php echo $listeForm['fon_libelle'] ?>" ><?php echo $listeForm['fon_libelle'] ?></option>
					<?php
				endforeach?></select><br>
					<button type="submit">valider</button>
				</form><?php
			}
		}
		else{   //categorie differente
			if($_POST["categorie"]=="etudiant"){
				$listeDiv=$managerEtudiant->listeDivision();
				?>
				<form method="post" action="#">
				<select name="division"><?php
				foreach ($listeDiv as $donnees=>$listeDiv) :?>
					 		<option value="<?php echo $listeDiv['nom_div'] ?>" ><?php echo $listeDiv['nom_div'] ?></option>
					<?php
				endforeach ?></select><br>
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
			}
			else{
				$listeForm=$managerSalarie->listeFormation();


				?><form method="post" action="#">
					 <p>Telephone professionel : <input type="text" name="telPro"  /></p>
					 <?php echo "Fonction : ";?>
				<select name="formation"><?php
				foreach ($listeForm as $donnees=>$listeForm) :?>

							<option name="formation" id="formation" value="<?php echo $listeForm['fon_libelle'] ?>" ><?php echo $listeForm['fon_libelle'] ?></option>
					<?php
				endforeach?></select><br>
					<button type="submit">valider</button>
				</form><?php
			}
		}
	}
	else{
 		if(!isset($_GET["nump"])){ ?>
		<table>
		<tr>
			<th>Nom</th>
			<th>Prenom</th>
			<th>Modifier</th>
		</tr>
		<?php
		$listeNom=$manager->getList();
		$nombrePersonnes=$manager->getNombre()->nombrePersonne ;

		echo "Actuellement ".$nombrePersonnes." personnes enregistrées";

		foreach ($listeNom as $personne) {
			?>

			<tr>
				<td><?php echo $personne->getNomPer();?></td>
				<td><?php echo $personne->getPrenomPer();?></td>
				<td><a href="index.php?page=3&nump=<?php echo $personne->getNumPer();?>"</a> <?php echo $personne->getNumPer();?> </td>
			</tr>
			<?php
		}



	 ?>
	  </table>
<?php
}else{
	if(isset($_GET["nump"])){
		if(isset($_POST["division"])){
			$numDep=$managerEtudiant->getNumDep($_POST["nom_dep"])->dep_num;
			$divNum=$managerEtudiant->getNumDiv($_POST["division"])->div_num;
			if($_SESSION["meme_categorie"]){
				$managerEtudiant->modifierEtudiant($_GET["nump"],$numDep,$divNum);
			}
			else{
				$managerCitation->supprimerCitationSal($_GET["nump"]);
				$managerSalarie->supprimerSalarie($_GET["nump"]);
				$managerEtudiant->ajouterEtudiant($_GET["nump"],$numDep,$divNum);
			}
			echo "l'étudiant a été modifie";
		}
		if(isset($_POST["telPro"])&&$_POST["telPro"]!=NULL){
			$telPro=$_POST['telPro'];
			$numForm=$managerSalarie->getNumFonction($_POST['formation'])->fon_num;
			if($_SESSION["meme_categorie"]){
				$managerSalarie->modifierSalarie($_GET["nump"],$telPro,$numForm);
			}
			else{
				$managerCitation->supprimerCitationEtu($_GET["nump"]);
				$managerEtudiant->supprimerEtudiant($_GET["nump"]);
				$managerSalarie->ajouterSalarie($_GET["nump"],$telPro,$numForm);
			}
			echo "le salarie a été modifie";
		}
	}
	$personne_nom=$manager->getNomPer($_GET["nump"])->nom;
	$personne_prenom=$manager->getPrenomPer($_GET["nump"])->prenom;
	$personne_tel=$manager->getTelPer($_GET["nump"])->tel;
	$personne_mail=$manager->getMailPer($_GET["nump"])->mail;
	$personne_login=$manager->getLogPer($_GET["nump"])->log;
	$_SESSION["personne_etudiant"]=$manager->estEtudiant($_GET["nump"]);

	?>

	<form method="post" >
	<p> Nom :  <input type="text" id="nom" name="nom"  value="<?php if(isset($_POST['nom'])){ echo $_POST['nom'];}else{echo $personne_nom;}?>"> </p>
	<p> Prenom :  <input type="text" id="prenom" name="prenom"  value="<?php if(isset($_POST['prenom'])){ echo $_POST['prenom'];}else{echo $personne_prenom;} ?>"> </p>
	<p> Téléphone :  <input type="text" id="tel" name="tel" value="<?php if(isset($_POST['tel'])){ echo $_POST['tel'];}else{ echo $personne_tel;}?>"> </p>
	<p> Mail :  <input type="text" id="mail" name="mail" value="<?php if(isset($_POST['mail'])){ echo $_POST['mail'];}else{echo 	$personne_mail;}?>"> </p>
	<p> Login :  <input type="text" id="login" name="login" value="<?php if(isset($_POST['login'])){ echo $_POST['login'];}else{echo $personne_login;}?>"> </p>
	<p> Mot de passe :  <input type="text" id="motDePasse" name="motDePasse" value="<?php if(isset($_POST['motDePasse'])){ echo $_POST['motDePasse']; 	}?>"> </p>
	<form method="POST" name="cat">
	categorie
		<input type="radio" name="categorie" value="etudiant" <?php if($_SESSION["personne_etudiant"]){?> checked <?php } ?> > etudiant
		<input type="radio" name="categorie" value="employe" <?php if(!$_SESSION["personne_etudiant"]){?> checked <?php } ?> > employe<br>
		<button type="submit" > Valider </button>

	</form>



		<?php


}
}
?>
