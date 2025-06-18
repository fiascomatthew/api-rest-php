<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController {

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function getTask($id) {
    $taskModel = new Task($this->pdo);
    $task = $taskModel->findById($id);

    if (!$task) {
      http_response_code(404);
      echo json_encode(['error' => 'Task not found']);
      return;
    }

    echo json_encode($task, JSON_PRETTY_PRINT);
  }
}
