<?php

class Response {
  private int $code;
  private mixed $data;
  private array $headers;

  private function __construct(int $code, mixed $data = null) {
    $this->code = $code;
    $this->data = $data;
    $this->headers = [
      "Content-Type" => "application/json",
      "Charset" => "UTF-8"
    ];
  }

  public static function ok(mixed $data = null): self 
  {
    return new self(200, $data);
  }

  public static function created(mixed $data = null): self 
  {
    return new self(201, $data);
  }

  public static function noContent(): self 
  {
    return new self(204);
  }

  public static function badRequest(mixed $data = null): self 
  {
    return new self(400, $data);
  }

  public static function notFound($data = null): self 
  {
    return new self(404, $data);
  }

  public static function notAllowed($data = null): self 
  {
    return new self(405, $data);
  }

  public static function internalServerError(mixed $data = null): self 
  {
    return new self(500, $data);
  }

  public function send(): void
  {
    http_response_code($this->code);
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }
    if ($this->code !== 204 && $this->data !== null) {
      echo json_encode($this->data);
    }
  }
}