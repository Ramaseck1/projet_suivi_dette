<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Controllers;

use RamaSeck\ProjetSuiviDette3Mvc\App\App;
use RamaSeck\ProjetSuiviDette3Mvc\Core\Validators\Validators;
use RamaSeck\ProjetSuiviDette3Mvc\App\Entity\ClientEntity;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\ClientModel;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\DetteModel;
use RamaSeck\ProjetSuiviDette3Mvc\Core\File;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\DetailDetteModel; 
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\ArticleModel; // Ajout du modèle ArticleModel

use PDOException;
class ClientController {
    private $app;
    private $clientModel;

    public function __construct() {
        $this->app = App::getInstance();
        $this->clientModel = new ClientModel(); // Initialisation de ClientModel
       // Démarrer la session

    }   

    public function index() {
       
        $client = null;
        $dettes = null;
        $detaildette = null;

        if (isset($_POST['tel']) && !empty($_POST['tel'])) {
            $client = $this->app->getClientByPhone($_POST['tel']);

            if ($client) {
                $detteModel = new DetteModel();
                $dettes = $detteModel->getDetteByClient($client->getId());

             
                // Stocker l'ID du client en session pour une utilisation ultérieure
                $_SESSION['client_id'] = $client->getId();
                die();
            } else {
                $_SESSION['error'] = "Aucun client trouvé avec ce numéro de téléphone.";
                include '../views/home.html.php'; // Ou une autre vue appropriée pour gérer l'erreur
                return;
            }
        }

       include '../views/home.html.ph p';
    }

   
    



        public function store() {
        // Les données du formulaire
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'email' => $_POST['email'] ?? '',
            'tel' => $_POST['tel'] ?? '',
            'photo' => '',
            'password' => '123passer' // Mot de passe par défaut
        ];

        // Règles de validation
        $rules = [
            'nom' => ['required', ['regex', '/^[a-zA-ZÀ-ÿ\'\- ]{1,30}$/u']],
            'prenom' => ['required', ['regex', '/^[a-zA-ZÀ-ÿ\'\- ]{1,30}$/u']],
            'email' => ['required', 'email'],
            'tel' => ['required', ['regex', '/^(77|33)[0-9]{7}$/']],
            'photo' => ['file', ['required' => true], ['mimes', ['image/jpeg', 'image/png']], ['max', 2048]]
        ];

        // Validation des données
        $validator = new Validators();
        $errors = $validator->validate($data, $rules);

        if ($validator->hasErrors()) {
            $_SESSION['errors'] = $errors;
            include '../views/home.html.php';
            return;
        }

        // Traitement de l'upload de la photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '/var/www/html/Projet_suivi_dette_3_MVC/public/img/';

            // Utilisation de la classe FileHandler pour gérer l'upload de l'image
            $result = File::uploadImage($_FILES['photo'], $uploadDir);

            if (!empty($result['errors'])) {
                // Gestion des erreurs d'upload
                $_SESSION['errors'] = $result['errors'];
                include '../views/home.html.php';
                return;
            }

            // Récupération du nom de la photo téléchargée
            $photoName = $result['photoName'];

            // Vous pouvez ensuite utiliser $photoName dans votre application, par exemple l'enregistrer dans la base de données
            $data['photo'] = $photoName;
        } else {
            $_SESSION['errors']['photo'] = "Erreur lors de l'upload de la photo.";
            include '../views/home.html.php';
            return;
        }

        // Vérifications supplémentaires
        if ($this->app->isPhoneNumberTaken($data['tel'])) {
            $errors['tel'] = 'Ce numéro de téléphone existe déjà.';
        }
        if ($this->app->isEmailTaken($data['email'])) {
            $errors['email'] = 'Cet email existe déjà.';
        }

        if (empty($errors)) {
            $client = new ClientEntity();
            $client->setNom($data['nom']);
            $client->setPrenom($data['prenom']);
            $client->setEmail($data['email']);
            $client->setTel($data['tel']);
            $client->setPhoto($data['photo']);
            $client->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));

            $clientModel = new ClientModel();
            if ($clientModel->create($client)) {
                $client_id = $this->app->getLastInsertedId();
                $detteModel = new DetteModel();
                $montant = 1500.00;
                $montant_verse = 0.00;
                $montant_restant = $montant - $montant_verse;
                $detteModel->addDette($client_id, date('Y-m-d'), $montant, $montant_verse, $montant_restant);

                $_SESSION['notification'] = "Client ajouté!";
                include '../views/home.html.php';
                return;
            } else {
                $_SESSION['errors'][] = "Erreur lors de l'enregistrement du client.";
            }
        }

        include '../views/home.html.php';
    }

    public function search() {
        $tel = $_POST['tel'] ?? '';

        if (!empty($tel)) {
            $client = $this->app->getClientByPhone($tel);
            $_SESSION['nom']=$client->getNom();
            $_SESSION['prenom']=$client->getPrenom();
           var_dump($_SESSION['nom'],$_SESSION['prenom']);
            if ($client) {
                $detteModel = new DetteModel();
                $dettes = $detteModel->getDetteByClient($client->getId());
                include '../views/home.html.php';
            } else {
                $error = "Aucun client trouvé avec ce numéro de téléphone.";
                include '../views/home.html.php';
            }
        } else {
            $error = "Veuillez entrer un numéro de téléphone.";
            include '../views/home.html.php';
        }
    }

    public function addDette() {
        $detteModel = new DetteModel();
        $client_id = 2;
        $date = date('Y-m-d');
        $montant = 00.00;
        $montant_verse = 00.00;
        $montant_restant = $montant - $montant_verse;

        if ($detteModel->addDette($client_id, $date, $montant, $montant_verse, $montant_restant)) {
            echo "Dette ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la dette.";
        }
    }

    public function getDettesByClient($client_id) {
        $detteModel = new DetteModel();
        $dettes = $detteModel->getDetteByClient($client_id);

        var_dump($dettes);
    }
}
?>
