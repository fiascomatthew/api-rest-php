<?php
declare(strict_types=1);

class Router {
  private string $uri;
  private string $method;
  private array $routes = [];

  public function __construct(string $uri, string $method) {
    $this->uri = $uri;
    $this->method = $method;
  }

  public function add(string $method, string $pattern, callable $callback): void
  {
    $this->routes[] = [
      'method' => $method,
      'pattern' => $pattern,
      'callback' => $callback
    ];
  }

  public function dispatch(): mixed 
  {
    foreach ($this->routes as $route) {
      if ($this->method === $route['method'] && preg_match($route['pattern'], $this->uri, $matches)) {
        array_shift($matches);
        return call_user_func_array($route['callback'], $matches);
      }
    }
    return Response::notFound(['error' => 'The requested resource was not found.']);
  }
}
