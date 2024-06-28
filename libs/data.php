<?php
if(!isset($_SESSION)) session_start();
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
            autoArchiveTrips();
            if (isset($_GET['direction'])) $direction = $_GET['direction'];else $direction = null;
            if (isset($_GET['date'])) $date = $_GET['date'];else $date = null;
            if (isset($_GET['nbPassagers'])) $nbPassagers = $_GET['nbPassagers'];else $nbPassagers = null;

            autoArchiveTrips();
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

            if($trip_id = valider('trip_id')){
                $response = getRemainingSeatsForTrip($trip_id);
            }

        break;
            
        case 'getCurrentUser' :
            if(valider("connecte","SESSION")){
                $id = $_SESSION['idUser'];
                $response = getUserById($id);
            }
        break;  

        // CONVERSATIONS //

        case 'getConversations' :
            if(valider("connecte","SESSION")) { 
                $id = $_SESSION['idUser'];
                $response = getAllTripsLastMessages($id);
            }

        break;

        // MESSAGES //

        case 'getMessages' :
            if(valider("connecte","SESSION"))
            if(valider("trip_id")) { 
                $trip_id = $_GET['trip_id'];
                $response = getMessagesByTripId($trip_id);
            }

        break;        

        // PARTICIPANTS //

        case 'checkParticipantAtTrip' : 
            if(valider('connecte','SESSION') && $trip_id = valider('trip_id')) {
                $idUser = $_SESSION['idUser'];
                $response = checkParticipantAtTrip($idUser,$trip_id);
            }

        break;

        // INTERVENTIONS //

        case 'getInterventions' :
            if(valider('connecte','SESSION')){
                $id = $_SESSION['idUser'];
                $response = getInterventionsByUserId($id);
            }
        break;

        // MY TRIPS //

        case 'getMyDraftTrips' : 
            if(valider('connecte','SESSION')){
                $id = $_SESSION['idUser'];
                autoArchiveTrips();
                $response = getDraftTripsByUserId($id);
            }
        break;

        case 'getMyArchivedTrips' : 
            if(valider('connecte','SESSION')){
                $id = $_SESSION['idUser'];
                autoArchiveTrips();
                $response = getArchivedTripsByUserId($id);
            }
        break;

        // INVITATIONS //

        case 'getInvitations' :
            if(valider('connecte','SESSION')){
                $id = $_SESSION['idUser'];
                $response = getPendingInvitesForUser($id);
            }
        break;

    }
    if ($response === null) {
        $response = []; // Assigne un tableau vide si $response est null
    }

    echo json_encode($response);
}
else if(isset($_POST["action"])){

    switch($_POST["action"]){

        case 'updateUser' :
            if(valider("connecte","SESSION")){
                $id = $_SESSION['idUser'];
                if(valider('display_name') && valider('username') && valider("street_number") && valider("street") && valider("city") && valider("city_code")){
                    $display_name = valider('display_name');
                    $username = valider('username');
                    $street_number = valider("street_number");
                    $street = valider("street");
                    $city = valider("city");
                    $city_code = valider("city_code");
                    $response = updateUserById($id, $username, $display_name,  $street_number, $street, $city, $city_code);
                }
            }

        break;
    
        case 'updateUserPassword' :
            if(valider("connecte","SESSION")){
                $id = $_SESSION['idUser'];
                if(valider('ancienMDP') && valider('newMDP') && valider('confirmMDP')){
                    $password = valider('ancienMDP');
                    $new_password = valider('newMDP');
                    $new_password_confirmation = valider('confirmMDP');
                    if(verifUserBdd(getUserById($id)['username'], $password) && $new_password == $new_password_confirmation){
                        $response = updateUserPasswordById($id, $new_password);
                    }
                }
            }

        break;

        case 'leaveTrip':
            if(valider('connecte','SESSION')){
                $id = $_SESSION['idUser'];
                if($trip=valider('trip_id')){
                    unsubscribeFromTrip($id, $trip);
                }
            }
        break;

        case 'joinTrip' :
            if(valider('connecte','SESSION')){
                $id = $_SESSION['idUser'];
                if($trip=valider('trip_id')){
                    subscribeToTrip($id, $trip);
                }
            }
        break;

        case 'createIntervention' :
            if(valider("connecte","SESSION"))
            if(valider('lieu'))
            if (valider('date')) {
                $id = $_SESSION['idUser'];
                $lieu = $_POST['lieu'];
                $date = $_POST['date'];
                
                $response =createIntervention($id, $date, ($lieu == "I")?0:1);                
            }
        break;


        // MESSAGES //

        case 'postMessages' :
            if(valider("connecte","SESSION"))
            if(valider("trip_id"))
            if(valider("contenu")) { 
                $id = $_SESSION['idUser'];
                $content = $_POST['contenu'];
                $trip_id = $_POST['trip_id'];

                $idMsg = sendMessageToTrip($id, $trip_id, $content);
                $response = getMessageById($idMsg);
            }

        break;  

        case 'deleteVehicle':
            if(valider('connecte','SESSION'))
            if(valider('vehicle_id')){
                $vehicle_id = $_POST['vehicle_id'];
                $response = deleteVehicleById($vehicle_id);
            }
    }
    if ($response === null) {
        $response = []; // Assigne un tableau vide si $response est null
    }
    echo json_encode($response);
}
