<?php class CitationManager {

  public function __construct($db){
    $this->db = $db;
  }

  public function getList(){
    $listeCitations = array();
    $sql = 'SELECT concat(per_nom,per_prenom) as cit_nom_pers,c.cit_num,cit_libelle,cit_date,avg(vot_valeur) as cit_note FROM citation c
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

}
