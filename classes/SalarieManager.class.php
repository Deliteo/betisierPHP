<?php class SalarieManager{

    public function __construct($db){
      $this->db=$db;
    }

    // fonction qui retourne la liste des formations
    public function listeFormation(){
      $sql = "SELECT fon_libelle from fonction";
      $listForm=$this->db->prepare($sql);
      $listForm->execute();
      return $listForm;
    }

    //fonction qui retourne le numéro de fonction
    public function getNumFonction($nomFon){
      $sql = "SELECT fon_num from fonction where fon_libelle='$nomFon'";
      $req=$this->db->prepare($sql);
      $req->execute();
      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    //fonction qui ajoute un salarié
    public function ajouterSalarie($perNum,$telPro,$formation){
      $requete = $this->db->prepare(
        'INSERT INTO salarie (per_num,sal_telprof,fon_num) VALUES (:per_num,:sal_telprof,:fon_num);');
        $requete->bindValue(':per_num',$perNum);
        $requete->bindValue(':sal_telprof',$telPro);
        $requete->bindValue(':fon_num',$formation);

        $retour=$requete->execute();
        return $retour;

    }

    // fonction qui modifie un salarié
    public function modifierSalarie($nump,$telPro,$formation){
      $requete = $this->db->prepare(
        "UPDATE salarie set sal_telprof=:telpro,fon_num=:formation where per_num='$nump';");
        $requete->bindValue(':telpro',$telPro);
        $requete->bindValue(':formation',$formation);

        $retour=$requete->execute();
        return $retour;

    }

    //fonction qui supprime un salarie
    public function supprimerSalarie($nump){
      $requete = $this->db->prepare(
        "DELETE from salarie where per_num='$nump';");

        $retour=$requete->execute();
        return $retour;

    }
  }
  ?>
