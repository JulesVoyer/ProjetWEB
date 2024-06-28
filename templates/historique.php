<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "historique.php")
{
	header("Location:../index.php?view=historique");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 

?>

    <!-- **** B O D Y **** -->
    <div id="trajetBody">
        <br />


        <div action="controleur.php" method="post" id="searchFieldHistorique">
            <input type="date" name="date" placeholder="Quand" id="champDate">
            <input type="image" name="imgRecherche" src="ressources/loupe.png" alt="rechercheHistorique" id="imgRecherche">
        </div>

        <div id = "MyDraftTrips" class="subTitlePage">Mes trajets à venir</div>
        <div id= "MyArchivedTrips" class="subTitlePage"> Mes trajets </div>

        
    
    </div>


    <script>

    getAndDisplayDraftTrips();
    getAndDisplayArchivedTrips();

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


    //chercher et afficher les trajets à venir de l'utilisateur courant
    function getAndDisplayDraftTrips(){
        $.ajax({
            type: "GET",
            url: "./libs/data.php",
            data: {'action' : 'getMyDraftTrips'},
            dataType: "json",
            success: function (rep) {
                console.log(rep)
                for (var i = 0; i < rep.length; i++) {
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
                    $("#MyDraftTrips").append(trajetClone);

                }
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);
            }
        })
    }

    function getAndDisplayArchivedTrips(){
        $.ajax({
            type: "GET",
            url: "./libs/data.php",
            data: {'action' : 'getMyArchivedTrips'},
            dataType: "json",
            success: function (rep) {
                console.log(rep)
                for (var i = 0; i < rep.length; i++) {
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
                    $("#MyArchivedTrips").append(trajetClone);

                }
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);
            }

        })
    }
    
    </script>