<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\App\Controllers;

use RamaSeck\ProjetSuiviDette3Mvc\App\App;
use RamaSeck\ProjetSuiviDette3Mvc\App\Models\ArticleModel;

use RamaSeck\ProjetSuiviDette3Mvc\Core\File;

class ArticleController{
 public function __construct() {
    $this->app = App::getInstance();
    $this->aticleModel= new ArticleModel();
}


public function recuparticle(){
    $id=$_POST["views"];
    $_SESSION['id_A']=$id;

   

  $arts= $this->aticleModel->getArticleByIdDette($id);
  $client= $this->aticleModel->getClientByid($id);

  
     include '../views/article.html.php';
     
}
}





?>