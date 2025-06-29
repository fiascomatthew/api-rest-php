<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';

class TaskRepository {
  private PDO $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function findById(int $id): ?Task
  {
    $stmt = $this->pdo->prepare('SELECT id, user_id, title, description, creation_date, status FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? Task::fromArray($row) : null;
  }

  public function findAllByUserId(int $userId): array
  {
    $stmt = $this->pdo->prepare('SELECT id, user_id, title, description, creation_date, status FROM tasks WHERE user_id = ?');
    $stmt->execute([$userId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($row) => Task::fromArray($row), $rows);
  }

  public function insert(Task $task): Task
  {
    $stmt = $this->pdo->prepare('
      INSERT INTO tasks (user_id, title, description, status)
      VALUES (?, ?, ?, ?)
      RETURNING id, user_id, title, description, status, creation_date
    ');

    $stmt->execute([
      $task->getUserId(),
      $task->getTitle(),
      $task->getDescription(),
      $task->getStatus()
    ]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return Task::fromArray($row);
  }

  public function delete(int $id): bool 
  {
    $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
  }
}
