<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Models;
use RamaSeck\ProjetSuiviDette3Mvc\Core\Database\MysqlDatabase;
use RamaSeck\ProjetSuiviDette3Mvc\Core\Model\Model;
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ClientEntity;
use PDO;
use PDOException;


class ClientModel extends Model {
    protected $table = 'clients';
    private $db;


    public function __construct() {
        parent::__construct();
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM clients WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

      
        return null;
    }



    
    public function create(ClientEntity $client) {
        try {
            $hashedPassword = password_hash($client->getPassword(), PASSWORD_BCRYPT);
            $nom = $client->getNom();
            $prenom = $client->getPrenom();
            $email = $client->getEmail();
            $tel = $client->getTel();
            $photo = $client->getPhoto();
            $stmt = $this->database->prepare("INSERT INTO {$this->table} (nom, prenom, email, tel, photo, password) VALUES (:nom, :prenom, :email, :tel, :photo, :password)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':photo', $photo);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }

    public function getClientById($clientId) {
        $query = $this->db->prepare("SELECT * FROM clients WHERE id = :id");
        $query->bindParam(':id', $clientId);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function getClientByPhone($tel) {
         try {
            $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE tel = :tel");
            $stmt->bindParam(':tel', $tel);
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

    public function isPhoneNumberTaken($tel) {
        $stmt = $this->database->prepare("SELECT COUNT(*) AS count FROM {$this->table} WHERE tel = :tel");
        $stmt->bindParam(':tel', $tel);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function isEmailTaken($email) {
        $stmt = $this->database->prepare("SELECT COUNT(*) AS count FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function getLastInsertedId() {
        return $this->database->lastInsertId();
    }

    public function updateMontantRestant($client_id, $montant_restant) {
        try {
            $stmt = $this->database->prepare("
                UPDATE {$this->table}
                SET montant_restant = :montant_restant
                WHERE id = :client_id
            ");

            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':montant_restant', $montant_restant);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }
}
?>
