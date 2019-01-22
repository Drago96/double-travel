<?php

require_once(ROOT . "Models/User.php");

class UsersController extends Controller
{
  public function login()
  {
    $this->render("login");
  }
}
