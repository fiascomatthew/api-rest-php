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
    $userController->show($matches[1]);
    break;

  case $method === 'GET' && preg_match('#^/tasks/(\d+)$#', $uri, $matches):
    $taskController->show($matches[1]);
    break;

  case $method === 'GET' && preg_match('#^/users/(\d+)/tasks$#', $uri, $matches):
    $taskController->listByUser($matches[1]);
    break;

  case $method === 'POST' && preg_match('#^/users/(\d+)/tasks$#', $uri, $matches):
    $taskController->create($matches[1], getJsonInput());
    break;

  case $method === 'DELETE' && preg_match('#^/tasks/(\d+)$#', $uri, $matches):
    $taskController->delete($matches[1]);
    break;

  default:
    http_response_code(404);
    echo json_encode(['error' => "We cannot find what you're looking for."]);
    break;
}