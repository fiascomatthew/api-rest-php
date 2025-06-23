<?php
declare(strict_types=1);

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
  return $userController->show((int)$id);
});
$router->add('GET', '#^/tasks/(\d+)$#', function($id) use ($taskController) {
  return $taskController->show((int)$id);
});
$router->add('GET', '#^/users/(\d+)/tasks$#', function($userId) use ($taskController) {
  return $taskController->listByUser((int)$userId);
});
$router->add('POST', '#^/users/(\d+)/tasks$#', function($userId) use ($taskController) {
  return $taskController->create((int)$userId);
});
$router->add('DELETE', '#^/tasks/(\d+)$#', function($id) use ($taskController) {
  return $taskController->delete((int)$id);
});

try {
  $response = $router->dispatch();
  if ($response instanceof Response) {
    $response->send();
  }
} catch (Throwable $e) {
  Response::internalServerError(['error' => 'An internal server error occurred. Contact the service support'])->send();
}