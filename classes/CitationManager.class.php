<?php class CitationManager {

  public function __construct($db){
    $this->db = $db;
  }


  // fonction qui permet d'obtenir la liste des 2 citations validées
  public function getList(){
    $listeCitations = array();
    $sql = 'SELECT concat(per_nom,per_prenom) as cit_nom_pers,c.cit_num as cit_num,cit_libelle,cit_date FROM citation c
    INNER JOIN personne p ON p.per_num=c.per_num
    LEFT OUTER JOIN vote v ON v.cit_num=c.cit_num
    WHERE cit_valide=1 and cit_date_valide IS NOT NULL
    GROUP BY c.cit_num
    ORDER BY cit_date DESC
    LIMIT 2';
    $req=$this->db->prepare($sql);
    $req->execute();
    while ($citation = $req->fetch(PDO::FETCH_OBJ)){

      $listeCitations[]=new Citation($citation);

    }
    return $listeCitations;
    $req->closeCursor();
  }

  // fonction qui donne le nombre de citations existantes
  public function getNombre(){

    $sql =$this->db->prepare('SELECT count(cit_num) as nombreCitation from Citation
    WHERE cit_valide=1 and cit_date_valide IS NOT NULL');
    $sql->execute();

    $nombreCitation=$sql->fetch(PDO::FETCH_OBJ);

    return $nombreCitation;


  }

  // fonction qui retourne un booleen pour pouvoir voter une citation
  public function getPermVote($pernum,$citnum){

    $req=$this->db->prepare('SELECT cit_num as perm FROM vote WHERE per_num=:pernum AND cit_num=:citnum');
    $req->bindValue(':pernum',$pernum,PDO::PARAM_INT);
    $req->bindValue(':citnum',$citnum,PDO::PARAM_INT);
    $req->execute();
    $resultat=$req->fetch(PDO::FETCH_OBJ);
    $req->closeCursor();

    if($resultat==NULL){
      return true;
    }
    else{
      return false;
    }

  }

  // fonction qui retourne le contenu de la citation
  public function getLibelle($citnum){
    $req=$this->db->prepare('SELECT cit_libelle as libelle FROM citation WHERE cit_num=:citnum');
    $req->bindValue(':citnum',$citnum,PDO::PARAM_INT);
    $req->execute();
    $resultat=$req->fetch(PDO::FETCH_OBJ);
    $req->closeCursor();
    return $resultat->libelle;

  }

  // fonction qui retourne le nom/prenom de la citation à partir du numéro de citation
  public function getNomPers($citnum){
    $req=$this->db->prepare('SELECT concat(per_nom,per_prenom) as cit_nom_pers FROM citation c
    JOIN personne p ON p.per_num=c.per_num WHERE cit_num=:citnum');
    $req->bindValue(':citnum',$citnum,PDO::PARAM_INT);
    $req->execute();
    $resultat=$req->fetch(PDO::FETCH_OBJ);
    $req->closeCursor();
    return $resultat->cit_nom_pers;

  }
  // fonction qui retourne la liste des enseignants
  public function getListEnseignant(){
    $listeNom=array();

    $sql = 'SELECT per_num,per_nom from personne p where EXISTS (select per_num from salarie s where s.per_num=p.per_num) order by 1';
    $req=$this->db->prepare($sql);

    $req->execute();

    while ($nom = $req->fetch(PDO::FETCH_OBJ)){
      $listeNom[]=new Personne ($nom);
    }

    return $listeNom;
    $req->closeCursor();
  }

  //fonction qui ajoute une citation
  public function ajouterCitation($citation){
    $requete = $this->db->prepare(
    'INSERT INTO citation(per_num, per_num_etu, cit_libelle, cit_date) VALUES (:per_num,:per_num_etu,:cit_libelle,:cit_date)');

    $requete->bindValue(':per_num',$citation->getCitNomPers());
    $requete->bindValue(':per_num_etu',$citation->getCitPerNumEtu());
    $requete->bindValue(':cit_libelle',$citation->getCitLibelle());
    $requete->bindValue(':cit_date',$citation->getCitDate());

    $retour=$requete->execute();
    return $retour;

  }

  // fonction qui permet de vérifier mot par mot
  public function verifierMot($mot){
    $requete = $this->db->prepare(
    "SELECT mot_interdit from mot where mot_interdit=:mot");
    $requete->bindValue(':mot',$mot);
    $requete->execute();
    $resultat=$requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
    return $resultat;
  }

  //fonction qui permet de vérifier si une phrase contient un mot interdit
  public function verifierPhrase($phrase){
    $requete = $this->db->prepare(

    "SELECT mot_interdit from mot where MATCH(mot_interdit) AGAINST(:phrase)");
    $requete->bindValue(':phrase',$phrase);

    $requete->execute();
    $resultat=$requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
    return $resultat;
  }

  // fonction qui supprime une citation d'un étudiant 
  public function supprimerCitationEtu($nump){
    $requete = $this->db->prepare(
      "DELETE FROM citation where per_num_etu='$nump';");
      $retour=$requete->execute();
      return $retour;
  }

  //fonction qui supprime une citation sur un salarié
  public function supprimerCitationSal($nump){
    $requete = $this->db->prepare(
      "DELETE FROM citation where per_num='$nump';");
      $retour=$requete->execute();
      return $retour;
  }

  // fonction qui retourne la liste des citations ajoutées par un étudiant
  public function getCitationEtu($nump){
    $listeCitation = array();

    $sql = "select cit_num FROM citation where per_num_etu = $nump";
    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($citation = $requete->fetch(PDO::FETCH_OBJ))
        $listeCitation[] = new Citation($citation);

    $requete->closeCursor();
    if(empty($listeCitation)){
      $listeCitation = NULL;
    }
    return $listeCitation;
}

// fonction qui supprime un vote lié à une citation
public function supprimerVoteCit($numc){
  $requete = $this->db->prepare(
    "DELETE FROM vote where cit_num='$numc';");
    $retour=$requete->execute();
    return $retour;
}

// fonction qui supprime un vote lié à une personne
public function supprimerVotePer($numc){
  $requete = $this->db->prepare(
    "DELETE FROM vote where per_num='$numc';");
    $retour=$requete->execute();
    return $retour;
}

  // fonction qui permet de rechercher une citation selon 3 critères
  // la requete s'adapte aux champs remplis
  public function rechercherCitation($enseignant,$date,$note){

    if(!empty($enseignant)){
      $partieEnseignant=" AND concat(per_nom,per_prenom)=:enseignant";
    }
    if(!empty($date)){
      $partieDate=" AND cit_date=:dateCit";
    }
    if(!empty($note)){
      $partieNote=" HAVING avg(vot_valeur)=:note";
    }
    $bout=' ORDER BY cit_date DESC';

    $requeteSQL='SELECT concat(per_nom,per_prenom) as cit_nom_pers,c.cit_num,cit_libelle,cit_date,avg(vot_valeur) as cit_note
    FROM citation c
    INNER JOIN personne p ON p.per_num=c.per_num
    INNER JOIN vote v ON v.cit_num=c.cit_num
    WHERE cit_valide=1 and cit_date_valide IS NOT NULL';

    if($enseignant!=null){
      $requeteSQL=$requeteSQL.$partieEnseignant;

    }
    if($date!=null){
      $requeteSQL=$requeteSQL.$partieDate;
    }
    if($note!=null){
      $requeteSQL=$requeteSQL.' GROUP BY c.cit_num '.$partieNote;
    }
    else{
      $requeteSQL=$requeteSQL.' GROUP BY c.cit_num ';
    }

    $requeteSQL=$requeteSQL.$bout;
    $req=$this->db->prepare($requeteSQL);
    if(!empty($enseignant)){
      $req->bindValue(':enseignant',$enseignant,PDO::PARAM_STR);
    }
    if(!empty($date)){
      $req->bindValue(':dateCit',$date,PDO::PARAM_STR);
    }
    if(!empty($note)){
      $req->bindValue(':note',$note,PDO::PARAM_STR);
    }

    $req->execute();
    while ($citation = $req->fetch(PDO::FETCH_OBJ)){

      $listeCitations[]=new Citation($citation);

    }
    if(isset($listeCitations)){
      return $listeCitations;
    }else{
      return "";
    }

    $req->closeCursor();
  }

  //fonction qui retourne la liste des citations qui peuvent être validées
  public function getListeCitationNonValide(){
    $listeCitations = array();
    $sql = 'SELECT concat(per_nom,per_prenom) as cit_nom_pers,c.cit_num as cit_num,cit_libelle,cit_date FROM citation c
    INNER JOIN personne p ON p.per_num=c.per_num
    WHERE cit_valide=0 and cit_date_valide IS NULL
    ORDER BY cit_date DESC';
    $req= $this->db->query($sql);
    while ($citation = $req->fetch(PDO::FETCH_OBJ)){

      $listeCitations[]=new Citation($citation);

    }
    return $listeCitations;
    $req->closeCursor();
  }

  //fonction qui permet de valider une citation
  public function validerCitation($cit){
    $date=date("Y-m-d");
    $sql='UPDATE citation SET cit_valide=1, cit_date_valide=:date WHERE cit_num=:citnum';

    $requete=$this->db->prepare($sql);
    $requete->bindValue(':date',$date);
    $requete->bindValue(':citnum',$cit);
    $retour=$requete->execute();
    $requete->closeCursor();
    return $retour;
  }

}

