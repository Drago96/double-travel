<?php

require_once(ROOT . 'Core/Entry/Router.php');
require_once(ROOT . 'Core/Entry/Request.php');

require_once(ROOT . "Core/Database.php");
require_once(ROOT . "Core/Model.php");
require_once(ROOT . "Core/Controller/Controller.php");

require_once(ROOT . "Controllers/ErrorsController.php");

require_once(ROOT . "Models/User.php");
require_once(ROOT . "Models/Country.php");
require_once(ROOT . "Models/Location.php");
require_once(ROOT . "Models/Travel.php");
require_once(ROOT . "Models/TravelLocation.php");

class Dispatcher
{
  private $dispatchParams;

  private $excludedControllers = ["errors"];

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

    try {
      $controller->executeBeforeActions($actionName);

      call_user_func_array([$controller, $actionName], $arguments);
    } catch (Exception $e) {
      $this->renderInternalServerError($request);
    }
  }

  private function loadController($request)
  {
    $controllerPrefix = $this->dispatchParams["controller"];

    if (in_array(strtolower($controllerPrefix), $this->excludedControllers)) {
      $this->renderNotFound($request);
    }

    $controllerName = $controllerPrefix . "Controller";

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
    try {
      $action = new ReflectionMethod($controller, $actionName);
      if (count($arguments) !== $action->getNumberOfRequiredParameters()) {
        $this->renderNotFound($request);
      }
    } catch (ReflectionException $e) {
      $this->renderNotFound($request);
    }
  }

  private function renderNotFound($request)
  {
    $controller = new ErrorsController($request);

    $controller->notFound();

    exit;
  }

  private function renderInternalServerError($request)
  {
    $controller = new ErrorsController($request);

    $controller->internalServerError();

    exit;
  }
}
