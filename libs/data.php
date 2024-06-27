<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


include_once("maLibUtils.php");
include_once("modele.php");


header('Content-Type: application/json');

$response = null;

//on peut créer plusieurs point d'arrivée pour les requêtes
if (isset($_GET['action'])){

    switch($_GET['action']){
        case 'getDraftTrips' : 
            if (isset($_GET['direction'])) $direction = $_GET['direction'];else $direction = null;
            if (isset($_GET['date'])) $date = $_GET['date'];else $date = null;
            if (isset($_GET['nbPassagers'])) $nbPassagers = $_GET['nbPassagers'];else $nbPassagers = null;

            $response = getDraftTripsByDateDestinationAndRemainingSeats($date, $direction, $nbPassagers);       
        break;

        case 'getMyVehicles' : 
            if(valider("connecte","SESSION")){
                $id = $_SESSION['idUser'];
                $response = getUsersVehicles($id);
            }
        break;

        case 'getAvailableVehicles' :
            if(isset($_GET['date'])){ 
            
            $date = $_GET['date'];
            $response = getAvailableCentraleVehiclesByDate($date);
            }

        break;

        case 'getTrip' :

            if(isset($_GET['trip_id'])){

                $trip_id = $_GET['trip_id'];

                $response = getTripById($trip_id);
            }
        break;

        case 'getVehicle' :

            if(isset($_GET['vehicle_id'])){
                $vehicle_id = $_GET['vehicle_id'];
                $response = getVehicleById($vehicle_id);
            }

        break;

        case 'getUser' :

            if(isset($_GET['user_id'])){
                $user_id = $_GET['user_id'];
                $response = getUserById($user_id);
            }

        break;

        case 'getParticipants' :

            if(isset($_GET['trip_id'])){
                $trip_id = $_GET['trip_id'];
                $response = getTripParticipants($trip_id);
            }

        break;

        case 'getRemainingSeats' :

            if(isset($_GET['trip_id'])){
                $trip_id = $_GET['trip_id'];
                $response = getRemainingSeatsForTrip($trip_id);
            }

        break;
            




        

    }
    if ($response === null) {
        $response = []; // Assigne un tableau vide si $response est null
    }

    echo json_encode($response);
}