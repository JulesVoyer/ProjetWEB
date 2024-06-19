

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";







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

CREATE TABLE `user_rents_vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `rental_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_rents_vehicule_users_FK` (`user_id`),
  KEY `user_rents_vehicule_vehicules_FK` (`vehicle_id`),
  CONSTRAINT `user_rents_vehicule_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_rents_vehicule_vehicules_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- app.intervention definition

CREATE TABLE `intervention` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `direction` tinyint(1) NOT NULL,	
  PRIMARY KEY (`id`),
  KEY `intervention_users_FK` (`user_id`),
  CONSTRAINT `intervention_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.trip definition

CREATE TABLE `trip` (
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
  CONSTRAINT `trajet_users_FK` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`),
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
  CONSTRAINT `trip_has_participant_trip_FK` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`),
  CONSTRAINT `trip_has_participant_users_FK` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`)
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
  CONSTRAINT `messages_trip_FK` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`),
  CONSTRAINT `messages_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
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
  CONSTRAINT `invites_trip_FK` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`),
  CONSTRAINT `invites_users_FK_1` FOREIGN KEY (`target_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- app.users data
INSERT INTO app.users (username,password,display_name,driving_license,adress) VALUES
   ('systeme','systeme','Systeme',1,'{}')
	 ('jules','julesweb','Jules VOYER',1,'{"city": "Lille", "code": 59800, "number": 1, "street": "rue du Chevalier Français"}'),
	 ('test1','test','Test1',0,'{}');


-- app.vehicles data
INSERT INTO app.vehicles (name,nb_seats,code,model,owner_id) VALUES
	 ('Titine',5,'127-AAT-35','307sw',1);



-- app.trip data
INSERT INTO app.trip (departure_time,driver_id,vehicle_id,nb_passengers,status,meetup_point,direction) VALUES
	 ('2024-06-19 10:00:00',1,1,4,0,'{}',0);


-- app.trip_has_participant data
INSERT INTO app.trip_has_participant (trip_id,participant_id) VALUES
   (1,1),
   (1,2);

-- app.messages data
INSERT INTO app.messages (content,user_id,trip_id,send_time) VALUES
	 ('Bonjour ! je crée ce trajet pour demain matin',1,1,'2024-06-18 18:26:43');

