<?php class SalarieManager{

    public function __construct($db){
      $this->db=$db;
    }
    public function listeFormation(){
      $sql = "SELECT fon_libelle from fonction";
      $listForm=$this->db->query($sql);
      return $listForm;
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

    public function modifierSalarie($nump,$telPro,$formation){
      $requete = $this->db->prepare(
        "UPDATE salarie set sal_telprof=:telpro,fon_num=:formation where per_num='$nump';");
        $requete->bindValue(':telpro',$telPro);
        $requete->bindValue(':formation',$formation);

        $retour=$requete->execute();
        return $retour;

    }

    public function supprimerSalarie($nump){
      $requete = $this->db->prepare(
        "DELETE from salarie where per_num='$nump';");

        $retour=$requete->execute();
        return $retour;

    }
  }
  ?>
