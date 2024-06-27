<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "messages.php")
{
	header("Location:../index.php?view=messages");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 

?>

<div id="messageBody">

    <div id="msgTitlePage">
        <a id="msgRetourPagePrecedente" href="javascript:history.back()">
            <img id="msgFlecheRetour" src="ressources/flecheRetour.png" alt="Fleche">
        </a>
        <span class="msgNomTrajet">Nom du trajet</span>
        <a id="msgLienDetailTrajet" href="index.php?view=trajetsDetails">
            <img id="iconePoints" src="ressources/autre.png" alt="Points">
        </a>
    </div>
    
    <div id="msgConversation">
        
        <p class="msgHeureRecu">11:40 - <span class="msgUser">user1</span></p>
        <p class="msgRecu">Salut !</p>
        <p class="msgHeureEnvoye">12:00 - moi</p>
        <p class="msgEnvoye">Salut à tous, rdv devant Centrale demain à 8:50.</p>
        <p class="msgRejointQuitte"><span class="msgUser">user2</span> a rejoint le trajet</p>
        <p class="msgHeureRecu">12:05 - <span class="msgUser">user2</span></p>
        <p class="msgRecu">Salut ! On va bien à l'IG2I ?</p>
                
    </div>

    <div id="msgForm">
        <input type="text" name="msgContenu" id="msgContenu" placeholder="Ecrivez un message..">
        <input type="image" id="msgEnvoyer" src="ressources/paperPlane.png" value="Envoyer" name="action">
    </div>

    
</div>

<?php
    $tripId = valider("tripId");
    $tripName = valider("tripName");
?>

<script>
    $("#msgConversation").scrollTop(500);

    // ----- AJAX ----- //


    var tripId = <?php echo json_encode($tripId); ?>;
    
    // Message reçu
    var jMsgRecu = $("<p>").addClass("msgRecu");
    // Heure et utilisateur du message reçu
    var jmsgHeureRecu = $("<p>").addClass("msgHeureRecu");
    // Message envoyé
    var jMsgEnvoye = $("<p>").addClass("msgEnvoye");
    // // Heure et moi du message envoyé
    var jMsgHeureEnvoye = $("<p>").addClass("msgHeureEnvoye");

    // récupérations des messages de la conversation

    function getMessages() {
        var tripId = <?php echo json_encode($tripId); ?>;
        var tripName = <?php echo json_encode($tripName); ?>;
        var connectedUserId = <?php echo json_encode($_SESSION['idUser']); ?>;

        $.ajax({
            type: "GET",	
            url: "./libs/data.php",
            data: {'action' : 'getMessages', 'trip_id' : tripId},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);

                var d = new Date();
                var day = d.getDay();

                // Je retire les messages qui sont là
                $("#msgConversation").empty();
                
                // Je parcours le tableau et j'ajoute les messages
                for (i=0;i<oRep.length;i++) {
                    var lastMsgArrival = oRep[i].send_time.split(' ');
                    var lastMsgDate = lastMsgArrival[0].split('-');
                    var lastMsgTime = lastMsgArrival[1].split(':');
                    if (day == lastMsgDate[2]) lastMsgArrival = lastMsgTime[0] + ":" + lastMsgTime[1];
                    else lastMsgArrival = lastMsgDate[2] + "-" + lastMsgDate[1] + "-" + lastMsgDate[0];
                    //console.log(lastMsgArrival);
                    var userId = oRep[i].user_id;

                    $(".msgNomTrajet").html(tripName);

                    if (userId == connectedUserId) {
                        var annonce = lastMsgArrival + " - " + "moi";
                        var contenu = oRep[i].content;
                        jMsgHeureEnvoye.html(annonce);
                        jMsgEnvoye.html(contenu);
                        $("#msgConversation").append(jMsgHeureEnvoye.clone());
                        $("#msgConversation").append(jMsgEnvoye.clone());
                    } else {
                        var annonce = lastMsgArrival + " - " + "user" + userId;
                        var contenu = oRep[i].content;
                        jmsgHeureRecu.html(annonce);
                        jMsgRecu.html(contenu);
                        $("#msgConversation").append(jmsgHeureRecu.clone());
                        $("#msgConversation").append(jMsgRecu.clone());
                    }
                }                						
            }
        });
    } // fin getMessages() 

    // envoie de messages
    function postMessages(contenu) {

        $.ajax({
            type: "POST",	
            url: "./libs/data.php",
            data: {'action' : 'postMessages', 'trip_id' : tripId, 'contenu' : contenu},
            dataType: "json",
            success: function (oRep) {
                console.log(oRep);

                var d = new Date();
                var day = d.getDate();

                var lastMsgArrival = oRep[0].send_time.split(' ');
                var lastMsgDate = lastMsgArrival[0].split('-');
                var lastMsgTime = lastMsgArrival[1].split(':');
                if (day == lastMsgDate[2]) lastMsgArrival = lastMsgTime[0] + ":" + lastMsgTime[1];
                else lastMsgArrival = lastMsgDate[2] + "-" + lastMsgDate[1] + "-" + lastMsgDate[0];
                      
                var annonce = lastMsgArrival + " - " + "moi";
                var contenu = oRep[0].content;
                jMsgHeureEnvoye.html(annonce);
                jMsgEnvoye.html(contenu);
                $("#msgConversation").append(jMsgHeureEnvoye.clone());
                $("#msgConversation").append(jMsgEnvoye.clone());
            },
            error : function(xhs,status,error){
                console.log(xhs);
                console.log(status);
                console.log(error);
            }
        });
    } // fin getMessages() 


    // Récupération des messages au chargement de la page
    getMessages();

    // poster un message au clic sur envoyer
        $("#msgEnvoyer").click( function () {
        var contenu = $("#msgContenu").val();

        postMessages(contenu);
    } ); // fin poster un message au clic sur envoyer

</script>