<?php
namespace RamaSeck\ProjetSuiviDette3Mvc\Core\Model;

use RamaSeck\ProjetSuiviDette3Mvc\Core\Database\MysqlDatabase;
use PDO;

abstract class Model {
    protected $table;
    protected $database;

    public function __construct() {
        $this->database = MysqlDatabase::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->database->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->database->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($entity) {
        // Implementation of save method
    }

    public function delete($id) {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // Other methods like static update, hasMany, belongsTo, etc.
}
?>
