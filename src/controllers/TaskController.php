<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../utils/Validator.php';

class TaskController extends Controller {

  private $model;
  private $userModel;

  public function __construct($pdo) {
    $this->model = new Task($pdo);
    $this->userModel = new User($pdo);
  }

  public function show($id) {
    $task = $this->model->findById($id);

    if (!$task) {
      $this->jsonError('Task not found', 404);
      return;
    }

    $this->jsonResponse($task);
  }

  public function listByUser($userId) {
    if (!$this->userModel->findById($userId)) {
      $this->jsonError('User not found', 404);
      return;
    }
    
    $tasks = $this->model->findAllByUserId($userId);
    $this->jsonResponse($tasks);
  }

  public function create($userId) {
    $input = json_decode(file_get_contents('php://input'), true);

    $errors = Validator::validateTaskInput($input);
    if (!empty($errors)) {
      $this->jsonError(['errors' => $errors], 400);
      return;
    }
    
    if (!$this->userModel->findById($userId)) {
      http_response_code(404);
      $this->jsonError('User not found', 404);
      return;
    }

    $task = $this->model->create($userId, $input['title'], $input['description'], $input['status']);
    $this->jsonResponse($task);
  }

  public function delete($id) {
    $success = $this->model->delete($id);
    if (!$success) {
      $this->jsonError('Task not found', 404);
      return;
    }
    $this->jsonResponse(null, 204);
  }
}
