<?php

class Request
{
  private $urlParts;
  private $queryParameters;

  public function __construct()
  {
    $this->urlParts = parse_url($this->getUrl());

    if(array_key_exists("query", $this->urlParts, )) {
      parse_str($this->urlParts["query"], $queryParameters);
      $this->queryParameters = $queryParameters;
    } else {
      $this->queryParameters = [];
    }
  }

  public function getUrl()
  {
    return $_SERVER["REQUEST_URI"];
  }

  public function getPath()
  {
    return $this->urlParts['path'];
  }

  public function getMethod()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getForm()
  {
    return $this->secureForm($_POST);
  }

  public function getParam($name)
  {
    if(!array_key_exists($name, $this->queryParameters)) {
      return null;
    }

    return $this->queryParameters[$name];
  }

  private function secureForm($formParams)
  {
    $form = [];

    foreach ($formParams as $key => $value) {
      if(is_array($value)) {
        $form[$key] = $this->secureForm($value);
      } else {
        $form[$key] = $this->secureInput($value);
      }
    }

    return $form;
  }

  private function secureInput($value)
  {
    return htmlspecialchars(stripslashes(trim($value)));
  }
}
