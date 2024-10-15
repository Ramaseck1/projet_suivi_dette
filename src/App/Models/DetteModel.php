<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Models;

use RamaSeck\ProjetSuiviDette3Mvc\App\App;
use PDO;
use PDOException;

class DetteModel {
    private $db;

    public function __construct() {
        $this->db = App::getDatabase()->getConnection();
    }

    public function addDette($client_id, $date, $montant, $montant_verse, $montant_restant) {
        try {
            // Insérer une nouvelle dette
            $stmt = $this->db->prepare("
                INSERT INTO dette (client_id, date, montant, montant_verse, montant_restant)
                VALUES (:client_id, :date, :montant, :montant_verse, :montant_restant)
            ");

            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':montant_verse', $montant_verse);
            $stmt->bindParam(':montant_restant', $montant_restant);
            $stmt->execute();

            // Mettre à jour le montant restant dans la table clients
            $clientModel = App::getModel('Client');
            $clientModel->updateMontantRestant($client_id, $montant_restant);

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }

    public function getDetteByClient($client_id) {
        $stmt = $this->db->prepare("SELECT date, montant, montant_restant, montant_verse FROM dette WHERE client_id = :client_id");
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
