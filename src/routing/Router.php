<?php
declare(strict_types=1);

class Router {

  private Request $request;
  private array $routes = [];

  public function __construct(Request $request) {
    $this->request = $request;
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
      if ($this->request->getMethod() === $route['method'] && preg_match($route['pattern'], $this->request->getUri(), $matches)) {
        array_shift($matches);
        return call_user_func_array($route['callback'], $matches);
      }
    }
    return Response::notFound(['error' => 'The requested resource was not found.']);
  }
}
