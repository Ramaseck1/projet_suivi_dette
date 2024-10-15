<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Entity;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Entity\Entity;

class PaiementEntity extends Entity {
    protected $id;
    protected $dette_id;
    protected $date;
    
    protected $montant_verse;
  
    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDette() {
        return $this->dette_id;
    }

    public function setDette($dette_id) {
        $this->dette = $dette_id;
    }

    public function getMontant() {
        return $this->montant_verse;
    }

    public function setMontant($montant_verse) {
        $this->montant = $montant_verse;
    }
    public function getDate() {
        return $this->date;
    }

    public function setDate($getDate) {
        $this->montant = $getDate;
    }

}
?>
