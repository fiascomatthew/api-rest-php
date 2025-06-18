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
        return call_user_func_array($route['callback'], $matches);
      }
    }
    return Response::notFound(['error' => 'The requested resource was not found.']);
  }
}
