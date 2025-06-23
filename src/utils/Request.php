<?php
declare(strict_types=1);

class Request {
  private string $method;
  private string $uri;
  private ?string $body;
  private ?array $jsonBody;

  private function __construct() {
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->uri = $_SERVER['REQUEST_URI'];
    $this->body = file_get_contents('php://input');
    $this->jsonBody = $this->body ? json_decode($this->body, true) : null;
  }

  public static function createFromGlobals(): self {
    return new self();
  }

  public function getMethod(): string {
    return $this->method;
  }

  public function getUri(): string {
    return $this->uri;
  }

  public function getBody(): ?string {
    return $this->body;
  }

  public function getJsonBody(): ?array {
    return $this->jsonBody;
  }
} 