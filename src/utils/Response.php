<?php

class Response {
  private $code;
  private $data;
  private $headers;

  private function __construct($code, $data = null) {
    $this->code = $code;
    $this->data = $data;
    $this->headers = [
      "Content-Type" => "application/json",
      "Charset" => "UTF-8"
    ];
  }

  public static function ok($data = null) {
    return new self(200, $data);
  }

  public static function noContent() {
    return new self(204);
  }

  public static function badRequest($data = null) {
    return new self(400, $data);
  }

  public static function notFound($data = null) {
    return new self(404, $data);
  }

  public static function notAllowed($data = null) {
    return new self(405, $data);
  }

  public static function internalServerError($data = null) {
    return new self(500, $data);
  }

  public function send() {
    http_response_code($this->code);
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }
    if ($this->code !== 204 && $this->data !== null) {
      echo json_encode($this->data);
    }
  }
}