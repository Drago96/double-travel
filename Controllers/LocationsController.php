<?php

class LocationsController extends Controller
{
  protected $beforeActions = ["ensureAuthentication"];

  public function index()
  {
    $countryId = $this->request->getParam("country_id");

    $locations = Location::findByCountry($countryId);

    $this->json($locations);
  }
}