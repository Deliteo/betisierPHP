<?php
class PersonneManager{

    public function __construct($db){
      $this->db=$db;
    }

    public function getList(){
      $listeNom=array();

      $sql = 'SELECT per_num,per_nom,per_prenom from personne order by per_nom';
      $req=$this->db->query($sql);

      while ($nom = $req->fetch(PDO::FETCH_OBJ)){
        $listeNom[]=new Personne ($nom);
      }

      return $listeNom;
      $req->closeCursor();
    }

    public function getNombre(){

      $sql = 'SELECT count(per_nom) as nombrePersonne from Personne';
      $req=$this->db->query($sql);

      $nombrePersonnes=$req->fetch(PDO::FETCH_OBJ);

      return $nombrePersonnes;
    }

    public function getPrenomPer($nump){
      $sql = "SELECT per_prenom as prenom from Personne where per_num=$nump";
      $req=$this->db->query($sql);

      $prenom=$req->fetch(PDO::FETCH_OBJ);
      return $prenom;
    }

    public function getMailPer($nump){
      $sql = "SELECT per_mail as mail from Personne where per_num=$nump";
      $req=$this->db->query($sql);

      $mail=$req->fetch(PDO::FETCH_OBJ);
      return $mail;
    }

    public function getTelPer($nump){
      $sql = "SELECT per_tel as tel from Personne where per_num=$nump";
      $req=$this->db->query($sql);

      $tel=$req->fetch(PDO::FETCH_OBJ);
      return $tel;
    }

    public function getLogPer($nump){
      $sql = "SELECT per_login as log from Personne where per_num=$nump";
      $req=$this->db->query($sql);

      $log=$req->fetch(PDO::FETCH_OBJ);
      return $log;
    }

    public function getDepPer($nump){
      $sql = "SELECT dep_nom as dep from departement d join etudiant e on d.dep_num=e.dep_num where per_num=$nump";
      $req=$this->db->query($sql);

      $dep=$req->fetch(PDO::FETCH_OBJ);
      return $dep;
    }

    public function getVilPer($nump){
      $sql = "SELECT vil_nom as vil from departement d join etudiant e on d.dep_num=e.dep_num join ville v on v.vil_num=d.vil_num where per_num=$nump";
      $req=$this->db->query($sql);

      $vil=$req->fetch(PDO::FETCH_OBJ);
      return $vil;
    }

    public function estEtudiant($nump){
      $sql = "SELECT dep_nom as dep from departement d join etudiant e on d.dep_num=e.dep_num where per_num=$nump";
      $req=$this->db->query($sql);

      $dep=$req->fetch(PDO::FETCH_OBJ);

       if($dep!=null){
         return true;
       }
       return false;
    }

    public function getTelPro($nump){
      $sql = "SELECT sal_telprof as telPro from salarie  where per_num=$nump";
      $req=$this->db->query($sql);

      $telPro=$req->fetch(PDO::FETCH_OBJ);
      return $telPro;
    }

    public function getFonction($nump){
      $sql = "SELECT fon_libelle as fonction from salarie s join fonction f on f.fon_num=s.fon_num where per_num=$nump";
      $req=$this->db->query($sql);

      $fonction=$req->fetch(PDO::FETCH_OBJ);
      return $fonction;
    }

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

    public function getNumPer($log){
      $sql = "SELECT per_num as num from personne where per_login='$log'";
      $req=$this->db->query($sql);

      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    public function getNomPer($nump){
      $sql = "SELECT per_nom as nom from Personne where per_num=$nump";
      $req=$this->db->query($sql);

      $nom=$req->fetch(PDO::FETCH_OBJ);
      return $nom;
    }

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

    public function connexion($login){

      $sql = "SELECT per_pwd as mdp FROM personne WHERE per_login='$login'";
      $req=$this->db->query($sql);

      $pwd = $req->fetch(PDO::FETCH_OBJ);

      return $pwd;

    }
    public function perExiste($log){
      if($this->getNumPer($log)!=null){
        return true;
      }
      else{
        return false;
      }
    }

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

  public function listePersonne(){
    $sql = "SELECT per_login as log from personne";
    $listePer=$this->db->query($sql);

    return $listePer;
  }

  public function supprimerPersonne($nump){
    $requete = $this->db->prepare(
      "DELETE from personne where per_num='$nump';");

      $retour=$requete->execute();
      return $retour;
  }

  public function crypterPWD($pwd){
    $salt = "48@!alsd";
    $pwd_crypte= sha1(sha1($pwd).$salt);
    return $pwd_crypte;
  }

}

?>
