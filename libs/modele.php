<?php

/*
Partie modèle : on effectue ici tous les traitements sur la base de données (lecture, insertion, suppression, mise à jour).

Des fonctions sont déjà présentes : vous avez le droit de les modifier ou d'en ajouter à votre guise. Des indications sont données en commentaires.
*/
include_once("maLibSQL.pdo.php");




// USERS


/**
 * Vérifie l'identité d'un utilisateur en fonction des identifiants fournis.
 *
 * @param string $login Le pseudo de l'utilisateur.
 * @param string $passe Le mot de passe de l'utilisateur.
 * @return mixed Retourne l'ID de l'utilisateur si trouvé, sinon false.
 */
function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id FROM users u WHERE u.username='$login' AND u.password='$passe';";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}


/**
 * Vérifie si un nom d'utilisateur est déjà pris.
 *
 * @param string $login le nom d'utilisateur à vérifier.
 * @return int|false L'id de l'utilisateur si le nom est déjà pris, sinon false.
 */
function checkUsername($login){
	$SQL= "SELECT id FROM users WHERE username='$login';";
	return SQLGetChamp($SQL);
}

/**
 * Récupère les informations d'un utilisateur par son ID.
 * @param int $id 
 * @return array|false 
 */

function getUserById($id)
{
	$SQL="SELECT id, username, display_name, driving_license, adress FROM users WHERE id='$id';";

	$result = parcoursRs(SQLSelect($SQL));
	if (count($result)> 0)
	{
		return $result[0];
	}
	else
	{
		return false;
	}
}


/**
 * Crée un nouveau compte utilisateur dans la base de données avec les informations fournies.
 *
 * @param string $username Le nom d'utilisateur du nouveau compte.
 * @param string $password Le mot de passe du nouveau compte.
 * @param string $display_name Le nom d'affichage du nouveau compte.
 * @param string $driving_license Le numéro de permis de conduire du nouveau compte.
 * @param string $street_number Le numéro de rue de l'adresse du nouveau compte.
 * @param string $street Le nom de rue de l'adresse du nouveau compte.
 * @param string $city La ville de l'adresse du nouveau compte.
 * @param string $city_code Le code postal de l'adresse du nouveau compte.
 * @return int L'ID du compte nouvellement créé.
 */
function createAccount($username, $password, $display_name, $driving_license, $street_number, $street, $city, $city_code){
    $addressJson = json_encode(array(
        "street_number" => $street_number,
        "street" => $street,
        "code" => $city_code,
        "city" => $city
    ));
    $addressJson = addslashes($addressJson); // Échappe les caractères spéciaux dans la chaîne pour l'utiliser dans la requête SQL

    $SQL= "INSERT INTO users (username, password, display_name, driving_license, adress)
    VALUES ('$username', 
            '$password', 
            '$display_name', 
            '$driving_license', 
            '$addressJson'
            );";
    
    $id = SQLInsert($SQL);

    return $id;
}
/**
 * Mettre à jour les informations d'un utilisateur.
 *
 * @param int $id l'ID de l'utilisateur
 * @param string $username le nouveau nom d'utilisateur
 * @param string $password le nouveau mot de passe
 * @param string $display_name le nouveau nom d'affichage
 * @param string $driving_license nouvelle confirmation de permis
 * @param string $street_number le nouveau numero de rue
 * @param string $street la nouvelle rue
 * @param string $city la nouvelle ville
 * @param string $city_code le nouveau code postal
 * @return int le nombre de lignes mises à jour par l'opération
 */
function updateUserById($id, $username, $display_name, $street_number, $street, $city, $city_code){
	$SQL= "UPDATE users
	SET username = '$username',
		display_name = '$display_name',
		adress = '{
			\"street_number\" : \"$street_number\", 
			\"street\" : \"$street\" , 
			\"code\" : \"$city_code\" ,
			\"city\" : \"$city\"
		}'
	WHERE id = '$id';
	";

	$n = SQLUpdate($SQL);
	return $n;
}

function updateUserPasswordById($id, $password){
	$SQL= "UPDATE users
	SET password = '$password'
	WHERE id = '$id';
	";

	$n = SQLUpdate($SQL);
	return $n;
}

/**
 * supprimer un utilisateur de la base de données
 *
 * @param int $id l'ID de l'utilisateur
 * @return int Le nombre de lignes affectées par l'opération (1)
 */
function deleteUserById($id){
	$SQL= "DELETE FROM users WHERE id = '$id';";

	$n = SQLDelete($SQL);
	return $n;
}

function verifDriverLicenseById($id){
	$SQL= "SELECT driving_license FROM users WHERE id = '$id';";

	return SQLGetChamp($SQL);
}

// VEHICLES


/**
 * Déclare un nouveau vehicule dans la base de données
 *
 * @param string $name  le nom du vehicule
 * @param int $nb_seats le nombre de places du vehicule
 * @param string $code l'immatriculation du vehicule
 * @param string $model le modele du vehicule
 * @param int $owner_id l'id de l'utilisateur
 * @return void
 */
function createVehicle($name, $nb_seats, $code, $model, $owner_id) {
	// $code et $model peuvent etre NULL, si l'utilisateur ne les a pas renseignés, et on veut les laisser NULL en base
	$code_value = is_null($code) ?"NULL": "'$code'";
	$model_value = is_null($model) ?"NULL": "'$model'";

	$SQL= "INSERT INTO vehicles (name, nb_seats, code, model, owner_id)
	VALUES ('$name', '$nb_seats', $code_value, $model_value, '$owner_id');";
	SQLInsert($SQL);
	return;
	}

/**
 * Récupérer tous les vehicules d'un utilisateur
 *
 * @param int $id id de l'utilisateur
 * @return array|false renvoie un tableau associatif de véhicules ou false
 */
function getUsersVehicles($id)
{
	$SQL="SELECT * FROM vehicles WHERE owner_id='$id';";

	$result = ParcoursRs(SQLSelect($SQL));
	if (count($result)> 0)
	{
		return $result;
	}
	else
	{
		return false;
	}
}

/**
 * Récupérer un vehicule par son ID. Retourne false si aucun vehicule n'est trouvé.
 *
 * @param int $id l'ID du vehicule à recuperer
 * @return array|false renvoie  un tableau associatif du vehicule ou false
 */
function getVehicleById($id)
{
	$SQL="SELECT * FROM vehicles WHERE id='$id';";

$result = ParcoursRs(SQLSelect($SQL));
if (count($result)> 0)
{
	return $result[0];
}
else
{
	return false;
}
}

/**
 * Mettre à jour les informations d'un vehicule.
 * @param int $id L'ID du vehicule.
 * @param string $name le nouveau nom du vehicule.
 * @param int $nb_seats le nouveau nombre de places du vehicule.
 * @param string $code le nouveau code d'immatriculation du vehicule.
 * @param string $model le nouveau modele du vehicule.
 * @param int $owner_id le nouveau ID de l'utilisateur.
 * @return int The number of rows affected by the update query.
 */
function updateVehicleById($id,$name, $nb_seats, $code, $model) {
	$SQL= "UPDATE vehicles
	SET name = '$name',
		nb_seats = '$nb_seats',
		code = '$code',
		model = '$model'
	WHERE id = '$id';
	";
	$n=SQLUpdate($SQL);

	return $n;
}

	/**
	 * Récupère les vehicules disponibles pour une date donnée.
	 *
	 * @param string  $date La date pour laquelle on veut les vehicules disponibles.
	 * @return array|false Un tableau associatif de vehicules disponibles ou false.
	 */
function getAvailableCentraleVehiclesByDate($date){
	$SQL= "SELECT 
			v.* 
		FROM 
			vehicles v
			LEFT JOIN 
			user_rents_vehicle urv
				ON v.id = urv.vehicle_id
		WHERE 
			v.owner_id = 1
		GROUP BY 
			v.id
		HAVING 
			COUNT(urv.id) = 0;";
	$result = ParcoursRs(SQLSelect($SQL));
	if (count($result)> 0)
	{
		return $result;
	}
	else
	{
		return false;
	}
}	

/**
 * Retourne l'état de disponibilité d'un vehicule pour une date donnée.
 *
 * @param int $vehicle_id L'id du vehicule
 * @param string $date La date recherchée 
 * @return bool Renvoie l'état de disponibilité du véhicule
 */
function getCentraleVehicleAvailabilityByIdAndDate($vehicle_id, $date){
	$SQL= "SELECT COUNT(*) FROM user_rents_vehicle
	WHERE vehicle_id = '$vehicle_id' AND rental_date = '$date';";
	$result = intval(SQLGetChamp($SQL));
	return ($result == 0);
}



/**
 * Insère une nouvelle réservation de vehicule dans la base de données.
 *
 * @param int $vehicle_id L'id du véhicule à réserver
 * @param string $rental_date La date de la réservation
 * @param int $user_id L'id de l'utilisateur qui réserve
 * @return void
 */
function bookVehicleByIds($vehicle_id, $rental_date, $user_id){
	$SQL= "INSERT INTO user_rents_vehicle (vehicle_id, rental_date, user_id)
	VALUES ('$vehicle_id', '$rental_date', '$user_id');";
	SQLInsert($SQL);

}

// INTERVENTIONS

/**
 * Déclare une nouvelle Intervention dans la base
 *
 * @param int $user_id L'ID de l'utilisateur qui va effectuer l'intervention.
 * @param string $date La date de l'intervention.
 * @param string $direction Le lieu de l'intervention.
 * @return void
 */
function createIntervention($user_id, $date, $direction){
	$SQL= "INSERT INTO interventions (user_id, date, direction)
	VALUES ('$user_id', '$date', '$direction');
	";
	SQLInsert($SQL);
	return;
}

/**
 * Supprime une Intervention dans la base 
 *
 * @param int $id L'id de l'intervention à supprimer.
 * @return void
 */
function deleteInterventionById($id) {
	$SQL= "DELETE FROM interventions WHERE id = '$id';";
	SQLInsert($SQL);
	return;
}

/**
 * Récupère les utilisateurs qui ont une intervention à une date donnée.
 *
 * @param string $date La date des de l'intervention.
 * @return array Un tableau de tous les utilisateurs qui ont une intervention à la date donnée.
 */


function getUsersInterventionsByDate($date) {
	$SQL= "SELECT u.* FROM 
		interventions i
		JOIN users u ON interventions.user_id = u.id
	WHERE i.date = '$date';";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


// TRIPS

/**
 * Récupère  tous les voyages en cours d'édition dans la base de données.
 *
 * @return array Un tableau associatif de tous les voyages en cours d'édition, trié par date et ordre de priorité.
 * 
 *
 */
function getDraftTrips(){
	$SQL= "SELECT * FROM trips
	WHERE status = 0
	ORDER BY departure_time ASC, (driver_id IS NULL) DESC, (vehicle_id IS NULL) DESC ;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

/**
 * Récupère tous les voyages en cours d'édition pour une date et une destination données.
 *
 * @param string $date La date des voyages à récupérer.
 * @param string $direction La destination  des voyages à récupérer.
 * @return array Un tableau  associatif de tous les voyages en cours d'édition pour la date et la destination données, trié par date et ordre de priorité.
 */
function getDraftTripsByDateDestinationAndRemainingSeats($date, $direction, $wished_seats){
	$direction_filter = is_null($direction) ?"": "AND direction = '$direction'";
	$date_filter = is_null($date) ?"":"AND DATE(departure_time) = '$date'";
	$seats_value = is_null($wished_seats) ?"1":"'$wished_seats'";

	$SQL= "SELECT t.*, COUNT(thp.participant_id) AS nb_participants  FROM trips t
	LEFT JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE status = 0 ". $date_filter." ". $direction_filter ." 
	GROUP BY t.id
	HAVING t.nb_passengers - COUNT(thp.participant_id) >= '$wished_seats'
	ORDER BY t.departure_time ASC, (t.driver_id IS NULL) DESC, (t.vehicle_id IS NULL) DESC ;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}



/**
 * Récupère tous les voyages en cours d'édition auxquels un utilisateur participe.
 *
 * @param int $user_id L'id de l'utilisateur.
 * @return array Un tableau associatif de tous les voyages en cours d'édition auxquels l'utilisateur participe, trié par date 
 */
function getDraftTripsByUserId($user_id){
	$SQL= "SELECT t.* FROM trips t
		JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE status = 0 AND thp.participant_id = '$user_id'
	ORDER BY departure_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


/**
 * Récupère  tous les voyages archivés dans la base de données auxquels un utilisateur a participé .
 *
 * @param int $user_id L'id de l'utilisateur.
 * @return array Un tableau associatif de tous les voyages archivés auxquels l'utilisateur a participé, trié par date.
 */
function getArchivedTripsByUserId( $user_id ) {
	$SQL= "SELECT t.* FROM trips t 
		JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE thp.participant_id = '$user_id' AND t.status = 2
	ORDER BY departure_time DESC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

/**
 * Récupère tous les trajets validés à venir  auxquels  un utilisateur participe.
 * @param int $user_id L'id  de l'utilisateur.
 * @return array Un tableau  associatif de tous les trajets validés à venir auxquels l'utilisateur participe, trié par date.
 */
function getUpcomingTripsByUserId( $user_id ) {
	$SQL= "SELECT t.* FROM trips t 
		JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE thp.participant_id = '$user_id' AND t.status = 1
	ORDER BY departure_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


/**
 * Insère un nouveau voyage dans la base de données.
 *
 * @param string $departure_time l'heure de départ du voyage.
 * @param int|null $driver_id l'id du conducteur pour le voyage.
 * @param int|null $vehicle_id L'id du  véhicule pour le voyage.
 * @param int|null $nb_passengers Le nombre  de passagers max pour le voyage.
 * @param int $direction La direction dun voyage
 * @return int
 */
function createTrip( $departure_time, $driver_id, $vehicle_id, $nb_passengers, $direction)
{
	$driver_id = is_null($driver_id) ? "NULL" : "'$driver_id'";

	$nb_passengers = is_null($nb_passengers) ? "NULL" : "'$nb_passengers'";

	$vehicle_id = is_null($vehicle_id) ? "NULL" : "'$vehicle_id'";

	$SQL= "INSERT INTO trips (departure_time, driver_id, vehicle_id, nb_passengers, status,  direction)
	VALUES ('$departure_time', $driver_id, $vehicle_id, $nb_passengers,0, '$direction');";
	$id = SQLInsert($SQL);
	return $id;
}

	/**
	 * Met à jour  un voyage dans la base de données.
	 *
	 * @param int $id L'id du voyage à mettre à jour.
	 * @param string $departure_time La nouvelle heure de départ du voyage.
	 * @param int $driver_id Le nouvel ID du conducteur pour le voyage.
	 * @param int $vehicle_id Le nouvel ID du véhicule pour le voyage.
	 * @param int $nb_passengers Le nouveau nombre de passagers max pour le voyage.
	 * @return int Le nombre de lignes affectées par l'opération.
	 */
function updateTripById($id, $departure_time, $driver_id, $vehicle_id, $nb_passengers)
{
	$SQL= "UPDATE trips
	SET departure_time = '$departure_time',
		driver_id = '$driver_id',
		vehicle_id = '$vehicle_id',
		nb_passengers = '$nb_passengers',
	WHERE id = '$id';";
	$n=SQLUpdate($SQL);

	return $n;
}

/**
 * Récupère un voyage en fonction de son identifiant.
 *
 * @param int $id L'identifiant du voyage.
 * @throws Exception Description de l'exception
 * @return array|false Les informations du voyage. 
 */
function getTripById($id){
	$SQL= "SELECT * FROM trips WHERE id = '$id';";
	$res = parcoursRs(SQLSelect($SQL));
	if (count($res)){
		return $res[0];
	}else {
		return false;
	}
}

/**
 * Mettre à jour le conducteur d'un voyage.
 * @param int $user_id l'ID de l'utilisateur qui deviendra le conducteur.
 * @param int $trip_id L'ID du voyage.
 * @return int Le  nombre de lignes affectées par l'opération.
 */
function declareUserAsTripDriverByIds($user_id, $trip_id) {
	$SQL= "UPDATE trips
	SET driver_id = '$user_id'
	WHERE id = '$trip_id';";
	$n=SQLUpdate($SQL);

	return $n;
}

/**
 * Met à jour le véhicule d'un voyage.
 *
 * @param int $vehicle_id L'id du véhicule.
 * @param int $trip_id L'id du voyage.
 * @return int Le nombre de lignes affectées par l'opération.
*/
function setVehicleForTripByIds($vehicle_id, $trip_id) {
	$SQL= "UPDATE trips
	SET vehicle_id = '$vehicle_id',
	    nb_passengers = (SELECT nb_seats FROM vehicles WHERE id = '$vehicle_id')

	WHERE id = '$trip_id';";
	$n=SQLUpdate($SQL);

	return $n;
}
/**
 * Envoie la validation d'un voyage à la base de données.
 * @param int $id L'id du voyage à valider.
 * @return int Le nombre de lignes affectées par l'opération.
 */
function validateTripById($id) {
	$SQL= "UPDATE trips
	SET status = 1
	WHERE id = '$id';";
	$n=SQLUpdate($SQL);

	return $n;
}

/**
 * Archive automatiquement tous les voyages dont la date de départ est passée d'un jour au moins;
 *
 * @return int Le nombre de lignes affectées par l'opération.
 */
function autoArchiveTrips() {
	$SQL= "UPDATE trips
	SET status = 2
	WHERE DATE(DATEADD(departure_time, INTERVAL 1 DAY)) < NOW();";
	$n=SQLUpdate($SQL);

	return $n;
}

/**
 * Supprime  un voyage de la base de données.
 * @param int $id L'id du  voyage à supprimer.
 * @return void
 */
function deleteTripById($id) {
	$SQL= "DELETE FROM trips WHERE id = '$id';";
	SQLInsert($SQL);
	return;
}


	/**
	 * Récupère le nombre de places restantes pour un voyage
	 *
	 * @param int $id L'id du voyage.
	 * @return int Le nombre de places restantes pour le voyage.
	 */
function getRemainingSeatsForTrip($id) {
	$SQL= "SELECT t.nb_passengers - COUNT(thp.id) FROM trips t LEFT JOIN trip_has_participant thp ON t.id = thp.trip_id GROUP BY t.id HAVING t.id = '$id';";
	$res = SQLGetChamp($SQL);
	return $res;
}

/**
 * Vérifie si un voyage est quittable.
 *
 * @param int $trip_id L'id du voyage.
 * @return bool Renvoie true si le voyage est quittable, sinon false.
 */
function verifLeavableTrip($trip_id){
	$SQL= "SELECT status FROM trips WHERE id = '$trip_id';";
	$res = SQLGetChamp($SQL);
	if ($res) {
	return (intval(SQLGetChamp($SQL))==0);
	}
	else {
		return false;
	}
}
// PARTICIPANTS

/**
 * Réccupère la liste des participants à un voyage.
 *
 * @param int $id L'id du voyage.
 * @return array Le tableau associatif des participants au voyage.
 */
function getTripParticipants($id) {
	$SQL= "SELECT * FROM trip_has_participant
	WHERE trip_id = '$id';";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


/**
 * Enregistre un utilisateur comme participant à un voyage.
 *
 * @param int $user_id L'id de l'utilisateur à ajouter.
 * @param int $trip_id L'id du voyage.
 * @return void
 */
function subscribeToTrip($user_id, $trip_id)
{
	$SQL= "INSERT INTO trip_has_participant (trip_id, participant_id)
	VALUES ('$trip_id', '$user_id');";
	SQLInsert($SQL);

	//Envoi du message de bienvenue

	$display_name = getUserById($user_id)["display_name"];

	sendMessageToTrip(1,$trip_id,"$display_name a rejoint le trajet.");

	return;
}

/**
 * Désinscrit un utilisateur d'un voyage.
 *
 * @param int $user_id L'id de l'utilisateur à désinscrire.
 * @param int $trip_id L'id du voyage.
 * @return void
 */
function unsubscribeFromTrip($user_id, $trip_id)
{
	$SQL= "DELETE FROM trip_has_participant
	WHERE trip_id = '$trip_id' AND participant_id = '$user_id';";
	SQLDelete($SQL);

	$display_name = getUserById($user_id)[""];

	sendMessageToTrip(1,$trip_id,"$display_name a quitté le trajet.");

	return;
}

function checkParticipantAtTrip($user_id, $trip_id){
	$SQL= "SELECT * FROM trip_has_participant
	WHERE trip_id = '$trip_id' AND participant_id = '$user_id';";
	$res = SQLGetChamp($SQL);
	return $res; 

}




// INVITES

/**
 * Insère une invitation dans la base de données.
 *
 * @param int $user_id L'id de l'utilisateur à inviter.
 * @param int $trip_id L'id du voyage.
 * @return void
 */
function sendInviteToUser($user_id, $trip_id) {
	$SQL= "INSERT INTO invites (target_id, trip_id,status)
	VALUES ('$user_id', '$trip_id', 0);";
	SQLInsert($SQL);
	return;
}

/**
 * récupère toutes les invitations en attente pour un voyage.
 *
 * @param int $user_id L'id de l'utilisateur.
 * @return array Un tableau associatif de toutes les invitations en attente pour l'utilisateur.
 */
function getPendingInvitesForUser($user_id) {
	$SQL= "SELECT * FROM invites
	WHERE target_id = '$user_id' AND status = 0;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

/**
 * Met à jour le statut d'une invitation à "accepté" pour un voyage.
 *
 * @param int $user_id L'id de l'utilisateur associé à l'invitation.
 * @param int $trip_id L'id du voyage.
 * @return int le nombre de lignes affectées par l'opération.
 */
function acceptInvite($user_id, $trip_id) {
	$SQL= "UPDATE invites
	SET status = 1
	WHERE target_id = '$user_id' AND trip_id = '$trip_id';";
	$n=SQLUpdate($SQL);

	return $n;
}

/**
 * Met à jour le statut d'une invitation à "refusé" pour un voyage.
 *
 * @param int $user_id L'id de l'utilisateur associé à l'invitation.
 * @param int $trip_id L'id du voyage.
 * @return int Le nombre de lignes affectées par l'opération.
 */
function declineInvite($user_id, $trip_id) {
	$SQL= "UPDATE invites
	SET status = 2
	WHERE target_id = '$user_id' AND trip_id = '$trip_id';";
	$n = SQLUpdate($SQL);
	return $n;
}

// MESSAGES

/**
 * Récupère les derniers messages des voyages auxquel un utilisateur participe.
 * @param int $user_id L'id du voyage.
 * @return array Un tableau asociatif contenant les données d'intitulé du trajet et le contenu du dernier message posté, trié par date de départ.
 */
function getAllTripsLastMessages($user_id){
	// PARTITION BY  : requiert MySQL 8 au moins 
	$SQL= "SELECT 
		t.departure_time,
		t.direction,
		t.id as trip_id,
		lm.send_time as last_message_time,
		lm.content,
		lm.user_id as sender_id
	FROM 
		(SElECT *,
			ROW_NUMBER() OVER (PARTITION BY trip_id ORDER BY send_time DESC) as n 
		FROM messages m )
		lm
		JOIN 
		trips t ON lm.trip_id = t.id
		JOIN 
		trip_has_participant thp ON t.id = thp.trip_id
	WHERE	
		thp.participant_id = '$user_id' AND lm.n = 1
	ORDER BY
		t.departure_time DESC;";

	$res = parcoursRs(SQLSelect($SQL));
	return $res;

}

/**
 * Récupère les messages d'un voyage spécifique.
 *
 * @param int $trip_id L'identifiant du voyage.
 * @throws Exception Description de l'exception
 * @return array Les messages du voyage spécifié.
 */
function getMessagesByTripId( $trip_id ) {
	$SQL= "SELECT * FROM messages
	WHERE trip_id = '$trip_id'
	ORDER BY send_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

/**
 * Publie un nouveau message dans la base de données.
 * @param int $user_id L'id de l'utilisateur qui envoie le message.
 * @param int $trip_id L'id du voyage auquel le message est associé.
 * @param string $content Le contenu du message.
 * @return void
 */
function sendMessageToTrip($user_id, $trip_id, $content) {
	$SQL= "INSERT INTO messages (content,user_id, trip_id, send_time)
	VALUES ('$user_id', '$trip_id', '$content',NOW());";
	SQLInsert($SQL);
	return;
}