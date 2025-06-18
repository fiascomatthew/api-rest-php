<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

  private $model;

  public function __construct($pdo) {
    $this->model = new User($pdo);
  }

  public function show($id) {
    $user = $this->model->findById($id);

    if (!$user) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }

    echo json_encode($user, JSON_PRETTY_PRINT);
  }
}
