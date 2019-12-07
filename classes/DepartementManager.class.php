<?php

class DepartementManager {
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function getAllDepartement(){
            $listeDepartements = array();

            $sql = 'select * FROM departement';

            $requete = $this->db->prepare($sql);
            $requete->execute();

            while ($departement = $requete->fetch(PDO::FETCH_OBJ))
                $listeDepartements[] = new Departement($departement);

            $requete->closeCursor();
            return $listeDepartements;
		}


	public function supprimerDepartementVille($numVille){
		$sql = "delete from departement
						WHERE vil_num = $numVille";

		$requete = $this->db->prepare($sql);
		$requete->execute();
	}

	public function supprimerDepartement($numDep){
		$sql = "delete from departement where dep_num=$numDep";

		print_r($sql);
		$requete = $this->db->prepare($sql);
		$requete->execute();
	}

  public function getPersonne($dep_num){
    $listePer = array();

    $sql = "select per_num FROM Etudiant where dep_num = $dep_num";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($personne = $requete->fetch(PDO::FETCH_OBJ))
        $listePer[] = new Etudiant($personne);

    $requete->closeCursor();
    if(empty($listePer)){
      $listePer = NULL;
    }
    return $listePer;
}



}

?>
