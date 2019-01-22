<?php

class Router
{
  static public function parse($path)
  {
    if ($path == "/") {
      return [
        "controller" => "home",
        "action" => "index",
        "arguments" => []
      ];
    }

    $path_exploded = array_slice(explode('/', $path), 1);

    return [
      "controller" => $path_exploded[0],
      "action" => $path_exploded[1],
      "arguments" => array_slice($path_exploded, 2)
    ];
  }
}