CREATE DATABASE `app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;


-- app.vehicles definition

CREATE TABLE `vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nb_seats` int CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_centrale` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.users definition

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `driving_license` tinyint(1) NOT NULL,
  `adress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- app.user_owns_vehicule definition

CREATE TABLE `user_owns_vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_owns_vehicule_vehicules_FK` (`vehicle_id`),
  KEY `user_owns_vehicule_users_FK` (`user_id`),
  CONSTRAINT `user_owns_vehicule_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_owns_vehicule_vehicules_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
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
  `status` tinyint(1) NOT NULL,
  `meetup_point` varchar(100) DEFAULT NULL,
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

