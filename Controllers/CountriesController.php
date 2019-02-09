<?php

class CountriesController extends Controller {
  protected $beforeActions = ["ensureAuthentication"];

  public function index() {
    $countries = Country::all();

    $this->json($countries);
  }
}