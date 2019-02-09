<?php

class Country extends Model
{
  public static function all()
  {
    $query = "SELECT * FROM countries";

    $stmt = Database::getConnection()->prepare($query);
    $stmt->execute();

    $countries = [];

    while ($country = $stmt->fetch(PDO::FETCH_ASSOC)) {
      array_push($countries, [
        "id" => $country["id"],
        "name" => $country["name"]
      ]);
    }

    return $countries;
  }
}