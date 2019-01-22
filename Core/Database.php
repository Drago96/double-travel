<?php

require_once(ROOT . "Config/Config.php");

class Database
{
  private static $pdo = null;

  private function __construct()
  {
  }

  public static function getConnection()
  {
    if (is_null(self::$pdo)) {
      self::$pdo = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
    }

    return self::$pdo;
  }
}
