<?php

abstract class Model
{
  protected $connection;

  public function __construct()
  {
    $this->connection = Database::getConnection();
  }

  public function isValid()
  {
    return count($this->getValidationErrors()) === 0;
  }

  abstract public function getValidationErrors();
}
