<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)
echo '<script type="text/javascript">';
echo 'console.log("marche");';
echo '</script>';
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "trajetsDetails.php")
{
	header("Location:../index.php?view=trajetsDetails");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 


if(!$trip_id = valider("trip_id")){
    header("Location:../index.php?view=trajets");
    die("");
}

?>


<!-- **** B O D Y **** -->

<div id="detailTrajetBody">
    <br/><br/><br/>    
    <!-- Section pour afficher les détails du trajet -->

        <div id="tDtlTitlePage">
            <a id="retourPagePrecedente" href="javascript:history.back()">
                <img id="flecheRetour" src="ressources/flecheRetour.png" alt="Fleche">
            </a>
            <p>Retour</p>
        </div>

    <!-- Classe trajet récupéré de la page trajet  -->
    <div id="detailsTrajet" class="trajet">


        <h1 id="detailsTrajetDate">DUMMY_DATE</h1>

        <div class="iconeTrajet">
                <div id="detailRond" class="rond"></div>
                <div id="detailTrait" class="trait"></div>
        </div>

        <p id="detailsTrajetHeure"> DUMMY_DEPARTURE_TIME</p>
        <p id="detailsTrajetDepart"> DUMMY_STARTING_POINT</p>
        <p id="detailsTrajetArrive"> DUMMY_ARRIVING_POINT </p>

        <br><br><br>
        <h1> Nombre de place(s) restantes : <span id = "detailsTrajetRemainingSeats">DUMMY_REMAINING_SEATS</span> </h1>
        <br>

        <h1>Participants : </h1>
        <ul id = "detailsTrajetParticipants">
            <!-- DUMMY_PARTICIPANTS -->
            <li class='detailTrajetListElm'><a href='index.php?view=detailUtilisateur'>DUMMY_NAME</a></li>

        </ul>

        <h1>Voiture : </h1>
        <div id = noVehicleDeclaredDisclaimer>
            <img  src = "ressources/auto-rouge.png" class = 'icon'/>
            <p> Aucune voiture n'est attribuée à ce trajet </p>
        </div>
        
        <div id="detailTrajetVoitureAssigne">
            <p><b>Modèle :</b> <span id ="TripDetailVehicleModel">DUMMY_MODEL</span>  </p>
            <p><b>Immatriculation :</b> <span id = "TripDetailVehiclePlate">DUMMY_CODE</span> </p>
            <p><b>Propriétaire :</b> <span id = "TripDetailVehicleOwner">DUMMY_OWNER</span> </p>
        </div>

        <input id="trjRejoindre" class="btn btnTrajet" type="button" value="Rejoindre" />
    </div>
</div>

<script>
    $(document).ready(function(){
        // On récupère l'id du trajet dans l'url
        displayTrip();        


    });
    

    function displayTrip(){
        var trip_id = <?php echo $trip_id; ?>;
        // On récupère les informations du trajet
        $.ajax({
            url: './libs/data.php',
            type: 'GET',
            data: {
                action: 'getTrip',
                trip_id: trip_id
            },
            dataType: "json",
            success: function(data){
                console.log(data);
                // On affiche les informations du trajet
                var datetime = data.departure_time;
                let [date, heure] =  datetime.split(" ");
                // formate la date en Jour n Mois
                date = date.split("-").reverse().join("-");
                heure = heure .split(":").slice(0, 2).join(":"); // Formate l'heure en hh:mm

                if (data.direction==0){
                    var depart = "Centrale - Villeneuve d'Ascq";
                    var arrivee = "IG21 - Lens";
                }else{
                    var depart = "IG21 - Lens";
                    var arrivee = "Centrale - Villeneuve d'Ascq";
                }
                $("#detailsTrajetDate").text(date);
                $("#detailsTrajetHeure").text(heure);
                $("#detailsTrajetDepart").text(depart);
                $("#detailsTrajetArrive").text(arrivee);
                displayVehicle(data.vehicle_id);
                displayParticipants(trip_id);
                displayRemainingSeats(trip_id);

            },
            error : function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
                alert("error");
            }
        });
    }

    function displayVehicle(id){
        if (id === undefined || id === null){
            $("#noVehicleDeclaredDisclaimer").show();
            $("#detailTrajetVoitureAssigne").hide();
            return;
        }

        $.ajax(
            {
                url: './libs/data.php',
                type: 'GET',
                data: {
                    action: 'getVehicle',
                    vehicle_id: id
                },
                dataType: "json",
                success: function(data){
                    console.log(data);
                    model = data.model;
                    immatriculation = data.immatriculation;
                    owner_id = data.owner_id;

                    if(model === undefined || model === null){
                        model = "Non renseigné";
                        $("#TripDetailVehicleModel").parent().hide();
                    }

                    if(immatriculation === undefined || immatriculation === null){
                        immatriculation = "Non renseigné";
                        $("#TripDetailVehiclePlate").parent().hide();
                    }

                    


                    $("#noVehicleDeclaredDisclaimer").hide();
                    $("#detailTrajetVoitureAssigne").show();

                    $("#TripDetailVehicleModel").text(model);
                    $("#TripDetailVehiclePlate").text(immatriculation);


                    $.ajax(
                        {
                            url: './libs/data.php',
                            type: 'GET',
                            data: {
                                action: 'getUser',
                                user_id: owner_id
                            },
                            dataType: "json",
                            success: function(data){
                                console.log(data);
                                owner = data;
                                $("#TripDetailVehicleOwner").text(owner.display_name);
                            },
                            error : function(xhr, status, error) {
                                console.log(xhr.responseText);
                                console.log(status);
                                console.log(error);
                                alert("error");
                            }
                        }
                    )
                    



                },

            }
        )
    }

    function displayParticipants(trip_id){
        $.ajax(
            {
                url: './libs/data.php',
                type: 'GET',
                data: {
                    action: 'getParticipants',
                    trip_id: trip_id
                },
                dataType: "json",
                success: function(data){
                    console.log(data);
                    data 
                    // On affiche les participants
                    var participants = data;
                    var list = $("#detailsTrajetParticipants");
                    list.empty();
                    for (var i = 0; i < participants.length; i++){
                        console.log(participants[i]);
                        $.ajax(
                            {
                                url: './libs/data.php',
                                type: 'GET',
                                data: {
                                    action: 'getUser',
                                    user_id: participants[i].participant_id
                                },
                                dataType: "json",
                                success: function(data){
                                    console.log(data);
                                    var participant = data;
                                    var li = $("<li></li>");
                                    var a = $("<a></a>");
                                    a.attr("href", "index.php?view=detailUtilisateur&user_id=" + participant.id);
                                    a.text(participant.display_name);
                                    li.append(a);
                                    list.append(li);
                                },
                                error : function(xhr, status, error) {
                                    console.log(xhr.responseText);
                                    console.log(status);
                                    console.log(error);
                                    alert("error");
                                }
                            }
                        )
                    }
                },
                error : function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                    alert("error");
                }
            }
        )
    }

    function displayRemainingSeats(trip_id){
        $.ajax(
            {
                url: './libs/data.php',
                type: 'GET',
                data: {
                    action: 'getRemainingSeats',
                    trip_id: trip_id
                },
                dataType: "json",
                success: function(data){
                    console.log(data);
                    var remaining_seats = data;
                    $("#detailsTrajetRemainingSeats").text(remaining_seats);
                },
                error : function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                    alert("error");
                }
            }
        )
    }

</script>

