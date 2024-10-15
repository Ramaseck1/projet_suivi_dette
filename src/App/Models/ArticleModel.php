<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Models;
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ArticleEntity; // Importer la classe MysqlDatabase
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ClientEntity; // Importer la classe MysqlDatabase

use RamaSeck\ProjetSuiviDette3Mvc\App\App;

use PDO;
use PDOException;

class ArticleModel {
    private $db;

    public function __construct() {
        $this->db = App::getDatabase()->getConnection();
    }

    // Méthode pour récupérer tous les articles
    public function getAllArticles() {
        $stmt = $this->db->prepare("SELECT * FROM Article");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un article par son ID
    public function getArticleByIdDette($id) {
        try {
            $stmt = $this->db->prepare("SELECT  
        A.id,A.libelle,A.qte,A.prix,A.montant
         from Article A
         join dette d
         on d.id=A.dette_id  
         WHERE A.dette_id=:id;");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $data;
          
       
         
           
            /*  if ($data) {
               $article = new ArticleEntity();
                $article->setId($data['id']);
                $article->setlibelle($data['libelle']);
                $article->setqte($data['qte']);
                $article->setprix($data['prix']);
               
                return $article;
             } */
            
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }


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




}
?>
