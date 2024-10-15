<?php 
use RamaSeck\ProjetSuiviDette3Mvc\App\Controllers\ArticleController;
use RamaSeck\ProjetSuiviDette3Mvc\App\Controllers\DetteController;
use RamaSeck\ProjetSuiviDette3Mvc\App\Controllers\PaiementController;
use RamaSeck\ProjetSuiviDette3Mvc\Core\Route;
use RamaSeck\ProjetSuiviDette3Mvc\App\Controllers\ClientController;
$clientController = new ClientController();

$router = new Route();
$router->ajouterRoute('/client/ajouter', ClientController::class, 'index');
$router->ajouterRoute('/client/enregistrer', ClientController::class, 'store');
$router->ajouterRoute('/client/ajouter', ClientController::class, 'search');
$router->ajouterRoute('/client/add', DetteController::class, 'add');
$router->ajouterRoute('/client/adddette', DetteController::class, 'addDette');
$router->ajouterRoute('/client/addsearch', DetteController::class, 'search');
$router->ajouterRoute('/client/addproduit', DetteController::class, 'addprodui');
$router->ajouterRoute('/client/addproduitTotable', DetteController::class, 'addproduitTotable');
$router->ajouterRoute('/client/paimentliste', PaiementController::class, 'paiement');
$router->ajouterRoute('/client/addpaiement', PaiementController::class, 'addMontVTOPaiment');
$router->ajouterRoute('/client/article', ArticleController::class, 'recuparticle');



return $router;
?>
