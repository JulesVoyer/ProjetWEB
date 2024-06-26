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
        Nom du trajet
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

    <form id="msgForm" action="controleur.php">
        <input type="text" name="msgContenu" id="msgContenu" placeholder="Ecrivez un message..">
        <input type="image" id="msgEnvoyer" src="ressources/paperPlane.png" value="Envoyer" name="action">
    </form>

    
</div>