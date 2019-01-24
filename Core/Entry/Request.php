<?php

class Request
{
  private $url_parts;

  public function __construct()
  {
    $this->url_parts = parse_url($this->getUrl());
  }

  public function getUrl()
  {
    return $_SERVER["REQUEST_URI"];
  }

  public function getPath()
  {
    return $this->url_parts['path'];
  }

  public function getMethod()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getForm()
  {
    return $this->secureForm();
  }

  private function secureForm()
  {
    $form = [];

    foreach ($_POST as $key => $value) {
      $form[$key] = $this->secureInput($value);
    }

    return $form;
  }

  private function secureInput($value)
  {
    return htmlspecialchars(stripslashes(trim($value)));
  }
}
