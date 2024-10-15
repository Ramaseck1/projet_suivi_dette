<?php

namespace RamaSeck\ProjetSuiviDette3Mvc\Core\Database;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class MysqlDatabase {
    private static $instance = null;
    protected $pdo;

    // Constructeur protégé pour empêcher l'instanciation directe
    protected function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            // Activer les exceptions PDO pour les erreurs
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Gérer les erreurs de connexion
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    // Méthode statique pour obtenir une instance unique de la connexion
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    // Méthode pour exécuter une requête avec des paramètres
    public function query($statement, $params = []) {
        $req = $this->pdo->prepare($statement);
        $req->execute($params);
        return $req;
    }

    // Méthode pour préparer une requête
    public function prepare($statement) {
        return $this->pdo->prepare($statement);
    }

    // Méthode pour tester la connexion
    public function testConnection() {
        try {
            $this->pdo->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Méthode pour obtenir l'objet PDO
    public function getConnection() {
        return $this->pdo;
    }
}
?>
