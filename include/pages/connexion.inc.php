<h1> Pour vous connecter </h1>

<?php

if(empty($_POST["nomUtilisateur"])) {



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

}


 ?>
