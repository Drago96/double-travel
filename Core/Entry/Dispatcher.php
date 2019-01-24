<?php

require_once(ROOT . 'Core/Entry/Router.php');
require_once(ROOT . 'Core/Entry/Request.php');

require_once(ROOT . "Core/Database.php");
require_once(ROOT . "Core/Model.php");
require_once(ROOT . "Core/Controller/Controller.php");

class Dispatcher
{
  private $dispatchParams;

  public function dispatch()
  {
    session_start();

    $request = new Request();

    $this->dispatchParams = Router::parse($request->getPath(), $request->getMethod());

    $controller = $this->loadController($request);

    $controller->executeBeforeActions();

    call_user_func_array([$controller, $this->dispatchParams["action"]], $this->dispatchParams["arguments"]);
  }

  private function loadController($request)
  {
    $controllerName = $this->dispatchParams["controller"] . "Controller";

    $file = ROOT . 'Controllers/' . $controllerName . '.php';
    require($file);

    $controller = new $controllerName($request);
    return $controller;
  }
}
