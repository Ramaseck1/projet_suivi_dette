<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Controllers;
use RamaSeck\ProjetSuiviDette3Mvc\App\App;
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\PaiementEntity;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\PaiementModel; 
class PaiementController{

    public function __construct() {
        $this->app = App::getInstance();
        $this->paiementModel = new PaiementModel(); // Initialisation de ClientModel
       // Démarrer la session

    }  
public function paiement() {

    $id=$_POST["liste"];
    $_SESSION['id_d']=$id;
    var_dump($id);
    $paiements=$this->paiementModel->getPaiementByid($id);
    $client=$this->paiementModel->getClientByid($id);
    $dette=$this->paiementModel->getDettebyclient($id);



    

    include '../views/paiement.html.php';
    
    // var_dump($dette);
      
}

public function addMontVTOPaiment() {
  
    $id=$_POST["paye"];
    $_SESSION['id_d']=$id;
    $client=$this->paiementModel->getClientByid($id);
    $dette=$this->paiementModel->getDettebyclient($id);

     $data = [
            'montant_verse' => $_POST['montant_verse'] ?? '',
            'dette_id' =>  $_POST['dette_id'] ?? '',
           
     ];

    if ($this->paiementModel->EnregistrerPaiement($data)) {
            $_SESSION['message'] = 'Le montant a été ajouté avec succès';
    } else {
            $_SESSION['message'] = 'Échec de l\'enregistrement du paiement';
        }

        include '../views/ajouterMontant.html.php';
        exit;
 
      
    }

}
