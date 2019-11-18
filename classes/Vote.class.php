<?php

class Vote {

  private citNum;
  private perNum;
  private votValeur;

  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

}

?>
