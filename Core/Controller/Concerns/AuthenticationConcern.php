<?php

trait AuthenticationConcern
{
  static $SESSION_USER_KEY = "user";

  public function getCurrentUser()
  {
    if ($this->isAuthenticated()) {
      return $_SESSION[self::$SESSION_USER_KEY];
    }

    return null;
  }

  public function isAuthenticated()
  {
    return isset($_SESSION[self::$SESSION_USER_KEY]);
  }

  protected function setCurrentUser(User $user)
  {
    $_SESSION[self::$SESSION_USER_KEY] = $user;
  }

  protected function clearCurrentUser()
  {
    if ($this->isAuthenticated()) {
      unset($_SESSION[self::$SESSION_USER_KEY]);
    }
  }

  protected function ensureAuthentication()
  {
    if (!$this->isAuthenticated()) {
      $this->redirect("/users/login");
    }
  }

  protected function ensureAnonymous()
  {
    if ($this->isAuthenticated()) {
      $this->redirect("/");
    }
  }
}
