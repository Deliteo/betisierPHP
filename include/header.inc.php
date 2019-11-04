<?php session_start();
 ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php
		$title = "Bienvenue sur le site du bétisier de l'IUT.";?>
		<title>
		<?php echo $title ?>
		</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css?t=<? echo time(); ?>" />

</head>
	<body>
	<div id="header">
		<div id="connect">
          <?php
            if(empty ($_SESSION['prenom'])){

           ?>
            <a href="index.php?page=13">Connexion</a>
            <?php
          }
            else{
                echo "Utilisateur : <b>".$_SESSION['prenom']." <a href='index.php?page=14'> Déconnexion </a></b>";

            }


             ?>
		</div>
		<div id="entete">
			<div id="logo">

			</div>
			<div id="titre">
				Le bétisier de l'IUT, <br />Partagez les meilleures perles !!!
			</div>
		</div>
	</div>
