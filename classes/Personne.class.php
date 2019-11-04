<?php
class Personne {
  private $per_num;
  private $per_nom;
  private $per_prenom;
  private $per_tel;
  private $per_mail;
  private $per_admin;
  private $per_login;
  private $per_pwd;



  public function __construct($valeurs = array()){
    if(!empty($valeurs))
      $this->affecte($valeurs);
  }

  public function affecte($donnees){
    foreach ($donnees as $attribut => $valeurs){
      switch($attribut){

        case 'per_num' : $this->setNumPer($valeurs);
        break;

        case 'per_nom' : $this->setNomPer($valeurs);
        break;

        case 'per_prenom' : $this->setPrenomPer($valeurs);
        break;

        case 'per_tel' : $this->setTelPer($valeurs);
        break;

        case 'per_mail' : $this->setMailPer($valeurs);
        break;

        case 'per_admin' : $this->setAdminPer($valeurs);
        break;

        case 'per_login' : $this->setLoginPer($valeurs);
        break;

        case 'per_pwd' : $this->setPwdPer($valeurs);
        break;
      }
    }
  }

  public function setNumPer($per_num){
    $this->per_num=$per_num;
  }

  public function setNomPer($per_nom){
    $this->per_nom=$per_nom;
  }

  public function setPrenomPer($per_prenom){
    $this->per_prenom=$per_prenom;
  }

  public function setTelPer($per_tel){
    $this->per_tel=$per_tel;
  }

  public function setMailPer($per_mail){
    $this->per_mail=$per_mail;
  }

  public function setAdminPer($per_admin){
    $this->per_admin=$per_admin;
  }

  public function setLoginPer($per_login){
    $this->per_login=$per_login;
  }

  public function setPwdPer($per_pwd){
    $this->per_pwd=$per_pwd;
  }





  public function getNumPer(){
    return $this->per_num;
  }

  public function getNomPer(){
    return $this->per_nom;
  }

  public function getPrenomPer(){
    return $this->per_prenom;
  }

  public function getTelPer(){
    return $this->per_tel;
  }

  public function getMailPer(){
    return $this->per_mail;
  }

  public function getAdminPer(){
    return $this->per_admin;
  }

  public function getLoginPer(){
    return $this->per_login;
  }

  public function getPwdPer(){
    return $this->per_pwd;
  }

}
?>
