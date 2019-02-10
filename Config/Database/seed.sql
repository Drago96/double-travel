INSERT INTO countries(name)
VALUES ('Bulgaria'),
       ('Greece'),
       ('Romania');

INSERT INTO locations(name, country_id)
VALUES ('Sofia', 1),
       ('Plovdiv', 1),
       ('Varna', 1),
       ('Athens', 2),
       ('Thessaloniki', 2),
       ('Larissa', 2),
       ('Bucharest', 3),
       ('Timisoara', 3),
       ('Oradea', 3);

INSERT INTO users(username, password_hash)
VALUES ('member1', 'some_password_hash'),
       ('member2', 'some_password_hash'),
       ('member3', 'some_password_hash');

INSERT INTO travels(user_id, starting_location_id, starting_departure_date)
VALUES (1, 1, '2018-02-20'),
       (2, 1, '2017-11-13'),
       (2, 2, '2018-03-30'),
       (3, 2, '2016-10-10');

INSERT INTO travel_locations(travel_id, location_id, arrival_date, departure_date)
VALUES (1, 2, '2018-02-22', '2018-02-25'),
       (1, 3, '2018-02-28', '2018-03-05'),
       (2, 4, '2017-12-01', '2017-12-15'),
       (2, 6, '2018-01-05', '2018-01-08'),
       (3, 3, '2018-04-05', '2018-04-06'),
       (3, 4, '2018-04-10', '2018-04-15'),
       (4, 3, '2016-10-10', '2016-10-11'),
       (4, 5, '2016-11-11', '2016-11-13');

INSERT INTO reviews(user_id, travel_location_id, content)
VALUES (1, 1, 'A great place to visit.'),
       (1, 2, 'Left a sore taste in my mouth.'),
       (2, 5, 'Not as bad as other people say.');
