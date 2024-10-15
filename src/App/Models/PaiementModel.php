<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Models;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Database\MysqlDatabase; // Importer la classe MysqlDatabase
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\PaiementEntity; // Importer la classe MysqlDatabase
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ClientEntity; // Importer la classe MysqlDatabase
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\DetteEntity; // Importer la classe MysqlDatabase

use PDO;
use PDOException;

class PaiementModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance()->getConnection(); // Utiliser MysqlDatabase pour obtenir la connexion
    }

   
   
   
    public function getPaiementByid ($id){
        try {
            $stmt = $this->db->prepare("SELECT
             p.id,p.montant_verse,p.date
             from paiement p
             join dette d
             on d.id=p.dette_id
             WHERE p.dette_id=:id;");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            return  $data;
            // if ($data) {
            //     $dettes = new DetteEntity();
            //     $dettes->setId($data['id']);
            //     $dettes->setDate($data['date']);
            //     $dettes->setMontant($data['montant']);
            //     $dettes->setmontant_restant($data['montant_restant']);
            //     $dettes->setmontant_verse($data['montant_verse']);      
            //     return $dettes;
            // }
            // return null;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }

    } 
    public function EnregistrerPaiement($data) {
        try {
            $stmt = $this->db->prepare("INSERT INTO paiement (montant_verse, dette_id,date) VALUES (:montant_verse, :dette_id, :CURDATE())");
            $stmt->bindParam(':montant_verse', $data['montant_verse']);
            $stmt->bindParam(':dette_id', $data['dette_id']);
            $stmt->execute();
            $this->updateDette($data['dette_id'], $data['montant_verse']);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    private function updateDette($dette_id, $montant_verse) {
        try {
            $stmt = $this->db->prepare("UPDATE dette
                                        SET montant_verse = montant_verse + :montant_verse, 
                                            montant_restant = montant_restant - :montant_verse
                                        WHERE id = :dette_id");
            $stmt->bindParam(':montant_verse', $montant_verse);
            $stmt->bindParam(':dette_id', $dette_id);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
        }
    }
    
    //table client
    public function getClientByid($id) {
        try {
           $stmt = $this->db->prepare("SELECT * FROM clients WHERE id = :id");
           $stmt->bindParam(':id', $id);
           $stmt->execute();
           $data = $stmt->fetch(PDO::FETCH_ASSOC);

           if ($data) {
              $client = new ClientEntity();
               $client->setId($data['id']);
               $client->setNom($data['nom']);
               $client->setPrenom($data['prenom']);
               $client->setEmail($data['email']);
               $client->setTel($data['tel']);
               $client->setPhoto($data['photo']);
               $client->setPassword($data['password']);
               return $client;
            }
           return null;
       } catch (PDOException $e) {
           // Gérer les erreurs de base de données
           return false;
       }
   }

   //table dette
   public function getDettebyclient($id){
    try {
        $stmt = $this->db->prepare("SELECT
         d.id,d.montant,d.montant_restant,d.montant_verse, d.date
         from dette d 
         join clients c 
         on c.id=d.client_id  
         WHERE d.client_id=:id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

     

       return $data;
       
       /*   if ($data) {
           $dettes = new DetteEntity();
            $dettes->setId($data['id']);
           $dettes->setDate($data['date']);
           $dettes->setMontant($data['montant']);
           $dettes->setMontant_restant($data['montant_restant']);
            $dettes->setmontant_verse($data['montant_verse']);      
           return $dettes;
        } */
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        return false;
    }


}


}


?>
