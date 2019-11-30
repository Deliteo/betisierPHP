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

}
?>
