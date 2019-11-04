<?php $db = new MyPdo();
$manager=new PersonneManager($db);?>

<h1> Pour vous connecter </h1>

<?php

if(empty($_POST["nomUtilisateur"])||empty($_POST["passWord"])||empty($_POST["verification"])) {



 ?>

<form name="connexion" id="connexion" action="#" method="POST">
 <b>  Nom d'utilisateur : </b>
  <input type="text" name="nomUtilisateur"><br>
   <b> Mot de passe : </b>
  <input type="password" name="passWord"><br>

  <img class="nombre" src="image/nb/8" alt="nombre1" title="nombre1"/>
  <b> + </b>
  <img class="nombre" src="image/nb/5" alt="nombre2" title="nombre2"/>
  <b> = </b>
  <input type="text" name="verification"><br>

  <button type="submit"> Valider </button>
</form>

<?php


}else{
  $login=$_POST["nomUtilisateur"];
//  echo $login;

  $motDePasse= $_POST["passWord"];
//  echo $motDePasse;

  $salt = "48@!alsd";
  $pwd_crypte= sha1(sha1($motDePasse).$salt);
//  echo $pwd_crypte;

  $pwd=$manager->connexion($login)->mdp;
  if(empty($pwd)){
    $pwd=null;
  }


  if($pwd==$pwd_crypte){

    $num=$manager->getNumPer($login)->num;

    $prenom=$manager->getPrenomPer($num)->prenom;

    $_SESSION['prenom']=$prenom;

    ?>
    <p> Vous avez bien été connecté <br>
      <br>
      Redirection automatique dans 2 secondes.
    </p>
    <meta http-equiv="refresh" content="2;url=index.php"/>

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

      <img class="nombre" src="image/nb/8" alt="nombre1" title="nombre1"/>
      <b> + </b>
      <img class="nombre" src="image/nb/5" alt="nombre2" title="nombre2"/>
      <b> = </b>
      <input type="text" name="verification"><br>

      <button type="submit"> Valider </button>
    </form>
    <?php
  }
}
 ?>
