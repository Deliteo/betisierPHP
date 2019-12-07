<?php class VoteManager{

    public function __construct($db){
      $this->db=$db;
    }

    public function voterCitation($citNum,$perNum,$votValeur){
      $requete = $this->db->prepare(
        'INSERT INTO vote (cit_num,per_num,vot_valeur) VALUES (:cit_num,:per_num,:vot_valeur);');
        $requete->bindValue(':cit_num',$citNum);
        $requete->bindValue(':per_num',$perNum);
        $requete->bindValue(':vot_valeur',$votValeur);

        $retour=$requete->execute();
        return $retour;

    }

    public function getVotePer($nump){
      $listeVote = array();

      $sql = "select cit_num,per_num FROM vote where per_num = $nump";
      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($vote = $requete->fetch(PDO::FETCH_OBJ))
          $listeVote[] = new Citation($vote);

      $requete->closeCursor();
      if(empty($listeVote)){
        $listeVote = NULL;
      }
      return $listeVote;
  }

  public function getVoteCit($numc){
    $listeVote = array();

    $sql = "select cit_num,per_num FROM vote where cit_num = $numc";
    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($vote = $requete->fetch(PDO::FETCH_OBJ))
        $listeVote[] = new Citation($vote);

    $requete->closeCursor();
    if(empty($listeVote)){
      $listeVote = NULL;
    }
    return $listeVote;
}

public function supprimerVotePer($nump){
}

public function supprimerVoteCit($numc){
  
}

}
?>
