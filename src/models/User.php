<?php
require_once __DIR__ . '/../config/Database.php';

class User {
  private $dataSource;

  public function __construct($dataSource) {
    $this->dataSource = $dataSource;
  }

  public function findById($id) {
    $connection = $this->dataSource->getConnection();
    $stmt = $connection->prepare('SELECT id, name, email FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
