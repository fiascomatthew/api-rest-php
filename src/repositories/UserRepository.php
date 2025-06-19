<?php
require_once __DIR__ . '/../config/Database.php';

class UserRepository {
  private PDO $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function findById($id): ?User
  {
    $stmt = $this->pdo->prepare('SELECT id, name, email FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? User::fromArray($row) : null;
  }
}
