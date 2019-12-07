<?php $db = new MyPdo();
$manager=new PersonneManager($db);
?>

<h1> Pour vous connecter </h1>

<?php

if(empty($_POST["nomUtilisateur"])||empty($_POST["passWord"])||empty($_POST["verification"])) {

  $nb1= rand(1,9);
  $nb2= rand(1,9);
  $_SESSION["nb1"]=$nb1;
  $_SESSION["nb2"]=$nb2;
 ?>

<form name="connexion" id="connexion" action="#" method="POST">
 <b>  Nom d'utilisateur : </b>
  <input type="text" name="nomUtilisateur"><br>
   <b> Mot de passe : </b>
  <input type="password" name="passWord"><br>

  <img src="<?php echo 'image/nb/'.$nb1 ?>" alt="nombre1" name="nombre1" value="<?php echo 'image/nb/'.$nb1 ?>"/>
  <b> + </b>
  <img src="<?php echo 'image/nb/'.$nb2 ?>" alt="nombre2" name="nombre2" value="<?php echo 'image/nb/'.$nb2 ?>"/>
  <b> = </b>
  <input type="text" name="verification"><br>

  <button type="submit"> Valider </button>
</form>

<?php


}else{


  $verif= $_POST["verification"];
  $resultat = $_SESSION["nb1"]+$_SESSION["nb2"];

  $login=$_POST["nomUtilisateur"];

  $motDePasse= $_POST["passWord"];


  if($manager->connexion($login)!=null){
    $pwd=$manager->connexion($login)->mdp;
    $pwd=$manager->crypterPWD($pwd);
  }
  else{
    unset($pwd);
  }

  $pwd=$manager->connexion($login)->mdp;
  if(empty($pwd)){
    $pwd=null;
  }

  $pwd_crypte=$manager->crypterPWD($motDePasse);

  if(($pwd==$pwd_crypte )&&($resultat==$verif)) {

    $num=$manager->getNumPer($login)->num;
    $prenom=$manager->getPrenomPer($num)->prenom;
    $admin=$manager->getAdmin($num);

    $_SESSION['admin']=$admin;
    $_SESSION['num']=$num;
    $_SESSION['prenom']=$prenom;

    ?>
    <p> Vous avez bien été connecté <br>
      <br>
      Redirection automatique dans 2 secondes.
    </p>
  <!--  <meta http-equiv="refresh" content="2;url=index.php"/> -->

    <?php
  }
  else{
  ?>
   <p> Votre login ou mot de passe est incorrect </p>
    <form name="connexion" id="connexion" action="#" method="POST">
     <b>  Nom d'utilisateur : </b>
      <input type="text" name="nomUtilisateur"><br>
       <b> Mot de passe : </b>
      <input type="password" name="passWord"><br>

      <img src="<?php echo 'image/nb/'.$_SESSION["nb1"] ?>" alt="nombre1" name="nombre1" value="<?php echo 'image/nb/'.$_SESSION["nb1"] ?>"/>
      <b> + </b>
      <img src="<?php echo 'image/nb/'.$_SESSION["nb2"] ?>" alt="nombre2" name="nombre2" value="<?php echo 'image/nb/'.$_SESSION["nb2"] ?>"/>
      <b> = </b>
      <input type="text" name="verification"><br>

      <button type="submit"> Valider </button>
    </form>
    <?php
  }
}
 ?>
