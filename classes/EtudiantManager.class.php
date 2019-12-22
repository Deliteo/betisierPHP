
<?php class EtudiantManager{

    public function __construct($db){
      $this->db=$db;
    }

  // fonction qui retourne la liste des divisions
  public function listeDivision(){
    $sql = "SELECT div_nom as nom_div from division";
    $listeDiv=$this->db->prepare($sql);
    $listeDiv->execute();
    return $listeDiv;
  }

  // fonction qui retourne la liste des départements
  public function listeDepartement(){
    $sql = "SELECT dep_nom as nom_dep from departement";
    $listeDep=$this->db->prepare($sql);
    $listeDep->execute();
    return $listeDep;
  }

  // fonction qui retourne le numéro d'un département
  public function getNumDep($nomDep){
    $sql = "SELECT dep_num from departement where dep_nom='$nomDep'";
    $num=$this->db->prepare($sql);
    $num->execute();
    $req=$num->fetch(PDO::FETCH_OBJ);
    return $req;
  }

  //fonction qui retourne le numéro d'une division
  public function getNumDiv($nomDiv){
    $sql = "SELECT div_num from division where div_nom='$nomDiv'";
    $num=$this->db->prepare($sql);
    $num->execute();
    $req=$num->fetch(PDO::FETCH_OBJ);
    return $req;
  }

  // fonction qui ajoute un étudiant
      public function ajouterEtudiant($perNum,$depNum,$divNum){
        $requete = $this->db->prepare(
          'INSERT INTO etudiant (per_num,dep_num,div_num) VALUES (:per_num,:dep_num,:div_num);');
          $requete->bindValue(':per_num',$perNum);
          $requete->bindValue(':dep_num',$depNum);
          $requete->bindValue(':div_num',$divNum);

          $retour=$requete->execute();
          return $retour;

      }
      //fonction qui modifie un étudiant
      public function modifierEtudiant($nump,$depNum,$divNum){
        $requete = $this->db->prepare(
          "UPDATE etudiant set dep_num=:dep_num,div_num=:div_num where per_num='$nump';");
          $requete->bindValue(':dep_num',$depNum);
          $requete->bindValue(':div_num',$divNum);

          $retour=$requete->execute();
          return $retour;

      }

      // fonction qui supprime un étudiant
      public function supprimerEtudiant($nump){
        $requete = $this->db->prepare(
          "DELETE FROM etudiant where per_num='$nump';");

          $retour=$requete->execute();
          return $retour;

      }
}

?>
