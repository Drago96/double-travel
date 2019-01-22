<?php

class HomeController extends Controller
{
  protected $beforeActions = ["ensureAuthentication"];

  public function index()
  {
    $this->render("index");
  }
}
