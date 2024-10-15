<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Controllers;
use RamaSeck\ProjetSuiviDette3Mvc\App\App;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\DetailDetteModel; 
class DetteController{

    public function __construct() {
        $this->app = App::getInstance();
        $this->detteModel = new DetailDetteModel(); // Initialisation de ClientModel
       // Démarrer la session
session_start();


    }  
public function add() {

    $id=$_POST["dette"];
      
    $dettes=$this->detteModel->getDettebyclient($id);
   
    $client=$this->detteModel->getClientByid($id);
   
    include '../views/listeDette.html.php';
    
    // var_dump($dette);
  



    
}


public function addDette(){

    $id=$_POST["nouvelle"];
    $_SESSION['id']=$id;
    var_dump('$id');


    $arts= $this->detteModel->getAllArticles($id);
    $client=$this->detteModel->getClientByid($id);

  
 
    include '../views/ajoutdette.html.php';
}

public function search() {
    if (isset($_POST['ref'])) {
        $ref = $_POST['ref'] ?? '';
        $article = $this->detteModel->getArticleByref($ref);

        // Debugging
       /*  var_dump($ref);
        var_dump($article); */

        if ($article) {
            $_SESSION['article'] = $article; // Stocker l'article trouvé dans la session
/*             var_dump($_SESSION['article']); // Vérifier que l'article est bien stocké dans la session
 */        } else {
            $_SESSION['message'] = 'Aucun article trouvé pour la référence donnée.';
        }

        include '../views/ajoutdette.html.php';
    }
}

public function addproduitTotable() {
    if (isset($_POST['ok']) && isset($_SESSION['article'])) {
        $article = $_SESSION['article'];

        // Récupération des données du formulaire
        $qte = $_POST['qte'] ?? $article['qte'];
        $ref = $article['ref'];
        $dette_id = $_POST['dette_id'] ?? null;
        $libelle = $_POST['libelle'] ?? $article['libelle'];

        // Debugging: var_dump and error_log
        var_dump('Quantité:', $qte, 'Référence:', $ref, 'Dette ID:', $dette_id, 'Libellé:', $libelle);
        error_log('Quantité: ' . $qte . ', Référence: ' . $ref . ', Dette ID: ' . $dette_id . ', Libellé: ' . $libelle);

        // Vérification des données reçues
        if (empty($qte) || empty($ref) || empty($dette_id) || empty($libelle)) {
            $_SESSION['message'] = 'Veuillez remplir tous les champs.';
            include '../views/ajoutdette.html.php';
            return;
        }

        // Récupérer l'article depuis la base de données pour vérifier la quantité en stock
        $articleFromDB = $this->detteModel->getArticleByref($ref);

        // Debugging: var_dump and error_log
        var_dump('Article from DB:', $articleFromDB);
        error_log('Article from DB: ' . print_r($articleFromDB, true));

        if (!$articleFromDB) {
            $_SESSION['message'] = 'Article introuvable dans la base de données.';
            include '../views/ajoutdette.html.php';
            return;
        }

        // Vérifier si la quantité saisie est supérieure à la quantité en stock
        if ($qte > $articleFromDB['qte']) {
            $_SESSION['message'] = 'Quantité demandée supérieure à la quantité en stock.';
            include '../views/ajoutdette.html.php';
            return;
        }

        // Calculer le montant
        $montant = $articleFromDB['prix'] * $qte;

        // Debugging: var_dump and error_log
        var_dump('Montant calculé:', $montant);
        error_log('Montant calculé: ' . $montant);

        // Diminuer la quantité en stock dans la table Article
        $newQte = $articleFromDB['qte'] - $qte;
        if (!$this->detteModel->updateArticleQte($articleFromDB['id'], $newQte)) {
            $_SESSION['message'] = 'Échec de la mise à jour de la quantité.';
            include '../views/ajoutdette.html.php';
            return;
        }

        // Insérer les données dans la table ArticleDette
        $articleDetteData = [
            'libelle' => $libelle,
            'prix' => $articleFromDB['prix'],
            'qte' => $qte,
            'montant' => $montant,
            'article_id' => $articleFromDB['id'],
            'dette_id' => $dette_id
        ];

        // Debugging: var_dump and error_log
        var_dump('Données à insérer dans ArticleDette:', $articleDetteData);
        error_log('Données à insérer dans ArticleDette: ' . print_r($articleDetteData, true));

        if ($this->detteModel->enregistrerProduitDansArticleDette($articleDetteData)) {
            $_SESSION['message'] = 'Le produit a été ajouté avec succès';
        } else {
            $_SESSION['message'] = 'Échec de l\'enregistrement du produit';
        }

        include '../views/ajoutdette.html.php';
        exit;
    } else {
        $_SESSION['message'] = 'Aucun article trouvé dans la session.';
        include '../views/ajoutdette.html.php';
        exit;
    }
}



public function displayTotalMontant() {
    // Calculer le montant total
    $totalMontant = $this->detteModel->getTotalMontant();
    
    // Vérifier le résultat et stocker dans la session
    if ($totalMontant !== false) {
        $_SESSION['total_montant'] = number_format($totalMontant, 2, '.', ''); // Formatage en deux décimales
    } else {
        $_SESSION['message'] = 'Erreur lors du calcul du montant total';
        $_SESSION['total_montant'] = '0.00'; // Assurez-vous que le montant est défini même en cas d'erreur
    }

    // Inclure la vue
    include '../views/ajoutdette.html.php';
}




}






