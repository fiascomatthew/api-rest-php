<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/TaskController.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$db = new Database();
$pdo = $db->getConnection();

function getJsonInput() {
  return json_decode(file_get_contents('php://input'), true);
}

$userController = new UserController($pdo);
$taskController = new TaskController($pdo);

switch (true) {

  case $method === 'GET' && preg_match('#^/users/(\d+)$#', $uri, $matches):
    $userController->getUser($matches[1]);
    break;

  case $method === 'GET' && preg_match('#^/tasks/(\d+)$#', $uri, $matches):
    $taskController->getTask($matches[1]);
    break;

  case $method === 'GET' && preg_match('#^/users/(\d+)/tasks$#', $uri, $matches):
    $userId = $matches[1];
    $stmt = $pdo->prepare('SELECT id, user_id, title, description, creation_date, status FROM tasks WHERE user_id = ?');
    $stmt->execute([$userId]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks, JSON_PRETTY_PRINT);
    break;

  case $method === 'POST' && preg_match('#^/users/(\d+)/tasks$#', $uri, $matches):
    $userId = $matches[1];
    $input = getJsonInput();
    if (!isset($input['title'], $input['description'], $input['status'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Missing fields']);
      break;
    }
    $stmt = $pdo->prepare('INSERT INTO tasks (user_id, title, description, creation_date, status) VALUES (?, ?, ?, NOW(), ?) RETURNING id, user_id, title, description, creation_date, status');
    $stmt->execute([$userId, $input['title'], $input['description'], $input['status']]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($task, JSON_PRETTY_PRINT);
    break;


  case $method === 'DELETE' && preg_match('#^/users/(\d+)/tasks/(\d+)$#', $uri, $matches):
    $userId = $matches[1];
    $taskId = $matches[2];

    $stmt = $pdo->prepare('SELECT id FROM tasks WHERE id = ? AND user_id = ?');
    $stmt->execute([$taskId, $userId]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$task) {
      http_response_code(404);
      echo json_encode(['error' => 'Task not found for this user']);
      break;
    }
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$taskId]);
    http_response_code(204);
    break;

  default:
    http_response_code(404);
    echo json_encode(['error' => "We cannot find what you're looking for."]);
    break;
}