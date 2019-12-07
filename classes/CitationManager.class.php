<?php class CitationManager {

  public function __construct($db){
    $this->db = $db;
  }

  public function getList(){
    $listeCitations = array();
    $sql = 'SELECT concat(per_nom,per_prenom) as cit_nom_pers,c.cit_num as cit_num,cit_libelle,cit_date,avg(vot_valeur) as cit_note FROM citation c
    INNER JOIN personne p ON p.per_num=c.per_num
    INNER JOIN vote v ON v.cit_num=c.cit_num
    WHERE cit_valide=1 and cit_date_valide IS NOT NULL
    GROUP BY c.cit_num
    ORDER BY cit_date DESC
    LIMIT 2';
    $req= $this->db->query($sql);
    while ($citation = $req->fetch(PDO::FETCH_OBJ)){

      $listeCitations[]=new Citation($citation);

    }
    return $listeCitations;
    $req->closeCursor();
  }

  public function getNombre(){

    $sql = 'SELECT count(cit_num) as nombreCitation from Citation
    WHERE cit_valide=1 and cit_date_valide IS NOT NULL';
    $req=$this->db->query($sql);

    $nombreCitation=$req->fetch(PDO::FETCH_OBJ);

    return $nombreCitation;
  }

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

  public function getLibelle($citnum){
    $req=$this->db->prepare('SELECT cit_libelle as libelle FROM citation WHERE cit_num=:citnum');
    $req->bindValue(':citnum',$citnum,PDO::PARAM_INT);
    $req->execute();
    $resultat=$req->fetch(PDO::FETCH_OBJ);
    $req->closeCursor();
    return $resultat->libelle;

  }

  public function getNomPers($citnum){
    $req=$this->db->prepare('SELECT concat(per_nom,per_prenom) as cit_nom_pers FROM citation c
    JOIN personne p ON p.per_num=c.per_num WHERE cit_num=:citnum');
    $req->bindValue(':citnum',$citnum,PDO::PARAM_INT);
    $req->execute();
    $resultat=$req->fetch(PDO::FETCH_OBJ);
    $req->closeCursor();
    return $resultat->cit_nom_pers;

  }

  public function getListEnseignant(){
    $listeNom=array();

    $sql = 'SELECT per_num,per_nom from personne p where EXISTS (select per_num from salarie s where s.per_num=p.per_num) order by 1';
    $req=$this->db->prepare($sql);

    $req->execute();

    while ($nom = $req->fetch(PDO::FETCH_OBJ)){
      $listeNom[]=new Personne ($nom);
    }

    //print_r($listeNom);
    return $listeNom;
    $req->closeCursor();
  }


  public function ajouterCitation($enseignant,$etudiant,$date,$citation){
    $requete = $this->db->prepare(
    'INSERT INTO citation(per_num, per_num_etu, cit_libelle, cit_date) VALUES (:per_num,:per_num_etu,:cit_libelle,:cit_date)');

    $requete->bindValue(':per_num',$enseignant);
    $requete->bindValue(':per_num_etu',$etudiant);
    $requete->bindValue(':cit_libelle',$citation);
    $requete->bindValue(':cit_date',$date);



    $retour=$requete->execute();
    return $retour;

  }

  public function verifierMot($mot){
    $requete = $this->db->prepare(
    "SELECT mot_interdit from mot where mot_interdit=:mot");
    $requete->bindValue(':mot',$mot);
    $requete->execute();
    $resultat=$requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
    return $resultat;
  }

  public function verifierPhrase($phrase){
    $requete = $this->db->prepare(

    "SELECT mot_interdit from mot where MATCH(mot_interdit) AGAINST(:phrase)");
    $requete->bindValue(':phrase',$phrase);

    $requete->execute();
    $resultat=$requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
    return $resultat;
  }

  public function supprimerCitationEtu($nump){
    $requete = $this->db->prepare(
      "DELETE FROM citation where per_num_etu='$nump';");
      $retour=$requete->execute();
      return $retour;
  }

  public function supprimerCitationSal($nump){
    $requete = $this->db->prepare(
      "DELETE FROM citation where per_num='$nump';");
      $retour=$requete->execute();
      return $retour;
  }

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

public function supprimerVoteCit($numc){
  $requete = $this->db->prepare(
    "DELETE FROM vote where cit_num='$numc';");
    $retour=$requete->execute();
    return $retour;
}

public function supprimerVotePer($numc){
  $requete = $this->db->prepare(
    "DELETE FROM vote where per_num='$numc';");
    $retour=$requete->execute();
    return $retour;
}

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
    /*
    echo "<pre>";
    print_r($req->debugDumpParams());
    echo "/<pre>";
    */
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



}
// test de commentaire
// test de fetch
