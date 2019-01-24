<?php

class UsersController extends Controller
{
  protected $beforeActions = [
    ["method" => "ensureAuthentication", "only" => ["logoutPost"]],
    ["method" => "ensureAnonymous", "except" => ["logoutPost"]]
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
    } catch (Exception $e) {
      $formError = "An internal server error occurred.";

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
    } catch (Exception $e) {
      $formError = "An internal server error occurred.";

      $this->render("register", ["formError" => $formError, "model" => $user]);
    }
  }

  public function logoutPost() {
    $this->clearCurrentUser();

    $this->redirect("/");
  }
}
