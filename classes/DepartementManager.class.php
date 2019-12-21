<?php class DepartementManager {

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

		$requete = $this->db->prepare($sql);
		$requete->execute();
	}

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
