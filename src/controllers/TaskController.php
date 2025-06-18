<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController {

  private $pdo;
  private $model;

  public function __construct($pdo) {
    $this->pdo = $pdo;
    $this->model = new Task($pdo);
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
    $stmt = $this->pdo->prepare('SELECT id FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
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

    $stmt = $this->pdo->prepare('SELECT id FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }
    
    $task = $this->model->create($userId, $input['title'], $input['description'], $input['status']);
    echo json_encode($task, JSON_PRETTY_PRINT);
  }
}
