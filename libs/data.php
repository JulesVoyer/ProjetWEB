<?php
session_start();
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
            
        case 'getCurrentUser' :
            if(valider("connecte","SESSION")){
                $id = $_SESSION['idUser'];
                $response = getUserById($id);
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


    }
}