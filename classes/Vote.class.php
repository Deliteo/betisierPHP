<?php

class Vote {

  private citNum;
  private perNum;
  private votValeur;

  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

  public function affecte($donnees){
    foreach ($donnees as $attribut => $valeurs){
      switch($attribut){

        case 'cit_num' : $this->setNumCit($valeurs);
        break;

        case 'per_num' : $this->setNumPer($valeurs);
        break;

        case 'vot_valeur' : $this->setVotValeur($valeurs);
        break;
      }
    }
  }

  public function setNumCit($citnum){
    $this->citNum=$citnum;
  }
  public function setNumPer($pernum){
    $this->perNum=$pernum;
  }
  public function setVotValeur($valvot){
    $this->votValeur=$valvot;
  }

  public function getNumCit(){
    return $this->citNum;
  }
  public function getNumPer(){
    return $this->perNum;
  }
  public function getVotValeur(){
    return $this->votValeur;
  }

}

?>
