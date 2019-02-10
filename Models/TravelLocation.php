<?php

require_once(ROOT . "Utilities/Validator.php");
require_once(ROOT . "Utilities/Exceptions/ValidationException.php");

class TravelLocation extends Model
{
  protected static $tableName = "travel_locations";

  public $id;
  public $travelId;
  public $locationId;
  public $arrivalDate;
  public $departureDate;

  public function __construct($travelId, $locationId, $arrivalDate, $departureDate)
  {
    parent::__construct();
    $this->travelId = $travelId;
    $this->locationId = $locationId;
    $this->arrivalDate = $arrivalDate;
    $this->departureDate = $departureDate;
  }

  public static function getByTravelId($travelId)
  {
    $query = "SELECT * FROM `travel_locations`
            JOIN(SELECT name as location_name, id as location_id, country_id FROM locations) locations on travel_locations.location_id = locations.location_id
            JOIN(SELECT name as country_name, id as country_id FROM countries) countries on locations.country_id = countries.country_id
            WHERE travel_id = :travel_id ";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":travel_id", $travelId);

    $stmt->execute();

    $travelLocations = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $travelLocation = [
        "id" => $row["id"],
        "location" => [
          "id" => $row["location_id"],
          "name" => $row["location_name"]
        ],
        "country" => [
          "id" => $row["country_id"],
          "name" => $row["country_name"]
        ],
        "arrivalDate" => $row["arrival_date"],
        "departureDate" => $row["departure_date"]
      ];

      array_push($travelLocations, $travelLocation);
    }

    return $travelLocations;
  }

  /**
   * @throws ValidationException if validation fails
   */
  public function create()
  {
    $validationErrors = $this->getValidationErrors();

    if (count($validationErrors) != 0) {
      throw new ValidationException(implode($validationErrors));
    }

    $query = "INSERT INTO travel_locations
              SET
                travel_id = :travel_id,
                location_id = :location_id,
                arrival_date = :arrival_date,
                departure_date = :departure_date";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":travel_id", $this->travelId);
    $stmt->bindParam(":location_id", $this->locationId);
    $stmt->bindParam(":arrival_date", $this->arrivalDate);
    $stmt->bindParam(":departure_date", $this->departureDate);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $this->id = $this->connection->lastInsertId();
    }
  }

  public function getValidationErrors()
  {
    $errors = [];

    $arrivalDateError = Validator::validDate($this->arrivalDate, "Arrival date");

    if (!is_null($arrivalDateError)) {
      array_push($errors, $arrivalDateError);
    }

    $departureDateError = Validator::validDate($this->departureDate, "Departure date");

    if (!is_null($departureDateError)) {
      array_push($errors, $departureDateError);
    }

    $travelExists = Travel::exists($this->travelId);

    if (!$travelExists) {
      array_push($errors, "Travel does not exist.");
    }

    $locationExists = Location::exists($this->locationId);

    if (!$locationExists) {
      array_push($errors, "Starting location does not exist.");
    }

    return $errors;
  }
}
