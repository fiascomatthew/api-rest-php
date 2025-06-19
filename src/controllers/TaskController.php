<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/TaskRepository.php';
require_once __DIR__ . '/../utils/Validator.php';
require_once __DIR__ . '/../utils/Response.php';

class TaskController {

  private $repository;
  private $userRepository;

  public function __construct($pdo) {
    $this->repository = new TaskRepository($pdo);
    $this->userRepository = new UserRepository($pdo);
  }

  public function show($id) {
    $task = $this->repository->findById($id);

    if (!$task) {
      return Response::notFound(['error' => 'Task not found']);
    }

    return Response::ok($task);
  }

  public function listByUser($userId) {
    if (!$this->userRepository->findById($userId)) {
      return Response::notFound(['error' => 'User not found']);
    }
    
    $tasks = $this->repository->findAllByUserId($userId);
    return Response::ok($tasks);
  }

  public function create($userId) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$this->userRepository->findById($userId)) {
      return Response::notFound(['error' => 'User not found']);
    }

    $errors = Validator::validateTaskInput($input);
    if (!empty($errors)) {
      return Response::badRequest(['errors' => $errors]);
    }

    $task = new Task($userId, $input['title'], $input['description'], $input['status']);
    $task = $this->repository->insert($task);
    return Response::created($task);
  }

  public function delete($id) {
    $success = $this->repository->delete($id);
    if (!$success) {
      return Response::notFound(['error' => 'Task not found']);
    }

    return Response::noContent();
  }
}
