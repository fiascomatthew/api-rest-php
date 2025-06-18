<?php
require_once __DIR__ . '/../config/Database.php';

class User {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function findById($id) {
    $stmt = $this->pdo->prepare('SELECT id, name, email FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
