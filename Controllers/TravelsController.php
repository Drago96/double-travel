<?php

class TravelsController extends Controller
{
  protected $beforeActions = ["ensureAuthentication"];

  public function planner() {
    $this->render("planner");
  }

  public function createPost() {
    var_dump($this->request->getForm());
  }
}