<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/Response.php';

class UserController {

  private $model;

  public function __construct($pdo) {
    $this->model = new User($pdo);
  }

  public function show($id) {
    $user = $this->model->findById($id);

    if (!$user) {
      return Response::notFound(['error' => 'User not found']);
    }

    return Response::ok($user);
  }
}
