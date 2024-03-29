<?php
class Ville {
  private $vil_num;
  private $vil_nom;

  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

  public function affecte($donnees){
    foreach ($donnees as $attribut => $valeurs){
      switch($attribut){

        case 'vil_num' : $this->setNumVille($valeurs);
        break;

        case 'vil_nom' : $this->setNomVille($valeurs);
        break;
      }
    }
  }

  public function setNumVille($vil_num){
    $this->vil_num=$vil_num;
  }

  public function setNomVille($vil_nom){
    $this->vil_nom=$vil_nom;
  }

  public function getNumVille(){
    return $this->vil_num;
  }

  public function getNomVille(){
    return $this->vil_nom;
  }

}
?>
