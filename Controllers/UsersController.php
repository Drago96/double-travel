<?php

class UsersController extends Controller
{
  protected $beforeActions = [
    ["do" => "ensureAuthentication", "only" => ["logoutPost", "profile"]],
    ["do" => "ensureAnonymous", "except" => ["logoutPost", "profile"]]
  ];

  public function login()
  {
    $model = new User("", "");

    $this->render("login", ["model" => $model]);
  }

  public function loginPost()
  {
    $formData = $this->request->getForm();

    $user = new User($formData["username"], $formData["password"]);

    try {
      $user->login();

      $this->setCurrentUser($user);
      $this->redirect("/");
    } catch (ValidationException $e) {
      $formError = $e->getMessage();

      $this->render("login", ["formError" => $formError, "model" => $user]);
    }
  }

  public function register()
  {
    $model = new User("", "");

    $this->render("register", ["model" => $model]);
  }

  public function registerPost()
  {
    $formData = $this->request->getForm();

    $user = new User($formData["username"], $formData["password"]);

    try {
      $user->register();

      $this->setCurrentUser($user);
      $this->redirect("/");
    } catch (ValidationException $e) {
      $formError = $e->getMessage();

      $this->render("register", ["formError" => $formError, "model" => $user]);
    }
  }

  public function logoutPost()
  {
    $this->clearCurrentUser();

    $this->redirect("/");
  }

  public function profile()
  {
    $this->render("profile");
  }
}
