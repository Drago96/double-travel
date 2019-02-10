<?php

trait NotificationsConcern
{
  static $SESSION_SUCCESS_KEY = "successMessage";
  static $SESSION_ERROR_KEY = "errorMessage";

  public function notifySuccess($message)
  {
    $_SESSION[self::$SESSION_SUCCESS_KEY] = $message;
  }

  public function notifyError($message)
  {
    $_SESSION[self::$SESSION_ERROR_KEY] = $message;
  }

  public function extractMessages()
  {
    if (array_key_exists(self::$SESSION_SUCCESS_KEY, $_SESSION)) {
      $successMessage = $_SESSION[self::$SESSION_SUCCESS_KEY];

      $GLOBALS["success"] = $successMessage;

      unset($_SESSION[self::$SESSION_SUCCESS_KEY]);
    }

    if (array_key_exists(self::$SESSION_ERROR_KEY, $_SESSION)) {
      $errorMessage = $_SESSION[self::$SESSION_ERROR_KEY];

      $GLOBALS["error"] = $errorMessage;

      unset($_SESSION[self::$SESSION_ERROR_KEY]);
    }
  }
}