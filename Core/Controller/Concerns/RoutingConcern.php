<?php

trait RoutingConcern
{
  public function redirect($path)
  {
    header("Location: " . $path);
    exit();
  }
}