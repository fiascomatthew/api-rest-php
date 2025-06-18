<?php
class Router {
  private $uri;
  private $method;
  private $routes = [];

  public function __construct($uri, $method) {
    $this->uri = $uri;
    $this->method = $method;
  }

  public function add($method, $pattern, $callback) {
    $this->routes[] = [
      'method' => $method,
      'pattern' => $pattern,
      'callback' => $callback
    ];
  }

  public function dispatch() {
    foreach ($this->routes as $route) {
      if ($this->method === $route['method'] && preg_match($route['pattern'], $this->uri, $matches)) {
        array_shift($matches);
        call_user_func_array($route['callback'], $matches);
        return;
      }
    }
    http_response_code(404);
    echo json_encode(['error' => "The requested resource was not found."], JSON_PRETTY_PRINT);
  }
}
