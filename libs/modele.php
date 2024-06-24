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

	$SQL="SELECT id FROM users WHERE pseudo='$login' AND pass='$passe';";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

/**
 * Récupère les informations d'un utilisateur par son ID.
 * @param int $id 
 * @return mixed|false 
 */

function getUserById($id)
{
	$SQL="SELECT * FROM users WHERE id='$id';";

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
	$SQL= "INSERT INTO users (username, password, display_name, driving_license, adress)
	VALUES ('$username', 
			'$password', 
			'$display_name', 
			'$driving_license', 
			{\"street_number\" : \"'$street_number'\", 
				\"street\" : \"'$street'\" , 
				\"code\" : '$city_code' , 
				\"city\" : \"'$city'\"
			} );";
	
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
function updateUserById($id, $username, $password, $display_name, $driving_license, $street_number, $street, $city, $city_code){
	$SQL= "UPDATE users
	SET username = '$username',
		password = '$password',
		display_name = '$display_name',
		driving_license = '$driving_license',
		adress = {
			\"street_number\" : \"'$street_number'\", 
			\"street\" : \"'$street'\" , 
			\"code\" : '$city_code' ,
			\"city\" : \"'$city'\"
		}
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
	$SQL= "INSERT INTO vehicles (name, nb_seats, code, model, owner_id)
	VALUES ('$name', '$nb_seats', '$code', '$model', '$owner_id');
	";
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
	$SQL="SELECT * FROM vehicles WHERE id_user='$id';";

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

function getCentraleVehicleAvailabilityByIdAndDate($vehicle_id, $date){
	$SQL= "SELECT COUNT(*) FROM user_rents_vehicle
	WHERE vehicle_id = '$vehicle_id' AND rental_date = '$date';";
	$result = intval(SQLGetChamp($SQL));
	return ($result == 0);
}

function bookVehicleByIds($vehicle_id, $rental_date, $user_id){
	$SQL= "INSERT INTO user_rents_vehicle (vehicle_id, rental_date, user_id)
	VALUES ('$vehicle_id', '$rental_date', '$user_id');";
	SQLInsert($SQL);

}

// INTERVENTIONS

function createIntervention($user_id, $date, $direction){
	$SQL= "INSERT INTO interventions (user_id, date, direction)
	VALUES ('$user_id', '$date', '$direction');
	";
	SQLInsert($SQL);
	return;
}

function deleteInterventionById($id) {
	$SQL= "DELETE FROM interventions WHERE id = '$id';";
	SQLInsert($SQL);
	return;
}

function getInterventionsByDate($date) {
	$SQL= "SELECT * FROM interventions
	WHERE date = '$date';";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


// TRIPS

function getDraftTrips(){
	$SQL= "SELECT * FROM trips
	WHERE status = 0
	ORDER BY departure_time ASC, (driver_id IS NULL) DESC ;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

function getDraftTripsByDateAndDestination($date, $direction){
	$SQL= "SELECT * FROM trips
	WHERE status = 0 AND DATE(departure_time) = '$date' AND direction = '$direction'
	ORDER BY departure_time ASC, (driver_id IS NULL) DESC ;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

function getDraftTripsByUserId($user_id){
	$SQL= "SELECT t.* FROM trips t
		JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE status = 0 AND thp.participant_id = '$user_id'
	ORDER BY departure_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


function getArchivedTripsByUserId( $user_id ) {
	$SQL= "SELECT t.* FROM trips t 
		JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE thp.participant_id = '$user_id' AND t.status = 2
	ORDER BY departure_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

function getUpcomingTripsByUserId( $user_id ) {
	$SQL= "SELECT t.* FROM trips t 
		JOIN trip_has_participant thp ON t.id = thp.trip_id
	WHERE thp.participant_id = '$user_id' AND t.status = 1
	ORDER BY departure_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


function createTrip( $departure_time, $driver_id, $vehicle_id, $nb_passengers, $direction)
{
	$SQL= "INSERT INTO trips (departure_time, driver_id, vehicle_id, nb_passengers, status,  direction)
	VALUES ('$departure_time', '$driver_id', '$vehicle_id', '$nb_passengers',0, '$direction');";
	SQLInsert($SQL);
	return;
}

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

function declareUserAsTripDriverByIds($user_id, $trip_id) {
	$SQL= "UPDATE trips
	SET driver_id = '$user_id'
	WHERE id = '$trip_id';";
	$n=SQLUpdate($SQL);

	return $n;
}

function setVehicleForTripByIds($vehicle_id, $trip_id) {
	$SQL= "UPDATE trips
	SET vehicle_id = '$vehicle_id',
	    nb_passengers = (SELECT nb_seats FROM vehicles WHERE id = '$vehicle_id')

	WHERE id = '$trip_id';";
	$n=SQLUpdate($SQL);

	return $n;
}
function validateTripById($id) {
	$SQL= "UPDATE trips
	SET status = 1
	WHERE id = '$id';";
	$n=SQLUpdate($SQL);

	return $n;
}

function autoArchiveTrips() {
	$SQL= "UPDATE trips
	SET status = 2
	WHERE DATE(DATEADD(departure_time, INTERVAL 1 DAY)) < NOW();";
	$n=SQLUpdate($SQL);

	return $n;
}

function deleteTripById($id) {
	$SQL= "DELETE FROM trips WHERE id = '$id';";
	SQLInsert($SQL);
	return;
}


function getRemainingSeatsForTrip($id) {
	$SQL= "SELECT t.nb_passengers - COUNT(*) FROM trip t JOIN trip_has_participant thp ON t.id = thp.trip_id;";
	$res = SQLGetChamp($SQL);
	return $res;
}

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

function getTripParticipants($id) {
	$SQL= "SELECT * FROM trip_has_participant
	WHERE trip_id = '$id';";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}


function subscribeToTrip($user_id, $trip_id)
{
	$SQL= "INSERT INTO trip_has_participant (trip_id, participant_id)
	VALUES ('$trip_id', '$user_id');";
	SQLInsert($SQL);
	return;
}

function unsubscribeFromTrip($user_id, $trip_id)
{
	$SQL= "DELETE FROM trip_has_participant
	WHERE trip_id = '$trip_id' AND participant_id = '$user_id';";
	SQLDelete($SQL);
	return;
}



// INVITES

function sendInviteToUser($user_id, $trip_id) {
	$SQL= "INSERT INTO invites (target_id, trip_id,status)
	VALUES ('$user_id', '$trip_id', 0);";
	SQLInsert($SQL);
	return;
}

function getPendingInvitesForUser($user_id) {
	$SQL= "SELECT * FROM invites
	WHERE target_id = '$user_id' AND status = 0;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

function acceptInvite($user_id, $trip_id) {
	$SQL= "UPDATE invites
	SET status = 1
	WHERE target_id = '$user_id' AND trip_id = '$trip_id';";
	$n=SQLUpdate($SQL);

	return $n;
}

function rdeclineInvite($user_id, $trip_id) {
	$SQL= "UPDATE invites
	SET status = 2
	WHERE target_id = '$user_id' AND trip_id = '$trip_id';";
	$n = SQLUpdate($SQL);
	return $n;
}

// MESSAGES

function getAllTripsLastMessages(){
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
	WHERE lm.n = 1;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;

}

function getMessagesByTripId( $trip_id ) {
	$SQL= "SELECT * FROM messages
	WHERE trip_id = '$trip_id'
	ORDER BY send_time ASC;";
	$res = parcoursRs(SQLSelect($SQL));
	return $res;
}

function sendMessageToTrip($user_id, $trip_id, $content) {
	$SQL= "INSERT INTO messages (content,user_id, trip_id, send_time)
	VALUES ('$user_id', '$trip_id', '$content',NOW());";
	SQLInsert($SQL);
	return;
}










?>
