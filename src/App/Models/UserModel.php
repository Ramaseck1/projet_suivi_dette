<?php

namespace RamaSeck\ProjetSuiviDette3Mvc\Model;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Database\MysqlDatabase;

class UserModel {
    protected $table = 'users';
    private $database;

    public function __construct() {
        $this->database = MysqlDatabase::getInstance();
    }

    // Add your methods for UserModel here
    public function connection() {
        // Your implementation
    }
}
