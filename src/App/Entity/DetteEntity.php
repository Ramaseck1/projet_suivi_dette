<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Entity;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Entity\Entity;

class DetteEntity extends Entity {
    protected $id;
    protected $date;
    protected $montant;
    protected $montant_restant; 
    protected $montant_verse;
  
    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
    }

    public function getMontant_restant() {
        return $this->montant_restant;
    }

    public function setMontant_restant($montant_restant) {
        $this->montant_restant = $montant_restant;
    }

    public function getmontant_verse() {
        return $this->montant_verse;
    }

    public function setmontant_verse($montant_verse) {
        $this->montant_verse = $montant_verse;
    }

    

}
?>
