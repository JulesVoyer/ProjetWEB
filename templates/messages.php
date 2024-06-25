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

    <!-- **** B O D Y **** -->
    <div id="messageBody">
        <br><br><br>

        <div id="titlePage">
            <a id="lienConversations" href="index.php?view=conversations">
                <img id="flecheRetour" src="ressources/flecheRetour.png" alt="Fleche">
            </a>
            Nom du trajet
            <a id="lienDetailTrajet" href="index.php?view=trajetsDetails">
                <img id="iconePoints" src="ressources/autre.png" alt="Points">
            </a>
        </div>
        
        <div id="conversation">
            <p class="heureRecu">11:40 - user1</p>
            <p class="messageRecu">Salut !</p>
            <p class="heureEnvoye">12:00 - moi</p>
            <p class="messageEnvoye">Salut à tous, rdv devant Centrale demain à 8:50.</p>
            <p class="rejointQuitte">user2 a rejoint le trajet</p>
            <p class="heureRecu">12:05 - user2</p>
            <p class="messageRecu">Salut ! On va bien à l'IG2I ?</p>
            
            <form action="controleur.php">
                <input type="text" name="contenuMessage" id="contenu" placeholder="Message">
                <input type="image" src="ressources/paperPlane.png" value="Envoyer" name="envoyerMessage">
            </form>
        </div>
    
    </div>