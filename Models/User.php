<?php

require_once(ROOT . "Utilities/Validator.php");
require_once(ROOT . "Utilities/Exceptions/ValidationException.php");

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

  public static function exists($username)
  {
    $query = "SELECT username FROM users WHERE username=:username";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
  }

  public static function existsById($id)
  {
    $query = "SELECT id FROM users WHERE id=:id";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
  }

  /**
   * @throws ValidationException if validation fails
   */
  public function login()
  {
    if (!self::exists($this->username)) {
      throw new ValidationException("Incorrect username or password.");
    }

    $query = "SELECT * FROM users WHERE username=:username";

    $stmt = $this->connection->prepare($query);

    $stmt->bindParam(":username", $this->username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!password_verify($this->password, $user['password_hash'])) {
        throw new ValidationException("Incorrect username or password.");
      }

      $this->id = $user["id"];
      $this->password = "";
    }
  }

  /**
   * @throws ValidationException if validation fails
   */
  public function register()
  {
    $validationErrors = $this->getValidationErrors();

    if (count($validationErrors) != 0) {
      throw new ValidationException(implode($validationErrors));
    }

    if (self::exists($this->username)) {
      throw new ValidationException("Username is already taken.");
    }

    $query = '
          INSERT INTO users
          SET
            username = :username,
            password_hash = :password_hash
      ';

    $stmt = $this->connection->prepare($query);

    $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':password_hash', $passwordHash);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $this->id = $this->connection->lastInsertId();
      $this->password = "";
    }
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
