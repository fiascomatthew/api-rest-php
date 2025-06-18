<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../utils/Response.php';

class UserController {

  private $repository;

  public function __construct($pdo) {
    $this->repository = new UserRepository($pdo);
  }

  public function show($id) {
    $user = $this->repository->findById($id);

    if (!$user) {
      return Response::notFound(['error' => 'User not found']);
    }

    return Response::ok($user);
  }
}
