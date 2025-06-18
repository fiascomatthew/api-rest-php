<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

  private $dataSource;

  public function __construct($dataSource) {
    $this->dataSource = $dataSource;
  }

  public function getUser($id) {
    $userModel = new User($this->dataSource);
    $user = $userModel->findById($id);

    if (!$user) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }

    echo json_encode($user, JSON_PRETTY_PRINT);
  }
}
