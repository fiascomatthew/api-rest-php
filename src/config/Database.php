<?php
class Database {

  private static $hostname = 'db';
  private static $port = '5432';
  private static $username = 'user';
  private static $password = 'password';
  private static $database = 'apidb';

  private $connection;

  public function __construct() {
    $this->connection = $this->createConnection();
  }

  public function getConnection() {
    return $this->connection;
  }

  private function createConnection() {
    try {
      $dsn = 'pgsql:host=' . self::$hostname . ';port=' . self::$port . ';dbname=' . self::$database;

      $pdo = new PDO($dsn, self::$username, self::$password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
      
      return $pdo;
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      exit;
    }
  }
}