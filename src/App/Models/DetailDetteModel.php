<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Models;

use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ArticleEntity;
use RamaSeck\ProjetSuiviDette3Mvc\Core\Database\MysqlDatabase; // Importer la classe MysqlDatabase
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\DetteEntity; // Importer la classe MysqlDatabase
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ClientEntity; // Importer la classe MysqlDatabase

use PDO;
use PDOException;
use Exception;

class DetailDetteModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance()->getConnection(); // Utiliser MysqlDatabase pour obtenir la connexion
    }

   
    public function getAll()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM DetailDette");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les lignes de la table detaildette
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return [];
        }
    }

  
    
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


public function Enregistrerproduit($data) {
    try {
        $stmt = $this->db->prepare(" INSERT INTO Article (libelle, prix, qte,ref,montant) VALUES (:libelle, :prix, :qte , :ref,:montant)");
        $stmt->bindParam(':libelle', $data['libelle']);
        $stmt->bindParam(':prix', $data['prix']);
        $stmt->bindParam(':ref', $data['ref']);
        $stmt->bindParam(':qte', $data['qte']);
        $stmt->bindParam(':montant', $data['montant']);
        $stmt->execute();
/*         $this->updateDette($data['dette_id'], $data['montant_verse']);
 */        return true;

        
    } catch (PDOException $e) {
        return false;
    }
  
}

//recherhe par ref dans la table article

public function getArticleByref($ref) {
    try {
       $stmt = $this->db->prepare("SELECT * FROM Article WHERE ref = :ref");
       $stmt->bindParam(':ref', $ref);
       $stmt->execute();
       $data = $stmt->fetch(PDO::FETCH_ASSOC);
       
       // Debugging
   
     
       return $data;
   } catch (PDOException $e) {
       // Gérer les erreurs de base de données
       var_dump($e->getMessage()); // Debugging
       return false;
   }
}
/* public function getAllArticles() {
    try {
        $stmt = $this->db->prepare("SELECT * FROM Article");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
} */
public function getTotalMontant() {
    try {
        $stmt = $this->db->prepare("SELECT SUM(montant) as total_montant FROM ArticleDette");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_montant'] !== null ? $result['total_montant'] : 0; // Assurez-vous que la valeur retournée est un nombre
    } catch (PDOException $e) {
        error_log('Error calculating total amount: ' . $e->getMessage()); // Log de l'erreur
        return 0; // Retourner 0 en cas d'erreur
    }
}


public function updateArticleQte($id, $newQte) {
    try {
        $stmt = $this->db->prepare("UPDATE Article SET qte = :qte WHERE id = :id");
        $stmt->bindParam(':qte', $newQte);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

public function enregistrerProduitDansArticleDette($data) {
    $sql = "INSERT INTO ArticleDette (libelle, prix, qte, montant, article_id, dette_id)
            VALUES (:libelle, :prix, :qte, :montant, :article_id, :dette_id)";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':libelle', $data['libelle']);
    $stmt->bindParam(':prix', $data['prix']);
    $stmt->bindParam(':qte', $data['qte']);
    $stmt->bindParam(':montant', $data['montant']);
    $stmt->bindParam(':article_id', $data['article_id']);
    $stmt->bindParam(':dette_id', $data['dette_id']);

    return $stmt->execute();
}





public function getAllArticlesDette() {
    try {
        $stmt = $this->db->prepare("SELECT * FROM ArticleDette");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

public function getAllArticlesDetteWithDetails() {
    try {
        $stmt = $this->db->prepare("
            SELECT 
                ad.id,
                a.libelle,
                a.prix,
                ad.qte,
                ad.montant,
                d.id AS dette_id,           -- Ajout de l'ID de la dette
                d.date AS dette_date,       -- Ajout de la date de la dette (ou tout autre champ pertinent)
                d.montant AS dette_montant   -- Ajout du montant de la dette (si nécessaire)
            FROM 
                ArticleDette ad
            JOIN 
                Article a 
            ON 
                ad.article_id = a.id
            JOIN 
                dette d
            ON 
                ad.dette_id = d.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error fetching articles and details: ' . $e->getMessage());
        return false;
    }
}


public function transaction($callback)
{
    $this->db->beginTransaction();
    try {
        $callback();
        $this->db->commit();
        return true;
    } catch (\PDOException $e) {
        $this->db->rollBack();
        // Log de l'erreur ou gestion d'erreur personnalisée
        error_log('Transaction Error: ' . $e->getMessage());
        return false;
    }
}
public function insertDette($data)
{
    try {
        $stmt = $this->db->prepare("INSERT INTO Dette (id_client, montant) VALUES (:id_client, :montant)");
        $stmt->bindParam(':id_client', $data['id_client']);
        $stmt->bindParam(':montant', $data['montant']);
        $stmt->execute();
        return $this->db->lastInsertId();
    } catch (\PDOException $e) {
        // Log de l'erreur ou gestion d'erreur personnalisée
        error_log('Insert Dette Error: ' . $e->getMessage());
        return false;
    }
}
public function recuplastId()
{
    try {
        $stmt = $this->db->query("SELECT MAX(id) as last_id FROM Dette");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['last_id'];
    } catch (\PDOException $e) {
        // Log de l'erreur ou gestion d'erreur personnalisée
        error_log('Fetch Last Dette ID Error: ' . $e->getMessage());
        return false;
    }
}

    
}
?>
