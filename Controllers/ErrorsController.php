<?php

class ErrorsController extends Controller
{
  public function notFound()
  {
    $this->render("404");
  }
}
