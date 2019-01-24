<?php

class Router
{
  static public function parse($path, $method)
  {
    if ($path == "/") {
      return [
        "controller" => "home",
        "action" => "index",
        "arguments" => []
      ];
    }

    $path_exploded = array_slice(explode('/', $path), 1);

    $controller = $path_exploded[0];

    $action = null;
    if(count($path_exploded) === 1) {
      $action = "index";
    } else {
      $action = $path_exploded[1];
    }

    if($method !== 'GET') {
      $action .= mb_convert_case($method, MB_CASE_TITLE, "UTF-8");
    }


    $arguments = array_slice($path_exploded, 2);

    return [
      "controller" => $controller,
      "action" => $action,
      "arguments" => $arguments
    ];
  }
}