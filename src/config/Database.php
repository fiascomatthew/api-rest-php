<?php
class Database {

  private $connection;

  public function __construct() {
    $this->connection = $this->createConnection();
  }

  public function getConnection() {
    return $this->connection;
  }

  private function createConnection() {
    try {
      $hostname = getenv('POSTGRES_HOST') ?: 'db';
      $port = getenv('POSTGRES_PORT') ?: '5432';
      $dbname = getenv('POSTGRES_DB') ?: 'apidb';
      $username = getenv('POSTGRES_USER') ?: 'user';
      $password = getenv('POSTGRES_PASSWORD') ?: 'password';
      
      $dsn = 'pgsql:host=' . $hostname . ';port=' . $port . ';dbname=' . $dbname;

      $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
      
      return $pdo;
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      exit;
    }
  }
}