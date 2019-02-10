<?php

class Review extends Model
{
  protected static $tableName = "reviews";


  public static function findByLocation($locationId)
  {
    $query = "SELECT * FROM `reviews`
              JOIN(SELECT username, id as user_id FROM users) users on reviews.user_id = users.user_id
              JOIN
              (
                SELECT arrival_date, departure_date, location_id, id as travel_location_id FROM travel_locations
              ) travel_locations
              on travel_locations.travel_location_id = reviews.travel_location_id
              WHERE location_id = :location_id
              ORDER BY created_at DESC";

    $stmt = Database::getConnection()->prepare($query);

    $stmt->bindParam(":location_id", $locationId);
    $stmt->execute();

    $reviews = [];

    while ($review = $stmt->fetch(PDO::FETCH_ASSOC)) {
      array_push($reviews, [
        "username" => $review["username"],
        "content" => $review["content"],
        "arrivalDate" => $review["arrival_date"],
        "departureDate" => $review["departure_date"],
        "createdAt" => $review["created_at"]
      ]);
    }

    return $reviews;
  }
}