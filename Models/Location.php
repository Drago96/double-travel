<?php

class Location extends Model
{
  protected static $tableName = "locations";


  public static function findByCountry($countryId)
  {
    $query = "SELECT * FROM locations
              WHERE country_id=:country_id
              ORDER BY name";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":country_id", $countryId);
    $stmt->execute();

    $locations = [];

    while ($location = $stmt->fetch(PDO::FETCH_ASSOC)) {
      array_push($locations, [
        "id" => $location["id"],
        "name" => $location["name"],
        "countryId" => $location["country_id"]
      ]);
    }

    return $locations;
  }
}