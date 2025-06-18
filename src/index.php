<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/TaskController.php';
require_once __DIR__ . '/routing/Router.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$db = new Database();
$pdo = $db->getConnection();

$userController = new UserController($pdo);
$taskController = new TaskController($pdo);

$router = new Router($uri, $method);

$router->add('GET', '#^/users/(\d+)$#', function($id) use ($userController) {
  $userController->show($id);
});
$router->add('GET', '#^/tasks/(\d+)$#', function($id) use ($taskController) {
  $taskController->show($id);
});
$router->add('GET', '#^/users/(\d+)/tasks$#', function($userId) use ($taskController) {
  $taskController->listByUser($userId);
});
$router->add('POST', '#^/users/(\d+)/tasks$#', function($userId) use ($taskController) {
  $taskController->create($userId);
});
$router->add('DELETE', '#^/tasks/(\d+)$#', function($id) use ($taskController) {
  $taskController->delete($id);
});

try {
  $router->dispatch();
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode([
    'error' => 'Internal Server Error',
    'message' => $e->getMessage()
  ]);
}