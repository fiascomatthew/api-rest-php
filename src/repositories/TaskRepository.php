<?php
require_once __DIR__ . '/../config/Database.php';

class TaskRepository {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function findById($id) {
    $stmt = $this->pdo->prepare('SELECT id, user_id, title, description, creation_date, status FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findAllByUserId($userId) {
    $stmt = $this->pdo->prepare('SELECT id, user_id, title, description, creation_date, status FROM tasks WHERE user_id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert(Task $task) {
    $stmt = $this->pdo->prepare('
      INSERT INTO tasks (user_id, title, description, status)
      VALUES (?, ?, ?, ?)
      RETURNING id, user_id, title, description, status
    ');
    $stmt->execute([
      $task->getUserId(),
      $task->getTitle(),
      $task->getDescription(),
      $task->getStatus()
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function delete($id) {
    $stmt = $this->pdo->prepare('SELECT id FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$task) return false;

    $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    return true;
  }
}
