<?php

abstract class Model
{
  protected static $tableName;

  protected $connection;

  public function __construct()
  {
    $this->connection = Database::getConnection();
  }

  public function __sleep()
  {
    return array_keys(getModelPublicProperties($this));
  }

  public static function exists($id)
  {
    $tableName = static::$tableName;

    $query = "SELECT id FROM {$tableName} WHERE id=:id";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
  }

  public function isValid()
  {
    return count($this->getValidationErrors()) === 0;
  }

  public function getValidationErrors()
  {
    return [];
  }
}

function getModelPublicProperties($object)
{
  return get_object_vars($object);
}
