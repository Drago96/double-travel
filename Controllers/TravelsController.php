<?php

class TravelsController extends Controller
{
  protected $beforeActions = ["ensureAuthentication"];

  public function planner()
  {
    $this->render("planner");
  }

  public function createPost()
  {
    $travelData = $this->request->getForm();

    $startingLocation = $travelData["startingLocation"];
    $nextLocations = $travelData["nextLocations"];

    try {
      $travel = new Travel($this->getCurrentUser()->id, $startingLocation["location"], $startingLocation["departureDate"]);
      $travel->create();

      foreach ($nextLocations as $nextLocation) {
        $travelLocation = new TravelLocation($travel->id, $nextLocation["location"], $nextLocation["arrivalDate"], $nextLocation["departureDate"]);
        $travelLocation->create();
      }
    } catch(ValidationException $e) {
      $this->notifyError("Something went wrong with your submission.");
      $this->redirect("/travels/planner");
  }

    $this->notifySuccess("Your journey has been recorded successfully.");
    $this->redirect("/users/profile");
  }

  public function past() {
    $this->json(Travel::getPastTravels($this->getCurrentUser()->id));
  }

  public function ongoing() {
    $this->json(Travel::getOngoingTravels($this->getCurrentUser()->id));
  }

  public function upcoming() {
    $this->json(Travel::getUpcomingTravels($this->getCurrentUser()->id));
  }
}