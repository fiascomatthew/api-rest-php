<?php
require_once __DIR__ . '/../models/Task.php';

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
      http_response_code(404);
      echo json_encode(['error' => 'Task not found']);
      return;
    }

    echo json_encode($task, JSON_PRETTY_PRINT);
  }

  public function listByUser($userId) {
    if (!$this->userModel->findById($userId)) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }
    
    $tasks = $this->model->findAllByUserId($userId);
    echo json_encode($tasks, JSON_PRETTY_PRINT);
  }

  public function create($userId, $input) {
    if (!isset($input['title'], $input['description'], $input['status'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Missing fields']);
      return;
    }

    if (!$this->userModel->findById($userId)) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }

    $task = $this->model->create($userId, $input['title'], $input['description'], $input['status']);
    echo json_encode($task, JSON_PRETTY_PRINT);
  }

  public function delete($id) {
    $success = $this->model->delete($id);
    if (!$success) {
      http_response_code(404);
      echo json_encode(['error' => 'Task not found']);
      return;
    }
    http_response_code(204);
  }
}
