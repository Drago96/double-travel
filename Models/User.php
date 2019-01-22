<?php

require_once("../Utilities/Validator.php");
require_once("../Utilities/Exceptions/ValidationException.php");

class User extends Model
{
  const USERNAME_MIN_LENGTH = 3;
  const USERNAME_MAX_LENGTH = 100;

  const PASSWORD_MIN_LENGTH = 6;
  const PASSWORD_MAX_LENGTH = 25;

  public $id;
  public $username;
  public $password;

  public function __construct($username, $password)
  {
    parent::__construct();
    $this->username = $username;
    $this->password = $password;
  }

  /**
   * @return bool
   * @throws ValidationException if validation fails
   */
  public function register()
  {
    $validationErrors = $this->getValidationErrors();

    if (count($validationErrors) != 0) {
      throw new ValidationException(implode($validationErrors));
    }

    $query = '
          INSERT INTO users
          SET
            username = :username,
            password = :password
      ';

    $stmt = $this->connection->prepare($query);

    $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password', $passwordHash);

    if ($stmt->execute()) {
      if (!$stmt->rowCount()) {
        return false;
      }

      $this->id = $this->connection->lastInsertId();
      return true;
    }

    return false;
  }

  public function getValidationErrors()
  {
    $errors = [];

    $usernameError = Validator::length($this->username, self::USERNAME_MIN_LENGTH, self::USERNAME_MAX_LENGTH, "Username");

    if (!is_null($usernameError)) {
      array_push($errors, $usernameError);
    }

    $passwordError = Validator::length($this->password, self::PASSWORD_MIN_LENGTH, self::PASSWORD_MAX_LENGTH, "Password");

    if (!is_null($passwordError)) {
      array_push($errors, $passwordError);
    }

    return $errors;
  }
}
