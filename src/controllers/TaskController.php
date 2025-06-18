<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../utils/Validator.php';
require_once __DIR__ . '/../utils/Response.php';

class TaskController {

  private $model;
  private $userModel;

  public function __construct($pdo) {
    $this->model = new Task($pdo);
    $this->userModel = new User($pdo);
  }

  public function show($id) {
    $task = $this->model->findById($id);

    if (!$task) {
      return Response::notFound(['error' => 'Task not found']);
    }

    return Response::ok($task);
  }

  public function listByUser($userId) {
    if (!$this->userModel->findById($userId)) {
      return Response::notFound(['error' => 'User not found']);
    }
    
    $tasks = $this->model->findAllByUserId($userId);
    return Response::ok($tasks);
  }

  public function create($userId) {
    $input = json_decode(file_get_contents('php://input'), true);

    $errors = Validator::validateTaskInput($input);
    if (!empty($errors)) {
      return Response::badRequest(['errors' => $errors]);
    }
    
    if (!$this->userModel->findById($userId)) {
      return Response::notFound(['error' => 'User not found']);
    }

    $task = $this->model->create($userId, $input['title'], $input['description'], $input['status']);
    return Response::created($task);
  }

  public function delete($id) {
    $success = $this->model->delete($id);
    if (!$success) {
      return Response::notFound(['error' => 'Task not found']);
    }
    return Response::noContent();
  }
}
