CREATE DATABASE `app` ;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";

USE app;

-- app.users definition

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `driving_license` tinyint(1) NOT NULL,
  `adress` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.users data
INSERT INTO app.users (username,password,display_name,driving_license,adress) VALUES
  ('systeme','systeme','Systeme',1,'{}'),
  ('Isabelle','web','LE GLAZ Isabelle',1,'{}'),
  ('Maxime','web','FOLSCHETTE Maxime',0,'{}'),
  ('Diego','web','CATTARUZZA Diego',1,'{}'),
  ('Khaled','web','MESGHOUNI Khaled',0,'{}'),
  ('Maxime','web','OGIER Maxime',1,'{}'),
  ('Christophe','web','SUEUR Christophe',0,'{}'),
  ('Emmanuel','web','DELMOTTE Emmanuel',1,'{}'),
  ('Michel','web','HECQUET Michel',0,'{}'),
  ('Thomas','web','BOURDEAUD HUY Thomas',0,'{}');

-- app.vehicles definition


CREATE TABLE `vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nb_seats` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `owner_id` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `vehicules_users_FK` (`owner_id`),
  CONSTRAINT `vehicules_users_FK` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- app.user_rents_vehicule definition

CREATE TABLE `user_rents_vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `rental_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_rents_vehicle_users_FK` (`user_id`),
  KEY `user_rents_vehicle_vehicules_FK` (`vehicle_id`),
  CONSTRAINT `user_rents_vehicle_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_rents_vehicle_vehicules_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- app.interventions definition

CREATE TABLE `interventions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `direction` tinyint(1) NOT NULL,	
  PRIMARY KEY (`id`),
  KEY `intervention_users_FK` (`user_id`),
  CONSTRAINT `intervention_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.trip definition

CREATE TABLE `trips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `departure_time` datetime NOT NULL,
  `driver_id` int DEFAULT NULL,
  `vehicle_id` int DEFAULT NULL,
  `nb_passengers` int NOT NULL DEFAULT '4',
  `status` tinyint(1) NOT NULL,
  `meetup_point` json DEFAULT NULL,
  `direction` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trajet_vehicles_FK` (`vehicle_id`),
  KEY `trajet_users_FK` (`driver_id`),
  CONSTRAINT `trajet_users_FK` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trajet_vehicles_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.trip_has_participant definition

CREATE TABLE `trip_has_participant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trip_id` int NOT NULL,
  `participant_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trip_has_participant_trip_FK` (`trip_id`),
  KEY `trip_has_participant_users_FK` (`participant_id`),
  CONSTRAINT `trip_has_participant_trip_FK` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trip_has_participant_users_FK` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.messages definition

CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(100) NOT NULL,
  `user_id` int NOT NULL,
  `trip_id` int NOT NULL,
  `send_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_trip_FK` (`trip_id`),
  KEY `messages_users_FK` (`user_id`),
  CONSTRAINT `messages_trip_FK` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.invites definition

CREATE TABLE `invites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `target_id` int NOT NULL,
  `trip_id` int NOT NULL,
  `status` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invites_trip_FK` (`trip_id`),
  KEY `invites_users_FK_1` (`target_id`),
  CONSTRAINT `invites_trip_FK` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invites_users_FK_1` FOREIGN KEY (`target_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- app.vehicles data
INSERT INTO app.vehicles (name,nb_seats,code,model,owner_id) VALUES
  ('KangooDuTurfuDeCentrale',7,'123-ABC-59','Kangoo',1),
  ('Titine',5,'AB-123-CD','Clio3',2),
  ('TwingoBlanche',4,'CD-123-EF','Twingo',4),
  ('BerlingoGris',3,'EF-123-GH','Berlingo',6),
  ('C3Rouge',5,'GH-123-IJ','CitroenC3',8);



-- app.trip data
INSERT INTO app.trips (departure_time,driver_id,vehicle_id,nb_passengers,status,meetup_point,direction) VALUES
  ('2024-06-19 07:30:00',1,1,7,0,'{}',0),
  ('2024-06-20 09:00:00',2,2,5,0,'{}',1),
  ('2024-06-21 08:30:00',4,3,4,0,'{}',1),
  ('2024-06-28 13:00:00',6,4,3,0,'{}',0);


-- app.trip_has_participant data
INSERT INTO app.trip_has_participant (trip_id,participant_id) VALUES
  (1,1),
  (2,2),
  (2,3),
  (3,4),
  (4,6);

-- app.messages data
INSERT INTO app.messages (content,user_id,trip_id,send_time) VALUES
  ('Bonjour ! je crée ce trajet pour demain matin',2,1,'2024-06-18 18:26:43');

