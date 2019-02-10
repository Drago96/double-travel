<?php

require_once(ROOT . "Utilities/Validator.php");
require_once(ROOT . "Utilities/Exceptions/ValidationException.php");

class Travel extends Model
{
  protected static $tableName = "travels";

  public $id;
  public $userId;
  public $startingLocationId;
  public $startingDepartureDate;

  public function __construct($userId, $startingLocationId, $startingDepartureDate)
  {
    parent::__construct();
    $this->userId = $userId;
    $this->startingLocationId = $startingLocationId;
    $this->startingDepartureDate = $startingDepartureDate;
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

    $query = "INSERT INTO travels
              SET
                user_id = :user_id,
                starting_location_id = :starting_location_id,
                starting_departure_date = :starting_departure_date";

    $stmt = $this->connection->prepare($query);

    $stmt->bindParam(":user_id", $this->userId);
    $stmt->bindParam(":starting_location_id", $this->startingLocationId);
    $stmt->bindParam(":starting_departure_date", $this->startingDepartureDate);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $this->id = $this->connection->lastInsertId();
    }
  }

  public static function getPastTravels($userId)
  {
    $query = self::travelsForUserQuery() . " AND return_date < CURDATE() 
                                            ORDER BY travels.starting_departure_date ASC";

    return self::getTravels($query, $userId);
  }

  public static function getOngoingTravels($userId)
  {
    $query = self::travelsForUserQuery() . "
              AND starting_departure_date <= CURDATE()
              AND return_date >= CURDATE()
              ORDER BY travels.starting_departure_date ASC";

    return self::getTravels($query, $userId);
  }

  public static function getUpcomingTravels($userId)
  {
    $query = self::travelsForUserQuery() . " AND starting_departure_date > CURDATE()
                                             ORDER BY travels.starting_departure_date ASC";

    return self::getTravels($query, $userId);
  }

  private static function travelsForUserQuery()
  {
    return "SELECT * FROM `travels`
            JOIN(SELECT name as location_name, id as location_id, country_id FROM locations) locations on starting_location_id = locations.location_id
            JOIN(SELECT name as country_name, id as country_id FROM countries) countries on locations.country_id = countries.country_id
            JOIN 
            (
              SELECT MAX(departure_date) as return_date, travel_id 
              FROM travel_locations 
              GROUP BY travel_id
            ) AS date_of_return
            ON travels.id = date_of_return.travel_id
            WHERE user_id = :user_id ";
  }

  private static function getTravels($query, $userId)
  {
    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":user_id", $userId);

    $stmt->execute();

    $travels = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $travel = [
        "id" => $row["id"],
        "startingLocation" => [
          "id" => $row["location_id"],
          "name" => $row["location_name"]
        ],
        "startingCountry" => [
          "id" => $row["country_id"],
          "name" => $row["country_name"]
        ],
        "startingDepartureDate" => $row["starting_departure_date"],
        "returnDate" => $row["return_date"],
        "locations" => TravelLocation::getByTravelId($row["id"])
      ];

      array_push($travels, $travel);
    }

    return $travels;
  }

  public function getValidationErrors()
  {
    $errors = [];

    $startingDepartureDateError = Validator::validDate($this->startingDepartureDate, "Starting departure date");

    if (!is_null($startingDepartureDateError)) {
      array_push($errors, $startingDepartureDateError);
    }

    $userExists = User::exists($this->userId);

    if (!$userExists) {
      array_push($errors, "User does not exist.");
    }

    $locationExists = Location::exists($this->startingLocationId);

    if (!$locationExists) {
      array_push($errors, "Starting location does not exist.");
    }

    return $errors;
  }
}