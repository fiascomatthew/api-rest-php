<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/Controller.php';

class UserController extends Controller {

  private $model;

  public function __construct($pdo) {
    $this->model = new User($pdo);
  }

  public function show($id) {
    $user = $this->model->findById($id);

    if (!$user) {
      $this->jsonError('User not found', 404);
      return;
    }

    $this->jsonResponse($user);
  }
}
