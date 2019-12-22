<?php class VilleManager{

    public function __construct($db){
      $this->db=$db;
    }

    // fonction qui retourne la liste des villes
    public function getList(){
      $listeVilles=array();

      $sql = 'SELECT vil_num,vil_nom from ville order by vil_nom';
      $req=$this->db->prepare($sql);
      $req->execute();

      while ($ville = $req->fetch(PDO::FETCH_OBJ)){
        $listeVilles[]=new Ville ($ville);
      }

      return $listeVilles;
      $req->closeCursor();
    }

    //fonction qui retourne le nombre de villes enregistrées
    public function getNombre(){

      $sql = 'SELECT count(vil_nom) as nombreVilles from ville';
      $req=$this->db->prepare($sql);
      $req->execute();

      $nombreVilles=$req->fetch(PDO::FETCH_OBJ);

      return $nombreVilles;
    }

    // fonction qui ajoute une ville
    public function ajouterVille($ville){
      $requete = $this->db->prepare(
      'INSERT INTO Ville (vil_nom) VALUES (:vil_nom);');

      $nomVille=$ville->getNomVille();
      $requete->bindValue(':vil_nom',$nomVille);


      $retour=$requete->execute();
      return $retour;
    }

    public function listeVille(){
      $sql = "SELECT vil_nom as ville from ville";
      $listeVille=$this->db->prepare($sql);
      $listeVille->execute();

      return $listeVille;
    }

    // fonction qui retourne le numéro d'une ville
    public function getNumVil($nom){
      $sql = "SELECT vil_num as num from ville where vil_nom='$nom'";
      $req=$this->db->prepare($sql);
      $req->execute();

      $num=$req->fetch(PDO::FETCH_OBJ);
      return $num;
    }

    //fonction qui supprime une ville
    public function supprimerVille($numv){
      $requete = $this->db->prepare(
        "DELETE from ville where vil_num='$numv';");

        $retour=$requete->execute();
        return $retour;
    }

    //fonction qui retourne la liste des départements d'une ville
    public function getDepartement($numVille){
      $listeDepartements = array();

      $sql = "select dep_num FROM departement where vil_num = $numVille";

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($departement = $requete->fetch(PDO::FETCH_OBJ))
          $listeDepartements[] = new Departement($departement);

      $requete->closeCursor();
      if(empty($listeDepartements)){
        $listeDepartements = NULL;
      }
      return $listeDepartements;
    }

    // fonction qui modifie une ville
    public function modifierVille($nomV,$numV){
      $requete = $this->db->prepare(
      "UPDATE ville set vil_nom=:nom_vil where vil_num='$numV';");

      $requete->bindValue(':nom_vil',$nomV);


      $retour=$requete->execute();
      return $retour;
    }
  }
?>
