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
}
