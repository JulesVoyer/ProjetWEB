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
        <a id="retourPagePrecedente" href="javascript:history.back()">
            <img id="flecheRetour" src="ressources/flecheRetour.png" alt="Fleche">
        </a>
        Nom du trajet
        <a id="lienDetailTrajet" href="index.php?view=trajetsDetails">
            <img id="iconePoints" src="ressources/autre.png" alt="Points">
        </a>
    </div>
    
    <div id="msgConversation">
        
        <p class="heureRecu">11:40 - user1</p>
        <p class="messageRecu">Salut !</p>
        <p class="heureEnvoye">12:00 - moi</p>
        <p class="messageEnvoye">Salut à tous, rdv devant Centrale demain à 8:50.</p>
        <p class="rejointQuitte">user2 a rejoint le trajet</p>
        <p class="heureRecu">12:05 - user2</p>
        <p class="messageRecu">Salut ! On va bien à l'IG2I ?</p>
                
    </div>

    <form id="msgForm" action="controleur.php">
        <input type="text" name="msgContenu" id="msgContenu" placeholder="Ecrivez un message..">
        <input type="image" id="msgEnvoyer" src="ressources/paperPlane.png" value="Envoyer" name="action">
    </form>

    
</div>