<?php class DepartementManager {

		public function __construct($db){
			$this->db = $db;
		}

		// fonction qui retourne la liste des départements
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

	//fonction qui supprime les départements d'une ville
	public function supprimerDepartementVille($numVille){
		$sql = "delete from departement
						WHERE vil_num = $numVille";

		$requete = $this->db->prepare($sql);
		$requete->execute();
	}

	// fonction qui permet de supprimer un département
	public function supprimerDepartement($numDep){
		$sql = "delete from departement where dep_num=$numDep";

		$requete = $this->db->prepare($sql);
		$requete->execute();
	}

	// fonction qui retourne la liste des étudiants d'un département
  public function getPersonne($dep_num){
    $listePer = array();

    $sql = "select per_num FROM Departement d join Etudiant e where d.dep_num=e.dep_num and dep_num = $dep_num";

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

// fonction qui retourne la liste des départements d'une ville
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



}

?>
