<?php

require_once("Concerns/AuthenticationConcern.php");
require_once("Concerns/RoutingConcern.php");
require_once("Concerns/TemplatingConcern.php");
require_once("Concerns/BeforeActionsConcern.php");
require_once("Concerns/JsonConcern.php");

abstract class Controller
{
  use AuthenticationConcern;
  use RoutingConcern;
  use TemplatingConcern;
  use BeforeActionsConcern;
  use JsonConcern;

  public $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
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
