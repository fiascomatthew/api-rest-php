<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';

class Task {

  private ?int $id = null;
  private int $userId;
  private string $title;
  private string $status;
  private ?string $description;
  private ?string $creationDate;

  public function __construct(
    int $userId,
    string $title,
    string $status,
    ?string $description = null,
    ?string $creationDate = null
  ) {
    $this->userId = $userId;
    $this->title = $title;
    $this->status = $status;
    $this->description = $description;
    $this->creationDate = $creationDate;
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

  public function getUserId(): int
  {
    return $this->userId;
  }

  public function setUserId(int $userId): self
  {
    $this->userId = $userId;
    return $this;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;
    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self 
  {
    $this->description = $description;
    return $this;
  }

  public function getCreationDate(): ?string
  {
    return $this->creationDate;
  }

  public function setCreationDate(?string $creationDate): self
  {
    $this->creationDate = $creationDate;
    return $this;
  }

  public function getStatus(): string
  {
    return $this->status;
  }

  public function setStatus(string $status): self
  {
    $this->status = $status;
    return $this;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'user_id' => $this->userId,
      'title' => $this->title,
      'status' => $this->status,
      'description' => $this->description,
      'creation_date' => $this->creationDate
    ];
  }

  public static function fromArray(array $data): self 
  {
    $task = new self(
      $data['user_id'],
      $data['title'],
      $data['status'],
      $data['description'] ?? null
    );

    if (isset($data['id'])) {
      $task->setId($data['id']);
    }

    if (isset($data['creation_date'])) {
      $task->setCreationDate($data['creation_date']);
    }

    return $task;
  }
}
