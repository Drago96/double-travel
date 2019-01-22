<?php

trait AuthenticationConcern
{
  static $SESSION_USER_KEY = "user";

  public function getCurrentUser()
  {
    if ($this->isAuthenticated()) {
      return $_SESSION[AuthenticationConcern::$SESSION_USER_KEY];
    }

    return null;
  }

  public function isAuthenticated()
  {
    return isset($_SESSION[AuthenticationConcern::$SESSION_USER_KEY]);
  }

  protected function setCurrentUser(User $user)
  {
    $_SESSION[AuthenticationConcern::$SESSION_USER_KEY] = $user;
  }

  protected function clearCurrentUser()
  {
    if ($this->isAuthenticated()) {
      unset($_SESSION[AuthenticationConcern::$SESSION_USER_KEY]);
    }
  }
}
