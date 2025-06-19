<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../utils/Response.php';

class UserController {

  private UserRepository $repository;

  public function __construct(PDO $pdo) {
    $this->repository = new UserRepository($pdo);
  }

  public function show(int $id): Response 
  {
    $user = $this->repository->findById($id);

    if (!$user) {
      return Response::notFound(['error' => 'User not found']);
    }

    return Response::ok($user->toArray());
  }
}
