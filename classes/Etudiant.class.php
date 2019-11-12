<?php
class Etudiant {
  private $per_num;
  private $dep_num;
  private $div_num;
  private $vote_cit_num;
  private $vote_per_num;


  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

  public function affecte($donnees){
    foreach ($donnees as $attribut => $valeurs){
      switch($attribut){

        case 'per_num' : $this->setNumPer($valeurs);
        break;

        case 'dep_num' : $this->setDepEtu($valeurs);
        break;

        case '$div_num' : $this->setDivEtu($valeurs);
        break;

        case '$vote_cit_num' : $this->setVoteCitEtu($valeurs);
        break;

        case '$vote_per_num' : $this->setVotePerNum($valeurs);
        break;
      }
    }
  }

  public function setNumPer($per_num){
    $this->per_num=$per_num;
  }

  public function setDepEtu($dep_etu){
    $this->dep_etu=$dep_etu;
  }

  public function setDivEtu($div_num){
    $this->div_num=$div_num;
  }
  public function setVoteCitEtu($vote_cit_num){
    $this->vote_cit_num=$vote_cit_num;
  }

  public function setVotePerNum($vote_per_num){
    $this->vote_per_num=$vote_per_num;
  }




  public function getNumPer(){
    return $this->per_num;
  }

  public function getDepEtu(){
    return $this->dep_etu;
  }

  public function getDivEtu(){
    return $this->div_num;
  }

  public function getVoteCitEtu(){
    return $this->vote_cit_num;
  }

  public function getVotePerNum(){
    return $this->vote_per_num;
  }



}
?>
