<?php class VilleManager{

    public function __construct($db){
      $this->db=$db;
    }

    public function getList(){
      $listeVilles=array();

      $sql = 'SELECT vil_num,vil_nom from ville order by vil_nom';
      $req=$this->db->query($sql);

      while ($ville = $req->fetch(PDO::FETCH_OBJ)){
        $listeVilles[]=new Ville ($ville);
      }

      return $listeVilles;
      $req->closeCursor();
    }

    public function getNombre(){

      $sql = 'SELECT count(vil_nom) as nombreVilles from ville';
      $req=$this->db->query($sql);

      $nombreVilles=$req->fetch(PDO::FETCH_OBJ);

      return $nombreVilles;
    }

    public function ajouterVille($ville){
            $requete = $this->db->prepare(
            'INSERT INTO Ville (vil_nom) VALUES (:vil_nom);');

            $requete->bindValue(':vil_nom',$ville);


            $retour=$requete->execute();
            return $retour;
        }
}
?>
