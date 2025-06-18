<?php
require_once __DIR__ . '/../config/Database.php';

class Task {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function findById($id) {
    $stmt = $this->pdo->prepare('SELECT id, user_id, title, description, creation_date, status FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
