<?php
require_once __DIR__ . '/../config/Database.php';

class Task {

  private $id;
  private $userId;
  private $title;
  private $description;
  private $creationDate;
  private $status;

  public function __construct($userId, $title, $description, $status, $creationDate = null) {
    $this->userId = $userId;
    $this->title = $title;
    $this->description = $description;
    $this->status = $status;
    $this->creationDate = $creationDate;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function setUserId($userId) {
    $this->userId = $userId;
    return $this;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  public function getCreationDate() {
    return $this->creationDate;
  }

  public function setCreationDate($creationDate) {
    $this->creationDate = $creationDate;
    return $this;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
    return $this;
  }
}
