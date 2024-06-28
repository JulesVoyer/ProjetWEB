<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "conversations.php")
{
	header("Location:../index.php?view=conversations");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

?>

<div id="convBody">
    <div id="convTitleInvit">Mes invitations</div>

    <div id="convContInvit">
        <div class="convInvitations">
            <p class="convTitleInvit">Un titre de conversation</p>
            <div class="convInvitContainer">
                <input type="button" class="convBtnRefuse btn" value="Refuser" />
                <input type="button" class="convBtnAccept btn" value="Accepter" />
            </div>
        </div>
        <div class="convInvitations">
            <p class="convTitleInvit">Un titre de conversation</p>
            <div class="convInvitContainer">
                <input type="button" class="convBtnRefuse btn" value="Refuser" />
                <input type="button" class="convBtnAccept btn" value="Accepter" />
            </div>
        </div>
        <div class="convInvitations">
            <p class="convTitleInvit">Un titre de conversation</p>
            <div class="convInvitContainer">
                <input type="button" class="convBtnRefuse btn" value="Refuser" />
                <input type="button" class="convBtnAccept btn" value="Accepter" />
            </div>
        </div>
        <div class="convInvitations">
            <p class="convTitleInvit">Un titre de conversation</p>
            <div class="convInvitContainer">
                <input type="button" class="convBtnRefuse btn" value="Refuser" />
                <input type="button" class="convBtnAccept btn" value="Accepter" />
            </div>
        </div>
    </div>

    <div id="convTitleConv">Mes conversations</div>

    <div id="convContConv">
        <div class="convConversations">
            <p class="convTitleConv">Un titre de conversation</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Dernier message Dernier message Dernier message Dernier message</p>
                <p class="convLastMessageTime">10:00</p>
            </div>
        </div>
        <div class="convConversations">
            <p class="convTitleConv">Un titre de conversation</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Dernier message</p>
                <p class="convLastMessageTime">10:00</p>
            </div>
        </div>
        <div class="convConversations">
            <p class="convTitleConv">Un titre de conversation</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Dernier message</p>
                <p class="convLastMessageTime">10:00</p>
            </div>
        </div>
        <div class="convConversations">
            <p class="convTitleConv">Un titre de conversation</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Dernier message</p>
                <p class="convLastMessageTime">10:00</p>
            </div>
        </div>
        <div class="convConversations">
            <p class="convTitleConv">Un titre de conversation</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Dernier message</p>
                <p class="convLastMessageTime">10:00</p>
            </div>
        </div>
        <div class="convConversations">
            <p class="convTitleConv">Un titre de conversation</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Dernier message</p>
                <p class="convLastMessageTime">10:00</p>
            </div>
        </div>
    </div>
    
</div>

<script>
    /* ---- AJAX ----- */

    // récupération des invitations

    // Invitations
    // titre invitations
    var titleInvit = $("<div>")
                    .attr("id", "convTitleInvit")
                    .html("Mes invitations");
    // structure invitations
    var jConvInvitations = $("<div>").addClass("convInvitations");
    // Titre de l'invitation 
    var jConvTitleInvit = $("<p>").addClass("convTitleInvit");
    // Le container
    var jConvInvitContainer = $("<div>").addClass("convInvitContainer");
    // les boutons
    var jBtnRefuser = $("<input>")
        .attr("type", "button")
        .addClass("btn")
        .addClass("convBtnRefuse")
        .val("Refuser")
        .click( function () {
                console.log("on souahite refuser");
                $.ajax({

                    type: "POST",	
                    url: "./libs/data.php",
                    data: {action : 'refuseInvitation', 
                        trip_id : $(this).parent().data("trip_id")},
                    dataType: "json",
                    success: function (oRep) {
                        console.log(oRep);
                        getInvitations();
                    },
                    error: function (xhr, status, error) {
                        console.log("Status de l'erreur : " + status);
                        console.log("error : " + error);
                        console.log("Réponse complète : " + xhr.responseText);

                    }
                });
            });
    var jBtnAccept = $("<input>")
        .attr("type", "button")
        .addClass("btn")
        .addClass("convBtnAccept")
        .val("Accepter")
        .click( function () {
        console.log("on souahite accepter");
        $.ajax({

            type: "POST",	
            url: "./libs/data.php",
            data: {action : 'acceptInvitation', 
                trip_id : $(this).parent().data("trip_id")},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);
                getInvitations();
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);

            }
        });
    });

    function getInvitations() {
        
        $.ajax({
            type: "GET",	
            url: "./libs/data.php",
            data: {'action' : 'getInvitations'},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);

                // Je retire les invitations qui sont là
                $("#convContInvit").empty();
                
                for (i=0;i<oRep.length;i++) {

                    // je vide mes éléments
                    jConvInvitations.empty();
                    jConvInvitContainer.empty();

                    // Je remplis les couches les plus profondes en premier
                    var tripName = false;

                    var departure = oRep[i].departure_time.split(' ');
                    var departureDate = departure[0].split('-');
                    departureDate = departureDate[2] + "-" + departureDate[1] + "-" + departureDate[0];
                    var departureTime = departure[1].split(':');
                    departureTime = departureTime[0] + ":" + departureTime[1];
                    
                    if (oRep[i].direction) {
                        tripName = "IG2I -> Centrale Lille, départ : " + departureDate + " à " + departureTime;
                    } else {
                        tripName = "Centrale Lille -> I2GI, départ : " + departureDate + " à " + departureTime;
                    }
                    var contenu = "User" + oRep[i].sender_id + " : " + oRep[i].content; //ici à changer le user, faire un getUser()

                    jConvTitleInvit.html(tripName);

                    // Puis le container
                    jConvInvitContainer.append(jBtnRefuser.clone(true));
                    jConvInvitContainer.append(jBtnAccept.clone(true));
                    jConvInvitContainer.data("trip_id", oRep[i].trip_id);

                    // Puis le lien 
                    jConvInvitations.append(jConvTitleInvit.clone());
                    jConvInvitations.append(jConvInvitContainer.clone());
                    
                    // Puis on l'ajoute à la suite des conversations
                    $("#convContInvit").append(jConvInvitations.clone());
                }	
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);

            }
        });
    } // fin getInvitations


    // récupération des conversations

    // Lien vers les messages
    var jConvConversation = $("<a>").addClass("convConversations");
    // Titre de la conversation 
    var jConvTitleConv = $("<p>").addClass("convTitleConv");
    // Le container
    var jConvMessageContainer = $("<div>").addClass("convMessageContainer");
    // Le dernier message
    var jConvLastMessage = $("<p>").addClass("convLastMessage");
    // L'heure du dernier message
    var jConvLastMessageTime = $("<p>").addClass("convLastMessageTime");


    function getConversations() {
        
        $.ajax({
            type: "GET",	
            url: "./libs/data.php",
            data: {'action' : 'getConversations'},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);

                var d = new Date();
                var day = d.getDay();

                // Je retire les conversations qui sont là
                $("#convContConv").empty();
                
                // Je parcours le tableau et j'ajoute les conversations
                for (i=0;i<oRep.length;i++) {
                    // data.php renvoit les messages triés par heure d'arrivée, le plus récent en premier
                    
                    // Si le message a été envoyé aujourd'hui, j'affiche l'heure, sinon la date du jour d'envoi
                    var lastMsgArrival = oRep[i].last_message_time.split(' ');
                    var lastMsgDate = lastMsgArrival[0].split('-');
                    var lastMsgTime = lastMsgArrival[1].split(':');
                    if (day == lastMsgDate[2]) lastMsgArrival = lastMsgTime[0] + ":" + lastMsgTime[1];
                    else lastMsgArrival = lastMsgDate[2] + "-" + lastMsgDate[1] + "-" + lastMsgDate[0];

                    // je vide mes éléments
                    jConvConversation.empty();
                    jConvMessageContainer.empty();

                    // Je remplis les couches les plus profondes en premier
                    var tripName = false;

                    var departure = oRep[i].departure_time.split(' ');
                    var departureDate = departure[0].split('-');
                    departureDate = departureDate[2] + "-" + departureDate[1] + "-" + departureDate[0];
                    var departureTime = departure[1].split(':');
                    departureTime = departureTime[0] + ":" + departureTime[1];
                    
                    if (oRep[i].direction) {
                        tripName = "IG2I -> Centrale Lille, départ : " + departureDate + " à " + departureTime;
                    } else {
                        tripName = "Centrale Lille -> I2GI, départ : " + departureDate + " à " + departureTime;
                    }
                    var contenu = "User" + oRep[i].sender_id + " : " + oRep[i].content; //ici à changer le user, faire un getUser()

                    jConvLastMessage.html(contenu);
                    jConvLastMessageTime.html(lastMsgArrival);
                    jConvTitleConv.html(tripName);

                    // Puis le container
                    jConvMessageContainer.append(jConvLastMessage.clone());
                    jConvMessageContainer.append(jConvLastMessageTime.clone());

                    // Puis le lien 
                    jConvConversation.append(jConvTitleConv.clone());
                    jConvConversation.append(jConvMessageContainer.clone());
                    jConvConversation.attr("href", "index.php?view=messages&tripId=" + oRep[i].trip_id + "&tripName=" + tripName);
                    
                    // Puis on l'ajoute à la suite des conversations
                    $("#convContConv").append(jConvConversation.clone());
                }					
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);

            }
        });
    } // fin getConversations

    getInvitations();
    // Récupération des conversations au chargement de la page
    getConversations();


    $("#convBtnRefuse").click( function () {
        console.log("on souahite refuser");
        $.ajax({

            type: "POST",	
            url: "./libs/data.php",
            data: {action : 'refuseInvitation', 
                trip_id : $(this).parent().data("trip_id")},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);
                getInvitations();
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);

            }
        });
    })

$(document).on(("click"), ".convBtnAccept", function() {
    
})
    $("#convBtnAccept").click( function () {
        console.log("on souahite accepter");
        $.ajax({

            type: "POST",	
            url: "./libs/data.php",
            data: {action : 'acceptInvitation', 
                trip_id : $(this).parent().data("trip_id")},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);
                getInvitations();
            },
            error: function (xhr, status, error) {
                console.log("Status de l'erreur : " + status);
                console.log("error : " + error);
                console.log("Réponse complète : " + xhr.responseText);

            }
        });
    })
</script>
