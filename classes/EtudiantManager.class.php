
<?php class EtudiantManager{

    public function __construct($db){
      $this->db=$db;
    }


  public function listeDivision(){
    $sql = "SELECT div_nom as nom_div from division";
    $listeDiv=$this->db->query($sql);

    return $listeDiv;
  }

  public function listeDepartement(){
    $sql = "SELECT dep_nom as nom_dep from departement";
    $listeDep=$this->db->query($sql);

    return $listeDep;
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


      public function ajouterEtudiant($perNum,$depNum,$divNum){
        $requete = $this->db->prepare(
          'INSERT INTO etudiant (per_num,dep_num,div_num) VALUES (:per_num,:dep_num,:div_num);');
          $requete->bindValue(':per_num',$perNum);
          $requete->bindValue(':dep_num',$depNum);
          $requete->bindValue(':div_num',$divNum);

          $retour=$requete->execute();
          return $retour;

      }

      public function modifierEtudiant($nump,$depNum,$divNum){
        $requete = $this->db->prepare(
          "UPDATE etudiant set dep_num=:dep_num,div_num=:div_num where per_num='$nump';");
          $requete->bindValue(':dep_num',$depNum);
          $requete->bindValue(':div_num',$divNum);

          $retour=$requete->execute();
          return $retour;

      }

      public function supprimerEtudiant($nump){
        $requete = $this->db->prepare(
          "DELETE FROM etudiant where per_num='$nump';");

          $retour=$requete->execute();
          return $retour;

      }
}

?>
