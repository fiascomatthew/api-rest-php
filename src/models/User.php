<?php
require_once __DIR__ . '/../config/Database.php';

class User {
  private $id;
  private $name;
  private $email;

  public function __construct($name, $email) {
    $this->name = $name;
    $this->email = $email;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }
}
