<?php

abstract class Model
{
  protected $connection;

  public function __construct()
  {
    $this->connection = Database::getConnection();
  }

  public function __sleep()
  {
    return array_keys(getModelPublicProperties($this));
  }

  public function isValid()
  {
    return count($this->getValidationErrors()) === 0;
  }

  abstract public function getValidationErrors();
}

function getModelPublicProperties($object) {
  return get_object_vars($object);
}
