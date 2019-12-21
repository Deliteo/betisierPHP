<?php

class Citation {

  private $cit_nom_pers;
  private $cit_num;
  private $cit_libelle;
  private $cit_date;
  private $per_num_etu;

  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

  public function affecte($donnees){

    foreach($donnees as $attribut => $valeur){

      switch ($attribut){

        case 'cit_nom_pers': $this->setCitNomPers($valeur);
            break;

        case 'cit_num': $this->setCitNum($valeur);
            break;

        case 'cit_libelle': $this->setCitLibelle($valeur);
            break;

        case 'cit_date': $this->setCitDate($valeur);
            break;

            case 'per_num_etu': $this->setCitPerNumEtu($valeur);
                break;
      }

    }

  }

  public function setCitNomPers ($cit_nom_pers){
     $this->cit_nom_pers= $cit_nom_pers;
  }

  public function getCitNomPers(){
    return $this->cit_nom_pers;
  }

  public function setCitNum ($cit_num){
     $this->cit_num= $cit_num;
  }

  public function getCitNum(){
    return $this->cit_num;
  }

  public function setCitLibelle ($cit_libelle){
     $this->cit_libelle= $cit_libelle;
  }

  public function getCitLibelle(){
    return $this->cit_libelle;
  }

  public function setCitDate ($cit_date){
     $this->cit_date= $cit_date;
  }

  public function getCitDate(){
    return $this->cit_date;
  }

  public function setCitPerNumEtu ($per_num_etu){
     $this->per_num_etu= $per_num_etu;
  }

  public function getCitPerNumEtu(){
    return $this->per_num_etu;
  }
}


?>
