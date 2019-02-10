<?php

class ReviewsController extends Controller
{
  protected $beforeActions = ["ensureAuthentication"];

  public function index()
  {
    $locationId = $this->request->getParam("location_id");

    $reviews = Review::findByLocation($locationId);

    $this->json($reviews);
  }
}
