<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';

class User {
  private ?int $id = null;
  private string $name;
  private string $email;

  public function __construct(string $name, string $email) {
    $this->name = $name;
    $this->email = $email;
  }

  public function getId(): ?int 
  {
    return $this->id;
  }

  public function setId(int $id): self 
  {
    $this->id = $id;
    return $this;
  }

  public function getName(): string 
  {
    return $this->name;
  }

  public function setName(string $name): self 
  {
    $this->name = $name;
    return $this;
  }

  public function getEmail(): string 
  {
    return $this->email;
  }

  public function setEmail(string $email): self 
  {
    $this->email = $email;
    return $this;
  }

  public static function fromArray(array $data): self 
  {
    $user = new self($data['name'], $data['email']);
    if (isset($data['id'])) {
      $user->setId((int)$data['id']);
    }
    return $user;
  }

  public function toArray(): array 
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email
    ];
  }
}
