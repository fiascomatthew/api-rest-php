<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function show($id) {
    $userModel = new User($this->pdo);
    $user = $userModel->findById($id);

    if (!$user) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }

    echo json_encode($user, JSON_PRETTY_PRINT);
  }
}
