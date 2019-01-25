<?php

class ErrorsController extends Controller
{
  public function notFound()
  {
    http_response_code(404);
    $this->render("404");
  }

  public function internalServerError() {
    http_response_code(500);
    $this->render("500");
  }
}
