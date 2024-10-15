<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Entity;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Entity\Entity;

class ArticleEntity extends Entity {
    protected $id;
    protected $libelle;
    protected $qte;
    protected $ref;
    protected $prix; 
    protected $montant;
  


    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getlibelle() {
        return $this->libelle;
    }

    public function setlibelle($libelle) {
        $this->libelle = $libelle;
    }

    public function getqte() {
        return $this->qte;
    }

    public function setqte($qte) {
        $this->qte = $qte;
    }

    public function getprix() {
        return $this->prix;
    }

    public function setprix($prix) {
        $this->prix = $prix;
    }

    public function getref() {
        return $this->dette_id;
    }

    public function setref($ref) {
        $this->ref = $ref;
    }

    public function getmontant() {
        return $this->montant;
    }

    public function setmontant($montant) {
        $this->montant = $montant;
    }

   

    
}
?>
