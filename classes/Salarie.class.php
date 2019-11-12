<?php
class Salarie {
  private $per_num;
  private $sal_telprof;
  private $fon_num;

  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

  public function affecte($donnees){
    foreach ($donnees as $attribut => $valeurs){
      switch($attribut){

        case 'per_num' : $this->setNumPer($valeurs);
        break;

        case 'dep_num' : $this->setTelProf($valeurs);
        break;

        case '$div_num' : $this->setFor($valeurs);
        break;
      }
    }
  }

  public function setNumPer($per_num){
    $this->per_num=$per_num;
  }

  public function setTelProf($sal_telprof){
    $this->sal_telprof=$sal_telprof;
  }

  public function setFonNum($fon_num){
    $this->fon_num=$fon_num;
  }



  public function getNumPer(){
    return $this->per_num;
  }

  public function getTelProf(){
    return $this->sal_telprof;
  }

  public function getFonNum(){
    return $this->fon_num;
  }




}
?>
