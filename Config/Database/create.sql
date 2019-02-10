CREATE TABLE IF NOT EXISTS users
(
  id            INT          NOT NULL AUTO_INCREMENT,
  username      VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS countries
(
  id   INT         NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS locations
(
  id         INT         NOT NULL AUTO_INCREMENT,
  name       VARCHAR(50) NOT NULL UNIQUE,
  country_id INT         NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_LOCATION_COUNTRY FOREIGN KEY (country_id)
    REFERENCES countries (id)
);

CREATE TABLE IF NOT EXISTS travels
(
  id                      INT      NOT NULL AUTO_INCREMENT,
  user_id                 INT      NOT NULL,
  starting_location_id    INT      NOT NULL,
  starting_departure_date DATE     NOT NULL,
  created_at              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT FK_TRAVEL_USER FOREIGN KEY (user_id)
    REFERENCES users (id),
  CONSTRAINT FK_TRAVEL_STARTING_LOCATION FOREIGN KEY (starting_location_id)
    REFERENCES locations (id)
);

CREATE TABLE IF NOT EXISTS travel_locations
(
  id             INT  NOT NULL AUTO_INCREMENT,
  travel_id      INT  NOT NULL,
  location_id    INT  NOT NULL,
  arrival_date   DATE NOT NULL,
  departure_date DATE NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_TRAVEL_LOCATION_TRAVEL FOREIGN KEY (travel_id)
    REFERENCES travels (id),
  CONSTRAINT FK_TRAVEL_LOCATION_LOCATION FOREIGN KEY (location_id)
    REFERENCES locations (id)
);


CREATE TABLE IF NOT EXISTS reviews
(
  user_id            INT           NOT NULL,
  travel_location_id INT           NOT NULL,
  content            VARCHAR(5000) NOT NULL,
  created_at         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, travel_location_id),
  CONSTRAINT FK_REVIEW_USER FOREIGN KEY (user_id)
    REFERENCES users (id),
  CONSTRAINT FK_REVIEW_TRAVEL FOREIGN KEY (travel_location_id)
    REFERENCES travel_locations (id)
)