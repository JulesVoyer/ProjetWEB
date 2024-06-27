<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "trajets.php")
{
	header("Location:../index.php?view=trajets");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 

?>

    <!-- **** B O D Y **** -->
    <div id="trajetBody">
        <br />


        <div id="searchFieldTrajet">
            <select type = "select" name = "direction" id = "champDirection">
                <option value = "-1" selected = "true" >Tous</option>
                <option value = "0">Centrale -> IG2I</option>
                <option value = "1">IG2I -> Centrale </option>

            </select>
            <input type="date" name="dateHeure" placeholder="Quand" id="champDate">
            <input type="text" name="nbPassagers" placeholder="Places restantes" id="champNbPassagers">
            <input type="image" name="imgRecherche" src="ressources/loupe.png" alt="rechercheTrajet" id="imgRecherche">
        </div>
        
        <div id="trajetsList">
        </div>
           
        <div class="incentive">
            <p>Pas de trajet disponible ? Créez en un !</p>
        </div>

        <!-- TODO : refaire le FRONT !!! -->
        <form id="createTrajet" class="creationForm" action = "controleur.php" method = "get">
            <legend>Créez un trajet</legend>
            <input type="datetime-local" name="dateHeure" id="createTripDateTime">

            <select type = "select" name = "direction" id = "createTripDirection">
                <option  selected = "true" disable>Choisissez une direction</option>
                <option value = "c2i">Centrale -> IG2I</option>
                <option value = "i2c">IG2I -> Centrale</option>
            </select>

            <div>
                <input type ="checkbox" name = "conducteur" id = "createTripConducteur">
                <label for="conducteur">Vous conduisez ?</label>
            </div>


            <input type="submit" value="Créer un trajet" class = "btn" name="action" id="CreateTripSubmit">



            <div id = "createTripVehiclePopup" class = "popup">
                <div>
                    <h3> Mes véhicules </h3>

                    <div id = "createTripMyVehiclesList">
                    </div>

                    <h3> Véhicules Disponibles à la location </h3>

                    <div id = "createTripAvailableVehiclesList">
                    </div>
                
                    <div>
                        <input type = "button" value = "Annuler" class = "btn" id = "createTripVehiclePopupClose">
                        <input type = "button" value = "Valider" class = "btn" id = "createTripVehiclePopupValidate">
                    </div>
                </div>
            </div>

        </form>  

    
        
        
    </div>
    <script>
        
        $(".incentive").hide();
        //traitement des trajets

        jTrajet = $(`<a href="index.php?view=trajetsDetails" class="trajet">
                        <div class="infoTrajet">
                            <p class="dateTrajet">DATE_DUMMY</p>            
                            <img id="autoRouge" src="ressources/auto-rouge.png" alt="icone voiture rouge" class="icon" style="display: none;"/>
                        </div>
                        <div class="contTrajet">
                            <p class="heureDepart">HEURE_DUMMY</p>
                            <p class="pointDepart">DEPART_DUMMY</p>
                            <p class="pointArrivee">ARRIVEE_DUMMY</p>
                        </div>
                            
                        <div class="iconeTrajet">
                            <div class="rond"></div>
                            <div class="trait"></div>
                        </div>
                    </a>`);
                    

        function getTrips(data){
            $("#trajetsList").empty();
            $(".incentive").hide();
            $.ajax(
                {
                    type: "GET",	
                    url: "./libs/data.php",
                    data: {'action' : 'getDraftTrips', ...data},
                    dataType: "json",
                    success: function (rep) {
                        console.log(rep)
                        if (rep.length == 0) {
                            $(".incentive").show();
                        
                        }
                        for (var i = 0; i < rep.length; i++) {
                            console.log(rep[i]);
                            var trajetClone = jTrajet.clone();
                            var datetime = rep[i].departure_time;
                            var driver = rep[i].driver_id;
                            var vehicle = rep[i].vehicle_id;
                            var nb_max_passagers = rep[i].nb_passengers;
                            var nb_participants = rep[i].nb_participants;
                            var direction = rep[i].direction;

                            let [date, heure] = datetime.split(" ");
                            heure = heure.split(":").slice(0, 2).join(":"); // Formate l'heure en hh:mm

                            if (direction==0){
                                var depart = "Centrale - Villeneuve d'Ascq";
                                var arrivee = "IG21 - Lens";
                            }
                            else{
                                var depart = "IG21 - Lens";
                                var arrivee = "Centrale - Villeneuve d'Ascq";
                            }



                            trajetClone.attr("href", "index.php?view=trajetsDetails&trip_id="+rep[i].id);
                            trajetClone.data(rep[i]);

                            if(rep[i].vehicle_id === null){
                                console.log("pas de vehicule");
                                trajetClone.find("#autoRouge").show();
                            }

                            trajetClone.find(".dateTrajet").html(date);
                            trajetClone.find(".heureDepart").html(heure);
                            trajetClone.find(".pointDepart").html(depart);
                            trajetClone.find(".pointArrivee").html(arrivee);
                            $("#trajetsList").append(trajetClone);

                        }							
                    },
                    error: function (xhr, status, error) {
                        console.log("Status de l'erreur : " + status);
                        console.log("error : " + error);
                        console.log("Réponse complète : " + xhr.responseText);

                    }
                }
            )
        }
        //fin fonction getTrips

        // faire requête au chargement de la page

        getTrips({});

        // faire une recherche lors du clic sur le bouton de recherche
        
        $("#imgRecherche").click( 
            function () {
                var direction = $("#champDirection").val();
                var date = $("#champDate").val();
                var nbPassagers = $("#champNbPassagers").val();
                var data = {};
                if (direction == "0") {
                    data["direction"] = "0";
                } else if (direction == "1") {
                    data["direction"] = "1";
                }

                //check if nbPassagers string can be converted to a number
                if ($.trim(nbPassagers) !== "" && !isNaN(nbPassagers)) {
                    data["nbPassagers"] = nbPassagers;
                }

                var regexDate = /^\d{4}-\d{2}-\d{2}$/;

                if (regexDate.test(date)) {
                    data["date"] = date;
                }

                getTrips(data);				
                }
            )

            jVehicleRadio = $(`<div class="vehicleRadio">
                                <input type="radio" name="vehicle" value="" class = "objectRadio">                            
                                <img src="ressources/auto-noir.png" alt="vehicle" class="icon">
                                <p class="vehicleName">VEHICLE_NAME</p>
                                <p class="vehicleSeats">VEHICLE_SEATS</p>
                            </div>
                        </input>`);

            function getMyVehicles(){
                $("#createTripMyVehiclesList").empty();
                $.ajax(
                    {
                        type: "GET",
                        url: "./libs/data.php",
                        data: {'action' : 'getMyVehicles'},
                        dataType: "json",
                        success: function (rep) {
                            console.log(rep)
                            for (var i = 0; i < rep.length; i++) {

                                Jclone = jVehicleRadio.clone()
                                Jclone.find(".vehicleName").html(rep[i].name);
                                Jclone.find(".vehicleSeats").html(rep[i].nb_seats);
                                Jclone.find(".vehicleSeats").append(" places");
                                Jclone.find(".vehicle").data(rep[i]);
                                Jclone.find("input").val(rep[i].id);
                                $("#createTripMyVehiclesList").append(Jclone);


                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("Status de l'erreur : " + status);
                            console.log("error : " + error);
                            console.log("Réponse complète : " + xhr.responseText);

                        }

                    }
                )
            }

            function getAvailableVehicles(){
                $("#createTripAvailableVehiclesList").empty();
                var datetime = $("#createTripDateTime").val()
                var regexDateTime = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/ ;
                if(!regexDateTime.test(datetime)){
                    $("#createTripAvailableVehiclesList").append("<p>Veuillez choisir une date valide pour réserver un véhicule</p>");
                }
                else{
                let[date, heure] =  datetime.split("T");
                
                $.ajax(
                    {
                        method: "GET",
                        url: "./libs/data.php",
                        data: {'action' : 'getAvailableVehicles', 'date' : date},
                        dataType: "json",
                        success: function (rep) {
                            console.log(rep)
                            for (var i = 0; i < rep.length; i++) {

                                Jclone = jVehicleRadio.clone();
                                Jclone.find(".vehicleName").html(rep[i].name);
                                Jclone.find(".vehicleSeats").html(rep[i].nb_seats);
                                Jclone.find(".vehicleSeats").append(" places");
                                Jclone.find(".vehicle").data(rep[i]);
                                Jclone.val(rep[i].id);
                                Jclone.attr("name", "vehicle")
                                $("#createTripAvailableVehiclesList").append(Jclone);

                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("Status de l'erreur : " + status);
                            console.log("error : " + error);
                            console.log("Réponse complète : " + xhr.responseText);

                        }

                    }
                )
                }
            }

            $("#createTripConducteur").click(
                function(){
                    if($(this).is(':checked')){                        
                        getMyVehicles();
                        getAvailableVehicles();
                        $("#createTripVehiclePopup").show();

                    }
                }
            )

            $("#createTripVehiclePopupClose").click(function(){
                $("input[name=vehicle]:checked").prop("checked", false);
                $("#createTripVehiclePopup").hide();
            })
            
            $("#createTripVehiclePopupValidate").click(function(){
                var vehicle = $("input[name=vehicle]:checked").val();
                console.log(vehicle)
                if(vehicle){
                    $("#createTripVehiclePopup").hide();
                }
                else{
                    alert("Veuillez choisir un véhicule");
                }
            })


            // fin traitement des trajets
    </script>