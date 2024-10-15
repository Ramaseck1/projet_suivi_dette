<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Database\MysqlDatabase;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\ClientModel;
use PDO;
use PDOException;
class App {
    private static $instance = null;
    private $database;

    private function __construct() {
        $this->database = MysqlDatabase::getInstance();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public static function getDatabase() {
        return self::getInstance()->database;
    }

    public static function getModel($model) {
        switch ($model) {
            case 'Client':
                return new ClientModel();
            case 'User':
                // return new UserModel();
            default:
                throw new \Exception("Model not found");
        }
    }

    public static function getClientByPhone($tel) {
        $clientModel = self::getModel('Client');
        return $clientModel->getClientByPhone($tel);
    }

    public static function isPhoneNumberTaken($tel) {
        $clientModel = self::getModel('Client');
        return $clientModel->isPhoneNumberTaken($tel);
    }

    public static function isEmailTaken($email) {
        $clientModel = self::getModel('Client');
        return $clientModel->isEmailTaken($email);
    }

    public static function getLastInsertedId() {
        $clientModel = self::getModel('Client');
        return $clientModel->getLastInsertedId();
    }

    public static function getSecurityDB() {
        return self::getDatabase();
    }
    public function getDetailsByClientId($clientId) {
        try {
            $stmt = $this->database->prepare('SELECT * FROM clients WHERE id = :client_id');
            $stmt->execute(['client_id' => $clientId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return null;
        }
    }
}
?>
