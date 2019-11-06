<?php class PersonneManager{

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

    public function ajouterPersonne($nom,$prenom,$tel,$mail,$login,$motDePasse){
        $requete = $this->db->prepare(
        'INSERT INTO personne (per_nom,per_prenom,per_tel,per_mail,per_admin,per_login,per_pwd) VALUES (:per_nom,:per_prenom,:per_tel,:per_mail,:per_admin,:per_login,:per_pwd);');

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

    public function listeDepartement(){
      $sql = "SELECT dep_nom as nom_dep from departement";
      $listeDep=$this->db->query($sql);

      return $listeDep;
    }

    public function listeDivision(){
      $sql = "SELECT div_nom as nom_div from division";
      $listeDiv=$this->db->query($sql);

      return $listeDiv;
    }

    public function listeFormation(){
      $sql = "SELECT fon_libelle from fonction";
      $listForm=$this->db->query($sql);
      return $listForm;
    }

    public function getNumPer($log){
      $sql = "SELECT per_num as num from personne where per_login='$log'";
      $req=$this->db->query($sql);

      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    public function connexion($login){

      $sql = "SELECT per_pwd as mdp FROM personne WHERE per_login='$login'";
      $req=$this->db->query($sql);

      $pwd = $req->fetch(PDO::FETCH_OBJ);

      return $pwd;

    }

    public function ajouterEtudiant($perNum,$depNum,$divNum){
      $requete = $this->db->prepare(
        'INSERT INTO etudiant (per_num,dep_num,div_num) VALUES (:per_num,:dep_num,:div_num);');
        $requete->bindValue(':per_num',$perNum);
        $requete->bindValue(':dep_num',$depNum);
        $requete->bindValue(':div_num',$divNum);

        $retour=$requete->execute();
        return $retour;

    }

    public function getNumDep($nomDep){
      $sql = "SELECT dep_num from departement where dep_nom='$nomDep'";
      $req=$this->db->query($sql);

      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    public function getNumDiv($nomDiv){
      $sql = "SELECT div_num from division where div_nom='$nomDiv'";
      $req=$this->db->query($sql);

      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    public function getNumFonction($nomFon){
      $sql = "SELECT fon_num from fonction where fon_libelle='$nomFon'";
      $req=$this->db->query($sql);

      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    public function ajouterSalarie($perNum,$telPro,$formation){
      $requete = $this->db->prepare(
        'INSERT INTO salarie (per_num,sal_telprof,fon_num) VALUES (:per_num,:sal_telprof,:fon_num);');
        $requete->bindValue(':per_num',$perNum);
        $requete->bindValue(':sal_telprof',$telPro);
        $requete->bindValue(':fon_num',$formation);

        $retour=$requete->execute();
        return $retour;

    }

    public function perExiste($log){
      if($this->getNumPer($log)!=null){
        return true;
      }
      else{
        return false;
      }
    }

}

?>
