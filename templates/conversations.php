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
        
        <div id="convTitlePage">Mes conversations</div>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">Jules : Ça marche, rdv demain à IG2I :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">Clément : Ça marche, rdv demain à IG2I :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">Maöz : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">Guillem : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>
        
        <a href="index.php?view=messages" class="convConversations">
            <p class="convTitleConv">Nom de la conv</p>
            <div class="convMessageContainer">
                <p class="convLastMessage">User : Ça marche, rdv demain à Centrale :)</p>
                <p class="convLastMessageTime">09:41</p>
            </div>
        </a>
    
</div>

<script>
    /* ---- AJAX ----- */

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

                // Je retire les conversations qui sont là
                $("#convBody").remove(".convConversations");

                
                // Je parcours le tableau et j'ajoute les conversations
                for (i=0;i<oRep.length;i++) {
                    // data.php renvoit les messages triés par heure d'arrivée, le plus récent en premier
                    
                    // je vide mes éléments
                    jConvConversation.empty();
                    jConvMessageContainer.empty();

                    // Je remplis les couches les plus profondes en premier
                    var tripName = oRep[i].direction + " " + oRep[i].departure_time;
                    var contenu = "User" + oRep[i].sender_id + " : " + oRep[i].content; //ici à changer le user, faire un getUser()

                    jConvLastMessage.html(contenu);
                    jConvLastMessageTime.html(oRep[i].last_message_time);
                    jConvTitleConv.html(tripName);


                    // Puis le container
                    jConvMessageContainer.append(jConvLastMessage.clone());
                    jConvMessageContainer.append(jConvLastMessageTime.clone());

                    // Puis le lien 
                    jConvConversation.append(jConvTitleConv.clone());
                    jConvConversation.append(jConvMessageContainer.clone());
                    jConvConversation.attr("href", "index.php?view=messages&tripId=" + oRep[i].trip_id + "&tripName=" + tripName);
                    
                    // Puis on l'ajoute à la suite des conversations
                    $("#convBody").append(jConvConversation.clone());
                }					
            }
        });
    } // fin getConversations

    // Récupération des conversations au chargement de la page
    getConversations();

</script>
