<?php
class PersonneManager{

    public function __construct($db){
      $this->db=$db;
    }

    // fonction qui retourne la liste des personnes
    public function getList(){
      $listeNom=array();

      $sql = 'SELECT per_num,per_nom,per_prenom from personne order by per_nom';
      $req=$this->db->prepare($sql);
      $req->execute();
      while ($nom = $req->fetch(PDO::FETCH_OBJ)){
        $listeNom[]=new Personne ($nom);
      }

      return $listeNom;
      $req->closeCursor();
    }

    // fonction qui retourne le nombre de personnes enregistrées
    public function getNombre(){

      $sql = 'SELECT count(per_nom) as nombrePersonne from Personne';
      $req=$this->db->prepare($sql);
      $req->execute();
      $nombrePersonnes=$req->fetch(PDO::FETCH_OBJ);

      return $nombrePersonnes;
    }

    // fonction qui retourne le prénom d'une personne selon son numéro
    public function getPrenomPer($nump){
      $sql = "SELECT per_prenom as prenom from Personne where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $prenom=$req->fetch(PDO::FETCH_OBJ);
      return $prenom;
    }

    // fonction qui retourne le mail d'une personne selon son numéro
    public function getMailPer($nump){
      $sql = "SELECT per_mail as mail from Personne where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $mail=$req->fetch(PDO::FETCH_OBJ);
      return $mail;
    }

    // fonction qui retourne le téléphone d'une personne selon son numéro
    public function getTelPer($nump){
      $sql = "SELECT per_tel as tel from Personne where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $tel=$req->fetch(PDO::FETCH_OBJ);
      return $tel;
    }

    // fonction qui retourne le login d'une personne selon son numéro
    public function getLogPer($nump){
      $sql = "SELECT per_login as log from Personne where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $log=$req->fetch(PDO::FETCH_OBJ);
      return $log;
    }

    //  fonction qui retourne le département d'une personne selon son numéro
    public function getDepPer($nump){
      $sql = "SELECT dep_nom as dep from departement d join etudiant e on d.dep_num=e.dep_num where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $dep=$req->fetch(PDO::FETCH_OBJ);
      return $dep;
    }

    // fonction qui retourne la ville d'une personne selon son numéro
    public function getVilPer($nump){
      $sql = "SELECT vil_nom as vil from departement d join etudiant e on d.dep_num=e.dep_num join ville v on v.vil_num=d.vil_num where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $vil=$req->fetch(PDO::FETCH_OBJ);
      return $vil;
    }

    // fonction qui retourne si la personne est un étudiant
    public function estEtudiant($nump){
      $sql = "SELECT dep_nom as dep from departement d join etudiant e on d.dep_num=e.dep_num where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $dep=$req->fetch(PDO::FETCH_OBJ);

       if($dep!=null){
         return true;
       }
       return false;
    }

    // fonction qui retourne le téléphone professionnel d'une personne selon son numéro
    public function getTelPro($nump){
      $sql = "SELECT sal_telprof as telPro from salarie  where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $telPro=$req->fetch(PDO::FETCH_OBJ);
      return $telPro;
    }
    // fonction qui retourne la fonction d'une personne selon son numéro
    public function getFonction($nump){
      $sql = "SELECT fon_libelle as fonction from salarie s join fonction f on f.fon_num=s.fon_num where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();
      $fonction=$req->fetch(PDO::FETCH_OBJ);
      return $fonction;
    }


    // fonction qui permet d'ajouter une personne
    public function ajouterPersonne($personne){
      $requete = $this->db->prepare(
      'INSERT INTO personne (per_nom,per_prenom,per_tel,per_mail,per_admin,per_login,per_pwd) VALUES (:per_nom,:per_prenom,:per_tel,:per_mail,:per_admin,:per_login,:per_pwd);');

      $requete->bindValue(':per_nom',$personne->getNomPer());
      $requete->bindValue(':per_prenom',$personne->getPrenomPer());
      $requete->bindValue(':per_tel',$personne->getTelPer());
      $requete->bindValue(':per_mail',$personne->getMailPer());
      $requete->bindValue(':per_admin',0);
      $requete->bindValue(':per_login',$personne->getLoginPer());
      $requete->bindValue(':per_pwd',$personne->getPwdPer());

      $retour=$requete->execute();
      return $retour;
  }

  // fonction qui retourne le numéro d'une personne selon son login
    public function getNumPer($log){
      $sql = "SELECT per_num as num from personne where per_login='$log'";
      $req=$this->db->prepare($sql);
      $req->execute();
      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    // fonction qui retourne le nom d'une personne selon son numéro
    public function getNomPer($nump){
      $sql = "SELECT per_nom as nom from Personne where per_num=$nump";
      $req=$this->db->prepare($sql);
      $req->execute();

      $nom=$req->fetch(PDO::FETCH_OBJ);
      return $nom;
    }

    // fonction qui retourne si une personne est admin selon son numéro
    public function getAdmin($num){
      $req=$this->db->prepare('SELECT per_admin as admin FROM personne WHERE per_num=:num');
      $req->bindValue(':num',$num,PDO::PARAM_INT);
      $req->execute();
      $resultat=$req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();

      if($resultat->admin==1){
        return true;
      }
      else{
        return false;
      }
    }

    // fonction qui retourne le mot de passe enregistré dans la BD à partir du login
    public function connexion($login){

      $sql = "SELECT per_pwd as mdp FROM personne WHERE per_login='$login'";
      $req=$this->db->query($sql);

      $pwd = $req->fetch(PDO::FETCH_OBJ);

      return $pwd;

    }
    
    // fonction qui retourne si la personne existe
    public function perExiste($log){
      if($this->getNumPer($log)!=null){
        return true;
      }
      else{
        return false;
      }
    }

    // fonction qui modifie une personne
    public function modifierPersonne($nom,$prenom,$tel,$mail,$login,$motDePasse,$nump){
      $requete = $this->db->prepare(
      "UPDATE personne set per_nom=:per_nom,per_prenom=:per_prenom,per_tel=:per_tel,per_mail=:per_mail,per_admin=:per_admin,per_login=:per_login,per_pwd=:per_pwd where per_num='$nump';");

      $requete->bindValue(':per_nom',$nom);
      $requete->bindValue(':per_prenom',$prenom);
      $requete->bindValue(':per_tel',$tel);
      $requete->bindValue(':per_mail',$mail);
      $requete->bindValue(':per_admin',0);
      $requete->bindValue(':per_login',$login);
      $requete->bindValue(':per_pwd',$motDePasse);

      $retour=$requete->execute();
      return $retour;
  }

  // fonction qui retourne  la liste des personnes
  public function listePersonne(){
    $sql = "SELECT per_login as log from personne";
    $listePer=$this->db->query($sql);

    return $listePer;
  }

  // fonction qui supprime une personne
  public function supprimerPersonne($nump){
    $requete = $this->db->prepare(
      "DELETE from personne where per_num='$nump';");

      $retour=$requete->execute();
      return $retour;
  }

  // fonction qui permet de crypter le mot de passe
  public function crypterPWD($pwd){
    $salt = "48@!alsd";
    $pwd_crypte= sha1(sha1($pwd).$salt);
    return $pwd_crypte;
  }

}

?>
