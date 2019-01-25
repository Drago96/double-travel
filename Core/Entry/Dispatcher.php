<?php

require_once(ROOT . 'Core/Entry/Router.php');
require_once(ROOT . 'Core/Entry/Request.php');

require_once(ROOT . "Core/Database.php");
require_once(ROOT . "Core/Model.php");
require_once(ROOT . "Core/Controller/Controller.php");

require_once(ROOT . "Controllers/ErrorsController.php");

require_once(ROOT . "Models/User.php");

class Dispatcher
{
  private $dispatchParams;

  public function dispatch()
  {
    session_start();

    $request = new Request();

    $this->dispatchParams = Router::parse($request->getPath(), $request->getMethod());

    $controller = $this->loadController($request);

    $actionName = $this->dispatchParams["action"];

    $this->validateAction($controller, $actionName, $request);

    $arguments = $this->dispatchParams["arguments"];

    $this->validateArguments($controller, $actionName, $arguments, $request);

    $controller->executeBeforeActions($actionName);

    call_user_func_array([$controller, $actionName], $arguments);
  }

  private function loadController($request)
  {
    $controllerName = $this->dispatchParams["controller"] . "Controller";

    $file = ROOT . 'Controllers/' . $controllerName . '.php';

    if (!file_exists($file)) {
      $this->renderNotFound($request);
    }

    require_once($file);

    $controller = new $controllerName($request);
    return $controller;
  }


  private function validateAction($controller, $actionName, $request)
  {
    if (!method_exists($controller, $actionName)) {
      $this->renderNotFound($request);
    }
  }

  private function validateArguments($controller, $actionName, $arguments, $request)
  {
    $action = new ReflectionMethod($controller, $actionName);
    if (count($arguments) !== $action->getNumberOfRequiredParameters()) {
      $this->renderNotFound($request);
    }
  }

  private function renderNotFound($request)
  {
    $controller = new ErrorsController($request);

    $controller->notFound();

    exit;
  }
}
